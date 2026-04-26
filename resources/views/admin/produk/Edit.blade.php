@extends('admin.layouts.app')
@section('title', 'Edit Produk')
@section('breadcrumb')
  <a href="{{ route('admin.produk.index') }}" class="hover:text-gray-900 transition-colors">Produk</a>
  <svg class="w-3 h-3 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
  </svg>
  <span class="text-gray-900 font-semibold">Edit Produk</span>
@endsection

@section('content')

<div class="max-w-4xl">

  {{-- ── Header ── --}}
  <div class="flex items-center gap-4 mb-6">
    <a href="{{ route('admin.produk.index') }}"
       class="w-9 h-9 flex items-center justify-center rounded-xl border border-gray-200 text-gray-500 hover:text-gray-900 hover:bg-gray-50 transition-all">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
      </svg>
    </a>
    <div>
      <h1 class="text-2xl font-black text-gray-900 tracking-tight">Edit Produk</h1>
      <p class="text-gray-500 text-sm mt-0.5 line-clamp-1">{{ $produk->name }}</p>
    </div>
  </div>

  {{-- ── Form ── --}}
  <form method="POST" action="{{ route('admin.produk.update', $produk) }}" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

      {{-- Kolom Utama (2/3) --}}
      <div class="lg:col-span-2 space-y-5">

        {{-- Informasi Dasar --}}
        <div class="bg-white border border-gray-100 rounded-2xl p-6">
          <h2 class="text-sm font-black text-gray-900 uppercase tracking-widest mb-5">Informasi Produk</h2>

          <div class="mb-4">
            <label for="name" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
              Nama Produk <span class="text-red-500">*</span>
            </label>
            <input type="text" id="name" name="name" value="{{ old('name', $produk->name) }}"
                   class="w-full px-4 py-2.5 border rounded-xl text-sm focus:outline-none transition
                          {{ $errors->has('name') ? 'border-red-400 focus:border-red-500 focus:ring-2 focus:ring-red-100' : 'border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100' }}" />
            @error('name')
              <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
            @enderror
          </div>

          <div class="mb-4">
            <label for="category_id" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
              Kategori <span class="text-red-500">*</span>
            </label>
            <select id="category_id" name="category_id"
                    class="w-full px-4 py-2.5 border rounded-xl text-sm focus:outline-none transition
                           {{ $errors->has('category_id') ? 'border-red-400' : 'border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100' }}">
              <option value="">-- Pilih Kategori --</option>
              @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ old('category_id', $produk->category_id) == $cat->id ? 'selected' : '' }}>
                  {{ $cat->name }}
                </option>
              @endforeach
            </select>
            @error('category_id')
              <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label for="description" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
              Deskripsi <span class="text-red-500">*</span>
            </label>
            <textarea id="description" name="description" rows="5"
                      class="w-full px-4 py-2.5 border rounded-xl text-sm focus:outline-none transition resize-none
                             {{ $errors->has('description') ? 'border-red-400' : 'border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100' }}">{{ old('description', $produk->description) }}</textarea>
            @error('description')
              <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
            @enderror
          </div>
        </div>

        {{-- Kondisi --}}
        <div class="bg-white border border-gray-100 rounded-2xl p-6">
          <h2 class="text-sm font-black text-gray-900 uppercase tracking-widest mb-5">Kondisi Barang</h2>

          <div class="grid grid-cols-3 gap-3 mb-4">
            {{-- Logika diperbaiki: Menggunakan class Tailwind utuh agar tidak error saat di-compile --}}
            @foreach([
              ['value'=>'like_new','label'=>'Like New','desc'=>'Hampir sempurna','classes'=>'peer-checked:border-emerald-500 peer-checked:bg-emerald-50 hover:border-emerald-300'],
              ['value'=>'good',    'label'=>'Good',    'desc'=>'Bekas, layak pakai','classes'=>'peer-checked:border-blue-500 peer-checked:bg-blue-50 hover:border-blue-300'],
              ['value'=>'fair',    'label'=>'Fair',    'desc'=>'Ada cacat minor','classes'=>'peer-checked:border-orange-500 peer-checked:bg-orange-50 hover:border-orange-300'],
            ] as $opt)
              <label class="relative cursor-pointer">
                <input type="radio" name="condition" value="{{ $opt['value'] }}"
                       {{ old('condition', $produk->condition) === $opt['value'] ? 'checked' : '' }}
                       class="sr-only peer" />
                <div class="border-2 rounded-xl p-3 text-center transition-all duration-200 border-gray-200 {{ $opt['classes'] }}">
                  <p class="text-sm font-black text-gray-900">{{ $opt['label'] }}</p>
                  <p class="text-[10px] text-gray-400 mt-0.5">{{ $opt['desc'] }}</p>
                </div>
              </label>
            @endforeach
          </div>

          <div>
            <label for="condition_notes" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
              Catatan Kondisi <span class="text-gray-400 font-normal normal-case">(opsional)</span>
            </label>
            <textarea id="condition_notes" name="condition_notes" rows="2"
                      class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition resize-none">{{ old('condition_notes', $produk->condition_notes) }}</textarea>
          </div>
        </div>

        {{-- Foto Tambahan --}}
        <div class="bg-white border border-gray-100 rounded-2xl p-6">
          <h2 class="text-sm font-black text-gray-900 uppercase tracking-widest mb-1">Foto Tambahan</h2>
          <p class="text-xs text-gray-400 mb-4">Centang foto untuk menghapus. Tambah foto baru di bawah.</p>

          {{-- Foto tambahan yang sudah ada --}}
          @if($produk->images && $produk->images->count() > 0)
            <div class="grid grid-cols-4 gap-3 mb-4">
              @foreach($produk->images->sortBy('sort_order') as $img)
                <label class="relative cursor-pointer group">
                  <input type="checkbox" name="delete_images[]" value="{{ $img->id }}"
                         class="sr-only peer" />
                  <div class="aspect-square rounded-xl overflow-hidden border-2 border-transparent
                              peer-checked:border-red-500 transition-all duration-200 relative">
                    <img src="{{ Storage::url($img->image_path) }}" class="w-full h-full object-cover" />
                    {{-- Overlay hapus --}}
                    <div class="absolute inset-0 bg-red-500/0 peer-checked:bg-red-500/40 group-hover:bg-black/20
                                transition-all duration-200 flex items-center justify-center">
                      <svg class="w-5 h-5 text-white opacity-0 peer-checked:opacity-100 group-hover:opacity-60 transition-opacity"
                           fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                      </svg>
                    </div>
                  </div>
                  <p class="text-[9px] text-center text-gray-400 mt-1 peer-checked:text-red-500 font-semibold">
                    <span class="peer-checked:block hidden">Hapus</span>
                    <span class="peer-checked:hidden">#{{ $loop->iteration }}</span>
                  </p>
                </label>
              @endforeach
            </div>
            <p class="text-[10px] text-amber-600 bg-amber-50 border border-amber-200 rounded-lg px-3 py-2 mb-4">
              ⚠️ Centang foto di atas untuk menghapusnya saat disimpan.
            </p>
          @endif

          {{-- Upload foto baru --}}
          <div id="gallery-dropzone"
               class="border-2 border-dashed border-gray-200 rounded-xl p-5 text-center hover:border-emerald-400 hover:bg-emerald-50/30 transition-all duration-200 cursor-pointer"
               onclick="document.getElementById('images-input').click()">
            <svg class="w-6 h-6 text-gray-300 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 4v16m8-8H4"/>
            </svg>
            <p class="text-xs text-gray-400">Klik untuk tambah foto baru</p>
          </div>
          <input type="file" id="images-input" name="images[]" multiple accept="image/*" class="hidden"
                 onchange="previewGallery(this)" />
          <div id="gallery-preview" class="grid grid-cols-4 gap-3 mt-3 hidden"></div>
        </div>

      </div>

      {{-- Kolom Sidebar (1/3) --}}
      <div class="space-y-5">

        {{-- Foto Utama --}}
        <div class="bg-white border border-gray-100 rounded-2xl p-6">
          <h2 class="text-sm font-black text-gray-900 uppercase tracking-widest mb-1">Foto Utama</h2>
          <p class="text-xs text-gray-400 mb-4">Kosongkan jika tidak ingin mengganti</p>

          <div id="main-image-preview"
               class="w-full aspect-square rounded-xl border-2 border-gray-200 overflow-hidden cursor-pointer hover:opacity-90 transition-opacity relative group"
               onclick="document.getElementById('main-image-input').click()">
            @if($produk->image)
              <img src="{{ Storage::url($produk->image) }}" class="w-full h-full object-cover" />
              <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-all flex items-center justify-center">
                <svg class="w-6 h-6 text-white opacity-0 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                </svg>
              </div>
            @else
              <div class="w-full h-full flex flex-col items-center justify-center">
                <svg class="w-8 h-8 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                <p class="text-xs text-gray-400">Upload foto utama</p>
              </div>
            @endif
          </div>
          <input type="file" id="main-image-input" name="image" accept="image/*" class="hidden"
                 onchange="previewMainImage(this)" />
          @error('image')
            <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
          @enderror
        </div>

        {{-- Harga & Logistik --}}
        <div class="bg-white border border-gray-100 rounded-2xl p-6">
          <h2 class="text-sm font-black text-gray-900 uppercase tracking-widest mb-5">Harga & Logistik</h2>

          <div class="mb-4">
            <label for="price" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
              Harga (Rp) <span class="text-red-500">*</span>
            </label>
            <div class="relative">
              <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm font-bold text-gray-400">Rp</span>
              {{-- Logika diperbaiki: Memaksa casting jadi int untuk menghindari angka desimal .00 --}}
              <input type="number" id="price" name="price" value="{{ old('price', (int) $produk->price) }}"
                     min="0" step="500"
                     class="w-full pl-10 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition" />
            </div>
            @error('price')
              <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
            @enderror
          </div>

          <div class="mb-4">
            <label for="weight" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
              Berat (gram) <span class="text-red-500">*</span>
            </label>
            <div class="relative">
              <input type="number" id="weight" name="weight" value="{{ old('weight', $produk->weight) }}"
                     min="1"
                     class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition" />
              <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-gray-400">gram</span>
            </div>
          </div>

          <div>
            <label for="stock" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
              Stok <span class="text-red-500">*</span>
            </label>
            <input type="number" id="stock" name="stock" value="{{ old('stock', $produk->stock) }}"
                   min="0" max="999"
                   class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition" />
          </div>
        </div>

        {{-- Status --}}
        <div class="bg-white border border-gray-100 rounded-2xl p-6">
          <h2 class="text-sm font-black text-gray-900 uppercase tracking-widest mb-4">Status Produk</h2>

          <div class="space-y-2">
            {{-- Logika diperbaiki: Mengubah value dan menulis class Tailwind secara penuh --}}
            @foreach([
              ['value'=>'available', 'label'=>'Aktif',    'desc'=>'Tampil di katalog',        'active_classes'=>'border-emerald-400 bg-emerald-50'],
              ['value'=>'sold',      'label'=>'Terjual',  'desc'=>'Tandai sudah terjual',     'active_classes'=>'border-gray-400 bg-gray-50'],
              ['value'=>'hidden',    'label'=>'Nonaktif', 'desc'=>'Sembunyikan dari katalog', 'active_classes'=>'border-red-400 bg-red-50'],
            ] as $opt)
              @php $isChecked = old('status', $produk->status) === $opt['value']; @endphp
              <label class="flex items-center gap-3 p-3 rounded-xl border-2 cursor-pointer transition-all duration-200
                            {{ $isChecked ? $opt['active_classes'] : 'border-gray-100 hover:border-gray-200' }}">
                <input type="radio" name="status" value="{{ $opt['value'] }}"
                       {{ $isChecked ? 'checked' : '' }}
                       class="accent-emerald-600" />
                <div>
                  <p class="text-sm font-bold text-gray-900">{{ $opt['label'] }}</p>
                  <p class="text-[10px] text-gray-400">{{ $opt['desc'] }}</p>
                </div>
              </label>
            @endforeach
          </div>
        </div>

        {{-- Submit --}}
        <div class="flex flex-col gap-3">
          <button type="submit"
                  class="w-full py-3 bg-gray-900 text-white text-sm font-bold rounded-xl hover:bg-emerald-600 transition-colors duration-200 shadow-sm">
            Simpan Perubahan
          </button>
          <a href="{{ route('admin.produk.index') }}"
             class="w-full py-3 bg-gray-100 text-gray-600 text-sm font-bold rounded-xl hover:bg-gray-200 transition-colors text-center">
            Batal
          </a>
        </div>

      </div>
    </div>
  </form>
</div>

@endsection

@push('scripts')
<script>
  // Script untuk preview gambar tetap dipertahankan karena fungsinya baik
  function previewMainImage(input) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
      document.getElementById('main-image-preview').innerHTML =
        `<img src="${e.target.result}" class="w-full h-full object-cover" />`;
    };
    reader.readAsDataURL(input.files[0]);
  }

  function previewGallery(input) {
    const preview = document.getElementById('gallery-preview');
    preview.innerHTML = '';
    if (!input.files || input.files.length === 0) { preview.classList.add('hidden'); return; }
    preview.classList.remove('hidden');
    Array.from(input.files).slice(0, 5).forEach(file => {
      const reader = new FileReader();
      reader.onload = e => {
        const div = document.createElement('div');
        div.className = 'aspect-square rounded-xl overflow-hidden bg-gray-100 border border-emerald-200';
        div.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover" />`;
        preview.appendChild(div);
      };
      reader.readAsDataURL(file);
    });
  }
</script>
@endpush