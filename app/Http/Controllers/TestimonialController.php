<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Testimonial;
use App\Models\TestimonialImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TestimonialController extends Controller
{
    public function create($orderCode)
    {
        $order = Order::where('order_code', $orderCode)
            ->where('user_id', 2) // Perlu FIX
            ->where('status', 'completed')
            ->firstOrFail();

        // Cegah double testimoni (BR-T02)
        if ($order->testimonial()->exists()) {
            return redirect()->back()->with('info', 'Anda sudah memberikan testimoni.');
        }

        return view('testimonials.create', compact('order'));
    }

    public function store(Request $request, $orderCode)
    {
        $order = Order::where('order_code', $orderCode)
            ->where('user_id', 2) // Pelu FIX
            ->where('status', 'completed')
            ->firstOrFail();

        // Cegah double testimoni
        if ($order->testimonial()->exists()) {
            return redirect()->back()->with('info', 'Anda sudah memberikan testimoni.');
        }

        // VALIDASI (BR-T07, BR-T08, BR-T04)
        $request->validate([
            'rating'    => 'required|integer|min:1|max:5',
            'comment'   => 'required|string|min:10|max:1000',
            'images'    => 'nullable|array|max:3',
            'images.*'  => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        DB::beginTransaction();

        try {
            // ✅ Simpan testimoni
            $testimonial = Testimonial::create([
                'user_id'  => 2, // Perlu FIX
                'order_id' => $order->id,
                'rating'   => $request->rating,
                'comment'  => $request->comment,
                'status'   => 'pending',
            ]);

            // ✅ Simpan gambar
            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $image) {

                    // generate nama unik (biar aman)
                    $filename = time() . '_' . $index . '.' . $image->getClientOriginalExtension();

                    $path = $image->storeAs('testimonials', $filename, 'public');

                    TestimonialImage::create([
                        'testimonial_id' => $testimonial->id,
                        'image_path'     => $path,
                        'sort_order'     => $index,
                    ]);
                }
            }

            DB::commit();

            return redirect()->back()->with('success', 'Testimoni berhasil dikirim dan sedang ditinjau admin.');

        } catch (\Exception $e) {

            DB::rollBack();

            // 🔥 DEBUG MODE (sementara aktifkan ini)
            dd($e->getMessage());

            // kalau sudah production nanti ganti jadi:
            // return redirect()->back()->with('error', 'Terjadi kesalahan.');
        }
    }
}