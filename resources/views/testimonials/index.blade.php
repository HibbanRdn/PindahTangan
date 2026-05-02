<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Testimoni Pembeli — PindahTangan</title>
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
      --gray-200:    #e5e7eb;
      --gray-100:    #f3f4f6;
      --gray-50:     #f9fafb;
      --border:      #e5e7eb;
      --white:       #ffffff;
      --star:        #f59e0b;
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

    /* ── Hero stats ── */
    .hero {
      background: var(--white);
      border-bottom: 1px solid var(--border);
      padding: 60px 24px 48px;
      text-align: center;
    }
    .hero-badge {
      display: inline-flex; align-items: center; gap: 6px;
      background: #fef9c3; color: #92400e;
      border: 1px solid #fde68a;
      border-radius: 99px; padding: 4px 14px;
      font-size: 12px; font-weight: 700;
      margin-bottom: 16px;
    }
    .hero-stars {
      display: inline-flex; gap: 4px; margin: 12px 0 8px;
    }
    .hero-stars svg { width: 28px; height: 28px; fill: var(--star); }

    /* ── Stats row ── */
    .stats-row {
      display: flex; justify-content: center; gap: 0;
      max-width: 480px; margin: 24px auto 0;
      background: var(--gray-50);
      border: 1px solid var(--border);
      border-radius: 16px; overflow: hidden;
    }
    .stat-item {
      flex: 1; padding: 16px 12px; text-align: center;
      border-right: 1px solid var(--border);
    }
    .stat-item:last-child { border-right: none; }
    .stat-num {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 22px; font-weight: 800; color: var(--gray-900);
      line-height: 1;
    }
    .stat-label { font-size: 11px; color: var(--gray-400); margin-top: 3px; font-weight: 600; }

    /* ── Filter bar ── */
    .filter-bar {
      max-width: 1280px; margin: 0 auto;
      padding: 20px 24px 0;
      display: flex; align-items: center; gap: 8px; flex-wrap: wrap;
    }
    .filter-btn {
      display: inline-flex; align-items: center; gap: 5px;
      padding: 7px 14px; border-radius: 99px;
      font-size: 12.5px; font-weight: 700;
      border: 1.5px solid var(--border);
      background: var(--white); color: var(--gray-500);
      cursor: pointer; text-decoration: none;
      transition: all .15s;
    }
    .filter-btn:hover { border-color: var(--emerald); color: var(--emerald-600); background: var(--emerald-50); }
    .filter-btn.active { background: var(--gray-900); color: #fff; border-color: var(--gray-900); }
    .filter-btn .star-mini { fill: var(--star); width: 12px; height: 12px; }

    /* ── Grid ── */
    .testimonials-grid {
      max-width: 1280px; margin: 0 auto;
      padding: 20px 24px 60px;
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
      gap: 16px;
    }

    /* ── Testimonial card ── */
    .t-card {
      background: var(--white);
      border: 1px solid var(--border);
      border-radius: 18px;
      padding: 22px;
      transition: border-color .2s, box-shadow .2s;
      display: flex; flex-direction: column; gap: 14px;
    }
    .t-card:hover {
      border-color: var(--emerald-100);
      box-shadow: 0 6px 28px rgba(0,0,0,0.07);
    }

    /* Card header: avatar + name + date */
    .t-header {
      display: flex; align-items: center; gap: 10px;
    }
    .t-avatar {
      width: 40px; height: 40px; border-radius: 50%;
      background: linear-gradient(135deg, var(--emerald-100), #a7f3d0);
      display: flex; align-items: center; justify-content: center;
      font-size: 16px; font-weight: 800; color: var(--emerald-700);
      flex-shrink: 0;
    }
    .t-name { font-size: 13.5px; font-weight: 700; color: var(--gray-900); }
    .t-date { font-size: 11.5px; color: var(--gray-400); margin-top: 1px; }

    /* Stars */
    .t-stars { display: flex; gap: 3px; }
    .t-stars svg { width: 15px; height: 15px; fill: var(--star); }
    .t-stars svg.empty { fill: var(--gray-200); }

    /* Comment */
    .t-comment {
      font-size: 13.5px; color: var(--gray-700);
      line-height: 1.65; flex: 1;
    }
    .t-comment.clamped {
      display: -webkit-box;
      -webkit-line-clamp: 4;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }
    .t-read-more {
      background: none; border: none; padding: 0;
      font-size: 12.5px; font-weight: 700; color: var(--emerald-600);
      cursor: pointer; margin-top: 4px; display: inline-block;
    }

    /* Product ref */
    .t-product {
      display: flex; align-items: center; gap: 9px;
      background: var(--gray-50); border: 1px solid var(--border);
      border-radius: 10px; padding: 9px 12px;
    }
    .t-product-img {
      width: 36px; height: 36px; border-radius: 7px;
      overflow: hidden; border: 1px solid var(--border);
      background: var(--gray-100); flex-shrink: 0;
    }
    .t-product-img img { width: 100%; height: 100%; object-fit: cover; }
    .t-product-name {
      font-size: 12px; font-weight: 600; color: var(--gray-700);
      overflow: hidden; display: -webkit-box;
      -webkit-line-clamp: 1; -webkit-box-orient: vertical;
    }
    .t-product-price { font-size: 11px; color: var(--gray-400); margin-top: 1px; }

    /* Photo gallery */
    .t-photos { display: flex; gap: 6px; flex-wrap: wrap; }
    .t-photo {
      width: 72px; height: 72px; border-radius: 10px;
      overflow: hidden; border: 1px solid var(--border);
      cursor: pointer; flex-shrink: 0;
    }
    .t-photo img { width: 100%; height: 100%; object-fit: cover; transition: transform .2s; }
    .t-photo:hover img { transform: scale(1.08); }

    /* ── Lightbox ── */
    .lightbox {
      position: fixed; inset: 0; z-index: 9999;
      background: rgba(0,0,0,0.85);
      display: none; align-items: center; justify-content: center;
      padding: 20px;
    }
    .lightbox.open { display: flex; }
    .lightbox img {
      max-width: 90vw; max-height: 85vh;
      border-radius: 14px; object-fit: contain;
    }
    .lightbox-close {
      position: absolute; top: 20px; right: 20px;
      width: 40px; height: 40px; border-radius: 50%;
      background: rgba(255,255,255,.15); border: none;
      color: #fff; cursor: pointer; font-size: 20px;
      display: flex; align-items: center; justify-content: center;
      transition: background .15s;
    }
    .lightbox-close:hover { background: rgba(255,255,255,.3); }

    /* ── Empty ── */
    @keyframes floatEmpty { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-8px)} }
    .empty-float { animation: floatEmpty 3s ease-in-out infinite; }

    /* ── Pagination ── */
    .pagination-wrap {
      display: flex; align-items: center; justify-content: center; gap: 6px;
      padding: 0 24px 60px; flex-wrap: wrap;
    }
    .page-btn {
      display: inline-flex; align-items: center; justify-content: center;
      width: 36px; height: 36px; border-radius: 9px;
      font-size: 13px; font-weight: 600;
      text-decoration: none; color: var(--gray-700);
      border: 1px solid var(--border); background: var(--white);
      transition: all .15s;
    }
    .page-btn:hover { border-color: var(--emerald); color: var(--emerald-600); background: var(--emerald-50); }
    .page-btn.active { background: var(--gray-900); color: #fff; border-color: var(--gray-900); }
    .page-btn.disabled { opacity: .4; pointer-events: none; }

    /* ── Animations ── */
    @keyframes fadeUp { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: translateY(0); } }
    .fade-up { animation: fadeUp .5s cubic-bezier(0.22,1,0.36,1) both; }

    @media (max-width: 640px) {
      .nav-inner { padding: 0 16px; }
      .testimonials-grid { grid-template-columns: 1fr; padding: 16px 16px 48px; }
      .hero { padding: 48px 16px 36px; }
    }
  </style>
</head>
<body>

{{-- ══ LIGHTBOX ══ --}}
<div class="lightbox" id="lightbox" onclick="closeLightbox()">
  <button class="lightbox-close" onclick="closeLightbox()">
    <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
    </svg>
  </button>
  <img id="lightbox-img" src="" alt="Foto testimoni" onclick="event.stopPropagation()" />
</div>

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
      @auth
        <a href="{{ route('keranjang.index') }}" class="nav-link">
          <svg style="width:13px;height:13px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
          </svg>
          Keranjang
        </a>
      @endauth
    </div>
  </div>
</nav>

{{-- ══ HERO ══ --}}
<div style="padding-top:64px;">
  <div class="hero">
    <div class="hero-badge">
      <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20">
        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
      </svg>
      Testimoni Pembeli
    </div>

    <h1 class="jakarta" style="font-size:clamp(28px,5vw,48px);font-weight:800;letter-spacing:-.03em;margin:0 0 6px;">
      Kata Mereka yang
      <em class="cormorant" style="color:var(--emerald-600);display:block;font-size:1.15em;">Sudah Berbelanja.</em>
    </h1>
    <p style="font-size:14px;color:var(--gray-400);max-width:400px;margin:0 auto;line-height:1.7;">
      Ulasan nyata dari pembeli preloved PindahTangan — jujur, apa adanya.
    </p>

    {{-- Bintang rata-rata --}}
    @if($stats['total'] > 0)
      <div class="hero-stars">
        @for($i = 1; $i <= 5; $i++)
          <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
               style="fill:{{ $i <= round($stats['avg']) ? 'var(--star)' : 'var(--gray-200)' }}">
            <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
          </svg>
        @endfor
      </div>
      <p class="jakarta" style="font-size:28px;font-weight:800;color:var(--gray-900);margin:0;">
        {{ number_format($stats['avg'], 1) }}
        <span style="font-size:14px;font-weight:500;color:var(--gray-400);">/ 5.0</span>
      </p>

      <div class="stats-row">
        <div class="stat-item">
          <div class="stat-num">{{ $stats['total'] }}</div>
          <div class="stat-label">Total Ulasan</div>
        </div>
        <div class="stat-item">
          <div class="stat-num">{{ number_format($stats['avg'], 1) }}</div>
          <div class="stat-label">Rating Rata‑rata</div>
        </div>
        <div class="stat-item">
          <div class="stat-num">{{ $stats['total'] > 0 ? round($stats['five'] / $stats['total'] * 100) : 0 }}%</div>
          <div class="stat-label">Bintang 5 ⭐</div>
        </div>
      </div>
    @endif
  </div>
</div>

{{-- ══ FILTER ══ --}}
<div class="filter-bar">
  <a href="{{ route('testimoni.index') }}" class="filter-btn {{ !request('rating') ? 'active' : '' }}">
    Semua
  </a>
  @foreach([5,4,3,2,1] as $r)
    <a href="{{ route('testimoni.index', ['rating' => $r]) }}" class="filter-btn {{ request('rating') == $r ? 'active' : '' }}">
      <svg class="star-mini" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
      </svg>
      {{ $r }} Bintang
    </a>
  @endforeach
</div>

{{-- ══ GRID ══ --}}
@if($testimonials->isEmpty())
  <div style="text-align:center;padding:80px 24px;" class="fade-up">
    <div class="empty-float" style="margin-bottom:20px;">
      <div style="width:80px;height:80px;border-radius:24px;background:var(--emerald-50);display:flex;align-items:center;justify-content:center;margin:0 auto;">
        <svg style="width:40px;height:40px;color:#a7f3d0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
        </svg>
      </div>
    </div>
    <h3 class="jakarta" style="font-size:20px;font-weight:800;margin:0 0 8px;">Belum ada testimoni</h3>
    <p style="font-size:13px;color:var(--gray-400);margin:0 0 24px;">Filter ini belum ada ulasannya. Coba filter lain.</p>
    <a href="{{ route('testimoni.index') }}" style="display:inline-flex;align-items:center;gap:6px;padding:10px 22px;font-size:13px;font-weight:700;color:#fff;background:var(--gray-900);border-radius:99px;text-decoration:none;">
      Lihat Semua
    </a>
  </div>
@else
  <div class="testimonials-grid">
    @foreach($testimonials as $i => $t)
      @php
        $initials = collect(explode(' ', $t->user->name))->take(2)->map(fn($w) => strtoupper($w[0]))->join('');
        $firstItem = $t->order->items->first();
        $img = $firstItem?->product?->image ?? null;
        $longComment = strlen($t->comment) > 200;
      @endphp
      <div class="t-card fade-up" style="animation-delay:{{ ($i % 12) * 50 }}ms;">

        {{-- Header --}}
        <div class="t-header">
          <div class="t-avatar">{{ $initials }}</div>
          <div style="flex:1;min-width:0;">
            <div class="t-name">{{ $t->user->name }}</div>
            <div class="t-date">{{ $t->created_at->diffForHumans() }}</div>
          </div>
          {{-- Stars --}}
          <div class="t-stars" style="flex-shrink:0;">
            @for($s = 1; $s <= 5; $s++)
              <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" class="{{ $s <= $t->rating ? '' : 'empty' }}">
                <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
              </svg>
            @endfor
          </div>
        </div>

        {{-- Comment --}}
        <div>
          <p class="t-comment {{ $longComment ? 'clamped' : '' }}" id="comment-{{ $t->id }}">
            "{{ $t->comment }}"
          </p>
          @if($longComment)
            <button class="t-read-more" onclick="toggleComment({{ $t->id }}, this)">Baca selengkapnya ↓</button>
          @endif
        </div>

        {{-- Photos --}}
        @if($t->images->isNotEmpty())
          <div class="t-photos">
            @foreach($t->images->take(4) as $photo)
              <div class="t-photo" onclick="openLightbox('{{ Storage::url($photo->image_path) }}')">
                <img src="{{ Storage::url($photo->image_path) }}" alt="Foto testimoni" loading="lazy" />
              </div>
            @endforeach
          </div>
        @endif

        {{-- Product ref --}}
        @if($firstItem)
          <div class="t-product">
            <div class="t-product-img">
              @if($img)
                <img src="{{ Storage::url($img) }}" alt="{{ $firstItem->product_name }}" />
              @else
                <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;">
                  <svg style="width:16px;height:16px;color:#d1d5db;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                  </svg>
                </div>
              @endif
            </div>
            <div style="flex:1;min-width:0;">
              <div class="t-product-name">{{ $firstItem->product_name }}</div>
              <div class="t-product-price">
                Rp {{ number_format($firstItem->product_price, 0, ',', '.') }}
                @if($t->order->items->count() > 1)
                  <span>· +{{ $t->order->items->count() - 1 }} item lain</span>
                @endif
              </div>
            </div>
          </div>
        @endif

      </div>
    @endforeach
  </div>

  {{-- Pagination --}}
  @if($testimonials->hasPages())
    <div class="pagination-wrap">
      @if($testimonials->onFirstPage())
        <span class="page-btn disabled">
          <svg style="width:13px;height:13px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </span>
      @else
        <a href="{{ $testimonials->previousPageUrl() }}" class="page-btn">
          <svg style="width:13px;height:13px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
      @endif
      @foreach($testimonials->getUrlRange(1, $testimonials->lastPage()) as $page => $url)
        @if($page == $testimonials->currentPage())
          <span class="page-btn active">{{ $page }}</span>
        @else
          <a href="{{ $url }}" class="page-btn">{{ $page }}</a>
        @endif
      @endforeach
      @if($testimonials->hasMorePages())
        <a href="{{ $testimonials->nextPageUrl() }}" class="page-btn">
          <svg style="width:13px;height:13px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </a>
      @else
        <span class="page-btn disabled">
          <svg style="width:13px;height:13px;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
        </span>
      @endif
    </div>
  @endif
@endif

{{-- FOOTER --}}
<footer style="background:var(--white);border-top:1px solid var(--border);">
  <div style="max-width:1280px;margin:0 auto;padding:20px 24px;display:flex;justify-content:space-between;align-items:center;gap:16px;flex-wrap:wrap;">
    <img src="{{ asset('images/logo_full.png') }}" alt="PindahTangan" style="height:28px;width:auto;" />
    <p style="font-size:11.5px;color:var(--gray-400);margin:0;">© {{ date('Y') }} PindahTangan. All rights reserved.</p>
  </div>
</footer>

<script>
function openLightbox(src) {
  document.getElementById('lightbox-img').src = src;
  document.getElementById('lightbox').classList.add('open');
  document.body.style.overflow = 'hidden';
}
function closeLightbox() {
  document.getElementById('lightbox').classList.remove('open');
  document.body.style.overflow = '';
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeLightbox(); });

function toggleComment(id, btn) {
  const el = document.getElementById('comment-' + id);
  const clamped = el.classList.toggle('clamped');
  btn.textContent = clamped ? 'Baca selengkapnya ↓' : 'Sembunyikan ↑';
}
</script>
</body>
</html>