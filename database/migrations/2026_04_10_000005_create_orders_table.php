<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->restrictOnDelete();
            // restrictOnDelete: user tidak bisa dihapus
            // jika masih punya riwayat pesanan

            $table->string('order_code', 50)->unique();
            // format: PT-YYYYMMDD-XXXX, contoh: PT-20250408-0001
            // dibuat di aplikasi, bukan di database

            $table->decimal('subtotal', 12, 2);
            // total harga produk sebelum ongkir

            $table->decimal('shipping_cost', 12, 2)->default(0);
            // ongkos kirim dari RajaOngkir

            $table->decimal('total_amount', 12, 2);
            // subtotal + shipping_cost

            $table->string('courier', 50)->nullable();
            // kode kurir: jne, tiki, pos, sicepat, dll

            $table->string('courier_service', 50)->nullable();
            // layanan: REG, OKE, YES, BEST, dll

            $table->string('shipping_estimate', 50)->nullable();
            // estimasi dari RajaOngkir, contoh: "2-3 hari"

            $table->enum('status', [
                'pending',      // order dibuat, menunggu pembayaran
                'processing',   // pembayaran sukses, admin sedang memproses
                'shipped',      // barang sudah dikirim
                'completed',    // barang sudah diterima / selesai
                'cancelled',    // dibatalkan (pembayaran gagal/expired atau admin)
            ])->default('pending');

            $table->text('notes')->nullable();
            // catatan opsional dari pembeli saat checkout

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};