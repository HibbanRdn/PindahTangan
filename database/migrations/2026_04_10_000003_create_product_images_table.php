<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')
                  ->constrained('products')
                  ->cascadeOnDelete();
            // cascadeOnDelete: jika produk dihapus,
            // semua gambar tambahan ikut terhapus otomatis

            $table->string('image_path', 255);
            $table->unsignedTinyInteger('sort_order')->default(0);
            // sort_order: urutan tampil gambar (0 = pertama)

            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};