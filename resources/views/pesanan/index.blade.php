<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Riwayat Pesanan — PindahTangan</title>
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
    .nav-link {
      display: inline-flex; align-items: center; gap: 5px;
      font-size: 13px; font-weight: 600;
      color: var(--gray-500); text-decoration: none;
      padding: 6px 12px; border-radius: 8px;
      border: 1px solid transparent;
      transition: all .15s;
    }
    .nav-link:hover { color: var(--gray-900); border-color: var(--border); background: var(--white); }

    /* ── Order card ── */
    .order-card {
      background: var(--white);
      border: 1px solid var(--border);
      border-radius: 18px;
      overflow: hidden;
      transition: border-color .2s, box-shadow .2s;
    }
    .order-card:hover {
      border-color: var(--emerald-100);
      box-shadow: 0 4px 24px rgba(0,0,0,0.07);
    }
    .order-card-header {
      padding: 16px 20px;
      border-bottom: 1px solid var(--gray-100);
      display: flex; align-items: center; justify-content: space-between; gap: 12px;
      flex-wrap: wrap;
    }
    .order-card-body { padding: 16px 20px; }
    .order-card-footer {
      padding: 12px 20px;
      border-top: 1px solid var(--gray-100);
      display: flex; align-items: center; justify-content: space-between; gap: 12px;
      flex-wrap: wrap;
    }

    /* ── Status badges ── */
    .badge {
      display: inline-flex; align-items: center; gap: 5px;
      padding: 3px 10px; border-radius: 99px;
      font-size: 11.5px; font-weight: 700;
    }
    .badge-dot { width: 6px; height: 6px; border-radius: 50%; }

    /* Order status */
    .badge-pending     { background: #fef9c3; color: #854d0e; }
    .badge-processing  { background: #dbeafe; color: #1e40af; }
    .badge-shipped     { background: #ede9fe; color: #5b21b6; }
    .badge-completed   { background: var(--emerald-50); color: var(--emerald-700); }
    .badge-cancelled   { background: #fee2e2; color: #b91c1c; }

    /* Payment status */
    .pay-pending  { background: #fef9c3; color: #854d0e; }
    .pay-paid     { background: var(--emerald-50); color: var(--emerald-700); }
    .pay-failed   { background: #fee2e2; color: #b91c1c; }
    .pay-expired  { background: var(--gray-100); color: var(--gray-500); }

    /* ── Item thumbnails ── */
    .item-thumb-row { display: flex; gap: 8px; align-items: center; flex-wrap: wrap; }
    .item-thumb {
      width: 52px; height: 52px;
      border-radius: 10px;
      overflow: hidden;
      border: 1px solid var(--border);
      background: var(--gray-100);
      flex-shrink: 0;
    }
    .item-thumb img { width: 100%; height: 100%; object-fit: cover; }
    .item-thumb-placeholder {
      width: 100%; height: 100%;
      display: flex; align-items: center; justify-content: center;
    }
    .item-thumb-more {
      width: 52px; height: 52px;
      border-radius: 10px;
      background: var(--gray-100);
      border: 1px dashed var(--border);
      display: flex; align-items: center; justify-content: center;
      font-size: 12px; font-weight: 700; color: var(--gray-400);
      flex-shrink: 0;
    }
    .item-info { flex: 1; min-width: 0; }
    .item-names {
      font-size: 13px; font-weight: 600; color: var(--gray-900);
      line-height: 1.4;
      overflow: hidden;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
    }
    .item-meta { font-size: 11.5px; color: var(--gray-400); margin-top: 3px; }

    /* ── Buttons ── */
    .btn-detail {
      display: inline-flex; align-items: center; gap: 6px;
      padding: 8px 18px;
      font-size: 13px; font-weight: 700;
      color: var(--gray-900);
      background: var(--white);
      border: 1.5px solid var(--border);
      border-radius: 10px;
      text-decoration: none;
      transition: all .18s;
      white-space: nowrap;
    }
    .btn-detail:hover {
      border-color: var(--emerald);
      color: var(--emerald-600);
      background: var(--emerald-50);
    }
    .btn-detail svg { width: 13px; height: 13px; }

    /* ── Empty state ── */
    @keyframes floatEmpty { 0%,100% { transform:translateY(0);} 50% { transform:translateY(-8px);} }
    .empty-float { animation: floatEmpty 3s ease-in-out infinite; }

    /* ── Fade in ── */
    @keyframes fadeUp { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: translateY(0); } }
    .fade-up { animation: fadeUp .5s cubic-bezier(0.22,1,0.36,1) both; }

    /* ── Pagination ── */
    .pagination-wrap {
      display: flex; align-items: center; justify-content: center; gap: 6px;
      margin-top: 32px; flex-wrap: wrap;
    }
    .page-btn {
      display: inline-flex; align-items: center; justify-content: center;
      width: 36px; height: 36px;
      border-radius: 9px;
      font-size: 13px; font-weight: 600;
      text-decoration: none; color: var(--gray-700);
      border: 1px solid var(--border);
      background: var(--white);
      transition: all .15s;
    }
    .page-btn:hover { border-color: var(--emerald); color: var(--emerald-600); background: var(--emerald-50); }
    .page-btn.active { background: var(--gray-900); color: #fff; border-color: var(--gray-900); }
    .page-btn.disabled { opacity: .4; pointer-events: none; }

    @media (max-width: 640px) {
      .nav-inner { padding: 0 16px; }
      .order-card-header { flex-direction: column; align-items: flex-start; }
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
    <div style="display:flex;align-items:center;gap:8px;">
      <a href="{{ route('produk.index') }}" class="nav-link">
        <svg style="width:13px;height:13px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Katalog
      </a>
      <a href="{{ route('keranjang.index') }}" class="nav-link">
        <svg style="width:13px;height:13px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
        </svg>
        Keranjang
      </a>
      <form method="POST" action="{{ route('logout') }}" style="display:inline;">
        @csrf
        <button type="submit" style="width:36px;height:36px;border-radius:50%;border:1px solid var(--border);background:transparent;cursor:pointer;display:flex;align-items:center;justify-content:center;color:var(--gray-400);transition:all .2s;"
          onmouseover="this.style.color='#ef4444';this.style.borderColor='#fca5a5';this.style.background='#fff5f5'"
          onmouseout="this.style.color='var(--gray-400)';this.style.borderColor='var(--border)';this.style.background='transparent'"
          title="Logout">
          <svg style="width:15px;height:15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
          </svg>
        </button>
      </form>
    </div>
  </div>
</nav>

{{-- ══ MAIN ══ --}}
<main style="max-width:860px;margin:0 auto;padding:88px 24px 80px;">

  {{-- Header --}}
  <div style="margin-bottom:28px;" class="fade-up">
    <h1 class="jakarta" style="font-size:clamp(26px,4vw,38px);font-weight:800;letter-spacing:-.03em;margin:0 0 4px;">
      Riwayat <em class="cormorant" style="color:var(--emerald-600);font-size:1.1em;">Pesanan.</em>
    </h1>
    <p style="font-size:13px;color:var(--gray-400);margin:0;">
      {{ $orders->total() }} pesanan tercatat atas akun Anda
    </p>
  </div>

  @if($orders->isEmpty())

    {{-- ── Empty State ── --}}
    <div style="display:flex;flex-direction:column;align-items:center;justify-content:center;padding:80px 0;text-align:center;" class="fade-up">
      <div class="empty-float" style="margin-bottom:24px;">
        <div style="width:96px;height:96px;border-radius:28px;background:var(--emerald-50);display:flex;align-items:center;justify-content:center;margin:0 auto;">
          <svg style="width:48px;height:48px;color:#a7f3d0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
          </svg>
        </div>
      </div>
      <h3 class="jakarta" style="font-size:22px;font-weight:800;margin:0 0 8px;">Belum ada pesanan</h3>
      <p style="font-size:13.5px;color:var(--gray-400);max-width:280px;line-height:1.6;margin:0 0 28px;">
        Yuk mulai belanja barang preloved berkualitas di katalog kami!
      </p>
      <a href="{{ route('produk.index') }}"
         style="display:inline-flex;align-items:center;gap:8px;padding:12px 28px;font-size:13px;font-weight:700;color:#fff;background:var(--gray-900);border-radius:99px;text-decoration:none;transition:background .2s,transform .15s;"
         onmouseover="this.style.background='var(--emerald-600)';this.style.transform='translateY(-1px)'"
         onmouseout="this.style.background='var(--gray-900)';this.style.transform='translateY(0)'">
        <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
        Jelajahi Katalog
      </a>
    </div>

  @else

    <div style="display:flex;flex-direction:column;gap:14px;">
      @foreach($orders as $index => $order)
        @php
          $payment = $order->payment;
          $items   = $order->items;
          $thumb   = $items->take(3);
          $more    = max(0, $items->count() - 3);

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
          $os  = $orderStatusMap[$order->status] ?? ['label' => ucfirst($order->status), 'class' => 'badge-pending'];
          $ps  = $payStatusMap[$payment?->status ?? 'pending'] ?? ['label' => 'Pending', 'class' => 'pay-pending'];
        @endphp

        <div class="order-card fade-up" style="animation-delay:{{ $index * 60 }}ms">

          {{-- Header --}}
          <div class="order-card-header">
            <div>
              <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
                <span class="jakarta" style="font-size:13px;font-weight:800;color:var(--gray-900);">
                  {{ $order->order_code }}
                </span>
                <span class="badge {{ $os['class'] }}">{{ $os['label'] }}</span>
              </div>
              <div style="font-size:12px;color:var(--gray-400);margin-top:3px;">
                {{ $order->created_at->format('d M Y') }} · {{ $order->created_at->format('H:i') }} WIB
              </div>
            </div>
            <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap;">
              <span class="badge {{ $ps['class'] }}">
                <svg style="width:8px;height:8px;" fill="currentColor" viewBox="0 0 8 8">
                  <circle cx="4" cy="4" r="4"/>
                </svg>
                {{ $ps['label'] }}
              </span>
              <span class="jakarta" style="font-size:15px;font-weight:800;color:var(--gray-900);">
                Rp {{ number_format($order->total_amount, 0, ',', '.') }}
              </span>
            </div>
          </div>

          {{-- Body: item thumbnails --}}
          <div class="order-card-body">
            <div class="item-thumb-row">
              @foreach($thumb as $item)
                <div class="item-thumb">
                  @php
                    $img = $item->product?->image ?? null;
                  @endphp
                  @if($img)
                    <img src="{{ Storage::url($img) }}" alt="{{ $item->product_name }}" />
                  @else
                    <div class="item-thumb-placeholder">
                      <svg style="width:20px;height:20px;color:#d1d5db;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                      </svg>
                    </div>
                  @endif
                </div>
              @endforeach
              @if($more > 0)
                <div class="item-thumb-more">+{{ $more }}</div>
              @endif
              <div class="item-info">
                <div class="item-names">
                  {{ $items->pluck('product_name')->take(2)->implode(', ') }}{{ $items->count() > 2 ? ', ...' : '' }}
                </div>
                <div class="item-meta">
                  {{ $items->count() }} item ·
                  {{ ucfirst($order->courier) }} {{ $order->courier_service }}
                </div>
              </div>
            </div>
          </div>

          {{-- Footer --}}
          <div class="order-card-footer">
            <div style="font-size:12px;color:var(--gray-400);">
              @if($order->status === 'shipped')
                <span style="display:inline-flex;align-items:center;gap:4px;color:#5b21b6;">
                  <svg style="width:12px;height:12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8l1.443 9.634A2 2 0 008.43 20h7.14a2 2 0 001.987-1.757L19 8M10 12h4"/>
                  </svg>
                  Dalam perjalanan
                </span>
              @elseif($order->status === 'completed')
                <span style="display:inline-flex;align-items:center;gap:4px;color:var(--emerald-700);">
                  <svg style="width:12px;height:12px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                  </svg>
                  Pesanan selesai
                </span>
              @elseif($order->status === 'pending')
                <span style="color:#854d0e;">Menunggu konfirmasi pembayaran</span>
              @endif
            </div>
            <a href="{{ route('pesanan.show', $order->order_code) }}" class="btn-detail">
              Lihat Detail
              <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
              </svg>
            </a>
          </div>

        </div>
      @endforeach
    </div>

    {{-- ── Pagination ── --}}
    @if($orders->hasPages())
      <div class="pagination-wrap">
        {{-- Prev --}}
        @if($orders->onFirstPage())
          <span class="page-btn disabled">
            <svg style="width:13px;height:13px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
          </span>
        @else
          <a href="{{ $orders->previousPageUrl() }}" class="page-btn">
            <svg style="width:13px;height:13px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
          </a>
        @endif

        {{-- Pages --}}
        @foreach($orders->getUrlRange(1, $orders->lastPage()) as $page => $url)
          @if($page == $orders->currentPage())
            <span class="page-btn active">{{ $page }}</span>
          @else
            <a href="{{ $url }}" class="page-btn">{{ $page }}</a>
          @endif
        @endforeach

        {{-- Next --}}
        @if($orders->hasMorePages())
          <a href="{{ $orders->nextPageUrl() }}" class="page-btn">
            <svg style="width:13px;height:13px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
          </a>
        @else
          <span class="page-btn disabled">
            <svg style="width:13px;height:13px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
          </span>
        @endif
      </div>
    @endif

  @endif

</main>

{{-- ══ FOOTER ══ --}}
<footer style="background:var(--white);border-top:1px solid var(--border);margin-top:0;">
  <div style="max-width:860px;margin:0 auto;padding:20px 24px;display:flex;justify-content:space-between;align-items:center;gap:16px;flex-wrap:wrap;">
    <img src="{{ asset('images/logo_full.png') }}" alt="PindahTangan" style="height:28px;width:auto;" />
    <p style="font-size:11.5px;color:var(--gray-400);margin:0;">© {{ date('Y') }} PindahTangan. All rights reserved.</p>
  </div>
</footer>

</body>
</html>