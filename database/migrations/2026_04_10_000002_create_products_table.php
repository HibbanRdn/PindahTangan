<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')
                  ->constrained('categories')
                  ->restrictOnDelete(); 
            // restrictOnDelete: kategori tidak bisa dihapus
            // jika masih ada produk di dalamnya

            $table->string('name', 200);
            $table->string('slug', 220)->unique();
            $table->text('description');
            $table->text('condition_notes')->nullable();
            // condition_notes: catatan kondisi spesifik dari admin,
            // contoh: "ada sedikit noda di bagian bawah kanan"

            $table->enum('condition', ['like_new', 'good', 'fair']);
            // like_new  = seperti baru, hampir tidak ada tanda pemakaian
            // good      = bekas pakai tapi masih sangat layak
            // fair      = ada tanda pemakaian yang terlihat, masih layak

            $table->decimal('price', 12, 2);
            $table->unsignedInteger('weight');
            // weight dalam gram, dipakai untuk kalkulasi RajaOngkir

            $table->unsignedTinyInteger('stock')->default(1);
            // untuk preloved, praktis hanya bernilai 0 atau 1

            $table->enum('status', ['available', 'sold', 'hidden'])->default('available');
            // available = tampil di katalog, bisa dibeli
            // sold      = sudah terjual, tidak tampil di katalog
            // hidden    = disembunyikan admin sementara, tidak tampil di katalog

            $table->string('image', 255)->nullable();
            // path gambar utama, contoh: products/kemeja-flanel-123.jpg

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};