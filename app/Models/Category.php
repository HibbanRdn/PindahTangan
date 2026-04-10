<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    // Mengizinkan field ini diisi secara massal
    protected $fillable = ['name', 'slug'];

    // Relasi: Satu kategori memiliki banyak produk (One-to-Many)
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}