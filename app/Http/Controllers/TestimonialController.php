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
            ->where('user_id', auth()->id()) // FIX: pakai auth user
            ->where('status', 'completed')
            ->firstOrFail();

        // Cegah double testimoni (BR-T02)
        if ($order->testimonial()->exists()) {
            return redirect()->back()->with('info', 'Anda sudah memberikan testimoni untuk pesanan ini.');
        }

        return view('testimonials.create', compact('order'));
    }

    public function store(Request $request, $orderCode)
    {
        $order = Order::where('order_code', $orderCode)
            ->where('user_id', auth()->id()) // FIX: pakai auth user
            ->where('status', 'completed')
            ->firstOrFail();

        // Cegah double testimoni
        if ($order->testimonial()->exists()) {
            return redirect()->back()->with('info', 'Anda sudah memberikan testimoni untuk pesanan ini.');
        }

        $request->validate([
            'rating'    => 'required|integer|min:1|max:5',
            'comment'   => 'required|string|min:10|max:1000',
            'images'    => 'nullable|array|max:3',
            'images.*'  => 'image|mimes:jpg,jpeg,png,webp|max:2048',
        ], [
            'rating.required'   => 'Rating wajib dipilih.',
            'rating.min'        => 'Rating minimal 1 bintang.',
            'rating.max'        => 'Rating maksimal 5 bintang.',
            'comment.required'  => 'Komentar wajib diisi.',
            'comment.min'       => 'Komentar minimal 10 karakter.',
            'comment.max'       => 'Komentar maksimal 1000 karakter.',
            'images.max'        => 'Maksimal 3 foto.',
            'images.*.image'    => 'File harus berupa gambar.',
            'images.*.max'      => 'Ukuran foto maksimal 2MB.',
        ]);

        DB::beginTransaction();

        try {
            $testimonial = Testimonial::create([
                'user_id'  => auth()->id(), // FIX: pakai auth user
                'order_id' => $order->id,
                'rating'   => $request->rating,
                'comment'  => $request->comment,
                'status'   => 'pending',
            ]);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $image) {
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

            return redirect()
                ->route('pesanan.show', $orderCode)
                ->with('success', 'Testimoni berhasil dikirim dan sedang ditinjau admin. Terima kasih!');

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan. Silakan coba lagi.');
        }
    }
}