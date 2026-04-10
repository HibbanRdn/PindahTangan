<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')
                  ->unique()
                  ->constrained('orders')
                  ->cascadeOnDelete();
            // unique: one-to-one dengan orders

            $table->string('transaction_id', 100)->unique()->nullable();
            // ID transaksi dari Sakurupiah.
            // NULL sebelum response pertama diterima.
            // Unique: dipakai sebagai kunci idempotency webhook —
            // jika webhook dengan transaction_id ini sudah diproses,
            // sistem tidak akan memprosesnya lagi.

            $table->string('payment_method', 50)->nullable();
            // diisi setelah user memilih metode di halaman Sakurupiah
            // contoh: "bank_transfer", "qris", "virtual_account"

            $table->decimal('amount', 12, 2);
            // nominal yang harus dibayar, sama dengan orders.total_amount

            $table->enum('status', ['pending', 'paid', 'failed', 'expired'])
                  ->default('pending');
            // pending  = menunggu pembayaran
            // paid     = pembayaran dikonfirmasi Sakurupiah
            // failed   = pembayaran gagal
            // expired  = batas waktu pembayaran terlewati

            $table->timestamp('paid_at')->nullable();
            // diisi saat webhook 'paid' diterima dan diverifikasi
            // berbeda dari updated_at yang bisa berubah karena alasan lain

            $table->json('response_snapshot')->nullable();
            // menyimpan seluruh payload response dari Sakurupiah
            // berguna untuk audit, debugging, dan dispute resolution
            // tanpa perlu memanggil API ulang

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};