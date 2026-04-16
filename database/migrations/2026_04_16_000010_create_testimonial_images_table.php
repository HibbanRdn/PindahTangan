<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('testimonial_images', function (Blueprint $table) {
            $table->id();

            $table->foreignId('testimonial_id')
                  ->constrained('testimonials')
                  ->cascadeOnDelete();
            // cascadeOnDelete: jika testimoni dihapus,
            // semua foto yang terkait ikut terhapus otomatis

            $table->string('image_path', 255);
            // path file foto yang diupload pembeli
            // contoh: testimonials/2025/04/abc123.jpg

            $table->unsignedTinyInteger('sort_order')->default(0);
            // urutan tampil foto jika ada lebih dari satu

            $table->timestamp('created_at')->useCurrent();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('testimonial_images');
    }
};