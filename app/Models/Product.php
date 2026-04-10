<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    protected $fillable = [
        'category_id', 'name', 'slug', 'description', 
        'condition_notes', 'condition', 'price', 'weight', 
        'stock', 'status', 'image'
    ];

    // Relasi: Produk dimiliki oleh satu kategori (Belongs-To)
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    // Relasi: Satu produk bisa punya banyak gambar tambahan
    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class);
    }
}