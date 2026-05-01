<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Detail Pesanan {{ $order->order_code }} — PindahTangan</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,700;9..40,800&family=Plus+Jakarta+Sans:ital,wght@0,400;0,600;0,700;0,800;1,400&family=Cormorant+Garamond:ital,wght@1,400;1,600&display=swap" rel="stylesheet">

  <style>
    :root {
      --emerald:     #10b981;
      --emerald-600: #059669;
      --emerald-700: #047857;
      --emerald-50:  #ecfdf5;
      --emerald-100: #d1fae5;
      --gray-900:    #111827;
      --gray-700:    #374151;
      --gray-500:    #6b7280;
      --gray-400:    #9ca3af;
      --gray-100:    #f3f4f6;
      --gray-50:     #f9fafb;
      --border:      #e5e7eb;
      --white:       #ffffff;
    }

    *, *::before, *::after { box-sizing: border-box; }
    html { scroll-behavior: smooth; }
    body {
      font-family: 'DM Sans', sans-serif;
      background: var(--gray-50);
      color: var(--gray-900);
      margin: 0;
      -webkit-font-smoothing: antialiased;
    }
    .jakarta   { font-family: 'Plus Jakarta Sans', sans-serif; }
    .cormorant { font-family: 'Cormorant Garamond', serif; }

    /* ── Navbar ── */
    #navbar {
      position: fixed; top: 0; width: 100%; z-index: 50;
      background: rgba(255,255,255,0.92);
      backdrop-filter: blur(16px);
      border-bottom: 1px solid var(--border);
      box-shadow: 0 1px 8px rgba(0,0,0,0.04);
    }
    .nav-inner {
      max-width: 1280px; margin: 0 auto;
      padding: 0 24px; height: 64px;
      display: flex; align-items: center; justify-content: space-between;
    }

    /* ── Cards ── */
    .detail-card {
      background: var(--white);
      border: 1px solid var(--border);
      border-radius: 18px;
      overflow: hidden;
    }
    .card-head {
      padding: 18px 22px;
      border-bottom: 1px solid var(--gray-100);
      display: flex; align-items: center; gap: 10px;
    }
    .card-icon {
      width: 34px; height: 34px; border-radius: 10px;
      background: var(--emerald-50);
      display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .card-icon svg { width: 16px; height: 16px; color: var(--emerald-600); }
    .card-title { font-family: 'Plus Jakarta Sans', sans-serif; font-size: 14px; font-weight: 700; color: var(--gray-900); }
    .card-subtitle { font-size: 12px; color: var(--gray-400); margin-top: 1px; }
    .card-body { padding: 20px 22px; }

    /* ── Status badges ── */
    .badge {
      display: inline-flex; align-items: center; gap: 5px;
      padding: 4px 12px; border-radius: 99px;
      font-size: 12px; font-weight: 700;
    }
    .badge-pending     { background: #fef9c3; color: #854d0e; }
    .badge-processing  { background: #dbeafe; color: #1e40af; }
    .badge-shipped     { background: #ede9fe; color: #5b21b6; }
    .badge-completed   { background: var(--emerald-50); color: var(--emerald-700); }
    .badge-cancelled   { background: #fee2e2; color: #b91c1c; }
    .pay-pending  { background: #fef9c3; color: #854d0e; }
    .pay-paid     { background: var(--emerald-50); color: var(--emerald-700); }
    .pay-failed   { background: #fee2e2; color: #b91c1c; }
    .pay-expired  { background: var(--gray-100); color: var(--gray-500); }

    /* ── Order item row ── */
    .order-item-row {
      display: flex; align-items: center; gap: 14px;
      padding: 14px 0;
      border-bottom: 1px solid var(--gray-50);
    }
    .order-item-row:last-child { border-bottom: none; }
    .order-item-img {
      width: 64px; height: 64px;
      border-radius: 12px;
      overflow: hidden;
      border: 1px solid var(--border);
      background: var(--gray-100);
      flex-shrink: 0;
    }
    .order-item-img img { width: 100%; height: 100%; object-fit: cover; }

    /* ── Info rows ── */
    .info-row {
      display: flex; justify-content: space-between; align-items: flex-start;
      padding: 9px 0;
      border-bottom: 1px solid var(--gray-50);
      gap: 16px;
    }
    .info-row:last-child { border-bottom: none; }
    .info-label { font-size: 12.5px; color: var(--gray-400); font-weight: 500; flex-shrink: 0; }
    .info-value { font-size: 13px; color: var(--gray-900); font-weight: 600; text-align: right; }

    /* ── Price summary ── */
    .price-row {
      display: flex; justify-content: space-between; align-items: center;
      font-size: 13px; color: var(--gray-500);
      padding: 7px 0;
    }
    .price-row .val { font-weight: 600; color: var(--gray-700); }
    .price-total {
      display: flex; justify-content: space-between; align-items: baseline;
      padding-top: 14px; margin-top: 4px;
      border-top: 1.5px solid var(--border);
    }

    /* ── Status timeline ── */
    .timeline { display: flex; flex-direction: column; gap: 0; }
    .timeline-item {
      display: flex; align-items: flex-start; gap: 14px;
      padding: 10px 0; position: relative;
    }
    .timeline-item:not(:last-child)::before {
      content: '';
      position: absolute;
      left: 11px; top: 34px;
      width: 2px; height: calc(100% - 10px);
      background: var(--border);
    }
    .timeline-dot {
      width: 24px; height: 24px; border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      flex-shrink: 0; margin-top: 2px;
      border: 2px solid var(--border);
      background: var(--white);
      position: relative; z-index: 1;
    }
    .timeline-dot.done { background: var(--emerald-600); border-color: var(--emerald-600); }
    .timeline-dot.active { background: var(--white); border-color: var(--emerald-600); box-shadow: 0 0 0 3px var(--emerald-100); }
    .timeline-dot svg { width: 12px; height: 12px; color: #fff; }
    .timeline-label { font-size: 13px; font-weight: 600; color: var(--gray-900); }
    .timeline-sub { font-size: 11.5px; color: var(--gray-400); margin-top: 2px; }

    /* ── Buttons ── */
    .btn-back {
      display: inline-flex; align-items: center; gap: 5px;
      font-size: 12.5px; font-weight: 600;
      color: var(--gray-400); text-decoration: none;
      padding: 6px 12px;
      border: 1px solid var(--border); border-radius: 8px;
      transition: all .15s;
    }
    .btn-back:hover { color: var(--gray-900); border-color: var(--gray-300); background: var(--white); }
    .btn-testimoni {
      display: inline-flex; align-items: center; justify-content: center; gap: 8px;
      padding: 12px 24px; width: 100%;
      font-size: 13.5px; font-weight: 800;
      font-family: 'Plus Jakarta Sans', sans-serif;
      color: #fff; background: var(--emerald-600);
      border: none; border-radius: 12px;
      text-decoration: none; cursor: pointer;
      transition: background .2s, transform .15s, box-shadow .2s;
    }
    .btn-testimoni:hover {
      background: var(--emerald-700);
      box-shadow: 0 8px 24px rgba(5,150,105,0.3);
      transform: translateY(-1px);
    }
    .btn-testimoni svg { width: 16px; height: 16px; }

    /* ── Condition badge ── */
    .cond-badge {
      display: inline-flex; align-items: center; gap: 3px;
      padding: 2px 8px; border-radius: 99px;
      font-size: 10.5px; font-weight: 700;
    }
    .cond-like_new { background: #dcfce7; color: #15803d; }
    .cond-good     { background: #dbeafe; color: #1d4ed8; }
    .cond-fair     { background: #ffedd5; color: #9a3412; }

    /* ── Fade in ── */
    @keyframes fadeUp { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: translateY(0); } }
    .fade-up { animation: fadeUp .5s cubic-bezier(0.22,1,0.36,1) both; }

    @media (max-width: 640px) {
      .nav-inner { padding: 0 16px; }
      .detail-grid { grid-template-columns: 1fr !important; }
    }
  </style>
</head>
<body>

{{-- ══ NAVBAR ══ --}}
<nav id="navbar">
  <div class="nav-inner">
    <a href="/">
      <img src="{{ asset('images/logo_full.png') }}" alt="PindahTangan" style="height:40px;width:auto;" />
    </a>
    <a href="{{ route('pesanan.index') }}" class="btn-back">
      <svg style="width:13px;height:13px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
      </svg>
      Riwayat Pesanan
    </a>
  </div>
</nav>

{{-- ══ MAIN ══ --}}
<main style="max-width:960px;margin:0 auto;padding:88px 24px 80px;">

  @php
    $payment = $order->payment;
    $address = $order->address;

    $orderStatusMap = [
      'pending'    => ['label' => 'Menunggu Bayar',  'class' => 'badge-pending'],
      'processing' => ['label' => 'Diproses',        'class' => 'badge-processing'],
      'shipped'    => ['label' => 'Dikirim',         'class' => 'badge-shipped'],
      'completed'  => ['label' => 'Selesai',         'class' => 'badge-completed'],
      'cancelled'  => ['label' => 'Dibatalkan',      'class' => 'badge-cancelled'],
    ];
    $payStatusMap = [
      'pending' => ['label' => 'Belum Dibayar', 'class' => 'pay-pending'],
      'paid'    => ['label' => 'Lunas',         'class' => 'pay-paid'],
      'failed'  => ['label' => 'Gagal',         'class' => 'pay-failed'],
      'expired' => ['label' => 'Kedaluwarsa',   'class' => 'pay-expired'],
    ];
    $os = $orderStatusMap[$order->status] ?? ['label' => ucfirst($order->status), 'class' => 'badge-pending'];
    $ps = $payStatusMap[$payment?->status ?? 'pending'] ?? ['label' => 'Pending', 'class' => 'pay-pending'];

    $timelineSteps = [
      ['key' => 'pending',    'label' => 'Pesanan Dibuat',   'sub' => 'Menunggu pembayaran'],
      ['key' => 'processing', 'label' => 'Pembayaran Lunas', 'sub' => 'Pesanan sedang diproses admin'],
      ['key' => 'shipped',    'label' => 'Dikirim',          'sub' => 'Paket dalam perjalanan'],
      ['key' => 'completed',  'label' => 'Selesai',          'sub' => 'Pesanan telah diterima'],
    ];
    $statusOrder = ['pending', 'processing', 'shipped', 'completed'];
    $currentIdx  = array_search($order->status, $statusOrder);

    $canTestimoni = $order->status === 'completed'
      && is_null($order->testimonial);
  @endphp

  {{-- Page header --}}
  <div style="margin-bottom:24px;" class="fade-up">
    <div style="display:flex;align-items:center;gap:10px;flex-wrap:wrap;margin-bottom:6px;">
      <h1 class="jakarta" style="font-size:clamp(22px,3vw,30px);font-weight:800;letter-spacing:-.03em;margin:0;">
        {{ $order->order_code }}
      </h1>
      <span class="badge {{ $os['class'] }}">{{ $os['label'] }}</span>
      <span class="badge {{ $ps['class'] }}">{{ $ps['label'] }}</span>
    </div>
    <p style="font-size:13px;color:var(--gray-400);margin:0;">
      Dibuat {{ $order->created_at->format('d M Y') }} pukul {{ $order->created_at->format('H:i') }} WIB
    </p>
  </div>

  <div style="display:grid;grid-template-columns:1fr 320px;gap:20px;align-items:start;" class="detail-grid">

    {{-- ── KOLOM KIRI ── --}}
    <div style="display:flex;flex-direction:column;gap:16px;">

      {{-- STATUS TIMELINE --}}
      @if($order->status !== 'cancelled')
        <div class="detail-card fade-up" style="animation-delay:.04s">
          <div class="card-head">
            <div class="card-icon">
              <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
              </svg>
            </div>
            <div>
              <div class="card-title">Status Pesanan</div>
              <div class="card-subtitle">Progres pengiriman pesanan Anda</div>
            </div>
          </div>
          <div class="card-body">
            <div class="timeline">
              @foreach($timelineSteps as $i => $step)
                @php
                  $isDone   = $currentIdx !== false && $i < $currentIdx;
                  $isActive = $i === $currentIdx;
                @endphp
                <div class="timeline-item">
                  <div class="timeline-dot {{ $isDone ? 'done' : ($isActive ? 'active' : '') }}">
                    @if($isDone)
                      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/>
                      </svg>
                    @endif
                  </div>
                  <div>
                    <div class="timeline-label" style="{{ $isActive ? 'color:var(--emerald-700);' : ($isDone ? '' : 'color:var(--gray-400);') }}">
                      {{ $step['label'] }}
                    </div>
                    <div class="timeline-sub">{{ $step['sub'] }}</div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        </div>
      @else
        <div class="detail-card fade-up" style="border-color:#fecaca;animation-delay:.04s">
          <div class="card-body" style="display:flex;align-items:center;gap:12px;background:#fff5f5;">
            <svg style="width:24px;height:24px;color:#ef4444;flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div>
              <div style="font-size:14px;font-weight:700;color:#b91c1c;">Pesanan Dibatalkan</div>
              <div style="font-size:12px;color:#dc2626;margin-top:2px;">Pesanan ini tidak dapat diproses lebih lanjut.</div>
            </div>
          </div>
        </div>
      @endif

      {{-- ITEM PESANAN --}}
      <div class="detail-card fade-up" style="animation-delay:.08s">
        <div class="card-head">
          <div class="card-icon">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
          </div>
          <div>
            <div class="card-title">Item Pesanan</div>
            <div class="card-subtitle">{{ $order->items->count() }} item preloved</div>
          </div>
        </div>
        <div class="card-body" style="padding-top:6px;padding-bottom:6px;">
          @foreach($order->items as $item)
            @php
              $condLabel = match($item->product_condition ?? '') {
                'like_new' => 'Like New',
                'good'     => 'Good',
                'fair'     => 'Fair',
                default    => null,
              };
              $img = $item->product?->image ?? null;
            @endphp
            <div class="order-item-row">
              <div class="order-item-img">
                @if($img)
                  <img src="{{ Storage::url($img) }}" alt="{{ $item->product_name }}" />
                @else
                  <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;">
                    <svg style="width:22px;height:22px;color:#d1d5db;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                  </div>
                @endif
              </div>
              <div style="flex:1;min-width:0;">
                <div style="display:flex;align-items:center;gap:6px;margin-bottom:4px;">
                  @if($condLabel)
                    <span class="cond-badge cond-{{ $item->product_condition }}">{{ $condLabel }}</span>
                  @endif
                </div>
                <div class="jakarta" style="font-size:13.5px;font-weight:700;color:var(--gray-900);line-height:1.3;">
                  {{ $item->product_name }}
                </div>
              </div>
              <div class="jakarta" style="font-size:14px;font-weight:800;color:var(--gray-900);flex-shrink:0;">
                Rp {{ number_format($item->product_price, 0, ',', '.') }}
              </div>
            </div>
          @endforeach
        </div>
      </div>

      {{-- ALAMAT PENGIRIMAN --}}
      @if($address)
        <div class="detail-card fade-up" style="animation-delay:.12s">
          <div class="card-head">
            <div class="card-icon">
              <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
              </svg>
            </div>
            <div>
              <div class="card-title">Alamat Pengiriman</div>
              <div class="card-subtitle">Tujuan pengiriman paket</div>
            </div>
          </div>
          <div class="card-body">
            <div class="info-row">
              <span class="info-label">Penerima</span>
              <span class="info-value">{{ $address->recipient_name }}</span>
            </div>
            <div class="info-row">
              <span class="info-label">Telepon</span>
              <span class="info-value">{{ $address->phone }}</span>
            </div>
            <div class="info-row">
              <span class="info-label">Alamat</span>
              <span class="info-value" style="max-width:240px;">{{ $address->address_detail }}</span>
            </div>
            <div class="info-row">
              <span class="info-label">Kota / Kecamatan</span>
              <span class="info-value">{{ $address->city_name }}</span>
            </div>
            <div class="info-row">
              <span class="info-label">Provinsi</span>
              <span class="info-value">{{ $address->province_name }}</span>
            </div>
            <div class="info-row">
              <span class="info-label">Kode Pos</span>
              <span class="info-value">{{ $address->postal_code }}</span>
            </div>
          </div>
        </div>
      @endif

      {{-- INFO PENGIRIMAN --}}
      <div class="detail-card fade-up" style="animation-delay:.16s">
        <div class="card-head">
          <div class="card-icon">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 17l3 3 7-7M3 12l2.5 2.5M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707"/>
            </svg>
          </div>
          <div>
            <div class="card-title">Informasi Pengiriman</div>
            <div class="card-subtitle">Kurir dan estimasi pengiriman</div>
          </div>
        </div>
        <div class="card-body">
          <div class="info-row">
            <span class="info-label">Kurir</span>
            <span class="info-value" style="text-transform:uppercase;">{{ $order->courier }}</span>
          </div>
          <div class="info-row">
            <span class="info-label">Layanan</span>
            <span class="info-value">{{ $order->courier_service }}</span>
          </div>
          @if($order->shipping_estimate)
            <div class="info-row">
              <span class="info-label">Estimasi</span>
              <span class="info-value">
                {{ preg_replace('/HARI|hari|DAY|day/i', '', $order->shipping_estimate) }} Hari
              </span>
            </div>
          @endif
          @if($order->notes)
            <div class="info-row">
              <span class="info-label">Catatan</span>
              <span class="info-value" style="max-width:240px;font-style:italic;color:var(--gray-500);">{{ $order->notes }}</span>
            </div>
          @endif
        </div>
      </div>

    </div>

    {{-- ── KOLOM KANAN ── --}}
    <div style="display:flex;flex-direction:column;gap:16px;">

      {{-- RINGKASAN HARGA --}}
      <div class="detail-card fade-up" style="animation-delay:.06s">
        <div class="card-head">
          <div class="card-icon">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 11h.01M12 11h.01M15 11h.01M4 19h16a2 2 0 002-2V7a2 2 0 00-2-2H4a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
          </div>
          <div>
            <div class="card-title">Ringkasan Biaya</div>
          </div>
        </div>
        <div class="card-body">
          <div class="price-row">
            <span>Subtotal ({{ $order->items->count() }} item)</span>
            <span class="val">Rp {{ number_format($order->subtotal, 0, ',', '.') }}</span>
          </div>
          <div class="price-row">
            <span>Ongkos Kirim</span>
            <span class="val">Rp {{ number_format($order->shipping_cost, 0, ',', '.') }}</span>
          </div>
          <div class="price-total">
            <span style="font-size:14px;font-weight:700;color:var(--gray-900);">Total</span>
            <span class="jakarta" style="font-size:22px;font-weight:800;color:var(--gray-900);">
              Rp {{ number_format($order->total_amount, 0, ',', '.') }}
            </span>
          </div>
        </div>
      </div>

      {{-- INFO PEMBAYARAN --}}
      <div class="detail-card fade-up" style="animation-delay:.10s">
        <div class="card-head">
          <div class="card-icon">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
            </svg>
          </div>
          <div>
            <div class="card-title">Pembayaran</div>
          </div>
        </div>
        <div class="card-body">
          <div class="info-row">
            <span class="info-label">Status</span>
            <span class="info-value">
              <span class="badge {{ $ps['class'] }}">{{ $ps['label'] }}</span>
            </span>
          </div>
          @if($payment?->payment_method)
            <div class="info-row">
              <span class="info-label">Metode</span>
              <span class="info-value">{{ strtoupper($payment->payment_method) }}</span>
            </div>
          @endif
          @if($payment?->transaction_id)
            <div class="info-row">
              <span class="info-label">ID Transaksi</span>
              <span class="info-value" style="font-size:11px;word-break:break-all;color:var(--gray-500);">
                {{ $payment->transaction_id }}
              </span>
            </div>
          @endif
          <div class="info-row">
            <span class="info-label">Via</span>
            <span class="info-value">Sakurupiah</span>
          </div>
        </div>
      </div>

      {{-- CTA TESTIMONI --}}
      @if($canTestimoni)
        <div class="detail-card fade-up" style="border-color:var(--emerald-100);animation-delay:.14s">
          <div class="card-body" style="background:var(--emerald-50);">
            <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px;">
              <div style="width:36px;height:36px;border-radius:10px;background:var(--emerald-100);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg style="width:18px;height:18px;color:var(--emerald-700);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                </svg>
              </div>
              <div>
                <div class="card-title" style="color:var(--emerald-700);">Bagikan Pengalaman Anda</div>
                <div style="font-size:12px;color:var(--emerald-600);margin-top:1px;">Testimoni membantu pembeli lain</div>
              </div>
            </div>
            <a href="{{ route('testimoni.create', $order->order_code) }}" class="btn-testimoni">
              <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
              </svg>
              Tulis Testimoni
            </a>
          </div>
        </div>
      @elseif($order->testimonial)
        <div class="detail-card fade-up" style="border-color:var(--emerald-100);animation-delay:.14s">
          <div class="card-body" style="background:var(--emerald-50);">
            <div style="display:flex;align-items:center;gap:10px;">
              <svg style="width:20px;height:20px;color:var(--emerald-600);flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
              <div>
                <div style="font-size:13px;font-weight:700;color:var(--emerald-700);">Testimoni sudah dikirim</div>
                <div style="font-size:11.5px;color:var(--emerald-600);margin-top:2px;">Terima kasih telah berbagi pengalaman!</div>
              </div>
            </div>
          </div>
        </div>
      @endif

    </div>

  </div>

</main>

{{-- ══ FOOTER ══ --}}
<footer style="background:var(--white);border-top:1px solid var(--border);margin-top:0;">
  <div style="max-width:960px;margin:0 auto;padding:20px 24px;display:flex;justify-content:space-between;align-items:center;gap:16px;flex-wrap:wrap;">
    <img src="{{ asset('images/logo_full.png') }}" alt="PindahTangan" style="height:28px;width:auto;" />
    <p style="font-size:11.5px;color:var(--gray-400);margin:0;">© {{ date('Y') }} PindahTangan. All rights reserved.</p>
  </div>
</footer>

</body>
</html>