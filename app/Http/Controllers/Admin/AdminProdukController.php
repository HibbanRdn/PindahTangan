<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminProdukController extends Controller
{
    // ── INDEX ────────────────────────────────────────────────────
    public function index(Request $request)
    {
        $query = Product::with('category')->latest();

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $produk     = $query->paginate(15)->withQueryString();
        $categories = Category::orderBy('name')->get();

        return view('admin.produk.index', compact('produk', 'categories'));
    }

    // ── CREATE ───────────────────────────────────────────────────
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.produk.create', compact('categories'));
    }

    // ── STORE ────────────────────────────────────────────────────
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'category_id'     => 'required|exists:categories,id',
            'description'     => 'required|string',
            'condition'       => 'required|in:like_new,good,fair',
            'condition_notes' => 'nullable|string|max:500',
            'price'           => 'required|numeric|min:0',
            'weight'          => 'required|numeric|min:1',
            'stock'           => 'required|integer|min:0',
            // FIX: status enum DB = available, sold, hidden (bukan active/inactive)
            'status'          => 'required|in:available,sold,hidden',
            'image'           => 'required|image|mimes:jpg,jpeg,png,webp|max:3072',
            'images'          => 'nullable|array|max:5',
            'images.*'        => 'image|mimes:jpg,jpeg,png,webp|max:3072',
        ], [
            'image.required' => 'Foto utama produk wajib diunggah.',
            'image.max'      => 'Foto utama maksimal 3MB.',
            'images.max'     => 'Maksimal 5 foto tambahan.',
        ]);

        DB::beginTransaction();

        try {
            $slug      = $this->generateUniqueSlug($request->name);
            $imagePath = $request->file('image')->store('products', 'public');

            $product = Product::create([
                'category_id'     => $validated['category_id'],
                'name'            => $validated['name'],
                'slug'            => $slug,
                'description'     => $validated['description'],
                'condition'       => $validated['condition'],
                'condition_notes' => $validated['condition_notes'] ?? null,
                'price'           => $validated['price'],
                'weight'          => $validated['weight'],
                'stock'           => $validated['stock'],
                'status'          => $validated['status'],
                'image'           => $imagePath,
            ]);

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $index => $img) {
                    $path = $img->store('products/gallery', 'public');
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $path,
                        'sort_order' => $index,
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('admin.produk.index')
                ->with('success', "Produk \"{$product->name}\" berhasil ditambahkan.");

        } catch (\Exception $e) {
            DB::rollBack();
            if (isset($imagePath)) Storage::disk('public')->delete($imagePath);

            return back()->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // ── SHOW ─────────────────────────────────────────────────────
    public function show(Product $produk)
    {
        $produk->load('category', 'images');
        return view('admin.produk.show', compact('produk'));
    }

    // ── EDIT ─────────────────────────────────────────────────────
    public function edit(Product $produk)
    {
        $produk->load('images');
        $categories = Category::orderBy('name')->get();
        return view('admin.produk.edit', compact('produk', 'categories'));
    }

    // ── UPDATE ───────────────────────────────────────────────────
    public function update(Request $request, Product $produk)
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'category_id'     => 'required|exists:categories,id',
            'description'     => 'required|string',
            'condition'       => 'required|in:like_new,good,fair',
            'condition_notes' => 'nullable|string|max:500',
            'price'           => 'required|numeric|min:0',
            'weight'          => 'required|numeric|min:1',
            'stock'           => 'required|integer|min:0',
            // FIX: status enum DB = available, sold, hidden
            'status'          => 'required|in:available,sold,hidden',
            'image'           => 'nullable|image|mimes:jpg,jpeg,png,webp|max:3072',
            'images'          => 'nullable|array|max:5',
            'images.*'        => 'image|mimes:jpg,jpeg,png,webp|max:3072',
            'delete_images'   => 'nullable|array',
            'delete_images.*' => 'integer|exists:product_images,id',
        ]);

        DB::beginTransaction();

        try {
            $data = [
                'category_id'     => $validated['category_id'],
                'name'            => $validated['name'],
                'slug'            => $this->generateUniqueSlug($validated['name'], $produk->id),
                'description'     => $validated['description'],
                'condition'       => $validated['condition'],
                'condition_notes' => $validated['condition_notes'] ?? null,
                'price'           => $validated['price'],
                'weight'          => $validated['weight'],
                'stock'           => $validated['stock'],
                'status'          => $validated['status'],
            ];

            // FIX: Hanya hapus & ganti foto utama jika ada file baru diunggah.
            // Sebelumnya kode selalu menghapus foto lama meskipun tidak ada foto baru.
            if ($request->hasFile('image')) {
                if ($produk->image && Storage::disk('public')->exists($produk->image)) {
                    Storage::disk('public')->delete($produk->image);
                }
                $data['image'] = $request->file('image')->store('products', 'public');
            }

            $produk->update($data);

            // Hapus foto tambahan yang dicentang
            if ($request->filled('delete_images')) {
                $toDelete = ProductImage::whereIn('id', $request->delete_images)
                    ->where('product_id', $produk->id)
                    ->get();

                foreach ($toDelete as $img) {
                    Storage::disk('public')->delete($img->image_path);
                    $img->delete();
                }
            }

            // Upload foto tambahan baru
            if ($request->hasFile('images')) {
                $lastOrder = $produk->images()->max('sort_order') ?? -1;
                foreach ($request->file('images') as $index => $img) {
                    $path = $img->store('products/gallery', 'public');
                    ProductImage::create([
                        'product_id' => $produk->id,
                        'image_path' => $path,
                        'sort_order' => $lastOrder + $index + 1,
                    ]);
                }
            }

            DB::commit();

            return redirect()
                ->route('admin.produk.index')
                ->with('success', "Produk \"{$produk->name}\" berhasil diperbarui.");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    // ── DESTROY ──────────────────────────────────────────────────
    public function destroy(Product $produk)
    {
        DB::beginTransaction();

        try {
            if ($produk->image && Storage::disk('public')->exists($produk->image)) {
                Storage::disk('public')->delete($produk->image);
            }
            foreach ($produk->images as $img) {
                Storage::disk('public')->delete($img->image_path);
            }

            $name = $produk->name;
            $produk->delete();

            DB::commit();

            return redirect()
                ->route('admin.produk.index')
                ->with('success', "Produk \"{$name}\" berhasil dihapus.");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus produk: ' . $e->getMessage());
        }
    }

    // ── HELPER ───────────────────────────────────────────────────
    private function generateUniqueSlug(string $name, ?int $excludeId = null): string
    {
        $slug  = Str::slug($name);
        $base  = $slug;
        $count = 1;

        while (true) {
            $query = Product::where('slug', $slug);
            if ($excludeId) $query->where('id', '!=', $excludeId);
            if (! $query->exists()) break;
            $slug = $base . '-' . $count++;
        }

        return $slug;
    }
}