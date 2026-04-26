@extends('admin.layouts.app')
@section('title', 'Detail Produk')
@section('breadcrumb')
  <a href="{{ route('admin.produk.index') }}" class="hover:text-gray-900 transition-colors">Produk</a>
  <svg class="w-3 h-3 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
  </svg>
  <span class="text-gray-900 font-semibold">Detail Produk</span>
@endsection

@section('content')

<div class="max-w-4xl">

  {{-- ── Header ── --}}
  <div class="flex items-center justify-between gap-4 mb-6">
    <div class="flex items-center gap-4">
      <a href="{{ route('admin.produk.index') }}"
         class="w-9 h-9 flex items-center justify-center rounded-xl border border-gray-200 text-gray-500 hover:text-gray-900 hover:bg-gray-50 transition-all">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
      </a>
      <h1 class="text-2xl font-black text-gray-900 tracking-tight">Detail Produk</h1>
    </div>
    <div class="flex gap-3">
      <a href="{{ route('admin.produk.edit', $produk) }}"
         class="inline-flex items-center gap-2 px-4 py-2 bg-gray-900 text-white text-sm font-bold rounded-xl hover:bg-emerald-600 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
        </svg>
        Edit
      </a>
    </div>
  </div>

  <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Kolom Foto --}}
    <div class="lg:col-span-1 space-y-4">
      <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden">
        <div class="aspect-square">
          @if($produk->image)
            <img src="{{ Storage::url($produk->image) }}" alt="{{ $produk->name }}"
                 class="w-full h-full object-cover" />
          @else
            <div class="w-full h-full flex items-center justify-center bg-gray-50">
              <svg class="w-12 h-12 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
              </svg>
            </div>
          @endif
        </div>
      </div>

      @if($produk->images->count() > 0)
        <div class="grid grid-cols-3 gap-2">
          @foreach($produk->images->sortBy('sort_order') as $img)
            <div class="aspect-square rounded-xl overflow-hidden border border-gray-100">
              <img src="{{ Storage::url($img->image_path) }}" class="w-full h-full object-cover" />
            </div>
          @endforeach
        </div>
      @endif
    </div>

    {{-- Kolom Detail --}}
    <div class="lg:col-span-2 space-y-5">

      {{-- Info Utama --}}
      <div class="bg-white border border-gray-100 rounded-2xl p-6">
        <div class="flex items-start justify-between gap-4 mb-4">
          <div>
            <p class="text-xs text-gray-400 font-semibold uppercase tracking-widest mb-1">
              {{ $produk->category->name ?? '—' }}
            </p>
            <h2 class="text-2xl font-black text-gray-900 tracking-tight leading-tight">{{ $produk->name }}</h2>
          </div>

          {{-- FIX: Status badge map pakai enum DB: available, sold, hidden --}}
          @php
            $stMap = [
              'available' => ['label' => 'Tersedia',      'class' => 'bg-emerald-100 text-emerald-700'],
              'sold'      => ['label' => 'Terjual',       'class' => 'bg-gray-100 text-gray-600'],
              'hidden'    => ['label' => 'Disembunyikan', 'class' => 'bg-red-100 text-red-600'],
            ];
            $st = $stMap[$produk->status] ?? ['label' => $produk->status, 'class' => 'bg-gray-100 text-gray-600'];
          @endphp
          <span class="shrink-0 px-3 py-1 rounded-full text-xs font-black {{ $st['class'] }}">
            {{ $st['label'] }}
          </span>
        </div>

        <p class="text-3xl font-black text-gray-900 mb-4">
          Rp {{ number_format($produk->price, 0, ',', '.') }}
        </p>

        <div class="grid grid-cols-3 gap-4 py-4 border-t border-b border-gray-100 mb-4">
          <div>
            <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold mb-1">Kondisi</p>
            @php
              $condMap = [
                'like_new' => ['label' => 'Like New', 'class' => 'bg-emerald-100 text-emerald-700'],
                'good'     => ['label' => 'Good',     'class' => 'bg-blue-100 text-blue-700'],
                'fair'     => ['label' => 'Fair',     'class' => 'bg-orange-100 text-orange-700'],
              ];
              $cond = $condMap[$produk->condition] ?? ['label' => $produk->condition, 'class' => 'bg-gray-100 text-gray-600'];
            @endphp
            <span class="px-2.5 py-1 rounded-full text-xs font-bold {{ $cond['class'] }}">
              {{ $cond['label'] }}
            </span>
          </div>
          <div>
            <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold mb-1">Stok</p>
            <p class="text-lg font-black {{ $produk->stock === 0 ? 'text-red-500' : 'text-gray-900' }}">
              {{ $produk->stock }}
            </p>
          </div>
          <div>
            <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold mb-1">Berat</p>
            <p class="text-lg font-black text-gray-900">{{ $produk->weight }}g</p>
          </div>
        </div>

        <div>
          <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold mb-2">Deskripsi</p>
          <p class="text-sm text-gray-600 leading-relaxed whitespace-pre-line">{{ $produk->description }}</p>
        </div>

        @if($produk->condition_notes)
          <div class="mt-4 p-3 bg-amber-50 border border-amber-200 rounded-xl">
            <p class="text-[10px] text-amber-700 uppercase tracking-widest font-bold mb-1">Catatan Kondisi</p>
            <p class="text-sm text-amber-800 leading-relaxed">{{ $produk->condition_notes }}</p>
          </div>
        @endif
      </div>

      {{-- Meta --}}
      <div class="bg-white border border-gray-100 rounded-2xl p-6">
        <h3 class="text-sm font-black text-gray-900 uppercase tracking-widest mb-4">Informasi Sistem</h3>
        <div class="grid grid-cols-2 gap-4 text-sm">
          <div>
            <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold mb-1">ID Produk</p>
            <p class="font-bold text-gray-700">#{{ $produk->id }}</p>
          </div>
          <div>
            <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold mb-1">Slug</p>
            <p class="font-mono text-xs text-gray-500 break-all">{{ $produk->slug }}</p>
          </div>
          <div>
            <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold mb-1">Dibuat</p>
            <p class="text-gray-700">{{ $produk->created_at->format('d M Y, H:i') }}</p>
          </div>
          <div>
            <p class="text-[10px] text-gray-400 uppercase tracking-widest font-bold mb-1">Diperbarui</p>
            <p class="text-gray-700">{{ $produk->updated_at->format('d M Y, H:i') }}</p>
          </div>
        </div>
      </div>

      {{-- Danger Zone --}}
      <div class="bg-white border border-red-100 rounded-2xl p-6">
        <h3 class="text-sm font-black text-red-600 uppercase tracking-widest mb-2">Danger Zone</h3>
        <p class="text-xs text-gray-500 mb-4">Tindakan ini tidak dapat dibatalkan. Semua foto akan ikut terhapus.</p>
        <button onclick="confirmDelete('{{ route('admin.produk.destroy', $produk) }}', '{{ addslashes($produk->name) }}')"
                class="inline-flex items-center gap-2 px-4 py-2 bg-red-50 text-red-600 text-sm font-bold rounded-xl border border-red-200 hover:bg-red-600 hover:text-white transition-all duration-200">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
          </svg>
          Hapus Produk Ini
        </button>
      </div>

    </div>
  </div>
</div>

{{-- Delete Modal --}}
<div id="delete-modal" class="fixed inset-0 bg-black/50 z-50 hidden items-center justify-center p-4">
  <div class="bg-white rounded-2xl p-6 max-w-sm w-full shadow-2xl">
    <div class="w-12 h-12 bg-red-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
      <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
      </svg>
    </div>
    <h3 class="text-lg font-black text-gray-900 text-center mb-1">Hapus Produk?</h3>
    <p id="delete-modal-desc" class="text-sm text-gray-500 text-center mb-6 leading-relaxed"></p>
    <div class="flex gap-3">
      <button onclick="closeDeleteModal()"
              class="flex-1 py-2.5 text-sm font-bold text-gray-600 bg-gray-100 rounded-xl hover:bg-gray-200 transition-colors">
        Batal
      </button>
      <form id="delete-form" method="POST" class="flex-1">
        @csrf
        @method('DELETE')
        <button type="submit"
                class="w-full py-2.5 text-sm font-bold text-white bg-red-600 rounded-xl hover:bg-red-700 transition-colors">
          Hapus
        </button>
      </form>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
  function confirmDelete(url, name) {
    document.getElementById('delete-form').action = url;
    document.getElementById('delete-modal-desc').textContent =
      `Produk "${name}" akan dihapus permanen beserta semua fotonya.`;
    document.getElementById('delete-modal').classList.remove('hidden');
    document.getElementById('delete-modal').classList.add('flex');
  }
  function closeDeleteModal() {
    document.getElementById('delete-modal').classList.add('hidden');
    document.getElementById('delete-modal').classList.remove('flex');
  }
  document.getElementById('delete-modal').addEventListener('click', function(e) {
    if (e.target === this) closeDeleteModal();
  });
</script>
@endpush