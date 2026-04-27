@extends('admin.layouts.app')
@section('title', 'Kelola Pesanan')
@section('breadcrumb')<span>Pesanan</span>@endsection

@section('content')

{{-- ── Page Header ── --}}
<div style="display:flex;align-items:flex-start;justify-content:space-between;gap:16px;margin-bottom:24px;">
  <div>
    <div style="font-size:22px;font-weight:800;color:var(--text-1);letter-spacing:-.02em;">Pesanan</div>
    <div style="font-size:13px;color:var(--text-3);margin-top:3px;">{{ $pesanan->total() }} pesanan ditemukan</div>
  </div>
</div>

{{-- ── Status Tabs ── --}}
@php
  $tabs = [
    ''           => 'Semua',
    'pending'    => 'Pending',
    'processing' => 'Diproses',
    'shipped'    => 'Dikirim',
    'completed'  => 'Selesai',
    'cancelled'  => 'Dibatalkan',
  ];
  $tabColors = [
    'pending'    => '#854D0E',
    'processing' => '#0F766E',
    'shipped'    => '#7E22CE',
    'completed'  => '#15803D',
    'cancelled'  => '#B91C1C',
  ];
@endphp
<div style="display:flex;flex-wrap:wrap;gap:6px;margin-bottom:20px;">
  @foreach($tabs as $val => $label)
    @php
      $isActive = request('status', '') === $val;
      $count = $val ? ($counts[$val] ?? 0) : null;
    @endphp
    <a href="{{ route('admin.pesanan.index', array_merge(request()->query(), ['status' => $val])) }}"
       style="display:inline-flex;align-items:center;gap:6px;padding:6px 14px;border-radius:20px;font-size:12.5px;font-weight:600;text-decoration:none;transition:all .15s;
              {{ $isActive
                  ? 'background:#0F172A;color:#fff;border:1px solid #0F172A;'
                  : 'background:#fff;color:var(--text-2);border:1px solid var(--border);' }}">
      {{ $label }}
      @if($count > 0)
        <span style="font-size:10.5px;font-weight:700;padding:1px 6px;border-radius:20px;
                     {{ $isActive ? 'background:rgba(255,255,255,.15);color:#fff;' : 'background:var(--page-bg);color:var(--text-3);' }}">
          {{ $count }}
        </span>
      @endif
    </a>
  @endforeach
</div>

{{-- ── Search ── --}}
<div class="card" style="padding:14px;margin-bottom:20px;">
  <form method="GET" style="display:flex;gap:10px;">
    <input type="hidden" name="status" value="{{ request('status') }}" />
    <div style="flex:1;position:relative;">
      <svg style="position:absolute;left:11px;top:50%;transform:translateY(-50%);width:15px;height:15px;color:var(--text-3);" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
      <input type="text" name="search" value="{{ request('search') }}"
             placeholder="Cari kode pesanan atau nama pembeli..."
             class="form-input" style="padding-left:36px;" />
    </div>
    <button type="submit" class="btn btn-primary">Cari</button>
    @if(request()->filled('search'))
      <a href="{{ route('admin.pesanan.index', request()->only('status')) }}" class="btn btn-ghost">Reset</a>
    @endif
  </form>
</div>

{{-- ── Table ── --}}
<div class="card" style="overflow:hidden;">

  {{-- Skeleton --}}
  <div id="skeleton-content">
    <div style="overflow-x:auto;">
      <table class="data-table">
        <thead>
          <tr>
            <th>Kode</th><th>Pembeli</th><th>Item</th><th>Total</th><th>Pembayaran</th><th>Status</th><th>Tanggal</th><th></th>
          </tr>
        </thead>
        <tbody>
          @for($s = 0; $s < 7; $s++)
            <tr class="skeleton-row">
              <td><span class="skeleton-block sk-line" style="width:100px;"></span></td>
              <td>
                <span class="skeleton-block sk-line" style="width:120px;margin-bottom:5px;"></span>
                <span class="skeleton-block sk-line" style="width:160px;height:10px;"></span>
              </td>
              <td><span class="skeleton-block sk-line" style="width:40px;"></span></td>
              <td><span class="skeleton-block sk-line" style="width:90px;"></span></td>
              <td><span class="skeleton-block sk-badge"></span></td>
              <td><span class="skeleton-block sk-badge"></span></td>
              <td><span class="skeleton-block sk-line" style="width:70px;"></span></td>
              <td><span class="skeleton-block sk-btn"></span></td>
            </tr>
          @endfor
        </tbody>
      </table>
    </div>
  </div>

  {{-- Real Content --}}
  <div id="real-content">
    <div style="overflow-x:auto;">
      <table class="data-table">
        <thead>
          <tr>
            <th>Kode Pesanan</th>
            <th>Pembeli</th>
            <th>Item</th>
            <th>Total</th>
            <th>Pembayaran</th>
            <th>Status</th>
            <th>Tanggal</th>
            <th></th>
          </tr>
        </thead>
        <tbody>
          @forelse($pesanan as $p)
            @php
              $stMap = [
                'pending'    => ['Pending',    'badge-yellow'],
                'processing' => ['Diproses',   'badge-teal'],
                'shipped'    => ['Dikirim',    'badge-purple'],
                'completed'  => ['Selesai',    'badge-green'],
                'cancelled'  => ['Dibatalkan', 'badge-red'],
              ];
              [$sl, $sc] = $stMap[$p->status] ?? [$p->status, 'badge-gray'];

              $payMap = [
                'pending' => ['Menunggu',   'badge-yellow'],
                'paid'    => ['Lunas',       'badge-green'],
                'failed'  => ['Gagal',       'badge-red'],
                'expired' => ['Kadaluarsa', 'badge-gray'],
              ];
              [$pl, $pc] = $payMap[$p->payment?->status ?? 'pending'] ?? ['—', 'badge-gray'];
            @endphp
            <tr>
              <td>
                <span class="font-mono" style="font-size:12px;font-weight:600;background:var(--page-bg);padding:3px 8px;border-radius:5px;border:1px solid var(--border);white-space:nowrap;">
                  {{ $p->order_code }}
                </span>
              </td>
              <td>
                <div style="font-weight:600;font-size:13px;">{{ $p->user?->name ?? '—' }}</div>
                <div style="font-size:11.5px;color:var(--text-3);">{{ $p->user?->email }}</div>
              </td>
              <td style="font-size:13px;color:var(--text-2);">{{ $p->items->count() }} item</td>
              <td style="font-weight:700;font-size:13px;white-space:nowrap;">Rp {{ number_format($p->total_amount, 0, ',', '.') }}</td>
              <td><span class="badge {{ $pc }}">{{ $pl }}</span></td>
              <td><span class="badge {{ $sc }}">{{ $sl }}</span></td>
              <td style="font-size:12px;color:var(--text-3);white-space:nowrap;">
                {{ $p->created_at->format('d M Y') }}<br>
                <span style="font-size:11px;">{{ $p->created_at->format('H:i') }}</span>
              </td>
              <td style="text-align:right;">
                <a href="{{ route('admin.pesanan.show', $p->id) }}" class="btn btn-ghost btn-sm" style="white-space:nowrap;">
                  Detail
                  <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="8" style="text-align:center;padding:60px 16px;">
                <svg width="40" height="40" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:var(--border);margin:0 auto 12px;display:block;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                <div style="font-weight:600;font-size:13.5px;color:var(--text-2);margin-bottom:4px;">Tidak ada pesanan ditemukan</div>
                <div style="font-size:12.5px;color:var(--text-3);">Coba ubah filter atau kata kunci pencarian.</div>
              </td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if($pesanan->hasPages())
      <div style="padding:14px 20px;border-top:1px solid var(--border-light);">
        {{ $pesanan->links() }}
      </div>
    @endif
  </div>

</div>
@endsection