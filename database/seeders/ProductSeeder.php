<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil ID kategori yang sudah dibuat
        $categories = DB::table('categories')->pluck('id', 'name');

        $products = [

            // --- PAKAIAN ---
            [
                'category'        => 'Pakaian',
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
                'category'        => 'Pakaian',
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
                'category'        => 'Pakaian',
                'name'            => 'Jaket Bomber Hijau Army',
                'description'     => 'Jaket bomber warna hijau army. Bahan parasut, ada kantong dalam. Ukuran M-L (oversized).',
                'condition_notes' => 'Resleting depan sedikit agak berat tapi masih berfungsi normal.',
                'condition'       => 'good',
                'price'           => 85000,
                'weight'          => 550,
                'stock'           => 1,
                'status'          => 'available',
            ],

            // --- TAS & DOMPET ---
            [
                'category'        => 'Tas & Dompet',
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
                'category'        => 'Tas & Dompet',
                'name'            => 'Tote Bag Kanvas Hitam',
                'description'     => 'Tote bag berbahan kanvas tebal warna hitam. Ukuran besar, bisa muat banyak barang.',
                'condition_notes' => 'Ada sedikit bercak cat di bagian dalam, tidak terlihat dari luar.',
                'condition'       => 'fair',
                'price'           => 20000,
                'weight'          => 250,
                'stock'           => 1,
                'status'          => 'available',
            ],

            // --- BUKU ---
            [
                'category'        => 'Buku',
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
                'category'        => 'Buku',
                'name'            => 'Buku Algoritma & Pemrograman - Rinaldi Munir',
                'description'     => 'Buku teks Algoritma dan Pemrograman karangan Rinaldi Munir. Sering dipakai di perkuliahan informatika.',
                'condition_notes' => 'Ada beberapa halaman yang digarisbawahi dengan pensil, bisa dihapus.',
                'condition'       => 'good',
                'price'           => 55000,
                'weight'          => 800,
                'stock'           => 1,
                'status'          => 'available',
            ],

            // --- PERLENGKAPAN KULIAH ---
            [
                'category'        => 'Perlengkapan Kuliah',
                'name'            => 'Lampu Meja Belajar LED USB',
                'description'     => 'Lampu meja belajar dengan cahaya LED, kabel USB, bisa diredupkan. Cocok untuk belajar malam.',
                'condition_notes' => null,
                'condition'       => 'good',
                'price'           => 40000,
                'weight'          => 350,
                'stock'           => 1,
                'status'          => 'available',
            ],

            // --- ELEKTRONIK (status sold, untuk testing tampilan) ---
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
                // status 'sold' untuk testing tampilan produk terjual
            ],

            // --- AKSESORIS (status hidden, untuk testing fitur hidden) ---
            [
                'category'        => 'Aksesoris',
                'name'            => 'Jam Tangan Casio Analog Hitam',
                'description'     => 'Jam tangan Casio analog tali kulit warna hitam. Masih berfungsi normal.',
                'condition_notes' => 'Tali sedikit pudar warnanya karena pemakaian.',
                'condition'       => 'good',
                'price'           => 175000,
                'weight'          => 150,
                'stock'           => 1,
                'status'          => 'hidden',
                // status 'hidden': tidak tampil di katalog publik,
                // hanya terlihat di panel admin
            ],
        ];

        foreach ($products as $product) {
            $categoryId = $categories[$product['category']] ?? null;

            if (!$categoryId) {
                continue; // skip jika kategori tidak ditemukan
            }

            // Generate slug unik: nama-produk + timestamp
            // Ini mencegah bentrok jika ada nama produk yang sama
            $baseSlug  = Str::slug($product['name']);
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
                // null: gambar belum diupload; akan diisi via panel admin
                'created_at'      => now(),
                'updated_at'      => now(),
            ]);

            // Delay kecil agar timestamp tidak bentrok antar produk
            usleep(1000);
        }
    }
}