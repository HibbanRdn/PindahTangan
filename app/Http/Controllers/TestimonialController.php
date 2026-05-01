<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Testimonial;
use App\Models\TestimonialImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TestimonialController extends Controller
{
    /**
     * Halaman publik — daftar semua testimoni yang sudah approved.
     */
    public function index()
    {
        $testimonials = Testimonial::with(['user', 'order.items', 'images'])
            ->where('status', 'approved')
            ->latest()
            ->paginate(12);

        $stats = [
            'total'   => Testimonial::where('status', 'approved')->count(),
            'avg'     => round(Testimonial::where('status', 'approved')->avg('rating'), 1),
            'five'    => Testimonial::where('status', 'approved')->where('rating', 5)->count(),
        ];

        return view('testimonials.index', compact('testimonials', 'stats'));
    }

    /**
     * Form tulis testimoni.
     * Validasi: order harus milik user, status completed, belum ada testimoni.
     */
    public function create(string $order_code)
    {
        $order = Order::with(['items.product', 'testimonial'])
            ->where('order_code', $order_code)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        // Validasi business rules
        abort_if($order->status !== 'completed', 403, 'Pesanan belum selesai.');
        abort_if(! is_null($order->testimonial), 403, 'Testimoni sudah pernah dikirim.');

        return view('testimonials.create', compact('order'));
    }

    /**
     * Simpan testimoni baru.
     */
    public function store(Request $request, string $order_code)
    {
        $order = Order::with('testimonial')
            ->where('order_code', $order_code)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        abort_if($order->status !== 'completed', 403, 'Pesanan belum selesai.');
        abort_if(! is_null($order->testimonial), 403, 'Testimoni sudah pernah dikirim.');

        $request->validate([
            'rating'    => 'required|integer|min:1|max:5',
            'comment'   => 'required|string|min:10|max:1000',
            'images.*'  => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
        ], [
            'rating.required'   => 'Pilih rating bintang terlebih dahulu.',
            'comment.required'  => 'Tulis komentar testimoni Anda.',
            'comment.min'       => 'Komentar minimal 10 karakter.',
            'images.*.image'    => 'File harus berupa gambar.',
            'images.*.max'      => 'Ukuran foto maksimal 2 MB per file.',
        ]);

        $testimonial = Testimonial::create([
            'user_id'  => auth()->id(),
            'order_id' => $order->id,
            'rating'   => $request->rating,
            'comment'  => $request->comment,
            'status'   => 'pending', // menunggu moderasi admin
        ]);

        // Simpan foto (maks 3 foto)
        if ($request->hasFile('images')) {
            foreach (array_slice($request->file('images'), 0, 3) as $i => $file) {
                $path = $file->store('testimonials', 'public');

                TestimonialImage::create([
                    'testimonial_id' => $testimonial->id,
                    'image_path'     => $path,
                    'sort_order'     => $i,
                ]);
            }
        }

        return redirect()->route('pesanan.show', $order_code)
            ->with('success', 'Terima kasih! Testimoni Anda sudah dikirim dan sedang ditinjau oleh tim kami.');
    }
}