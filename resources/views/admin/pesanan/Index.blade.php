@extends('admin.layouts.app')
@section('title', 'Kelola Pesanan')
@section('breadcrumb')
  <span class="text-gray-900 font-semibold">Pesanan</span>
@endsection

@section('content')

{{-- ── Header ── --}}
<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
  <div>
    <h1 class="text-2xl font-black text-gray-900 tracking-tight">Pesanan</h1>
    <p class="text-gray-500 text-sm mt-0.5">{{ $pesanan->total() }} pesanan ditemukan</p>
  </div>
</div>

{{-- ── Status Counter Tabs ── --}}
{{-- FIX: Hapus tab 'paid' — tidak ada di enum orders.status di DB.
     Enum DB: pending, processing, shipped, completed, cancelled --}}
<div class="flex flex-wrap gap-2 mb-5">
  @php
    $tabs = [
      ''            => 'Semua',
      'pending'     => 'Pending',
      'processing'  => 'Diproses',
      'shipped'     => 'Dikirim',
      'completed'   => 'Selesai',
      'cancelled'   => 'Dibatalkan',
    ];
  @endphp
  @foreach($tabs as $val => $label)
    <a href="{{ route('admin.pesanan.index', array_merge(request()->query(), ['status' => $val])) }}"
       class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-bold transition-all duration-200
              {{ request('status', '') === $val
                 ? 'bg-gray-900 text-white shadow-sm'
                 : 'bg-white border border-gray-200 text-gray-500 hover:border-gray-400 hover:text-gray-900' }}">
      {{ $label }}
      @if($val && ($counts[$val] ?? 0) > 0)
        <span class="px-1.5 py-0.5 rounded-full text-[9px] font-black
               {{ request('status') === $val ? 'bg-white/20 text-white' : 'bg-gray-100 text-gray-600' }}">
          {{ $counts[$val] }}
        </span>
      @endif
    </a>
  @endforeach
</div>

{{-- ── Search Bar ── --}}
<form method="GET" class="bg-white border border-gray-100 rounded-2xl p-4 mb-5 flex gap-3">
  <input type="hidden" name="status" value="{{ request('status') }}" />
  <div class="flex-1 relative">
    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400"
         fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
    </svg>
    <input type="text" name="search" value="{{ request('search') }}"
           placeholder="Cari kode pesanan atau nama pembeli..."
           class="w-full pl-9 pr-4 py-2.5 border border-gray-200 rounded-xl text-sm focus:outline-none focus:border-emerald-500 focus:ring-2 focus:ring-emerald-100 transition" />
  </div>
  <button type="submit"
          class="px-4 py-2 bg-gray-900 text-white text-sm font-bold rounded-xl hover:bg-emerald-600 transition-colors">
    Cari
  </button>
  @if(request()->hasAny(['search']))
    <a href="{{ route('admin.pesanan.index', request()->only('status')) }}"
       class="px-4 py-2 bg-gray-100 text-gray-600 text-sm font-bold rounded-xl hover:bg-gray-200 transition-colors">
      Reset
    </a>
  @endif
</form>

{{-- ── Table ── --}}
<div class="bg-white border border-gray-100 rounded-2xl overflow-hidden">
  <div class="overflow-x-auto">
    <table class="w-full text-sm">
      <thead>
        <tr class="border-b border-gray-100 bg-gray-50">
          <th class="text-left px-6 py-3 text-[10px] font-black text-gray-400 uppercase tracking-widest">Kode</th>
          <th class="text-left px-6 py-3 text-[10px] font-black text-gray-400 uppercase tracking-widest">Pembeli</th>
          <th class="text-left px-6 py-3 text-[10px] font-black text-gray-400 uppercase tracking-widest">Item</th>
          <th class="text-left px-6 py-3 text-[10px] font-black text-gray-400 uppercase tracking-widest">Total</th>
          <th class="text-left px-6 py-3 text-[10px] font-black text-gray-400 uppercase tracking-widest">Pembayaran</th>
          <th class="text-left px-6 py-3 text-[10px] font-black text-gray-400 uppercase tracking-widest">Status</th>
          <th class="text-left px-6 py-3 text-[10px] font-black text-gray-400 uppercase tracking-widest">Tanggal</th>
          <th class="px-6 py-3"></th>
        </tr>
      </thead>
      <tbody class="divide-y divide-gray-50">

        @forelse($pesanan as $p)
          @php
            // FIX: Status map sesuai enum DB orders: pending, processing, shipped, completed, cancelled
            $statusMap = [
              'pending'    => ['label' => 'Pending',    'class' => 'bg-yellow-100 text-yellow-700'],
              'processing' => ['label' => 'Diproses',   'class' => 'bg-indigo-100 text-indigo-700'],
              'shipped'    => ['label' => 'Dikirim',    'class' => 'bg-purple-100 text-purple-700'],
              'completed'  => ['label' => 'Selesai',    'class' => 'bg-emerald-100 text-emerald-700'],
              'cancelled'  => ['label' => 'Dibatalkan', 'class' => 'bg-red-100 text-red-600'],
            ];
            $st = $statusMap[$p->status] ?? ['label' => $p->status, 'class' => 'bg-gray-100 text-gray-600'];

            // Status pembayaran diambil dari tabel payments (terpisah dari order status)
            $payMap = [
              'pending' => ['label' => 'Belum Bayar', 'class' => 'text-yellow-600'],
              'paid'    => ['label' => 'Lunas',        'class' => 'text-emerald-600'],
              'failed'  => ['label' => 'Gagal',        'class' => 'text-red-600'],
              'expired' => ['label' => 'Kadaluarsa',   'class' => 'text-gray-400'],
            ];
            $pay = $payMap[$p->payment?->status ?? 'pending'] ?? ['label' => '—', 'class' => 'text-gray-400'];
          @endphp
          <tr class="hover:bg-gray-50/60 transition-colors">

            <td class="px-6 py-4">
              <span class="font-mono text-xs font-bold text-gray-900 bg-gray-100 px-2 py-1 rounded-lg">
                {{ $p->order_code }}
              </span>
            </td>

            <td class="px-6 py-4">
              <p class="font-bold text-gray-900">{{ $p->user?->name ?? '—' }}</p>
              <p class="text-xs text-gray-400">{{ $p->user?->email }}</p>
            </td>

            <td class="px-6 py-4 text-gray-600">
              {{ $p->items->count() }} item
            </td>

            <td class="px-6 py-4 font-bold text-gray-900">
              Rp {{ number_format($p->total_amount, 0, ',', '.') }}
            </td>

            <td class="px-6 py-4">
              <span class="text-xs font-bold {{ $pay['class'] }}">{{ $pay['label'] }}</span>
            </td>

            <td class="px-6 py-4">
              <span class="px-2.5 py-1 rounded-full text-[10px] font-black {{ $st['class'] }}">
                {{ $st['label'] }}
              </span>
            </td>

            <td class="px-6 py-4 text-xs text-gray-400">
              {{ $p->created_at->format('d M Y') }}<br/>
              <span class="text-gray-300">{{ $p->created_at->format('H:i') }}</span>
            </td>

            <td class="px-6 py-4 text-right">
              <a href="{{ route('admin.pesanan.show', $p->id) }}"
                 class="inline-flex items-center gap-1 text-xs font-bold text-emerald-600 hover:text-emerald-800 transition-colors">
                Detail
                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
              </a>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="8" class="px-6 py-20 text-center">
              <svg class="w-10 h-10 mx-auto mb-3 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
              </svg>
              <p class="text-sm font-semibold text-gray-400">Tidak ada pesanan ditemukan.</p>
            </td>
          </tr>
        @endforelse

      </tbody>
    </table>
  </div>

  @if($pesanan->hasPages())
    <div class="px-6 py-4 border-t border-gray-100">
      {{ $pesanan->links() }}
    </div>
  @endif
</div>

@endsection