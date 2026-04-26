<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // 1. Matikan pengecekan foreign key sementara
        Schema::disableForeignKeyConstraints();

        // 2. Kosongkan tabel kategori (hapus semua data & reset ID)
        DB::table('categories')->truncate();

        // 3. Hidupkan kembali pengecekan foreign key
        Schema::enableForeignKeyConstraints();

        // ── Kategori ──────────────────────────────────────────────
        $categories = [
            ['name' => 'Pakaian & Fashion',    'slug' => 'pakaian-fashion'],
            ['name' => 'Sepatu & Sneakers',    'slug' => 'sepatu-sneakers'],
            ['name' => 'Tas & Aksesoris',      'slug' => 'tas-aksesoris'],
            ['name' => 'Elektronik',           'slug' => 'elektronik'],
            ['name' => 'Kamera & Lensa',       'slug' => 'kamera-lensa'],
            ['name' => 'Audio & Headphone',    'slug' => 'audio-headphone'],
            ['name' => 'Jam Tangan',           'slug' => 'jam-tangan'],
            ['name' => 'Buku & Koleksi',       'slug' => 'buku-koleksi'],
            ['name' => 'Peralatan Olahraga',   'slug' => 'peralatan-olahraga'],
            ['name' => 'Perabot & Dekorasi',   'slug' => 'perabot-dekorasi'],
        ];

        foreach ($categories as $category) {
            DB::table('categories')->insert([
                'name'       => $category['name'],
                'slug'       => $category['slug'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        $this->command->info('✅ Kategori berhasil diperbarui!');
    }
}