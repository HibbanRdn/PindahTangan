<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('addresses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')
                  ->unique()
                  ->constrained('orders')
                  ->cascadeOnDelete();
            // unique: one-to-one dengan orders
            // cascadeOnDelete: jika order dihapus, alamat ikut terhapus

            $table->string('recipient_name', 100);
            $table->string('phone', 20);

            // Data wilayah dari RajaOngkir
            // ID disimpan untuk referensi, nama disimpan sebagai snapshot
            // agar tetap terbaca walau tanpa memanggil API ulang
            $table->string('province_id', 10);
            $table->string('province_name', 100);
            $table->string('city_id', 10);
            $table->string('city_name', 100);
            $table->string('postal_code', 10);

            $table->text('address_detail');
            // jalan, nomor, RT/RW, kelurahan, kecamatan

            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};