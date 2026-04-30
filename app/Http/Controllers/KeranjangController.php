<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;

class KeranjangController extends Controller
{
    /**
     * Tampilkan halaman keranjang.
     * Validasi ulang stok saat halaman dibuka (BR-03: cart bukan reservasi).
     */
    public function index()
    {
        $cartItems = Cart::with(['product.category', 'product.images'])
            ->where('user_id', auth()->id())
            ->latest()
            ->get();

        // Tandai item yang produknya sudah tidak tersedia (sold/hidden/deleted)
        $unavailableIds = [];
        foreach ($cartItems as $item) {
            if (
                ! $item->product ||
                $item->product->status !== 'available' ||
                $item->product->stock < 1
            ) {
                $unavailableIds[] = $item->id;
            }
        }

        $subtotal = $cartItems
            ->filter(fn($item) => ! in_array($item->id, $unavailableIds))
            ->sum(fn($item) => $item->product->price ?? 0);

        return view('keranjang.index', compact('cartItems', 'unavailableIds', 'subtotal'));
    }

    /**
     * Tambah produk ke keranjang.
     * Validasi: produk tersedia, stok ada, belum di keranjang (unique constraint).
     */
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
        ]);

        $product = Product::findOrFail($request->product_id);

        // Cek produk masih available
        if ($product->status !== 'available') {
            return back()->with('error', 'Maaf, produk ini sudah tidak tersedia.');
        }

        // Cek stok
        if ($product->stock < 1) {
            return back()->with('error', 'Maaf, produk ini sedang kehabisan stok.');
        }

        // Cek sudah di keranjang sendiri (BR-10: unique user_id+product_id)
        $exists = Cart::where('user_id', auth()->id())
            ->where('product_id', $product->id)
            ->exists();

        if ($exists) {
            return back()->with('info', 'Produk ini sudah ada di keranjang Anda.');
        }

        // Cek produk sudah di keranjang user lain (preloved = 1 unit)
        // Tidak perlu dicegah di sini karena stok dipotong saat webhook paid,
        // bukan saat masuk keranjang (BR-03 + BR-05).

        Cart::create([
            'user_id'    => auth()->id(),
            'product_id' => $product->id,
            'quantity'   => 1, // selalu 1 karena preloved (BR-10)
        ]);

        return back()->with('success', "\"{$product->name}\" berhasil ditambahkan ke keranjang!");
    }

    /**
     * Update quantity — tidak digunakan untuk preloved (qty selalu 1).
     * Disediakan untuk kelengkapan route, redirect saja.
     */
    public function update(Request $request, int $id)
    {
        // Preloved: stok selalu 1, quantity tidak bisa diubah
        return back()->with('info', 'Kuantitas tidak dapat diubah untuk barang preloved.');
    }

    /**
     * Hapus item dari keranjang.
     */
    public function destroy(int $id)
    {
        $cartItem = Cart::where('id', $id)
            ->where('user_id', auth()->id()) // pastikan milik user ini
            ->firstOrFail();

        $productName = $cartItem->product->name ?? 'Produk';
        $cartItem->delete();

        return back()->with('success', "\"{$productName}\" dihapus dari keranjang.");
    }
}