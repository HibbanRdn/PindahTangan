<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Kosongkan tabel produk terlebih dahulu untuk mencegah duplikasi
        Schema::disableForeignKeyConstraints();
        DB::table('products')->truncate();
        Schema::enableForeignKeyConstraints();

        // Ambil ID kategori yang sudah dibuat
        $categories = DB::table('categories')->pluck('id', 'name');

        $products = [

            // --- PAKAIAN & FASHION ---
            [
                'category'        => 'Pakaian & Fashion',
                'name'            => 'Kemeja Flanel Merah Kotak-Kotak',
                'description'     => 'Kemeja flanel lengan panjang warna merah dengan motif kotak-kotak. Bahan tebal dan hangat, cocok untuk cuaca dingin. Ukuran M.',
                'condition_notes' => null,
                'condition'       => 'like_new',
                'price'           => 45000,
                'weight'          => 300,
                'stock'           => 1,
                'status'          => 'available',
            ],
            [
                'category'        => 'Pakaian & Fashion',
                'name'            => 'Kaos Polos Putih Uniqlo Size L',
                'description'     => 'Kaos polos putih dari Uniqlo, bahan katun halus, ukuran L. Masih sangat layak pakai.',
                'condition_notes' => 'Terdapat sedikit bekas setrika di bagian lengan kiri, tidak terlalu terlihat.',
                'condition'       => 'good',
                'price'           => 25000,
                'weight'          => 200,
                'stock'           => 1,
                'status'          => 'available',
            ],
            [
                'category'        => 'Pakaian & Fashion',
                'name'            => 'Jaket Bomber Hijau Army',
                'description'     => 'Jaket bomber warna hijau army. Bahan parasut, ada kantong dalam. Ukuran M-L (oversized).',
                'condition_notes' => 'Resleting depan sedikit agak berat tapi masih berfungsi normal.',
                'condition'       => 'good',
                'price'           => 85000,
                'weight'          => 550,
                'stock'           => 1,
                'status'          => 'available',
            ],

            // --- TAS & AKSESORIS ---
            [
                'category'        => 'Tas & Aksesoris',
                'name'            => 'Tas Ransel Laptop 14 Inch Abu-Abu',
                'description'     => 'Tas ransel dengan kompartemen laptop 14 inch. Ada banyak kantong, bahan polyester anti air. Warna abu-abu.',
                'condition_notes' => null,
                'condition'       => 'like_new',
                'price'           => 120000,
                'weight'          => 700,
                'stock'           => 1,
                'status'          => 'available',
            ],
            [
                'category'        => 'Tas & Aksesoris',
                'name'            => 'Tote Bag Kanvas Hitam',
                'description'     => 'Tote bag berbahan kanvas tebal warna hitam. Ukuran besar, bisa muat banyak barang.',
                'condition_notes' => 'Ada sedikit bercak cat di bagian dalam, tidak terlihat dari luar.',
                'condition'       => 'fair',
                'price'           => 20000,
                'weight'          => 250,
                'stock'           => 1,
                'status'          => 'available',
            ],

            // --- BUKU & KOLEKSI ---
            [
                'category'        => 'Buku & Koleksi',
                'name'            => 'Buku Clean Code - Robert C. Martin',
                'description'     => 'Buku Clean Code edisi bahasa Inggris. Salah satu buku wajib untuk programmer. Kondisi masih sangat baik.',
                'condition_notes' => null,
                'condition'       => 'like_new',
                'price'           => 95000,
                'weight'          => 600,
                'stock'           => 1,
                'status'          => 'available',
            ],
            [
                'category'        => 'Buku & Koleksi',
                'name'            => 'Buku Algoritma & Pemrograman - Rinaldi Munir',
                'description'     => 'Buku teks Algoritma dan Pemrograman karangan Rinaldi Munir. Sering dipakai di perkuliahan informatika.',
                'condition_notes' => 'Ada beberapa halaman yang digarisbawahi dengan pensil, bisa dihapus.',
                'condition'       => 'good',
                'price'           => 55000,
                'weight'          => 800,
                'stock'           => 1,
                'status'          => 'available',
            ],

            // --- ELEKTRONIK ---
            [
                'category'        => 'Elektronik',
                'name'            => 'Lampu Meja Belajar LED USB',
                'description'     => 'Lampu meja belajar dengan cahaya LED, kabel USB, bisa diredupkan. Cocok untuk belajar malam.',
                'condition_notes' => null,
                'condition'       => 'good',
                'price'           => 40000,
                'weight'          => 350,
                'stock'           => 1,
                'status'          => 'available',
            ],
            [
                'category'        => 'Elektronik',
                'name'            => 'Mouse Wireless Logitech M185',
                'description'     => 'Mouse wireless Logitech M185 warna hitam. Sudah termasuk baterai AA. Jangkauan hingga 10 meter.',
                'condition_notes' => null,
                'condition'       => 'like_new',
                'price'           => 130000,
                'weight'          => 200,
                'stock'           => 0,
                'status'          => 'sold',
            ],

            // --- JAM TANGAN ---
            [
                'category'        => 'Jam Tangan',
                'name'            => 'Jam Tangan Casio Analog Hitam',
                'description'     => 'Jam tangan Casio analog tali kulit warna hitam. Masih berfungsi normal.',
                'condition_notes' => 'Tali sedikit pudar warnanya karena pemakaian.',
                'condition'       => 'good',
                'price'           => 175000,
                'weight'          => 150,
                'stock'           => 1,
                'status'          => 'hidden',
            ],
        ];

        foreach ($products as $product) {
            $categoryId = $categories[$product['category']] ?? null;

            if (!$categoryId) {
                continue; 
            }

            $baseSlug   = Str::slug($product['name']);
            $uniqueSlug = $baseSlug . '-' . time() . rand(100, 999);

            DB::table('products')->insert([
                'category_id'     => $categoryId,
                'name'            => $product['name'],
                'slug'            => $uniqueSlug,
                'description'     => $product['description'],
                'condition_notes' => $product['condition_notes'],
                'condition'       => $product['condition'],
                'price'           => $product['price'],
                'weight'          => $product['weight'],
                'stock'           => $product['stock'],
                'status'          => $product['status'],
                'image'           => null,
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);

            usleep(1000);
        }

        $this->command->info('✅ Produk berhasil ditambahkan!');
    }
}