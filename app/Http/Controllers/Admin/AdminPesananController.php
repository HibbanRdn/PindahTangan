<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminPesananController extends Controller
{
    // ── INDEX ────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items', 'payment', 'address'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_code', 'like', "%{$search}%")
                  ->orWhereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%")
                                                    ->orWhere('email', 'like', "%{$search}%"));
            });
        }

        $pesanan = $query->paginate(20)->withQueryString();

        // FIX: Hitung per status sesuai enum DB orders:
        // pending, processing, shipped, completed, cancelled
        $counts = Order::selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('admin.pesanan.index', compact('pesanan', 'counts'));
    }

    // ── SHOW ─────────────────────────────────────────────────────
    public function show(int $id)
    {
        $pesanan = Order::with([
            'user',
            'items.product',
            'address',
            'payment',
            'testimonial.images',
        ])->findOrFail($id);

        return view('admin.pesanan.show', compact('pesanan'));
    }

    // ── UPDATE STATUS ─────────────────────────────────────────────
    public function updateStatus(Request $request, int $id)
    {
        // FIX: Hapus 'paid' — status ini tidak ada di enum kolom orders.status di DB.
        // Status pembayaran (paid/pending/failed) dikelola di tabel payments secara terpisah.
        $request->validate([
            'status' => 'required|in:pending,processing,shipped,completed,cancelled',
        ]);

        $pesanan = Order::findOrFail($id);

        $finalStatuses = ['completed', 'cancelled'];
        if (in_array($pesanan->status, $finalStatuses)) {
            return back()->with('error', 'Status pesanan yang sudah final tidak dapat diubah.');
        }

        $oldStatus = $pesanan->status;
        $pesanan->update(['status' => $request->status]);

        return back()->with('success',
            "Status pesanan #{$pesanan->order_code} diubah dari {$oldStatus} → {$request->status}."
        );
    }
}