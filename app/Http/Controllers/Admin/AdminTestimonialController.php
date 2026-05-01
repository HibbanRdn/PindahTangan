<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class AdminTestimonialController extends Controller
{
    /**
     * Daftar semua testimoni — bisa filter by status.
     */
    public function index(Request $request)
    {
        $query = Testimonial::with(['user', 'order.items', 'images'])
            ->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $testimonials = $query->paginate(15)->withQueryString();

        $counts = [
            'all'      => Testimonial::count(),
            'pending'  => Testimonial::where('status', 'pending')->count(),
            'approved' => Testimonial::where('status', 'approved')->count(),
            'rejected' => Testimonial::where('status', 'rejected')->count(),
        ];

        return view('admin.testimoni.index', compact('testimonials', 'counts'));
    }

    /**
     * Approve testimoni.
     */
    public function approve(int $id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->update(['status' => 'approved']);

        return back()->with('success', 'Testimoni berhasil di-approve.');
    }

    /**
     * Reject testimoni.
     */
    public function reject(int $id)
    {
        $testimonial = Testimonial::findOrFail($id);
        $testimonial->update(['status' => 'rejected']);

        return back()->with('success', 'Testimoni berhasil di-reject.');
    }
}