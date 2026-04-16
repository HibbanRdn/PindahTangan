<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testimonials', function (Blueprint $table) {
            $table->id();

            $table->foreignId('user_id')
                  ->constrained('users')
                  ->restrictOnDelete();
            // restrictOnDelete: user tidak bisa dihapus
            // jika sudah pernah memberikan testimoni

            $table->foreignId('order_id')
                  ->unique()
                  ->constrained('orders')
                  ->restrictOnDelete();
            // unique: satu order hanya bisa menghasilkan
            // satu testimoni — tidak bisa submit ulang
            // restrictOnDelete: order tidak bisa dihapus
            // jika sudah ada testimoninya

            $table->tinyInteger('rating')->unsigned();
            // nilai 1–5
            // validasi range dilakukan di level aplikasi

            $table->text('comment');
            // isi testimoni / komentar dari pembeli

            $table->enum('status', ['pending', 'approved', 'rejected'])
                  ->default('pending');
            // pending  = baru dikirim, belum ditinjau admin
            // approved = ditampilkan di halaman publik
            // rejected = disembunyikan admin (konten tidak layak, dll)
            // Testimoni TIDAK langsung tampil ke publik sebelum disetujui admin

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonials');
    }
};