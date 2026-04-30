<?php
namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Tampilkan halaman checkout hanya untuk item yang dipilih user.
     * Items dipilih dikirim via query string: ?items[]=1&items[]=3
     */
    public function index(Request $request)
    {
        $request->validate([
            'items'   => 'required|array|min:1',
            'items.*' => 'integer|exists:carts,id',
        ], [
            'items.required' => 'Pilih minimal 1 item untuk di-checkout.',
            'items.min'      => 'Pilih minimal 1 item untuk di-checkout.',
        ]);

        // Ambil hanya item yang dipilih & milik user ini
        $selectedItems = Cart::with(['product.category'])
            ->whereIn('id', $request->items)
            ->where('user_id', auth()->id())
            ->get();

        if ($selectedItems->isEmpty()) {
            return redirect()->route('keranjang.index')
                ->with('error', 'Item yang dipilih tidak ditemukan di keranjang.');
        }

        // Cek ulang ketersediaan setiap item yang dipilih
        $unavailableIds = [];
        foreach ($selectedItems as $item) {
            if (
                ! $item->product ||
                $item->product->status !== 'available' ||
                $item->product->stock < 1
            ) {
                $unavailableIds[] = $item->id;
            }
        }

        // Tolak jika semua item ternyata tidak tersedia
        $availableItems = $selectedItems->filter(fn($i) => ! in_array($i->id, $unavailableIds));
        if ($availableItems->isEmpty()) {
            return redirect()->route('keranjang.index')
                ->with('error', 'Semua item yang dipilih sudah tidak tersedia.');
        }

        $subtotal = $availableItems->sum(fn($i) => $i->product->price ?? 0);

        return view('checkout.index', compact('availableItems', 'unavailableIds', 'subtotal'));
    }
}