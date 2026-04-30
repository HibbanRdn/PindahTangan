<?php

namespace App\Services;

use App\Models\Order;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SakurupiahService
{
    public function createTransaction(Order $order, User $user, array $urls = []): array
    {
        $endpoint = rtrim((string) config('services.sakurupiah.base_url'), '/') . '/' . ltrim((string) config('services.sakurupiah.create_path'), '/');

        $method = (string) config('services.sakurupiah.default_method', 'QRIS');

        // --- AMBIL KUNCI API DENGAN AMAN ---
        $apiId = (string) config('services.sakurupiah.api_id');
        $apiKey = (string) config('services.sakurupiah.api_key');
        
        // Ambil signature key, jika benar-benar kosong, pakai API Key
        $sigKey = config('services.sakurupiah.signature_key');
        $secretKey = !empty($sigKey) ? (string) $sigKey : $apiKey;

        $payload = [
            'api_id'         => $apiId,
            'method'         => $method,
            'name'           => $user->name,
            'email'          => $user->email,
            'phone'          => preg_replace('/\D+/', '', (string) ($user->phone ?? '')) ?: '6280000000000',
            'merchant_ref'   => $order->order_code,
            'amount'         => (int) $order->total_amount,
            'merchant_fee'   => (int) config('services.sakurupiah.merchant_fee', 1),
            'expired'        => (int) config('services.sakurupiah.expired_hours', 24),
            'return_url'     => $urls['return_url'] ?? null,
            'callback_url'   => $urls['callback_url'] ?? null,
            // Pembuatan signature sekarang terjamin menggunakan key yang benar
            'signature'      => $this->createSignature($apiId, $method, $order->order_code, (int) $order->total_amount, $secretKey),
        ];

        $payload = array_filter($payload, fn ($value) => ! is_null($value));

        $response = Http::timeout(30)
            ->asForm()
            ->withToken($apiKey)
            ->acceptJson()
            ->withHeaders(['Content-Type' => 'application/x-www-form-urlencoded'])
            ->post($endpoint, $payload)
            ->throw()
            ->json();

        if ((string) data_get($response, 'status') !== '200') {
            Log::warning('Sakurupiah create transaksi non-200', ['response' => $response]);
        }

        // --- BACA DATA DARI DALAM ARRAY [0] JIKA ADA ---
        $dataNode = data_get($response, 'data');
        if (is_array($dataNode) && isset($dataNode[0])) {
            $dataNode = $dataNode[0];
        }

        $transactionId = data_get($dataNode, 'trx_id') 
            ?? data_get($response, config('services.sakurupiah.map.transaction_id')) 
            ?? data_get($response, 'trx_id');

        $checkoutUrl = data_get($dataNode, 'checkout_url') 
            ?? data_get($response, config('services.sakurupiah.map.checkout_url')) 
            ?? data_get($response, 'redirect_url');

        $paymentMethod = data_get($dataNode, 'payment_kode') 
            ?? data_get($response, config('services.sakurupiah.map.payment_method')) 
            ?? data_get($response, 'payment_method');

        return [
            'transaction_id' => $transactionId,
            'checkout_url'   => $checkoutUrl,
            'payment_method' => $paymentMethod,
            'raw'            => $response,
        ];
    }

    public function isValidWebhookSignature(string $rawBody, ?string $signature): bool
    {
        // Gunakan Webhook Secret jika diisi, jika kosong gunakan API KEY sesuai dokumentasi Sakurupiah
        $secret = (string) config('services.sakurupiah.webhook_secret');
        if ($secret === '') {
            $secret = (string) config('services.sakurupiah.api_key');
        }

        if ($signature === null || $secret === '') {
            return false;
        }

        $expected = hash_hmac('sha256', $rawBody, $secret);

        return hash_equals($expected, $signature);
    }

    private function createSignature(string $apiId, string $method, string $merchantRef, int $amount, string $key): string
    {
        return hash_hmac('sha256', $apiId . $method . $merchantRef . $amount, $key);
    }
}
