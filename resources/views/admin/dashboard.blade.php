@extends('admin.layouts.app')
@section('title', 'Dashboard')

@section('content')

@php
  // Chart: Orders per day (14 hari terakhir)
  $rawOrders = \App\Models\Order::selectRaw('DATE(created_at) as date, COUNT(*) as total')
    ->where('created_at', '>=', now()->subDays(13)->startOfDay())
    ->groupBy('date')
    ->orderBy('date')
    ->get()
    ->keyBy('date');

  $chartLabels = [];
  $chartValues = [];
  for ($i = 13; $i >= 0; $i--) {
    $date = now()->subDays($i)->format('Y-m-d');
    $chartLabels[] = now()->subDays($i)->isoFormat('D MMM');
    $chartValues[] = $rawOrders[$date]->total ?? 0;
  }

  // Chart: Product status distribution
  $prodAvailable = \App\Models\Product::where('status','available')->count();
  $prodSold      = \App\Models\Product::where('status','sold')->count();
  $prodHidden    = \App\Models\Product::where('status','hidden')->count();

  // Stats
  $totalPendingAmount = \App\Models\Order::whereIn('status',['pending','processing','shipped'])->count();
  $totalCompleted     = \App\Models\Order::where('status','completed')->count();
  $totalRevenue       = \App\Models\Order::where('status','completed')->sum('total_amount');
@endphp

{{-- ── Page Header ── --}}
<div style="margin-bottom:28px;">
  <div style="font-size:22px;font-weight:800;color:var(--text-1);letter-spacing:-.02em;">Dashboard</div>
  <div style="font-size:13.5px;color:var(--text-3);margin-top:3px;">
    Selamat datang kembali, <strong style="color:var(--text-2);">{{ auth()->user()->name }}</strong>
    — ringkasan toko hari ini.
  </div>
</div>

{{-- ── Stat Cards ── --}}
<div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:16px;margin-bottom:24px;">

  {{-- Produk Tersedia --}}
  <div class="card" style="padding:20px;">
    <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:16px;">
      <div style="width:40px;height:40px;background:#DCFCE7;border-radius:10px;display:flex;align-items:center;justify-content:center;">
        <svg width="18" height="18" fill="none" stroke="#15803D" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
      </div>
      <span class="badge badge-green" style="font-size:10.5px;">Aktif</span>
    </div>
    <div style="font-size:28px;font-weight:800;color:var(--text-1);letter-spacing:-.03em;line-height:1;">
      {{ number_format($prodAvailable) }}
    </div>
    <div style="font-size:12.5px;color:var(--text-3);margin-top:5px;">Produk tersedia</div>
  </div>

  {{-- Total Pesanan --}}
  <div class="card" style="padding:20px;">
    <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:16px;">
      <div style="width:40px;height:40px;background:#DBEAFE;border-radius:10px;display:flex;align-items:center;justify-content:center;">
        <svg width="18" height="18" fill="none" stroke="#1D4ED8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
      </div>
      <span class="badge badge-blue" style="font-size:10.5px;">Total</span>
    </div>
    <div style="font-size:28px;font-weight:800;color:var(--text-1);letter-spacing:-.03em;line-height:1;">
      {{ number_format(\App\Models\Order::count()) }}
    </div>
    <div style="font-size:12.5px;color:var(--text-3);margin-top:5px;">Total pesanan masuk</div>
  </div>

  {{-- Diproses --}}
  <div class="card" style="padding:20px;">
    <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:16px;">
      <div style="width:40px;height:40px;background:#FEF9C3;border-radius:10px;display:flex;align-items:center;justify-content:center;">
        <svg width="18" height="18" fill="none" stroke="#854D0E" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
      </div>
      <span class="badge badge-yellow" style="font-size:10.5px;">Aktif</span>
    </div>
    <div style="font-size:28px;font-weight:800;color:var(--text-1);letter-spacing:-.03em;line-height:1;">
      {{ number_format($totalPendingAmount) }}
    </div>
    <div style="font-size:12.5px;color:var(--text-3);margin-top:5px;">Pesanan diproses</div>
  </div>

  {{-- Pendapatan --}}
  <div class="card" style="padding:20px;">
    <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:16px;">
      <div style="width:40px;height:40px;background:#F3E8FF;border-radius:10px;display:flex;align-items:center;justify-content:center;">
        <svg width="18" height="18" fill="none" stroke="#7E22CE" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
      </div>
      <span class="badge badge-purple" style="font-size:10.5px;">Selesai</span>
    </div>
    <div style="font-size:22px;font-weight:800;color:var(--text-1);letter-spacing:-.03em;line-height:1;">
      Rp {{ $totalRevenue >= 1000000 ? number_format($totalRevenue/1000000, 1).'jt' : number_format($totalRevenue, 0, ',', '.') }}
    </div>
    <div style="font-size:12.5px;color:var(--text-3);margin-top:5px;">Dari {{ $totalCompleted }} pesanan selesai</div>
  </div>

</div>

{{-- ── Charts Row ── --}}
<div style="display:grid;grid-template-columns:1fr 320px;gap:16px;margin-bottom:24px;">

  {{-- Line Chart: Orders per day --}}
  <div class="card">
    <div class="card-header">
      <div>
        <div class="card-title">Aktivitas Pesanan</div>
        <div style="font-size:12px;color:var(--text-3);margin-top:2px;">14 hari terakhir</div>
      </div>
      <div style="display:flex;align-items:center;gap:6px;">
        <span style="width:10px;height:10px;border-radius:50%;background:#10B981;display:inline-block;"></span>
        <span style="font-size:12px;color:var(--text-3);">Pesanan masuk</span>
      </div>
    </div>
    <div style="padding:20px;">
      <canvas id="orderChart" style="height:220px;width:100%;"></canvas>
    </div>
  </div>

  {{-- Donut Chart: Product status --}}
  <div class="card">
    <div class="card-header">
      <div>
        <div class="card-title">Status Produk</div>
        <div style="font-size:12px;color:var(--text-3);margin-top:2px;">Distribusi keseluruhan</div>
      </div>
    </div>
    <div style="padding:20px;display:flex;flex-direction:column;align-items:center;">
      <div style="position:relative;width:160px;height:160px;margin-bottom:20px;">
        <canvas id="productChart"></canvas>
        <div style="position:absolute;inset:0;display:flex;flex-direction:column;align-items:center;justify-content:center;pointer-events:none;">
          <div style="font-size:26px;font-weight:800;color:var(--text-1);">{{ $prodAvailable + $prodSold + $prodHidden }}</div>
          <div style="font-size:11px;color:var(--text-3);">Total produk</div>
        </div>
      </div>
      <div style="width:100%;display:flex;flex-direction:column;gap:10px;">
        @foreach([
          ['color'=>'#10B981','label'=>'Tersedia','val'=>$prodAvailable,'total'=>max(1,$prodAvailable+$prodSold+$prodHidden)],
          ['color'=>'#64748B','label'=>'Terjual', 'val'=>$prodSold,     'total'=>max(1,$prodAvailable+$prodSold+$prodHidden)],
          ['color'=>'#EF4444','label'=>'Hidden',  'val'=>$prodHidden,   'total'=>max(1,$prodAvailable+$prodSold+$prodHidden)],
        ] as $item)
          <div style="display:flex;align-items:center;justify-content:space-between;font-size:12.5px;">
            <div style="display:flex;align-items:center;gap:8px;">
              <span style="width:10px;height:10px;border-radius:3px;background:{{ $item['color'] }};flex-shrink:0;"></span>
              <span style="color:var(--text-2);">{{ $item['label'] }}</span>
            </div>
            <div style="display:flex;align-items:center;gap:10px;">
              <span style="font-weight:700;color:var(--text-1);">{{ $item['val'] }}</span>
              <span style="font-size:11px;color:var(--text-3);width:32px;text-align:right;">
                {{ $item['total'] > 0 ? round(($item['val']/$item['total'])*100) : 0 }}%
              </span>
            </div>
          </div>
        @endforeach
      </div>
    </div>
  </div>

</div>

{{-- ── Recent Orders Table ── --}}
<div class="card">
  <div class="card-header">
    <div class="card-title">Pesanan Terbaru</div>
    <a href="{{ route('admin.pesanan.index') }}" class="btn btn-ghost btn-sm">
      Lihat Semua
      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
    </a>
  </div>
  <div style="overflow-x:auto;">
    <table class="data-table">
      <thead>
        <tr>
          <th>Kode Pesanan</th>
          <th>Pembeli</th>
          <th>Total</th>
          <th>Status</th>
          <th>Tanggal</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
        @forelse(\App\Models\Order::with('user')->latest()->take(7)->get() as $o)
          @php
            $stMap = [
              'pending'    => ['Pending',    'badge-yellow'],
              'processing' => ['Diproses',   'badge-teal'],
              'shipped'    => ['Dikirim',    'badge-purple'],
              'completed'  => ['Selesai',    'badge-green'],
              'cancelled'  => ['Dibatalkan', 'badge-red'],
            ];
            [$sl, $sc] = $stMap[$o->status] ?? [$o->status, 'badge-gray'];
          @endphp
          <tr>
            <td>
              <span class="font-mono" style="font-size:12.5px;font-weight:600;color:var(--text-1);background:var(--page-bg);padding:3px 8px;border-radius:5px;border:1px solid var(--border);">
                {{ $o->order_code }}
              </span>
            </td>
            <td>
              <div style="font-weight:600;font-size:13px;">{{ $o->user?->name ?? '—' }}</div>
              <div style="font-size:12px;color:var(--text-3);">{{ $o->user?->email }}</div>
            </td>
            <td style="font-weight:700;">Rp {{ number_format($o->total_amount, 0, ',', '.') }}</td>
            <td><span class="badge {{ $sc }}">{{ $sl }}</span></td>
            <td style="color:var(--text-3);font-size:12.5px;">{{ $o->created_at->format('d M Y') }}</td>
            <td style="text-align:right;">
              <a href="{{ route('admin.pesanan.show', $o->id) }}" class="btn btn-ghost btn-sm btn-icon" title="Detail">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
              </a>
            </td>
          </tr>
        @empty
          <tr>
            <td colspan="6" style="text-align:center;padding:48px 16px;color:var(--text-3);">
              <svg width="36" height="36" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin:0 auto 12px;display:block;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
              <div style="font-weight:600;font-size:13px;margin-bottom:4px;">Belum ada pesanan</div>
            </td>
          </tr>
        @endforelse
      </tbody>
    </table>
  </div>
</div>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
  // Global chart defaults
  Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
  Chart.defaults.color = '#94A3B8';

  // ── Order Line Chart ──────────────────────────────────
  const orderLabels = @json($chartLabels);
  const orderValues = @json($chartValues);

  const orderCtx = document.getElementById('orderChart').getContext('2d');
  const gradientFill = orderCtx.createLinearGradient(0, 0, 0, 220);
  gradientFill.addColorStop(0, 'rgba(16,185,129,0.18)');
  gradientFill.addColorStop(1, 'rgba(16,185,129,0)');

  new Chart(orderCtx, {
    type: 'line',
    data: {
      labels: orderLabels,
      datasets: [{
        label: 'Pesanan',
        data: orderValues,
        borderColor: '#10B981',
        borderWidth: 2.5,
        backgroundColor: gradientFill,
        pointBackgroundColor: '#10B981',
        pointBorderColor: '#fff',
        pointBorderWidth: 2,
        pointRadius: 4,
        pointHoverRadius: 6,
        tension: 0.4,
        fill: true,
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      interaction: { mode: 'index', intersect: false },
      plugins: {
        legend: { display: false },
        tooltip: {
          backgroundColor: '#0F172A',
          titleColor: '#E2E8F0',
          bodyColor: '#94A3B8',
          padding: 12,
          cornerRadius: 8,
          displayColors: false,
          callbacks: {
            title: (items) => items[0].label,
            label: (item) => `${item.raw} pesanan`,
          }
        }
      },
      scales: {
        x: {
          grid: { display: false },
          border: { display: false },
          ticks: { font: { size: 11.5 }, maxRotation: 0 }
        },
        y: {
          beginAtZero: true,
          grid: { color: '#F1F5F9', drawBorder: false },
          border: { display: false, dash: [4,4] },
          ticks: {
            font: { size: 11.5 },
            stepSize: 1,
            callback: v => Number.isInteger(v) ? v : null
          }
        }
      }
    }
  });

  // ── Product Donut Chart ───────────────────────────────
  const available = {{ $prodAvailable }};
  const sold      = {{ $prodSold }};
  const hidden    = {{ $prodHidden }};
  const total     = available + sold + hidden;

  const productCtx = document.getElementById('productChart').getContext('2d');
  new Chart(productCtx, {
    type: 'doughnut',
    data: {
      labels: ['Tersedia', 'Terjual', 'Hidden'],
      datasets: [{
        data: total > 0 ? [available, sold, hidden] : [1, 0, 0],
        backgroundColor: total > 0 ? ['#10B981', '#64748B', '#EF4444'] : ['#E2E8F0'],
        borderWidth: 0,
        hoverOffset: 6,
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      cutout: '68%',
      plugins: {
        legend: { display: false },
        tooltip: {
          backgroundColor: '#0F172A',
          titleColor: '#E2E8F0',
          bodyColor: '#94A3B8',
          padding: 10,
          cornerRadius: 8,
          callbacks: {
            label: (item) => total > 0
              ? ` ${item.label}: ${item.raw} (${Math.round(item.raw/total*100)}%)`
              : ' Belum ada produk'
          }
        }
      }
    }
  });
</script>
@endpush