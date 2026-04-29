<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * Halaman katalog produk.
     * Hanya tampilkan produk dengan status 'available'.
     */
    public function index(Request $request)
    {
        $query = Product::with('category')
            ->where('status', 'available')
            ->latest();

        // Filter: pencarian nama
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter: kategori
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Filter: kondisi
        if ($request->filled('condition')) {
            $query->where('condition', $request->condition);
        }

        // Sorting
        $sort = $request->get('sort', 'latest');
        match ($sort) {
            'price_asc'  => $query->reorder('price', 'asc'),
            'price_desc' => $query->reorder('price', 'desc'),
            'name'       => $query->reorder('name', 'asc'),
            default      => $query->reorder('created_at', 'desc'),
        };

        $produk     = $query->paginate(12)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('produk.index', compact('produk', 'categories'));
    }

    /**
     * Halaman detail produk.
     * Produk hidden/sold tetap bisa dilihat via URL langsung,
     * tapi tombol beli dikunci di view.
     */
    public function show(string $slug)
    {
        $produk = Product::with(['category', 'images'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Produk terkait: kategori sama, status available, bukan produk ini
        $related = Product::where('category_id', $produk->category_id)
            ->where('status', 'available')
            ->where('id', '!=', $produk->id)
            ->latest()
            ->take(4)
            ->get();

        return view('produk.show', compact('produk', 'related'));
    }
}