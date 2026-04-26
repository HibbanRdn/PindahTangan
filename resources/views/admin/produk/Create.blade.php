@extends('admin.layouts.app')
@section('title', 'Tambah Produk')
@section('breadcrumb')
  <a href="{{ route('admin.produk.index') }}" class="hover:text-gray-900 transition-colors">Produk</a>
  <svg class="w-3 h-3 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
  </svg>
  <span class="text-gray-900 font-semibold">Tambah Produk</span>
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
      <h1 class="text-2xl font-black text-gray-900 tracking-tight">Tambah Produk</h1>
      <p class="text-gray-500 text-sm mt-0.5">Isi semua informasi produk dengan lengkap</p>
    </div>
  </div>

  {{-- ── Form ── --}}
  <form method="POST" action="{{ route('admin.produk.store') }}" enctype="multipart/form-data" id="product-form">
    @csrf

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

      {{-- Kolom Utama (2/3) --}}
      <div class="lg:col-span-2 space-y-5">

        {{-- Informasi Dasar --}}
        <div class="bg-white border border-gray-100 rounded-2xl p-6">
          <h2 class="text-sm font-black text-gray-900 uppercase tracking-widest mb-5">Informasi Produk</h2>

          {{-- Nama --}}
          <div class="mb-4">
            <label for="name" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
              Nama Produk <span class="text-red-500">*</span>
            </label>
            <input type="text" id="name" name="name" value="{{ old('name') }}"
                   placeholder="contoh: Sony WH-1000XM4"
                   class="w-full px-4 py-2.5 border rounded-xl text-sm focus:outline-none transition
                          {{ $errors->has('name') ? 'border-red-400 focus:border-red-500 focus:ring-2 focus:ring-red-100' : 'border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100' }}" />
            @error('name')
              <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                {{ $message }}
              </p>
            @enderror
          </div>

          {{-- Kategori --}}
          <div class="mb-4">
            <label for="category_id" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
              Kategori <span class="text-red-500">*</span>
            </label>
            <select id="category_id" name="category_id"
                    class="w-full px-4 py-2.5 border rounded-xl text-sm focus:outline-none transition
                           {{ $errors->has('category_id') ? 'border-red-400 focus:border-red-500 focus:ring-2 focus:ring-red-100' : 'border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100' }}">
              <option value="">-- Pilih Kategori --</option>
              @foreach($categories as $cat)
                <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                  {{ $cat->name }}
                </option>
              @endforeach
            </select>
            @error('category_id')
              <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
            @enderror
          </div>

          {{-- Deskripsi --}}
          <div>
            <label for="description" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
              Deskripsi <span class="text-red-500">*</span>
            </label>
            <textarea id="description" name="description" rows="5"
                      placeholder="Deskripsikan produk secara detail — merek, ukuran, warna, kelengkapan, riwayat penggunaan, dll."
                      class="w-full px-4 py-2.5 border rounded-xl text-sm focus:outline-none transition resize-none
                             {{ $errors->has('description') ? 'border-red-400 focus:border-red-500 focus:ring-2 focus:ring-red-100' : 'border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100' }}">{{ old('description') }}</textarea>
            @error('description')
              <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
            @enderror
          </div>
        </div>

        {{-- Kondisi --}}
        <div class="bg-white border border-gray-100 rounded-2xl p-6">
          <h2 class="text-sm font-black text-gray-900 uppercase tracking-widest mb-5">Kondisi Barang</h2>

          <div class="grid grid-cols-3 gap-3 mb-4">
            @foreach([
              ['value'=>'like_new','label'=>'Like New','desc'=>'Hampir sempurna',    'classes'=>'peer-checked:border-emerald-500 peer-checked:bg-emerald-50 hover:border-emerald-300'],
              ['value'=>'good',    'label'=>'Good',    'desc'=>'Bekas, layak pakai', 'classes'=>'peer-checked:border-blue-500 peer-checked:bg-blue-50 hover:border-blue-300'],
              ['value'=>'fair',    'label'=>'Fair',    'desc'=>'Ada cacat minor',    'classes'=>'peer-checked:border-orange-500 peer-checked:bg-orange-50 hover:border-orange-300'],
            ] as $opt)
              <label class="relative cursor-pointer">
                <input type="radio" name="condition" value="{{ $opt['value'] }}"
                       {{ old('condition') === $opt['value'] ? 'checked' : '' }}
                       class="sr-only peer" />
                <div class="border-2 rounded-xl p-3 text-center transition-all duration-200 border-gray-200 {{ $opt['classes'] }}">
                  <p class="text-sm font-black text-gray-900">{{ $opt['label'] }}</p>
                  <p class="text-[10px] text-gray-400 mt-0.5">{{ $opt['desc'] }}</p>
                </div>
              </label>
            @endforeach
          </div>
          @error('condition')
            <p class="mt-1 text-xs text-red-500">{{ $message }}</p>
          @enderror

          <div class="mt-4">
            <label for="condition_notes" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
              Catatan Kondisi
              <span class="text-gray-400 font-normal normal-case ml-1">(opsional — deskripsikan cacat/kekurangan secara jujur)</span>
            </label>
            <textarea id="condition_notes" name="condition_notes" rows="2"
                      placeholder="contoh: ada goresan kecil di sudut kanan bawah, strap original masih ada..."
                      class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition resize-none">{{ old('condition_notes') }}</textarea>
            @error('condition_notes')
              <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
            @enderror
          </div>
        </div>

        {{-- Foto Tambahan --}}
        <div class="bg-white border border-gray-100 rounded-2xl p-6">
          <h2 class="text-sm font-black text-gray-900 uppercase tracking-widest mb-1">Foto Tambahan</h2>
          <p class="text-xs text-gray-400 mb-4">Maks. 5 foto (JPG/PNG/WEBP, maks. 3MB/foto)</p>

          <div id="gallery-dropzone"
               class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center hover:border-emerald-400 hover:bg-emerald-50/30 transition-all duration-200 cursor-pointer"
               onclick="document.getElementById('images-input').click()">
            <svg class="w-8 h-8 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <p class="text-sm text-gray-400">Klik untuk upload foto tambahan</p>
          </div>
          <input type="file" id="images-input" name="images[]" multiple accept="image/*" class="hidden"
                 onchange="previewGallery(this)" />

          <div id="gallery-preview" class="grid grid-cols-4 gap-3 mt-3 hidden"></div>

          @error('images')
            <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
          @enderror
          @error('images.*')
            <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
          @enderror
        </div>

      </div>

      {{-- Kolom Sidebar (1/3) --}}
      <div class="space-y-5">

        {{-- Foto Utama --}}
        <div class="bg-white border border-gray-100 rounded-2xl p-6">
          <h2 class="text-sm font-black text-gray-900 uppercase tracking-widest mb-1">Foto Utama</h2>
          <p class="text-xs text-gray-400 mb-4">JPG/PNG/WEBP, maks. 3MB <span class="text-red-500">*</span></p>

          <div id="main-image-preview"
               class="w-full aspect-square rounded-xl border-2 border-dashed border-gray-200 flex flex-col items-center justify-center cursor-pointer hover:border-emerald-400 hover:bg-emerald-50/30 transition-all duration-200 overflow-hidden"
               onclick="document.getElementById('main-image-input').click()">
            <svg class="w-8 h-8 text-gray-300 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            <p class="text-xs text-gray-400 text-center px-4">Klik untuk upload foto utama</p>
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
              <input type="number" id="price" name="price" value="{{ old('price') }}"
                     placeholder="0" min="0" step="500"
                     class="w-full pl-10 pr-4 py-2.5 border rounded-xl text-sm focus:outline-none transition
                            {{ $errors->has('price') ? 'border-red-400 focus:border-red-500 focus:ring-2 focus:ring-red-100' : 'border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100' }}" />
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
              <input type="number" id="weight" name="weight" value="{{ old('weight') }}"
                     placeholder="contoh: 500" min="1"
                     class="w-full px-4 py-2.5 border rounded-xl text-sm focus:outline-none transition
                            {{ $errors->has('weight') ? 'border-red-400' : 'border-gray-200 focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100' }}" />
              <span class="absolute right-3 top-1/2 -translate-y-1/2 text-xs text-gray-400">gram</span>
            </div>
            @error('weight')
              <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
            @enderror
          </div>

          <div>
            <label for="stock" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
              Stok <span class="text-red-500">*</span>
            </label>
            <input type="number" id="stock" name="stock" value="{{ old('stock', 1) }}"
                   min="0" max="999"
                   class="w-full px-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition" />
            @error('stock')
              <p class="mt-1.5 text-xs text-red-500">{{ $message }}</p>
            @enderror
          </div>
        </div>

        {{-- FIX: Status Produk — value pakai enum DB: available, hidden --}}
        <div class="bg-white border border-gray-100 rounded-2xl p-6">
          <h2 class="text-sm font-black text-gray-900 uppercase tracking-widest mb-4">Status Produk</h2>

          <div class="space-y-2">
            @foreach([
              ['value'=>'available','label'=>'Tersedia',      'desc'=>'Tampil di katalog',        'active_classes'=>'border-emerald-400 bg-emerald-50'],
              ['value'=>'hidden',   'label'=>'Disembunyikan', 'desc'=>'Sembunyikan dari katalog', 'active_classes'=>'border-red-400 bg-red-50'],
            ] as $opt)
              @php $isChecked = old('status', 'available') === $opt['value']; @endphp
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

          @error('status')
            <p class="mt-2 text-xs text-red-500">{{ $message }}</p>
          @enderror
        </div>

        {{-- Submit --}}
        <div class="flex flex-col gap-3">
          <button type="submit"
                  class="w-full py-3 bg-gray-900 text-white text-sm font-bold rounded-xl hover:bg-emerald-600 transition-colors duration-200 shadow-sm">
            Simpan Produk
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
  function previewMainImage(input) {
    if (!input.files || !input.files[0]) return;
    const reader = new FileReader();
    reader.onload = e => {
      const preview = document.getElementById('main-image-preview');
      preview.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover" />`;
    };
    reader.readAsDataURL(input.files[0]);
  }

  function previewGallery(input) {
    const preview = document.getElementById('gallery-preview');
    preview.innerHTML = '';
    if (!input.files || input.files.length === 0) {
      preview.classList.add('hidden');
      return;
    }
    preview.classList.remove('hidden');
    Array.from(input.files).slice(0, 5).forEach(file => {
      const reader = new FileReader();
      reader.onload = e => {
        const div = document.createElement('div');
        div.className = 'aspect-square rounded-xl overflow-hidden bg-gray-100 border border-gray-200';
        div.innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover" />`;
        preview.appendChild(div);
      };
      reader.readAsDataURL(file);
    });
  }

  const dropzone = document.getElementById('gallery-dropzone');
  ['dragenter','dragover'].forEach(ev => {
    dropzone.addEventListener(ev, e => {
      e.preventDefault();
      dropzone.classList.add('border-emerald-400','bg-emerald-50');
    });
  });
  ['dragleave','drop'].forEach(ev => {
    dropzone.addEventListener(ev, e => {
      e.preventDefault();
      dropzone.classList.remove('border-emerald-400','bg-emerald-50');
    });
  });
  dropzone.addEventListener('drop', e => {
    const input = document.getElementById('images-input');
    input.files = e.dataTransfer.files;
    previewGallery(input);
  });
</script>
@endpush