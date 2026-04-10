# PindahTangan – Perencanaan Sistem E-Commerce Preloved

> Platform e-commerce single-store berbasis web untuk jual beli barang preloved, dibangun dengan **Laravel** + **MySQL**, terintegrasi dengan **Payment Gateway Sakurupiah** dan **API RajaOngkir**.

---

## Daftar Isi

1. [Requirement Analysis](#1-requirement-analysis)
2. [Aturan Bisnis Sistem](#2-aturan-bisnis-sistem-business-rules)
3. [Karakteristik Barang Preloved & Implikasinya](#3-karakteristik-barang-preloved-dan-implikasinya-terhadap-sistem)
4. [Perancangan Database](#4-perancangan-database)
5. [User Flow & Wireframe Planning](#5-user-flow-dan-wireframe-planning)
6. [Rekomendasi MVP Minggu Pertama](#6-rekomendasi-mvp-minggu-pertama)
7. [Urutan Implementasi Laravel](#7-urutan-implementasi-laravel-yang-paling-logis)
8. [Fitur yang Sebaiknya Ditunda](#8-fitur-yang-sebaiknya-ditunda)
9. [Risiko Integrasi API & Cara Mengatasinya](#9-risiko-integrasi-api-dan-cara-mengatasinya)

---

## 1. Requirement Analysis

### 1.1 Deskripsi Sistem

PindahTangan adalah platform e-commerce **single-store** berbasis web yang menjual barang preloved — barang layak pakai yang sudah tidak digunakan, seperti pakaian, tas, buku, aksesoris, dan perlengkapan sehari-hari.

**Hal yang membedakan PindahTangan dari e-commerce biasa:**
Setiap barang adalah **satu unit unik**. Ini bukan sekadar perbedaan angka stok — ini mengubah cara kerja cart, checkout, validasi stok, dan status produk secara fundamental. Seluruh desain sistem harus mencerminkan kenyataan ini.

### 1.2 Aktor Sistem

| Aktor | Deskripsi | Batasan Akses |
|-------|-----------|---------------|
| **Admin** | Pengelola toko; mengelola produk, pesanan, dan status transaksi | Akses penuh via panel admin |
| **Pembeli (User)** | Pengguna terdaftar dan terverifikasi; dapat berbelanja | Harus login + email verified untuk checkout |
| **Guest** | Pengunjung tanpa akun | Hanya bisa browse katalog dan detail produk |

### 1.3 Functional Requirements

#### Fitur Pembeli

| Kode | Fitur | Keterangan |
|------|-------|------------|
| F-U01 | Registrasi akun | Form nama, email, password |
| F-U02 | Verifikasi email | Email verifikasi dikirim otomatis pasca-registrasi |
| F-U03 | Login / Logout | Autentikasi email + password |
| F-U04 | Lihat katalog produk | Hanya produk available yang tampil |
| F-U05 | Lihat detail produk | Gambar, harga, kondisi, catatan kondisi, berat, status |
| F-U06 | Pencarian produk | Berdasarkan nama |
| F-U07 | Filter produk | Berdasarkan kategori dan kondisi |
| F-U08 | Tambah ke keranjang | Hanya untuk produk available; wajib login |
| F-U09 | Lihat keranjang | Daftar item beserta validasi ulang ketersediaan |
| F-U10 | Update / hapus item keranjang | Edit jumlah atau hapus item |
| F-U11 | Checkout | Memulai proses pembelian |
| F-U12 | Input alamat pengiriman | Nama, telepon, provinsi, kota, detail, kode pos |
| F-U13 | Pilih kurir dan layanan | Berdasarkan hasil kalkulasi RajaOngkir |
| F-U14 | Lihat estimasi dan biaya ongkir | Ditampilkan setelah user klik "Cek Ongkir" |
| F-U15 | Lihat ringkasan pesanan | Subtotal + ongkir = total akhir |
| F-U16 | Bayar via Sakurupiah | Redirect ke halaman payment eksternal |
| F-U17 | Lihat status pembayaran | paid / pending / failed / expired |
| F-U18 | Riwayat pesanan | Semua transaksi yang pernah dibuat |
| F-U19 | Detail pesanan | Item, alamat, kurir, status pesanan, status bayar |

#### Fitur Admin

| Kode | Fitur | Keterangan |
|------|-------|------------|
| F-A01 | Login admin | Autentikasi dengan role admin |
| F-A02 | Tambah produk | Lengkap dengan gambar, kondisi, berat, stok |
| F-A03 | Edit produk | Ubah semua field produk |
| F-A04 | Hapus produk | Hanya produk yang belum terlibat transaksi aktif |
| F-A05 | Ubah status produk | available / sold / hidden |
| F-A06 | Lihat daftar pesanan | Tabel semua pesanan dengan filter status |
| F-A07 | Lihat detail pesanan | Item, alamat, kurir, ongkir, pembayaran |
| F-A08 | Cek status pembayaran | Sumber data dari tabel payments |
| F-A09 | Update status pesanan | Hanya boleh mengikuti urutan status yang valid |

### 1.4 Non-Functional Requirements

| Aspek | Ketentuan |
|-------|-----------|
| Usability | Navigasi intuitif; pembeli bisa checkout tanpa panduan eksternal |
| Responsiveness | Tampilan berfungsi baik di desktop dan mobile (Tailwind / Bootstrap) |
| Keamanan autentikasi | Password di-hash bcrypt; proteksi CSRF pada semua form |
| Verifikasi email | Akun tidak bisa checkout sebelum email diverifikasi |
| Konsistensi data transaksi | Data produk di `order_items` adalah snapshot; tidak berubah walau produk diedit |
| Integrasi API | Timeout handling untuk RajaOngkir; idempotency untuk webhook Sakurupiah |
| Integritas stok | Tidak boleh terjadi overselling; stok dipotong hanya saat pembayaran sukses |
| Keterbacaan kode | Struktur MVC Laravel; logika bisnis di Service class, bukan di controller |

### 1.5 Prioritas Fitur

#### ✅ Fitur Wajib (MVP)

- Autentikasi lengkap: register, login, logout, verifikasi email
- Katalog produk dengan filter kategori dan pencarian
- Keranjang belanja dengan validasi stok real-time
- Checkout: alamat pengiriman, pilih kurir via RajaOngkir, ringkasan
- Pembayaran via Sakurupiah + penanganan webhook callback
- Riwayat dan detail pesanan (sisi pembeli)
- CRUD produk + kelola status produk (admin)
- Kelola pesanan + update status pesanan (admin)

#### 🔧 Fitur Tambahan (Opsional, Kerjakan Setelah MVP Selesai)

- Notifikasi email status pesanan
- Multiple gambar produk
- Wishlist
- Ulasan produk
- Dashboard statistik admin
- Sorting produk
- Manajemen kategori via panel admin

---

## 2. Aturan Bisnis Sistem (Business Rules)

Aturan inti yang **wajib ditegakkan** di semua lapisan sistem — controller, validasi, middleware, maupun query database.

| Kode | Aturan | Keterangan |
|------|--------|------------|
| BR-01 | Guest hanya bisa browse | Tanpa login, tidak bisa menambahkan ke cart atau checkout |
| BR-02 | Checkout wajib login + email verified | Middleware `auth` dan `verified` dipasang di semua route checkout |
| BR-03 | Cart bukan reservasi stok | Item di cart tidak mengunci stok; stok bisa habis saat user masih di checkout |
| BR-04 | Produk `sold` atau `hidden` tidak bisa dibeli | Validasi wajib di sisi backend sebelum order dibuat, bukan hanya di UI |
| BR-05 | Stok dipotong hanya saat pembayaran sukses | Callback/webhook Sakurupiah yang memicu pengurangan stok dan perubahan status produk |
| BR-06 | Snapshot data produk di `order_items` | Nama dan harga produk disimpan saat transaksi; tidak ikut berubah walau produk diedit |
| BR-07 | Webhook harus idempotent | Jika Sakurupiah mengirim notifikasi dua kali untuk transaksi yang sama, sistem tidak memproses ulang |
| BR-08 | Status pesanan hanya bergerak maju secara logis | `pending → processing → shipped → completed`; admin tidak bisa lompat dari pending ke completed |
| BR-09 | Pesanan gagal tidak menghapus histori | Order dan payment tetap disimpan dengan status `cancelled / failed / expired` untuk keperluan audit |
| BR-10 | Satu produk preloved tidak bisa ada di dua cart sekaligus | Batasi dengan unique constraint atau validasi saat menambahkan ke cart |

---

## 3. Karakteristik Barang Preloved dan Implikasinya terhadap Sistem

### 3.1 Stok Terbatas sebagai Karakteristik Inti

Pada PindahTangan, **satu produk hampir selalu berarti satu unit**. Ini mengubah cara sistem bekerja:

**Implikasi terhadap produk:**
- Field `stock` secara praktis hanya bernilai `0` atau `1`. Menggunakan `TINYINT` sudah cukup.
- Status `available` dan `sold` adalah state kritis yang harus selalu sinkron dengan nilai stock.
- Tidak ada skenario "stok tinggal 3 tersisa" seperti produk biasa.

**Implikasi terhadap cart:**
- Membatasi quantity maksimum per item di cart menjadi `1` adalah keputusan desain yang masuk akal.
- Sistem harus mencegah dua user memasukkan produk yang sama ke cart masing-masing secara bersamaan lalu keduanya berhasil checkout (**race condition**).

**Implikasi terhadap checkout:**
- Sebelum order dibuat, sistem wajib melakukan **re-check stok di backend**, bukan hanya mengandalkan kondisi saat item ditambahkan ke cart.

### 3.2 Masalah Cart dan Quantity pada Sistem Preloved

**Mengapa cart bukan reservasi:**
- Dua user bisa memasukkan produk yang sama ke cart masing-masing secara bersamaan.
- Siapa yang pertama menyelesaikan pembayaran, dialah yang mendapat produk.
- User yang kalah akan mendapat pemberitahuan bahwa produk sudah tidak tersedia.

**Konsekuensi UX yang harus diantisipasi:**
- Saat user membuka halaman keranjang, sistem harus memvalidasi ulang setiap item.
- Jika ada produk yang sudah `sold`, tampilkan peringatan dan arahkan user untuk menghapusnya.
- Tombol "Lanjut ke Checkout" harus dinonaktifkan jika ada item tidak valid di cart.

**Solusi paling realistis untuk MVP:**
- Batasi quantity di cart menjadi maksimal 1 per item (validasi di controller, bukan hanya di frontend).
- Tambahkan pengecekan `product.status === 'available'` saat halaman cart dimuat.
- Lakukan re-check stok di dalam database transaction saat proses pembuatan order.
- Tambahkan **unique constraint** pada kombinasi `(user_id, product_id)` di tabel `carts`.

### 3.3 Status Produk

```
status: ENUM('available', 'sold', 'hidden')
```

| Status | Tampil di Katalog Publik | Bisa Dibeli | Dikelola Admin | Keterangan |
|--------|:---:|:---:|:---:|------------|
| `available` | ✅ Ya | ✅ Ya | ✅ Ya | Produk aktif dijual |
| `sold` | ❌ Tidak | ❌ Tidak | ✅ Hanya lihat | Produk sudah terjual |
| `hidden` | ❌ Tidak | ❌ Tidak | ✅ Ya | Produk disembunyikan sementara; bisa diaktifkan kembali |

**Mengapa `hidden` penting:**
- Admin mungkin perlu menarik produk dari katalog untuk foto ulang, koreksi deskripsi, dll, tanpa menghapusnya secara permanen.
- `hidden` berbeda dari `sold`: `sold` adalah keadaan **final**, `hidden` adalah keadaan **sementara** yang reversibel.

---

## 4. Perancangan Database

### 4.1 Entitas dan Fungsi

| Tabel | Fungsi |
|-------|--------|
| `users` | Data akun pembeli dan admin, termasuk status verifikasi email |
| `categories` | Klasifikasi produk |
| `products` | Data barang preloved dengan atribut kondisi, stok, dan status |
| `product_images` | Gambar tambahan per produk (opsional untuk MVP) |
| `carts` | Item yang ingin dibeli; bersifat sementara, bukan reservasi |
| `orders` | Header transaksi pembelian beserta info pengiriman |
| `order_items` | Snapshot detail produk per transaksi |
| `addresses` | Alamat pengiriman yang diisi saat checkout |
| `payments` | Data transaksi dan status pembayaran dari Sakurupiah |

### 4.2 Struktur Tabel

#### Tabel `users`

| Field | Tipe | Keterangan |
|-------|------|------------|
| id | BIGINT UNSIGNED, PK, AI | — |
| name | VARCHAR(100) | Nama lengkap |
| email | VARCHAR(150), UNIQUE | Email akun |
| password | VARCHAR(255) | Hash bcrypt |
| role | ENUM('admin','user'), default 'user' | Hak akses |
| email_verified_at | TIMESTAMP, NULL | Diisi Laravel saat verifikasi berhasil |
| remember_token | VARCHAR(100), NULL | Token sesi |
| created_at | TIMESTAMP | — |
| updated_at | TIMESTAMP | — |

> `email_verified_at` adalah bagian dari struktur default Laravel. Aktifkan `MustVerifyEmail` di model `User`.

#### Tabel `categories`

| Field | Tipe | Keterangan |
|-------|------|------------|
| id | BIGINT UNSIGNED, PK, AI | — |
| name | VARCHAR(100) | Nama kategori |
| slug | VARCHAR(100), UNIQUE | Identifier URL-friendly |
| created_at | TIMESTAMP | — |
| updated_at | TIMESTAMP | — |

#### Tabel `products`

| Field | Tipe | Keterangan |
|-------|------|------------|
| id | BIGINT UNSIGNED, PK, AI | — |
| category_id | BIGINT UNSIGNED, FK → categories | Kategori produk |
| name | VARCHAR(200) | Nama produk |
| slug | VARCHAR(220), UNIQUE | URL produk |
| description | TEXT | Deskripsi umum |
| condition_notes | TEXT, NULL | Catatan kondisi spesifik dari admin |
| condition | ENUM('like_new','good','fair') | Kondisi umum barang |
| price | DECIMAL(12,2) | Harga jual |
| weight | INT UNSIGNED | Berat dalam gram; dipakai oleh RajaOngkir |
| stock | TINYINT UNSIGNED, default 1 | Stok tersedia; praktis hanya 0 atau 1 |
| status | ENUM('available','sold','hidden'), default 'available' | Status ketersediaan |
| image | VARCHAR(255) | Path gambar utama |
| created_at | TIMESTAMP | — |
| updated_at | TIMESTAMP | — |

#### Tabel `product_images`

| Field | Tipe | Keterangan |
|-------|------|------------|
| id | BIGINT UNSIGNED, PK, AI | — |
| product_id | BIGINT UNSIGNED, FK → products | Produk yang bersangkutan |
| image_path | VARCHAR(255) | Path gambar tambahan |
| sort_order | TINYINT, default 0 | Urutan tampil gambar |
| created_at | TIMESTAMP | — |

#### Tabel `carts`

| Field | Tipe | Keterangan |
|-------|------|------------|
| id | BIGINT UNSIGNED, PK, AI | — |
| user_id | BIGINT UNSIGNED, FK → users | Pemilik cart |
| product_id | BIGINT UNSIGNED, FK → products | Produk yang ditambahkan |
| quantity | TINYINT UNSIGNED, default 1 | Jumlah; dibatasi maksimal 1 untuk preloved |
| created_at | TIMESTAMP | — |
| updated_at | TIMESTAMP | — |

> ⚠️ Tambahkan **unique constraint** pada `(user_id, product_id)` untuk mencegah item duplikat di cart yang sama.

#### Tabel `orders`

| Field | Tipe | Keterangan |
|-------|------|------------|
| id | BIGINT UNSIGNED, PK, AI | — |
| user_id | BIGINT UNSIGNED, FK → users | Pembeli |
| order_code | VARCHAR(50), UNIQUE | Kode unik; contoh: `PT-20250408-0001` |
| subtotal | DECIMAL(12,2) | Total harga produk sebelum ongkir |
| shipping_cost | DECIMAL(12,2) | Ongkos kirim dari RajaOngkir |
| total_amount | DECIMAL(12,2) | subtotal + shipping_cost |
| courier | VARCHAR(50) | Kode kurir: jne, tiki, pos |
| courier_service | VARCHAR(50) | Layanan: REG, OKE, YES, dll |
| shipping_estimate | VARCHAR(50) | Estimasi dari RajaOngkir: 2-3 hari |
| status | ENUM('pending','processing','shipped','completed','cancelled') | Status logistik pesanan |
| notes | TEXT, NULL | Catatan opsional dari pembeli |
| created_at | TIMESTAMP | — |
| updated_at | TIMESTAMP | — |

#### Tabel `order_items`

| Field | Tipe | Keterangan |
|-------|------|------------|
| id | BIGINT UNSIGNED, PK, AI | — |
| order_id | BIGINT UNSIGNED, FK → orders | Pesanan induk |
| product_id | BIGINT UNSIGNED, FK → products, NULL | Referensi produk asli; NULL jika produk dihapus |
| product_name | VARCHAR(200) | **Snapshot** nama saat transaksi |
| product_price | DECIMAL(12,2) | **Snapshot** harga saat transaksi |
| product_condition | VARCHAR(50) | **Snapshot** kondisi saat transaksi |
| quantity | TINYINT UNSIGNED | Jumlah item (praktis selalu 1) |
| subtotal | DECIMAL(12,2) | product_price × quantity |
| created_at | TIMESTAMP | — |

#### Tabel `addresses`

| Field | Tipe | Keterangan |
|-------|------|------------|
| id | BIGINT UNSIGNED, PK, AI | — |
| order_id | BIGINT UNSIGNED, FK → orders, UNIQUE | One-to-one dengan order |
| recipient_name | VARCHAR(100) | Nama penerima |
| phone | VARCHAR(20) | Nomor telepon penerima |
| province_id | VARCHAR(10) | ID provinsi dari RajaOngkir |
| province_name | VARCHAR(100) | Nama provinsi; disimpan lokal |
| city_id | VARCHAR(10) | ID kota dari RajaOngkir |
| city_name | VARCHAR(100) | Nama kota; disimpan lokal |
| postal_code | VARCHAR(10) | Kode pos |
| address_detail | TEXT | Jalan, RT/RW, kelurahan, kecamatan |
| created_at | TIMESTAMP | — |

#### Tabel `payments`

| Field | Tipe | Keterangan |
|-------|------|------------|
| id | BIGINT UNSIGNED, PK, AI | — |
| order_id | BIGINT UNSIGNED, FK → orders, UNIQUE | One-to-one dengan order |
| transaction_id | VARCHAR(100), UNIQUE, NULL | ID transaksi dari Sakurupiah; NULL sebelum response diterima |
| payment_method | VARCHAR(50), NULL | Metode bayar yang dipilih user di Sakurupiah |
| amount | DECIMAL(12,2) | Nominal yang harus dibayar |
| status | ENUM('pending','paid','failed','expired'), default 'pending' | Status pembayaran |
| paid_at | TIMESTAMP, NULL | Waktu pembayaran dikonfirmasi; diisi oleh webhook |
| response_snapshot | JSON, NULL | Payload lengkap response dari Sakurupiah |
| created_at | TIMESTAMP | — |
| updated_at | TIMESTAMP | — |

**Penjelasan field penting:**
- `transaction_id` — Kunci idempotency. Sebelum memproses webhook, cek apakah sudah pernah diproses dengan status `paid`.
- `paid_at` — Timestamp resmi kapan pembayaran berhasil. Berbeda dari `updated_at`.
- `response_snapshot` — Safety net untuk dispute atau bug integrasi.
- `status` — Independen dari `orders.status`. Keduanya dibaca secara terpisah.

### 4.3 Pemisahan Status Pembayaran dan Status Pesanan

> ⚠️ Ini adalah titik yang paling sering membingungkan dan paling sering salah diimplementasikan.

| | `payments.status` | `orders.status` |
|--|---|---|
| **Fungsi** | Apakah uang sudah diterima? | Di mana posisi pesanan secara logistik? |
| **Diubah oleh** | Webhook Sakurupiah (otomatis) | Admin secara manual |
| **Nilai** | pending, paid, failed, expired | pending, processing, shipped, completed, cancelled |
| **Sumber kebenaran** | Sakurupiah | Admin toko |

> ❌ **Kesalahan umum:** Mencampurkan kedua status ke dalam satu field, atau membuat `orders.status` berisi nilai seperti `paid` atau `unpaid`.

**Alur status yang benar:**

```
[Order dibuat]
orders.status = 'pending'
payments.status = 'pending'
         │
         ▼
[User membayar di Sakurupiah]
         │
    [Webhook diterima]
         │
    ┌────┴────────────┐
    │ payment berhasil│         │ payment gagal/expired │
    │                 │         │                       │
    payments.status = 'paid'    payments.status = 'failed'/'expired'
    orders.status = 'processing'  orders.status = 'cancelled'
    products.status = 'sold'    (stok tidak berubah)
    products.stock = 0
```

### 4.4 Strategi Pengurangan Stok yang Aman

**Stok TIDAK boleh dikurangi:**
- ❌ Saat item ditambahkan ke cart
- ❌ Saat order dibuat dan masih berstatus `pending`

**Stok boleh dikurangi:**
- ✅ Hanya saat webhook dari Sakurupiah diterima dengan status `paid` dan telah diverifikasi

**Implementasi di webhook handler (konsep):**
1. Validasi keaslian request dari Sakurupiah
2. Cari payment berdasarkan `transaction_id`
3. Jika `payments.status` sudah `'paid'` → **STOP** (idempotent)
4. Update `payments.status = 'paid'`, `paid_at = NOW()`
5. Update `orders.status = 'processing'`
6. Untuk setiap `order_item`: Update `products.stock = 0` dan `products.status = 'sold'`
7. Kosongkan cart user yang bersangkutan
8. **Commit transaction**

> Semua langkah 4–7 dilakukan dalam **satu database transaction**. Jika salah satu langkah gagal, seluruhnya di-rollback.

### 4.5 Masalah Overselling dan Cara Mengatasinya

**Skenario nyata:**
1. User A dan User B sama-sama memasukkan Produk X ke cart.
2. Keduanya membuka halaman checkout hampir bersamaan.
3. Keduanya menekan "Bayar Sekarang" dalam hitungan detik.
4. Tanpa proteksi, kedua order bisa terbuat.

**Solusi — Pessimistic Locking:**

```sql
BEGIN TRANSACTION;

SELECT * FROM products
WHERE id = ? AND status = 'available' AND stock > 0
FOR UPDATE;  -- kunci baris selama proses

-- Jika tidak ditemukan: rollback, tampilkan pesan "Produk sudah tidak tersedia"
-- Jika ditemukan: buat order, insert order_items, insert payment

COMMIT;
```

Di Laravel, gunakan `DB::transaction()` dan `lockForUpdate()` pada Eloquent.

### 4.6 Penanganan Order Gagal dan Payment Expired

| Skenario | Penanganan |
|----------|------------|
| User tidak membayar | Sakurupiah kirim webhook `expired` → `payments.status = 'expired'`, `orders.status = 'cancelled'`. Stok tidak berubah. |
| Pembayaran gagal | Webhook `failed` → `payments.status = 'failed'`, `orders.status = 'cancelled'`. Stok tidak berubah. |
| Webhook tidak datang | Sediakan endpoint manual di admin panel untuk memicu pengecekan status ke Sakurupiah berdasarkan `transaction_id`. |

> 📌 **Jangan hapus record order yang gagal.** Simpan dengan status `cancelled/failed` untuk audit trail, deteksi pola, dan debugging integrasi.

### 4.7 Masalah Slug Produk

**Mengapa slug bisa bentrok:** Dua produk dengan nama "Kemeja Flanel" akan menghasilkan slug `kemeja-flanel` yang sama, menyebabkan error karena kolom `slug` bersifat UNIQUE.

**Solusi di Laravel:**

```php
// Opsi 1: Tambah timestamp
$slug = Str::slug($name) . '-' . time();

// Opsi 2: Cek database, tambah suffix angka jika sudah ada
// kemeja-flanel → kemeja-flanel-2 → kemeja-flanel-3

// Opsi 3: Paket otomatis
// composer require spatie/laravel-sluggable
```

> ⚠️ **Mengapa penting untuk routing:** Route `/produk/{slug}` akan selalu mengembalikan produk pertama jika dua produk memiliki slug sama — produk kedua tidak bisa diakses. Bug ini sulit dilacak karena halaman tetap tampil, hanya menampilkan produk yang salah.

### 4.8 Relasi Antar Tabel

| Relasi | Tipe | Keterangan |
|--------|------|------------|
| users → carts | One-to-Many | Satu user bisa punya banyak item di cart |
| users → orders | One-to-Many | Satu user bisa punya banyak riwayat pesanan |
| categories → products | One-to-Many | Satu kategori memiliki banyak produk |
| products → carts | One-to-Many | Satu produk bisa ada di cart banyak user |
| products → product_images | One-to-Many | Satu produk bisa punya banyak gambar tambahan |
| products → order_items | One-to-Many | Satu produk bisa muncul di banyak order_items |
| orders → order_items | One-to-Many | Satu order berisi satu atau lebih item |
| orders → addresses | One-to-One | Setiap order punya tepat satu alamat pengiriman |
| orders → payments | One-to-One | Setiap order punya tepat satu record pembayaran |

### 4.9 ERD (Format dbdiagram.io)

```
Table users {
  id bigint [pk, increment]
  name varchar(100)
  email varchar(150) [unique]
  password varchar(255)
  role enum('admin','user') [default: 'user']
  email_verified_at timestamp [null]
  remember_token varchar(100) [null]
  created_at timestamp
  updated_at timestamp
}

Table categories {
  id bigint [pk, increment]
  name varchar(100)
  slug varchar(100) [unique]
  created_at timestamp
  updated_at timestamp
}

Table products {
  id bigint [pk, increment]
  category_id bigint [ref: > categories.id]
  name varchar(200)
  slug varchar(220) [unique]
  description text
  condition_notes text [null]
  condition enum('like_new','good','fair')
  price decimal(12,2)
  weight int
  stock tinyint [default: 1]
  status enum('available','sold','hidden') [default: 'available']
  image varchar(255)
  created_at timestamp
  updated_at timestamp
}

Table product_images {
  id bigint [pk, increment]
  product_id bigint [ref: > products.id]
  image_path varchar(255)
  sort_order tinyint [default: 0]
  created_at timestamp
}

Table carts {
  id bigint [pk, increment]
  user_id bigint [ref: > users.id]
  product_id bigint [ref: > products.id]
  quantity tinyint [default: 1]
  created_at timestamp
  updated_at timestamp

  indexes {
    (user_id, product_id) [unique]
  }
}

Table orders {
  id bigint [pk, increment]
  user_id bigint [ref: > users.id]
  order_code varchar(50) [unique]
  subtotal decimal(12,2)
  shipping_cost decimal(12,2)
  total_amount decimal(12,2)
  courier varchar(50)
  courier_service varchar(50)
  shipping_estimate varchar(50)
  status enum('pending','processing','shipped','completed','cancelled') [default: 'pending']
  notes text [null]
  created_at timestamp
  updated_at timestamp
}

Table order_items {
  id bigint [pk, increment]
  order_id bigint [ref: > orders.id]
  product_id bigint [ref: > products.id, null]
  product_name varchar(200)
  product_price decimal(12,2)
  product_condition varchar(50)
  quantity tinyint
  subtotal decimal(12,2)
  created_at timestamp
}

Table addresses {
  id bigint [pk, increment]
  order_id bigint [ref: - orders.id, unique]
  recipient_name varchar(100)
  phone varchar(20)
  province_id varchar(10)
  province_name varchar(100)
  city_id varchar(10)
  city_name varchar(100)
  postal_code varchar(10)
  address_detail text
  created_at timestamp
}

Table payments {
  id bigint [pk, increment]
  order_id bigint [ref: - orders.id, unique]
  transaction_id varchar(100) [unique, null]
  payment_method varchar(50) [null]
  amount decimal(12,2)
  status enum('pending','paid','failed','expired') [default: 'pending']
  paid_at timestamp [null]
  response_snapshot json [null]
  created_at timestamp
  updated_at timestamp
}
```

### 4.10 Catatan Integrasi API

#### RajaOngkir

**Origin city** adalah kota lokasi toko — nilainya tetap dan disimpan di konfigurasi, bukan di database:

```env
RAJAONGKIR_ORIGIN_CITY_ID=418
RAJAONGKIR_API_KEY=xxxx
```

- Field `weight` di tabel `products` (dalam gram) dikirimkan sebagai parameter `weight` ke endpoint cost RajaOngkir.
- API **hanya dipanggil saat user klik "Cek Ongkir"**, bukan saat user membuka katalog atau cart.
- Setelah user memilih kurir, simpan `courier`, `courier_service`, `shipping_cost`, `shipping_estimate`, `province_name`, dan `city_name` langsung di tabel terkait.

#### Sakurupiah

**Alur teknis yang benar:**
1. User klik "Bayar Sekarang" → buat record `orders` (status `pending`) dan `payments` (status `pending`) → kirim request ke Sakurupiah untuk mendapatkan URL pembayaran.
2. Redirect user ke URL pembayaran Sakurupiah.
3. Sakurupiah mengirim **webhook callback** ke endpoint sistem saat status pembayaran berubah.
4. Sistem memverifikasi webhook → update `payments` dan `orders` sesuai hasil.

**Idempotency webhook — wajib diimplementasikan:**
Sebelum memproses webhook, cek apakah `payments` dengan `transaction_id` yang diterima sudah berstatus `paid`. Jika sudah, **abaikan webhook dan kembalikan HTTP 200**.

> 🛠️ **Testing webhook di localhost:** Gunakan **ngrok** untuk membuat tunnel dari localhost ke URL publik. Daftarkan URL ngrok sebagai webhook URL di dashboard Sakurupiah saat development.

#### Laravel Email Verification

Tidak memerlukan tabel atau migration tambahan:
1. Tambahkan `implements MustVerifyEmail` pada class `User`.
2. Pastikan route `email.verify` terdaftar (otomatis dengan `Auth::routes(['verify' => true])` atau Breeze).
3. Pasang middleware `verified` pada semua route sensitif: cart, checkout, pesanan.
4. Untuk development, gunakan **Mailtrap.io** sebagai SMTP testing.

---

## 5. User Flow dan Wireframe Planning

### 5.1 User Flow Pembeli

```
[Kunjungi Website]
        │
        ▼
[Lihat Katalog] ── guest bisa browse
        │
        ▼
[Lihat Detail Produk]
        │
        ▼
[Klik "Tambah ke Keranjang"]
        │
   ┌────┴─────┐
Belum       Sudah
login        login
   │           │
   ▼           ▼
[Redirect  [Cek: email verified?]
 Login]         │
           ┌────┴────┐
         Belum      Sudah
           │          │
      [Redirect   [Tambah ke Cart]
       Verify          │
       Notice]    [Lihat Halaman Cart]
                  [Validasi ulang stok]
                       │
                  ┌────┴─────┐
                Ada item   Semua valid
                invalid        │
                   │           ▼
              [Tampilkan  [Klik Checkout]
               warning]        │
                          [Isi Alamat Pengiriman]
                               │
                          [Pilih Kurir via RajaOngkir]
                               │
                          [Ringkasan Pesanan]
                               │
                          [Klik "Bayar Sekarang"]
                          [Order + Payment dibuat (pending)]
                               │
                          [Redirect ke Sakurupiah]
                               │
                     ┌─────────┴──────────┐
                  Bayar               Tidak bayar/
                 berhasil              expired
                    │                     │
              [Webhook paid]       [Webhook expired]
              [Stok dipotong]      [Stok tidak berubah]
                    │
              [Halaman Konfirmasi]
                    │
              [Riwayat Pesanan]
```

### 5.2 User Flow Admin

```
[Login Admin]
      │
      ▼
[Dashboard Admin]
      │
      ├──► [Kelola Produk]
      │         ├── Tambah produk
      │         ├── Edit produk
      │         ├── Ubah status (available / hidden)
      │         └── Hapus produk (jika tidak ada order aktif)
      │
      └──► [Kelola Pesanan]
                ├── Lihat daftar pesanan (filter: status)
                ├── Lihat detail pesanan
                │     ├── Info pembeli & penerima
                │     ├── Item yang dibeli (snapshot)
                │     ├── Kurir, layanan, ongkir, estimasi
                │     └── Status pembayaran
                └── Update status pesanan
                      (pending → processing → shipped → completed)
```

### 5.3 Daftar Halaman

#### Halaman Pembeli

| No | Halaman | Route |
|----|---------|-------|
| 1 | Katalog / Homepage | `/` |
| 2 | Detail Produk | `/produk/{slug}` |
| 3 | Filter / Pencarian | `/produk?search=&category=` |
| 4 | Register | `/register` |
| 5 | Login | `/login` |
| 6 | Verifikasi Email (notice) | `/email/verify` |
| 7 | Keranjang | `/keranjang` |
| 8 | Checkout | `/checkout` |
| 9 | Konfirmasi Pesanan | `/pesanan/sukses/{order_code}` |
| 10 | Riwayat Pesanan | `/pesanan` |
| 11 | Detail Pesanan | `/pesanan/{order_code}` |

#### Halaman Admin

| No | Halaman | Route |
|----|---------|-------|
| 1 | Login Admin | `/admin/login` |
| 2 | Dashboard | `/admin/dashboard` |
| 3 | Daftar Produk | `/admin/produk` |
| 4 | Tambah Produk | `/admin/produk/create` |
| 5 | Edit Produk | `/admin/produk/{id}/edit` |
| 6 | Daftar Pesanan | `/admin/pesanan` |
| 7 | Detail Pesanan | `/admin/pesanan/{id}` |

### 5.4 Rencana Isi Tiap Halaman

**Katalog / Homepage** — Navbar (logo, link katalog, ikon keranjang dengan badge, login/akun). Filter tab kategori. Grid produk: gambar, nama, kondisi (badge), harga, tombol "Lihat Detail". Produk `sold` atau `hidden` tidak muncul. Pagination.

**Detail Produk** — Gambar utama + thumbnail. Nama produk, harga (prominan), badge kondisi, berat, status. Catatan kondisi (`condition_notes`). Deskripsi lengkap. Tombol "Tambah ke Keranjang" — disabled dan bertuliskan "Terjual" jika `status = sold`. Guest di-redirect ke login.

**Keranjang** — Tabel item: gambar kecil, nama, kondisi, harga, quantity (max 1), subtotal, tombol hapus. Banner peringatan jika ada item tidak available. Tombol "Lanjut ke Checkout" disabled jika ada item tidak valid atau cart kosong.

**Checkout** — Dibagi tiga bagian: (1) Form alamat pengiriman dengan dropdown provinsi dan kota dinamis, (2) Pilihan kurir (tampil setelah klik "Cek Ongkir"), (3) Ringkasan pesanan: item, subtotal, ongkir, total. Tombol "Bayar Sekarang".

**Riwayat Pesanan** — Tabel: kode pesanan, tanggal, total, status pesanan, status pembayaran, tombol "Detail".

**Detail Pesanan** — Info penerima dan alamat. Daftar item (snapshot). Detail pengiriman. Status pesanan + status pembayaran **ditampilkan terpisah dan jelas**.

---

## 6. Rekomendasi MVP Minggu Pertama

Fokus pada fondasi sebelum fitur bisnis. **Target: sistem autentikasi berjalan penuh dan katalog bisa diakses.**

1. Setup project Laravel, konfigurasi `.env`, koneksi MySQL
2. Buat semua migration sesuai ERD (urutan: `users → categories → products → carts → orders → order_items → addresses → payments`)
3. Seeder: data kategori dan minimal 5 produk contoh dengan kondisi berbeda
4. Implementasikan autentikasi: register, login, logout, verifikasi email (`MustVerifyEmail`)
5. Role middleware: pisahkan akses admin dan user sejak awal
6. Halaman katalog dan detail produk (statis, tanpa integrasi API dulu)
7. Fitur keranjang: tambah, lihat, update, hapus (lengkap dengan validasi stok)

---

## 7. Urutan Implementasi Laravel yang Paling Logis

```
1. Migration + Seeder
2. Auth + Verifikasi Email + Role Middleware
3. CRUD Produk (Admin) + Upload Gambar
4. Katalog & Detail Produk (Frontend) + Filter + Pencarian
5. Fitur Keranjang (dengan validasi stok + unique constraint)
6. Integrasi RajaOngkir (Service class terpisah)
7. Alur Checkout (alamat → kurir → ringkasan → buat order)
8. Integrasi Sakurupiah (buat payment → redirect → webhook handler)
9. Kelola Pesanan Admin (lihat, update status)
10. Riwayat & Detail Pesanan (sisi pembeli)
```

> ⚠️ Setiap tahap harus berjalan dengan benar sebelum pindah ke tahap berikutnya. Jangan mengerjakan integrasi API sebelum alur dasar keranjang dan checkout berfungsi.

---

## 8. Fitur yang Sebaiknya Ditunda

| Fitur | Alasan |
|-------|--------|
| Notifikasi email status pesanan | Butuh konfigurasi mail queue; tambah kompleksitas awal |
| Multiple gambar produk | Mulai dengan 1 gambar utama; tambahkan setelah fitur inti selesai |
| Wishlist | Tidak krusial untuk alur transaksi |
| Ulasan & rating | Butuh tabel tambahan dan moderasi |
| Dashboard statistik admin | Tidak memengaruhi fungsi utama |
| Sorting produk | Tambahkan setelah katalog stabil |
| Manajemen kategori via panel admin | Seeder sudah cukup untuk MVP |

---

## 9. Risiko Integrasi API dan Cara Mengatasinya

### RajaOngkir

| Risiko | Solusi |
|--------|--------|
| API lambat atau timeout | Set timeout pada HTTP request; tampilkan spinner loading saat kalkulasi |
| Kuota request habis | Panggil API hanya saat user klik "Cek Ongkir", bukan otomatis |
| Salah origin city | Simpan origin city ID di `.env`; verifikasi dengan test manual sejak awal |
| Field `weight` kosong pada produk | Tambahkan validasi `required` untuk field `weight` di form produk admin |
| Perubahan struktur response API | Gunakan `RajaOngkirService` — class terpisah di `app/Services/` yang mudah diganti |

### Sakurupiah

| Risiko | Solusi |
|--------|--------|
| Webhook tidak diterima di localhost | Gunakan ngrok; daftarkan URL ngrok di dashboard Sakurupiah |
| Double processing webhook | Cek `payments.status` sebelum proses; jika sudah `paid`, kembalikan HTTP 200 tanpa proses ulang |
| Stok tidak terpotong jika webhook gagal | Gunakan database transaction; jika gagal di tengah, rollback semua |
| Order pending menumpuk tanpa kejelasan | Sediakan tombol "Cek Status Pembayaran" manual di panel admin |
| Payload webhook tidak terverifikasi | Validasi signature/token dari Sakurupiah sebelum proses apapun |

### Laravel Email Verification

| Risiko | Solusi |
|--------|--------|
| Email tidak terkirim di development | Gunakan Mailtrap.io sebagai SMTP testing |
| User tidak menemukan email verifikasi | Sediakan tombol "Kirim Ulang" di halaman notice |
| Akses checkout tanpa verifikasi | Pasang middleware `verified` di semua route sensitif, bukan hanya di controller |

---

## Tech Stack

| Komponen | Teknologi |
|----------|-----------|
| Backend Framework | Laravel (PHP) |
| Database | MySQL |
| Frontend Styling | Tailwind CSS / Bootstrap |
| Payment Gateway | Sakurupiah |
| Shipping API | RajaOngkir |
| Email Testing | Mailtrap.io |
| Webhook Testing | ngrok |

---

*Dokumen ini adalah perencanaan sistem untuk platform PindahTangan — e-commerce preloved single-store.*
