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

  // Testimoni stats
  $testimoniPending  = \App\Models\Testimonial::where('status','pending')->count();
  $testimoniApproved = \App\Models\Testimonial::where('status','approved')->count();
  $testimoniAvgRaw   = \App\Models\Testimonial::where('status','approved')->avg('rating');
  $testimoniAvg      = $testimoniAvgRaw ? round($testimoniAvgRaw, 1) : 0;

  // Recent testimoni
  $recentTestimoni = \App\Models\Testimonial::with(['user','order'])
    ->latest()->take(5)->get();
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

  {{-- ★ Testimoni Pending --}}
  <div class="card" style="padding:20px;position:relative;overflow:hidden;">
    {{-- Glow jika ada yang pending --}}
    @if($testimoniPending > 0)
      <div style="position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,#f59e0b,#fbbf24);border-radius:12px 12px 0 0;"></div>
    @endif
    <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:16px;">
      <div style="width:40px;height:40px;background:#FEF3C7;border-radius:10px;display:flex;align-items:center;justify-content:center;">
        <svg width="18" height="18" fill="#F59E0B" viewBox="0 0 24 24">
          <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
        </svg>
      </div>
      @if($testimoniPending > 0)
        <span class="badge badge-yellow" style="font-size:10.5px;animation:pulse 2s infinite;">
          {{ $testimoniPending }} pending
        </span>
      @else
        <span class="badge badge-green" style="font-size:10.5px;">Bersih</span>
      @endif
    </div>
    <div style="font-size:28px;font-weight:800;color:var(--text-1);letter-spacing:-.03em;line-height:1;">
      {{ $testimoniAvg > 0 ? $testimoniAvg : '—' }}
      @if($testimoniAvg > 0)
        <span style="font-size:14px;font-weight:600;color:var(--text-3);">/ 5</span>
      @endif
    </div>
    <div style="font-size:12.5px;color:var(--text-3);margin-top:5px;">
      Rating rata‑rata · {{ $testimoniApproved }} approved
    </div>
    <a href="{{ route('admin.testimoni.index') }}"
       style="display:inline-flex;align-items:center;gap:4px;margin-top:12px;font-size:11.5px;font-weight:700;color:#92400e;text-decoration:none;transition:color .15s;"
       onmouseover="this.style.color='#d97706'" onmouseout="this.style.color='#92400e'">
      Kelola testimoni
      <svg width="11" height="11" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
    </a>
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

{{-- ── Bottom Row: Recent Orders + Recent Testimoni ── --}}
<div style="display:grid;grid-template-columns:1fr 400px;gap:16px;">

  {{-- Recent Orders Table --}}
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

  {{-- ★ Recent Testimoni --}}
  <div class="card">
    <div class="card-header">
      <div>
        <div class="card-title">Testimoni Terbaru</div>
        <div style="font-size:12px;color:var(--text-3);margin-top:2px;">
          @if($testimoniPending > 0)
            <span style="color:#d97706;font-weight:700;">{{ $testimoniPending }} menunggu review</span>
          @else
            Semua sudah ditinjau
          @endif
        </div>
      </div>
      <a href="{{ route('admin.testimoni.index') }}" class="btn btn-ghost btn-sm">
        Kelola
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
      </a>
    </div>

    <div style="display:flex;flex-direction:column;">
      @forelse($recentTestimoni as $t)
        @php
          $statusMap = [
            'pending'  => ['Pending',  'badge-yellow'],
            'approved' => ['Approved', 'badge-green'],
            'rejected' => ['Rejected', 'badge-red'],
          ];
          [$tl, $tc] = $statusMap[$t->status] ?? [$t->status, 'badge-gray'];
        @endphp
        <div style="display:flex;align-items:flex-start;gap:12px;padding:14px 20px;border-bottom:1px solid var(--border);">

          {{-- Avatar inisial --}}
          @php
            $initials = collect(explode(' ', $t->user->name))->take(2)->map(fn($w) => strtoupper($w[0]))->join('');
          @endphp
          <div style="width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#d1fae5,#a7f3d0);display:flex;align-items:center;justify-content:center;font-size:13px;font-weight:800;color:#065f46;flex-shrink:0;">
            {{ $initials }}
          </div>

          <div style="flex:1;min-width:0;">
            <div style="display:flex;align-items:center;justify-content:space-between;gap:8px;margin-bottom:4px;">
              <div style="font-size:13px;font-weight:700;color:var(--text-1);overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                {{ $t->user->name }}
              </div>
              <span class="badge {{ $tc }}" style="font-size:10px;flex-shrink:0;">{{ $tl }}</span>
            </div>

            {{-- Bintang --}}
            <div style="display:flex;gap:2px;margin-bottom:5px;">
              @for($s = 1; $s <= 5; $s++)
                <svg width="12" height="12" viewBox="0 0 24 24"
                     style="fill:{{ $s <= $t->rating ? '#f59e0b' : '#e5e7eb' }}"
                     xmlns="http://www.w3.org/2000/svg">
                  <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                </svg>
              @endfor
            </div>

            {{-- Komentar --}}
            <div style="font-size:12px;color:var(--text-3);line-height:1.5;overflow:hidden;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;">
              "{{ $t->comment }}"
            </div>

            {{-- Aksi cepat jika pending --}}
            @if($t->status === 'pending')
              <div style="display:flex;gap:6px;margin-top:8px;">
                <form method="POST" action="{{ route('admin.testimoni.approve', $t->id) }}" style="display:inline;">
                  @csrf @method('PATCH')
                  <button type="submit"
                    style="font-size:11.5px;font-weight:700;padding:4px 10px;background:#DCFCE7;color:#15803D;border:none;border-radius:6px;cursor:pointer;transition:all .15s;"
                    onmouseover="this.style.background='#16a34a';this.style.color='#fff'"
                    onmouseout="this.style.background='#DCFCE7';this.style.color='#15803D'">
                    ✓ Approve
                  </button>
                </form>
                <form method="POST" action="{{ route('admin.testimoni.reject', $t->id) }}" style="display:inline;">
                  @csrf @method('PATCH')
                  <button type="submit"
                    style="font-size:11.5px;font-weight:700;padding:4px 10px;background:#FEE2E2;color:#B91C1C;border:none;border-radius:6px;cursor:pointer;transition:all .15s;"
                    onmouseover="this.style.background='#ef4444';this.style.color='#fff'"
                    onmouseout="this.style.background='#FEE2E2';this.style.color='#B91C1C'">
                    ✕ Reject
                  </button>
                </form>
              </div>
            @endif
          </div>
        </div>
      @empty
        <div style="text-align:center;padding:48px 16px;color:var(--text-3);">
          <svg width="32" height="32" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="margin:0 auto 10px;display:block;">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
          </svg>
          <div style="font-size:13px;font-weight:600;margin-bottom:4px;">Belum ada testimoni</div>
          <div style="font-size:12px;">Muncul di sini setelah pembeli mengirim ulasan</div>
        </div>
      @endforelse
    </div>
  </div>

</div>

@endsection

@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/4.4.1/chart.umd.min.js"></script>
<script>
  Chart.defaults.font.family = "'Plus Jakarta Sans', sans-serif";
  Chart.defaults.color = '#94A3B8';

  // ── Order Line Chart ─────────────────────────────────
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

  // ── Product Donut Chart ──────────────────────────────
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