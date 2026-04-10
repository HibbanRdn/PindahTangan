<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();
            // cascadeOnDelete: jika user dihapus, cart-nya ikut terhapus

            $table->foreignId('product_id')
                  ->constrained('products')
                  ->cascadeOnDelete();
            // cascadeOnDelete: jika produk dihapus, item cart-nya terhapus

            $table->unsignedTinyInteger('quantity')->default(1);
            // untuk barang preloved, quantity maksimal 1
            // batasan ini ditegakkan di level aplikasi (controller/validation)

            $table->timestamps();

            // Unique constraint: satu user tidak bisa memasukkan
            // produk yang sama ke cart lebih dari sekali
            $table->unique(['user_id', 'product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('carts');
    }
};