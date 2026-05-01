<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use App\Services\KomercePaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class KomercePaymentWebhookController extends Controller
{
    public function __construct(private KomercePaymentService $komerce)
    {
    }

    /**
     * Terima callback dari Komerce Payment (RajaOngkir).
     *
     * Komerce mengirim POST ke endpoint ini setiap kali status transaksi berubah.
     * Verifikasi dilakukan dengan mencocokkan callback_API_KEY yang kita set saat create.
     *
     * Tambahkan route di routes/api.php atau routes/web.php:
     *   Route::post('/webhook/komerce-payment', [KomercePaymentWebhookController::class, 'handle'])
     *        ->name('webhook.komerce-payment')
     *        ->withoutMiddleware([\App\Http\Middleware\VerifyCsrfToken::class]);
     */
    public function handle(Request $request)
    {
        $rawBody = $request->getContent();

        Log::info('Komerce Payment webhook diterima', [
            'payload' => $request->all(),
        ]);

        // ── 1. Verifikasi callback_API_KEY ─────────────────────────────────────
        // Komerce mengirimkan kembali key yang kita buat saat create transaksi.
        $receivedKey = $request->input('callback_API_KEY')
            ?? $request->input('callback_api_key')
            ?? '';

        if (! $this->komerce->isValidCallback($receivedKey)) {
            Log::warning('Komerce webhook: callback_API_KEY tidak valid', [
                'received' => $receivedKey,
                'ip'       => $request->ip(),
            ]);

            return response()->json(['message' => 'Unauthorized'], 401);
        }

        // ── 2. Ambil data dari payload ─────────────────────────────────────────
        // Komerce mengirim order_id = order_code kita, bukan primary key order.
        $orderCode = $request->input('order_id');
        $status    = strtoupper((string) $request->input('status', ''));   // PAID | EXPIRED | CANCELED
        $paymentId = $request->input('payment_id') ?? $request->input('trx_id');
        $amount    = (int) $request->input('amount', 0);

        if (! $orderCode || ! $status) {
            Log::warning('Komerce webhook: payload tidak lengkap', $request->all());
            return response()->json(['message' => 'Bad Request'], 400);
        }

        // ── 3. Cari order & payment ───────────────────────────────────────────
        $order = Order::where('order_code', $orderCode)->first();

        if (! $order) {
            Log::warning('Komerce webhook: order tidak ditemukan', ['order_code' => $orderCode]);
            // Tetap return 200 agar Komerce tidak retry terus-menerus
            return response()->json(['message' => 'Order not found'], 200);
        }

        $payment = Payment::where('order_id', $order->id)->latest()->first();

        if (! $payment) {
            Log::warning('Komerce webhook: payment tidak ditemukan', ['order_id' => $order->id]);
            return response()->json(['message' => 'Payment not found'], 200);
        }

        // ── 4. Update status berdasarkan status Komerce ───────────────────────
        DB::beginTransaction();

        try {
            match ($status) {
                'PAID' => $this->handlePaid($order, $payment, $paymentId, $amount, $request->all()),
                'EXPIRED' => $this->handleExpired($order, $payment, $request->all()),
                'CANCELED' => $this->handleCanceled($order, $payment, $request->all()),
                default => Log::info("Komerce webhook: status '{$status}' diabaikan", ['order_code' => $orderCode]),
            };

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Komerce webhook: gagal update order/payment', [
                'order_code' => $orderCode,
                'status'     => $status,
                'error'      => $e->getMessage(),
            ]);
            return response()->json(['message' => 'Internal Server Error'], 500);
        }

        return response()->json(['message' => 'OK'], 200);
    }

    // ── Helpers ────────────────────────────────────────────────────────────────

    private function handlePaid(Order $order, Payment $payment, ?string $paymentId, int $amount, array $raw): void
    {
        // Hindari double processing
        if ($payment->status === 'paid') {
            return;
        }

        $payment->update([
            'status'            => 'paid',
            'transaction_id'    => $paymentId ?? $payment->transaction_id,
            'paid_at'           => now(),
            'response_snapshot' => $raw,
        ]);

        $order->update(['status' => 'paid']);

        Log::info('Komerce webhook: pembayaran berhasil', [
            'order_code' => $order->order_code,
            'amount'     => $amount,
        ]);

        // TODO: Kirim notifikasi email/WhatsApp ke buyer & seller jika diperlukan
        // event(new OrderPaid($order));
    }

    private function handleExpired(Order $order, Payment $payment, array $raw): void
    {
        if (in_array($payment->status, ['paid', 'expired'])) {
            return;
        }

        $payment->update([
            'status'            => 'expired',
            'response_snapshot' => $raw,
        ]);

        $order->update(['status' => 'canceled']);

        Log::info('Komerce webhook: pembayaran expired', ['order_code' => $order->order_code]);
    }

    private function handleCanceled(Order $order, Payment $payment, array $raw): void
    {
        if (in_array($payment->status, ['paid', 'canceled'])) {
            return;
        }

        $payment->update([
            'status'            => 'canceled',
            'response_snapshot' => $raw,
        ]);

        $order->update(['status' => 'canceled']);

        Log::info('Komerce webhook: pembayaran dibatalkan', ['order_code' => $order->order_code]);
    }
}