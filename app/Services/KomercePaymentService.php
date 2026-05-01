<?php

namespace App\Services;

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class KomercePaymentService
{
    private function baseUrl(): string
    {
        return rtrim((string) config('services.komerce_payment.base_url'), '/');
    }

    private function apiKey(): string
    {
        return (string) config('services.komerce_payment.api_key');
    }

    private function payPageUrl(): string
    {
        return rtrim((string) config('services.komerce_payment.pay_page_url'), '/');
    }

    /**
     * Ambil daftar metode pembayaran yang tersedia (VA & QRIS).
     */
    public function getPaymentMethods(): array
    {
        $response = Http::timeout(15)
            ->withHeaders([
                'x-api-key'    => $this->apiKey(),
                'Content-Type' => 'application/json',
            ])
            ->get($this->baseUrl() . '/api/v1/user/methods');

        return $response->json() ?? [];
    }

    /**
     * Buat transaksi pembayaran baru via Komerce Payment (RajaOngkir).
     *
     * @param  Order  $order
     * @param  User   $user
     * @param  array  $options  ['callback_url' => ..., 'items' => [...]]
     * @return array  ['transaction_id', 'checkout_url', 'payment_method', 'raw']
     */
    public function createTransaction(Order $order, User $user, array $options = []): array
    {
        $endpoint    = $this->baseUrl() . '/api/v1/user/payment/create';
        $paymentType = (string) config('services.komerce_payment.default_payment_type', 'qris');

        // Items: bisa dikirim dari luar (dari $availableItems di controller),
        // atau fallback ke relasi orderItems jika sudah di-load.
        $rawItems = $options['items'] ?? $order->orderItems->map(fn ($i) => [
            'name'     => $i->product_name,
            'quantity' => (int) $i->quantity,
            'price'    => (int) $i->product_price,
        ])->toArray();

        $payload = [
            'order_id'        => $order->order_code,
            'payment_type'    => $paymentType,
            'amount'          => (int) $order->total_amount,
            'customer'        => [
                'name'  => $user->name,
                'email' => $user->email,
                // Pastikan format E.164 (awali 62, tanpa +)
                'phone' => preg_replace('/\D+/', '', (string) ($user->phone ?? '')) ?: '6280000000000',
            ],
            'items'           => $rawItems,
            'expiry_duration' => (int) config('services.komerce_payment.expiry_duration', 3600),
        ];

        // VA membutuhkan channel_code; QRIS tidak.
        if ($paymentType === 'bank_transfer') {
            $payload['channel_code'] = (string) config('services.komerce_payment.channel_code', 'BCA');
        }

        // Callback (opsional tapi sangat dianjurkan)
        $callbackUrl = $options['callback_url'] ?? null;
        if ($callbackUrl) {
            $payload['callback_url']     = $callbackUrl;
            $payload['callback_API_KEY'] = (string) config('services.komerce_payment.callback_api_key', '');
        }

        $response = Http::timeout(30)
            ->withHeaders([
                'x-api-key'    => $this->apiKey(),
                'Content-Type' => 'application/json',
            ])
            ->post($endpoint, $payload)
            ->throw()   // lempar exception jika HTTP error (4xx/5xx)
            ->json();

        // Periksa status di dalam body respons
        $metaCode = (int) data_get($response, 'meta.code', 0);
        if ($metaCode !== 200) {
            Log::warning('Komerce Payment create non-200', [
                'order_code' => $order->order_code,
                'response'   => $response,
            ]);
        }

        $data = data_get($response, 'data');

        // Ambil checkout URL langsung dari field 'payment_url' (sesuai response aktual Komerce).
        $checkoutUrl = data_get($data, 'payment_url')
            ?? data_get($data, 'checkout_url')
            ?? data_get($data, 'redirect_url');

        $paymentId = data_get($data, 'payment_id')
            ?? data_get($data, 'id')
            ?? data_get($data, 'trx_id');

        return [
            'transaction_id' => $paymentId,
            'checkout_url'   => $checkoutUrl,
            'payment_method' => data_get($data, 'payment_type') ?? $paymentType,
            'raw'            => $response,
        ];
    }

    /**
     * Cek status pembayaran berdasarkan payment_id.
     */
    public function getPaymentStatus(string $paymentId): array
    {
        $response = Http::timeout(15)
            ->withHeaders([
                'x-api-key'    => $this->apiKey(),
                'Content-Type' => 'application/json',
            ])
            ->get($this->baseUrl() . "/api/v1/user/payment/status/{$paymentId}");

        return $response->json() ?? [];
    }

    /**
     * Batalkan transaksi PENDING.
     */
    public function cancelPayment(string $paymentId, string $reason = 'Order canceled'): array
    {
        $response = Http::timeout(15)
            ->withHeaders([
                'x-api-key'    => $this->apiKey(),
                'Content-Type' => 'application/json',
            ])
            ->post($this->baseUrl() . '/api/v1/user/payment/cancel', [
                'payment_id' => $paymentId,
                'reason'     => $reason,
            ]);

        return $response->json() ?? [];
    }

    /**
     * Verifikasi keaslian callback dari Komerce Payment.
     * Komerce mengirim kembali callback_API_KEY yang kita set saat create.
     */
    public function isValidCallback(string $receivedKey): bool
    {
        $expectedKey = (string) config('services.komerce_payment.callback_api_key', '');

        if ($expectedKey === '' || $receivedKey === '') {
            return false;
        }

        return hash_equals($expectedKey, $receivedKey);
    }
}