<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class PesananController extends Controller
{
    /**
     * Daftar semua pesanan milik user yang sedang login.
     */
    public function index()
    {
        $orders = Order::with(['items', 'payment'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('pesanan.index', compact('orders'));
    }

    /**
     * Detail satu pesanan berdasarkan order_code.
     * Hanya bisa diakses oleh pemilik pesanan.
     */
    public function show(string $order_code)
    {
        $order = Order::with(['items', 'address', 'payment', 'testimonial'])
            ->where('order_code', $order_code)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('pesanan.show', compact('order'));
    }

    /**
     * Halaman konfirmasi setelah redirect dari Sakurupiah.
     * Pembayaran mungkin belum diverifikasi (menunggu webhook).
     */
    public function sukses(string $order_code)
    {
        $order = Order::with(['items', 'payment'])
            ->where('order_code', $order_code)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        return view('pesanan.sukses', compact('order'));
    }
}