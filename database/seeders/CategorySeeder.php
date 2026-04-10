<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            'Pakaian',
            'Tas & Dompet',
            'Buku',
            'Aksesoris',
            'Perlengkapan Kuliah',
            'Elektronik',
            'Sepatu & Sandal',
            'Lainnya',
        ];

        foreach ($categories as $name) {
            DB::table('categories')->insert([
                'name'       => $name,
                'slug'       => Str::slug($name),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}