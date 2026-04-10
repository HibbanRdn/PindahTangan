<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = [
        'order_id', 'transaction_id', 'payment_method', 
        'amount', 'status', 'paid_at', 'response_snapshot'
    ];

    protected function casts(): array
    {
        return [
            'response_snapshot' => 'array', // Otomatis konversi JSON ke Array di PHP
            'paid_at' => 'datetime',
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}