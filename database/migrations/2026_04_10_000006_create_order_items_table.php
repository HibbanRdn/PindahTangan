<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')
                  ->constrained('orders')
                  ->cascadeOnDelete();

            $table->foreignId('product_id')
                  ->nullable()
                  ->constrained('products')
                  ->nullOnDelete();
            // nullOnDelete: jika produk dihapus dari sistem,
            // product_id di sini menjadi NULL.
            // Data transaksi tetap valid karena semua info penting
            // sudah tersimpan dalam field snapshot di bawah.

            // --- SNAPSHOT DATA PRODUK SAAT TRANSAKSI ---
            // Field-field ini menyimpan kondisi produk tepat saat
            // order dibuat. Tidak akan berubah meski produk diedit.
            $table->string('product_name', 200);
            $table->decimal('product_price', 12, 2);
            $table->string('product_condition', 50);
            // contoh isi: "like_new", "good", "fair"
            // disimpan sebagai string agar tetap terbaca
            // walau enum produk berubah di masa depan

            $table->unsignedTinyInteger('quantity')->default(1);
            $table->decimal('subtotal', 12, 2);
            // product_price * quantity

            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};