<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImage extends Model
{
    public $timestamps = false; // Karena di migration kita hanya pakai created_at

    protected $fillable = ['product_id', 'image_path', 'sort_order', 'created_at'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}