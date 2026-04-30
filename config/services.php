<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'rajaongkir' => [
        'api_key' => env('RAJAONGKIR_API_KEY'),
        'origin'  => env('RAJAONGKIR_ORIGIN'),
    ],

    'sakurupiah' => [
        'base_url' => env('SAKURUPIAH_BASE_URL', 'https://sakurupiah.id/api-sanbox'),
        'create_path' => env('SAKURUPIAH_CREATE_PATH', '/create.php'),
        'api_id' => env('SAKURUPIAH_API_ID'),
        'api_key' => env('SAKURUPIAH_API_KEY'),
        'signature_key' => env('SAKURUPIAH_SIGNATURE_KEY'),
        'webhook_secret' => env('SAKURUPIAH_WEBHOOK_SECRET'),
        'webhook_signature_header' => env('SAKURUPIAH_WEBHOOK_SIGNATURE_HEADER', 'X-Callback-Signature'),
        'webhook_event_header' => env('SAKURUPIAH_WEBHOOK_EVENT_HEADER', 'X-Callback-Event'),
        'default_method' => env('SAKURUPIAH_DEFAULT_METHOD', 'QRIS'),
        'merchant_fee' => env('SAKURUPIAH_MERCHANT_FEE', 1),
        'expired_hours' => env('SAKURUPIAH_EXPIRED_HOURS', 24),
        'map' => [
            'transaction_id' => env('SAKURUPIAH_MAP_TRANSACTION_ID', 'trx_id'),
            'checkout_url' => env('SAKURUPIAH_MAP_CHECKOUT_URL', 'data.checkout_url'),
            'payment_method' => env('SAKURUPIAH_MAP_PAYMENT_METHOD', 'payment_kode'),
            'status' => env('SAKURUPIAH_MAP_STATUS', 'status'),
        ],
    ],

];