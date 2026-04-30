<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Services\SakurupiahService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WebhookController extends Controller
{
    public function __construct(private SakurupiahService $sakurupiah)
    {
    }

    public function handle(Request $request): JsonResponse
    {
        $rawBody = (string) $request->getContent();
        $signature = $request->header(config('services.sakurupiah.webhook_signature_header', 'X-Callback-Signature'));
        $event = $request->header(config('services.sakurupiah.webhook_event_header', 'X-Callback-Event'));

        if ($event !== 'payment_status') {
            return response()->json(['message' => 'Ignored event'], 200);
        }

        if (! $this->sakurupiah->isValidWebhookSignature($rawBody, $signature)) {
            return response()->json(['message' => 'Invalid signature'], 401);
        }

        $transactionId = data_get($request->all(), config('services.sakurupiah.map.transaction_id', 'trx_id'));
        $status = strtolower((string) data_get($request->all(), config('services.sakurupiah.map.status', 'status')));

        $statusMap = [
            'pending' => 'pending',
            'berhasil' => 'paid',
            'success' => 'paid',
            'expired' => 'expired',
            'failed' => 'failed',
        ];

        $normalizedStatus = $statusMap[$status] ?? null;

        if (! $transactionId || ! $normalizedStatus) {
            return response()->json(['message' => 'Ignored'], 200);
        }

        $payment = Payment::with('order.items.product')
            ->where('transaction_id', $transactionId)
            ->first();

        if (! $payment) {
            return response()->json(['message' => 'Payment not found'], 404);
        }

        if ($payment->status === 'paid') {
            return response()->json(['message' => 'Already processed'], 200);
        }

        DB::transaction(function () use ($payment, $normalizedStatus, $request): void {

            $payment->update([
                'status' => in_array($normalizedStatus, ['paid', 'failed', 'expired'], true) ? $normalizedStatus : 'pending',
                'payment_method' => data_get($request->all(), config('services.sakurupiah.map.payment_method', 'payment_method')),
                'paid_at' => $normalizedStatus === 'paid' ? now() : null,
                'response_snapshot' => $request->all(),
            ]);

            if ($normalizedStatus === 'paid') {
                $payment->order->update(['status' => 'processing']);

                foreach ($payment->order->items as $item) {
                    if ($item->product) {
                        $item->product->update([
                            'stock' => 0,
                            'status' => 'sold',
                        ]);
                    }
                }

                return;
            }

            if (in_array($normalizedStatus, ['failed', 'expired'], true)) {
                $payment->order->update(['status' => 'cancelled']);
            }
        });

        return response()->json(['message' => 'OK']);
    }
}
