<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

    /**
     * Batalkan pesanan yang masih pending (belum dibayar).
     *
     * Syarat:
     * - Pesanan milik user yang login
     * - Status order = 'pending'
     * - Status payment = 'pending'
     *
     * Tidak perlu restore stok karena stok baru dipotong saat webhook paid (BR-05).
     */
    public function cancel(string $order_code)
    {
        $order = Order::with('payment')
            ->where('order_code', $order_code)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Guard: hanya boleh batalkan jika masih pending
        if ($order->status !== 'pending') {
            return redirect()->route('pesanan.show', $order_code)
                ->with('error', 'Pesanan ini tidak dapat dibatalkan karena sudah diproses.');
        }

        if ($order->payment && $order->payment->status === 'paid') {
            return redirect()->route('pesanan.show', $order_code)
                ->with('error', 'Pembayaran sudah diterima, pesanan tidak bisa dibatalkan.');
        }

        DB::transaction(function () use ($order): void {
            $order->update(['status' => 'cancelled']);

            if ($order->payment) {
                $order->payment->update(['status' => 'failed']);
            }
        });

        return redirect()->route('pesanan.index')
            ->with('success', "Pesanan {$order->order_code} berhasil dibatalkan.");
    }
}