<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

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

        $subtotal    = $availableItems->sum(fn($i) => $i->product->price ?? 0);
        // FIX: totalWeight dibutuhkan oleh RajaOngkir untuk kalkulasi ongkir
        $totalWeight = max(1, $availableItems->sum(fn($i) => $i->product->weight ?? 0));

        return view('checkout.index', compact('availableItems', 'unavailableIds', 'subtotal', 'totalWeight'));
    }

    /**
     * Proxy ke RajaOngkir API V2 (Direct Search Method).
     *
     * Mode 1 — Search destinasi:
     *   GET /checkout/ongkir?search=menteng
     *
     * Mode 2 — Kalkulasi ongkir:
     *   GET /checkout/ongkir?destination=123&weight=500
     */
    public function cekOngkir(Request $request)
    {
        $apiKey  = config('services.rajaongkir.api_key');
        $baseUrl = 'https://rajaongkir.komerce.id/api/v1';

        // ── Mode: Search destinasi ──────────────────────────
        if ($request->filled('search')) {
            $response = Http::withHeaders(['key' => $apiKey])
                ->get("{$baseUrl}/destination/domestic-destination", [
                    'search' => $request->search,
                    'limit'  => 10,
                    'offset' => 0,
                ]);

            return response()->json($response->json());
        }

        // ── Mode: Kalkulasi ongkir ──────────────────────────
        $request->validate([
            'destination' => 'required',
            'weight'      => 'required|integer|min:1',
        ]);

        $response = Http::withHeaders(['key' => $apiKey])
            ->asForm()
            ->post("{$baseUrl}/calculate/domestic-cost", [
                'origin'      => config('services.rajaongkir.origin'),
                'destination' => $request->destination,
                'weight'      => (int) $request->weight,
                'courier'     => 'jne',
            ]);

        return response()->json($response->json());
    }

    /**
     * Proses checkout: buat Order, OrderItem, Address, Payment.
     */
    public function store(Request $request)
    {
        $request->validate([
            'items'             => 'required|array|min:1',
            'items.*'           => 'integer|exists:carts,id',
            'recipient_name'    => 'required|string|max:100',
            'phone'             => 'required|string|max:20',
            'destination_id'    => 'required|string',
            'province_name'     => 'required|string|max:100',
            'city_name'         => 'required|string|max:150',
            'postal_code'       => 'required|string|max:10',
            'address_detail'    => 'required|string|max:500',
            'courier'           => 'required|string|max:50',
            'courier_service'   => 'required|string|max:100',
            'shipping_cost'     => 'required|numeric|min:0',
            'shipping_estimate' => 'nullable|string|max:100',
            'notes'             => 'nullable|string|max:500',
        ], [
            'recipient_name.required' => 'Nama penerima wajib diisi.',
            'phone.required'          => 'Nomor telepon wajib diisi.',
            'destination_id.required' => 'Pilih destinasi pengiriman terlebih dahulu.',
            'address_detail.required' => 'Detail alamat (nama jalan, nomor rumah) wajib diisi.',
            'courier.required'        => 'Pilih kurir pengiriman terlebih dahulu.',
            'courier_service.required'=> 'Pilih layanan kurir terlebih dahulu.',
            'shipping_cost.required'  => 'Ongkos kirim belum terhitung. Pilih kurir terlebih dahulu.',
        ]);

        // Re-fetch cart items (security: wajib milik user ini)
        $cartItems = Cart::with('product')
            ->whereIn('id', $request->items)
            ->where('user_id', auth()->id())
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('keranjang.index')
                ->with('error', 'Item tidak ditemukan di keranjang.');
        }

        $availableItems = $cartItems->filter(
            fn($i) => $i->product && $i->product->status === 'available' && $i->product->stock >= 1
        );

        if ($availableItems->isEmpty()) {
            return redirect()->route('keranjang.index')
                ->with('error', 'Semua item yang dipilih sudah tidak tersedia. Silakan pilih ulang.');
        }

        $subtotal     = $availableItems->sum(fn($i) => $i->product->price);
        $shippingCost = (int) $request->shipping_cost;
        $total        = $subtotal + $shippingCost;

        DB::beginTransaction();

        try {
            // Generate unique order code: PT-YYMMDD-XXXXX
            do {
                $orderCode = 'PT-' . now()->format('ymd') . '-' . strtoupper(Str::random(5));
            } while (Order::where('order_code', $orderCode)->exists());

            $order = Order::create([
                'user_id'           => auth()->id(),
                'order_code'        => $orderCode,
                'subtotal'          => $subtotal,
                'shipping_cost'     => $shippingCost,
                'total_amount'      => $total,
                'courier'           => strtolower($request->courier),
                'courier_service'   => $request->courier_service,
                'shipping_estimate' => $request->shipping_estimate,
                'status'            => 'pending',
                'notes'             => $request->notes,
            ]);

            // Snapshot produk ke order_items (BR-06)
            foreach ($availableItems as $item) {
                OrderItem::create([
                    'order_id'          => $order->id,
                    'product_id'        => $item->product_id,
                    'product_name'      => $item->product->name,
                    'product_price'     => $item->product->price,
                    'product_condition' => $item->product->condition,
                    'quantity'          => 1,
                    'subtotal'          => $item->product->price,
                    'created_at'        => now(),
                ]);
            }

            // Simpan alamat pengiriman
            // province_id & city_id dikosongkan karena Direct Search tidak mengembalikan ID hierarkis
            Address::create([
                'order_id'       => $order->id,
                'recipient_name' => $request->recipient_name,
                'phone'          => $request->phone,
                'province_id'    => '',
                'province_name'  => $request->province_name,
                'city_id'        => $request->destination_id, // simpan subdistrict_id sebagai referensi
                'city_name'      => $request->city_name,
                'postal_code'    => $request->postal_code,
                'address_detail' => $request->address_detail,
                'created_at'     => now(),
            ]);

            // Buat payment record (pending — belum ada transaction_id dari Sakurupiah)
            Payment::create([
                'order_id' => $order->id,
                'amount'   => $total,
                'status'   => 'pending',
            ]);

            // Hapus cart items yang sudah di-checkout
            Cart::whereIn('id', $request->items)
                ->where('user_id', auth()->id())
                ->delete();

            DB::commit();

            // TODO: Redirect ke Sakurupiah payment gateway
            // Untuk sementara redirect ke halaman pesanan sukses
            return redirect()->route('pesanan.sukses', $orderCode)
                ->with('success', 'Pesanan berhasil dibuat! Segera selesaikan pembayaran.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan saat membuat pesanan. Silakan coba lagi.');
        }
    }
}