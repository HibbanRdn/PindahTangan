@extends('admin.layouts.app')
@section('title', 'Dashboard')

@section('content')

{{-- ── Header ── --}}
<div class="mb-8">
  <h1 class="text-2xl font-black text-gray-900 tracking-tight">Dashboard</h1>
  <p class="text-gray-500 text-sm mt-1">Selamat datang, {{ auth()->user()->name }}. Ini ringkasan toko hari ini.</p>
</div>

{{-- ── Stat Cards ── --}}
<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-8">

  {{-- FIX: Ganti 'active' → 'available' sesuai enum DB --}}
  <div class="bg-white border border-gray-100 rounded-2xl p-6 hover:shadow-md transition-shadow duration-200">
    <div class="flex items-start justify-between mb-4">
      <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-xl flex items-center justify-center">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
        </svg>
      </div>
      <span class="text-xs text-emerald-600 bg-emerald-50 px-2 py-0.5 rounded-full font-semibold">Tersedia</span>
    </div>
    <p class="text-3xl font-black text-gray-900">{{ \App\Models\Product::where('status','available')->count() }}</p>
    <p class="text-sm text-gray-400 mt-1">Produk tersedia</p>
  </div>

  {{-- Total Pesanan --}}
  <div class="bg-white border border-gray-100 rounded-2xl p-6 hover:shadow-md transition-shadow duration-200">
    <div class="flex items-start justify-between mb-4">
      <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
      </div>
      <span class="text-xs text-blue-600 bg-blue-50 px-2 py-0.5 rounded-full font-semibold">Total</span>
    </div>
    <p class="text-3xl font-black text-gray-900">{{ \App\Models\Order::count() }}</p>
    <p class="text-sm text-gray-400 mt-1">Total pesanan</p>
  </div>

  {{-- FIX: Pesanan Perlu Diproses — sesuai enum DB (tidak ada 'paid') --}}
  <div class="bg-white border border-gray-100 rounded-2xl p-6 hover:shadow-md transition-shadow duration-200">
    <div class="flex items-start justify-between mb-4">
      <div class="w-10 h-10 bg-orange-100 text-orange-600 rounded-xl flex items-center justify-center">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
      </div>
      <span class="text-xs text-orange-600 bg-orange-50 px-2 py-0.5 rounded-full font-semibold">Proses</span>
    </div>
    <p class="text-3xl font-black text-gray-900">{{ \App\Models\Order::whereIn('status',['pending','processing','shipped'])->count() }}</p>
    <p class="text-sm text-gray-400 mt-1">Perlu diproses</p>
  </div>

  {{-- Total User --}}
  <div class="bg-white border border-gray-100 rounded-2xl p-6 hover:shadow-md transition-shadow duration-200">
    <div class="flex items-start justify-between mb-4">
      <div class="w-10 h-10 bg-purple-100 text-purple-600 rounded-xl flex items-center justify-center">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>
      </div>
      <span class="text-xs text-purple-600 bg-purple-50 px-2 py-0.5 rounded-full font-semibold">Member</span>
    </div>
    <p class="text-3xl font-black text-gray-900">{{ \App\Models\User::where('role','user')->count() }}</p>
    <p class="text-sm text-gray-400 mt-1">Pengguna terdaftar</p>
  </div>

</div>

{{-- ── Produk Terbaru ── --}}
<div class="bg-white border border-gray-100 rounded-2xl overflow-hidden">
  <div class="flex items-center justify-between px-6 py-4 border-b border-gray-100">
    <h2 class="text-sm font-black text-gray-900 uppercase tracking-widest">Produk Terbaru</h2>
    <a href="{{ route('admin.produk.index') }}"
       class="text-xs text-emerald-600 hover:text-emerald-700 font-semibold transition-colors">
      Lihat Semua →
    </a>
  </div>

  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead>
        <tr class="border-b border-gray-100 bg-gray-50">
          <th class="text-left px-6 py-3 text-xs font-black text-gray-400 uppercase tracking-widest">Produk</th>
          <th class="text-left px-6 py-3 text-xs font-black text-gray-400 uppercase tracking-widest">Harga</th>
          <th class="text-left px-6 py-3 text-xs font-black text-gray-400 uppercase tracking-widest">Kondisi</th>
          <th class="text-left px-6 py-3 text-xs font-black text-gray-400 uppercase tracking-widest">Status</th>
          <th class="px-6 py-3"></th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-50">
        @foreach(\App\Models\Product::with('category')->latest()->take(6)->get() as $p)
          <tr>
            <td class="px-6 py-4">
              <div class="flex items-center gap-3">
                @if($p->image)
                  <img src="{{ Storage::url($p->image) }}" alt="{{ $p->name }}"
                       class="w-10 h-10 rounded-xl object-cover bg-gray-100" />
                @else
                  <div class="w-10 h-10 rounded-xl bg-gray-100 flex items-center justify-center">
                    <svg class="w-4 h-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                  </div>
                @endif
                <div>
                  <p class="font-bold text-gray-900 line-clamp-1">{{ $p->name }}</p>
                  <p class="text-xs text-gray-400">{{ $p->category->name ?? '-' }}</p>
                </div>
              </div>
            </td>
            <td class="px-6 py-4 font-bold text-gray-900">
              Rp {{ number_format($p->price, 0, ',', '.') }}
            </td>
            <td class="px-6 py-4">
              @php
                $condMap = [
                  'like_new' => ['label' => 'Like New', 'class' => 'bg-emerald-100 text-emerald-700'],
                  'good'     => ['label' => 'Good',     'class' => 'bg-blue-100 text-blue-700'],
                  'fair'     => ['label' => 'Fair',     'class' => 'bg-orange-100 text-orange-700'],
                ];
                $cond = $condMap[$p->condition] ?? ['label' => $p->condition, 'class' => 'bg-gray-100 text-gray-600'];
              @endphp
              <span class="px-2 py-0.5 rounded-full text-xs font-bold {{ $cond['class'] }}">
                {{ $cond['label'] }}
              </span>
            </td>
            {{-- FIX: Status map pakai enum DB: available, sold, hidden --}}
            <td class="px-6 py-4">
              @php
                $stMap = [
                  'available' => ['label' => 'Tersedia',      'class' => 'bg-emerald-100 text-emerald-700'],
                  'sold'      => ['label' => 'Terjual',       'class' => 'bg-gray-100 text-gray-600'],
                  'hidden'    => ['label' => 'Disembunyikan', 'class' => 'bg-red-100 text-red-600'],
                ];
                $st = $stMap[$p->status] ?? ['label' => $p->status, 'class' => 'bg-gray-100 text-gray-600'];
              @endphp
              <span class="px-2 py-0.5 rounded-full text-xs font-bold {{ $st['class'] }}">
                {{ $st['label'] }}
              </span>
            </td>
            <td class="px-6 py-4 text-right">
              <a href="{{ route('admin.produk.edit', $p) }}"
                 class="text-xs font-semibold text-emerald-600 hover:text-emerald-800 transition-colors">
                Edit
              </a>
            </td>
          </tr>
        @endforeach

        @if(\App\Models\Product::count() === 0)
          <tr>
            <td colspan="5" class="px-6 py-16 text-center text-gray-400">
              <svg class="w-10 h-10 mx-auto mb-3 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
              </svg>
              <p class="text-sm font-semibold">Belum ada produk.</p>
              <a href="{{ route('admin.produk.create') }}"
                 class="inline-flex items-center gap-1 mt-3 text-emerald-600 text-xs font-bold hover:underline">
                + Tambah produk pertama
              </a>
            </td>
          </tr>
        @endif
      </tbody>
    </table>
  </div>
</div>

@endsection