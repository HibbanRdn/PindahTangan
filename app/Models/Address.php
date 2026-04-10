<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'order_id', 'recipient_name', 'phone', 'province_id', 
        'province_name', 'city_id', 'city_name', 'postal_code', 
        'address_detail', 'created_at'
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}