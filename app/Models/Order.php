<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'order_code', 'subtotal', 'shipping_cost', 
        'total_amount', 'courier', 'courier_service', 
        'shipping_estimate', 'status', 'notes'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function address(): HasOne
    {
        return $this->hasOne(Address::class);
    }

    public function payment(): HasOne
    {
        return $this->hasOne(Payment::class);
    }

    // TAMBAHAN (WAJIB UNTUK TESTIMONI)
    public function testimonial(): HasOne
    {
        return $this->hasOne(Testimonial::class);
    }
}