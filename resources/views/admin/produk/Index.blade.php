@extends('admin.layouts.app')
@section('title', 'Kelola Produk')
@section('breadcrumb')
  <span class="text-gray-900 font-semibold">Produk</span>
@endsection

@section('content')

{{-- ── Header ── --}}
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
  <div>
    <h1 class="text-2xl font-black text-gray-900 tracking-tight">Produk</h1>
    <p class="text-gray-500 text-sm mt-0.5">{{ $produk->total() }} produk ditemukan</p>
  </div>
  <a href="{{ route('admin.produk.create') }}"
     class="inline-flex items-center gap-2 px-5 py-2.5 bg-gray-900 text-white text-sm font-bold
            rounded-xl hover:bg-emerald-600 transition-colors duration-200 shadow-sm self-start sm:self-auto">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
    </svg>
    Tambah Produk
  </a>
</div>

{{-- ── Filter Bar ── --}}
<form method="GET" class="bg-white border border-gray-100 rounded-2xl p-4 mb-5 flex flex-wrap gap-3 items-end">
  {{-- Search --}}
  <div class="flex-1 min-w-48">
    <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-1">Cari Produk</label>
    <div class="relative">
      <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
      </svg>
      <input type="text" name="search" value="{{ request('search') }}" placeholder="Nama produk..."
             class="w-full pl-9 pr-4 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition" />
    </div>
  </div>

  {{-- Kategori --}}
  <div class="min-w-36">
    <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-1">Kategori</label>
    <select name="category"
            class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition">
      <option value="">Semua</option>
      @foreach($categories as $cat)
        <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
          {{ $cat->name }}
        </option>
      @endforeach
    </select>
  </div>

  {{-- FIX: Status filter pakai nilai enum DB: available, sold, hidden --}}
  <div class="min-w-32">
    <label class="block text-[10px] font-black uppercase tracking-widest text-gray-400 mb-1">Status</label>
    <select name="status"
            class="w-full px-3 py-2 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition">
      <option value="">Semua</option>
      <option value="available" {{ request('status') === 'available' ? 'selected' : '' }}>Tersedia</option>
      <option value="sold"      {{ request('status') === 'sold'      ? 'selected' : '' }}>Terjual</option>
      <option value="hidden"    {{ request('status') === 'hidden'    ? 'selected' : '' }}>Disembunyikan</option>
    </select>
  </div>

  {{-- Actions --}}
  <div class="flex gap-2">
    <button type="submit"
            class="px-4 py-2 bg-gray-900 text-white text-sm font-bold rounded-xl hover:bg-emerald-600 transition-colors">
      Filter
    </button>
    @if(request()->hasAny(['search','category','status']))
      <a href="{{ route('admin.produk.index') }}"
         class="px-4 py-2 bg-gray-100 text-gray-600 text-sm font-bold rounded-xl hover:bg-gray-200 transition-colors">
        Reset
      </a>
    @endif
  </div>
</form>

{{-- ── Table ── --}}
<div class="bg-white border border-gray-100 rounded-2xl overflow-hidden">
  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead>
        <tr class="border-b border-gray-100 bg-gray-50">
          <th class="text-left px-6 py-3 text-[10px] font-black text-gray-400 uppercase tracking-widest w-12">#</th>
          <th class="text-left px-6 py-3 text-[10px] font-black text-gray-400 uppercase tracking-widest">Produk</th>
          <th class="text-left px-6 py-3 text-[10px] font-black text-gray-400 uppercase tracking-widest">Kategori</th>
          <th class="text-left px-6 py-3 text-[10px] font-black text-gray-400 uppercase tracking-widest">Harga</th>
          <th class="text-left px-6 py-3 text-[10px] font-black text-gray-400 uppercase tracking-widest">Kondisi</th>
          <th class="text-left px-6 py-3 text-[10px] font-black text-gray-400 uppercase tracking-widest">Stok</th>
          <th class="text-left px-6 py-3 text-[10px] font-black text-gray-400 uppercase tracking-widest">Status</th>
          <th class="px-6 py-3"></th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-50">

        @forelse($produk as $p)
          <tr>
            <td class="px-6 py-4 text-gray-400 text-xs">{{ $produk->firstItem() + $loop->index }}</td>

            {{-- Produk --}}
            <td class="px-6 py-4">
              <div class="flex items-center gap-3">
                @if($p->image)
                  <img src="{{ Storage::url($p->image) }}" alt="{{ $p->name }}"
                       class="w-12 h-12 rounded-xl object-cover bg-gray-100 shrink-0" />
                @else
                  <div class="w-12 h-12 rounded-xl bg-gray-100 flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                  </div>
                @endif
                <div class="min-w-0">
                  <p class="font-bold text-gray-900 line-clamp-1">{{ $p->name }}</p>
                  <p class="text-xs text-gray-400 mt-0.5">{{ $p->weight }}g</p>
                </div>
              </div>
            </td>

            {{-- Kategori --}}
            <td class="px-6 py-4 text-gray-600 text-xs">{{ $p->category->name ?? '—' }}</td>

            {{-- Harga --}}
            <td class="px-6 py-4 font-bold text-gray-900">
              Rp {{ number_format($p->price, 0, ',', '.') }}
            </td>

            {{-- Kondisi --}}
            <td class="px-6 py-4">
              @php
                $condMap = [
                  'like_new' => ['label' => 'Like New', 'class' => 'bg-emerald-100 text-emerald-700'],
                  'good'     => ['label' => 'Good',     'class' => 'bg-blue-100 text-blue-700'],
                  'fair'     => ['label' => 'Fair',     'class' => 'bg-orange-100 text-orange-700'],
                ];
                $cond = $condMap[$p->condition] ?? ['label' => $p->condition, 'class' => 'bg-gray-100 text-gray-600'];
              @endphp
              <span class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $cond['class'] }}">
                {{ $cond['label'] }}
              </span>
            </td>

            {{-- Stok --}}
            <td class="px-6 py-4">
              <span class="font-bold {{ $p->stock === 0 ? 'text-red-500' : 'text-gray-900' }}">
                {{ $p->stock }}
              </span>
            </td>

            {{-- FIX: Status badge map pakai enum DB: available, sold, hidden --}}
            <td class="px-6 py-4">
              @php
                $stMap = [
                  'available' => ['label' => 'Tersedia',      'class' => 'bg-emerald-100 text-emerald-700'],
                  'sold'      => ['label' => 'Terjual',       'class' => 'bg-gray-100 text-gray-600'],
                  'hidden'    => ['label' => 'Disembunyikan', 'class' => 'bg-red-100 text-red-600'],
                ];
                $st = $stMap[$p->status] ?? ['label' => $p->status, 'class' => 'bg-gray-100 text-gray-600'];
              @endphp
              <span class="px-2.5 py-1 rounded-full text-[10px] font-bold {{ $st['class'] }}">
                {{ $st['label'] }}
              </span>
            </td>

            {{-- Actions --}}
            <td class="px-6 py-4">
              <div class="flex items-center gap-1 justify-end">
                <a href="{{ route('admin.produk.show', $p) }}"
                   class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:text-blue-600 hover:bg-blue-50 transition-all"
                   title="Detail">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                  </svg>
                </a>
                <a href="{{ route('admin.produk.edit', $p) }}"
                   class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:text-emerald-600 hover:bg-emerald-50 transition-all"
                   title="Edit">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                  </svg>
                </a>
                <button onclick="confirmDelete('{{ route('admin.produk.destroy', $p) }}', '{{ addslashes($p->name) }}')"
                        class="w-8 h-8 rounded-lg flex items-center justify-center text-gray-400 hover:text-red-600 hover:bg-red-50 transition-all"
                        title="Hapus">
                  <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                  </svg>
                </button>
              </div>
            </td>
          </tr>

        @empty
          <tr>
            <td colspan="8" class="px-6 py-20 text-center">
              <svg class="w-10 h-10 mx-auto mb-3 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
              </svg>
              <p class="text-sm font-semibold text-gray-400">Tidak ada produk ditemukan.</p>
              <a href="{{ route('admin.produk.create') }}"
                 class="inline-flex items-center gap-1 mt-3 text-emerald-600 text-xs font-bold hover:underline">
                + Tambah produk baru
              </a>
            </td>
          </tr>
        @endforelse

      </tbody>
    </table>
  </div>

  @if($produk->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">
      {{ $produk->links() }}
    </div>
  @endif
</div>

{{-- Delete Confirmation Modal --}}
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
      `Produk "${name}" akan dihapus permanen beserta semua fotonya. Tindakan ini tidak dapat dibatalkan.`;
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