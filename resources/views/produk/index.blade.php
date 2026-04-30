<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Katalog Produk — PindahTangan</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,700;9..40,800&family=Plus+Jakarta+Sans:ital,wght@0,400;0,600;0,700;0,800;1,400;1,600&family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400;1,600&display=swap" rel="stylesheet">

  <style>
    /* ── Tokens ── */
    :root {
      --emerald:     #10b981;
      --emerald-600: #059669;
      --emerald-50:  #ecfdf5;
      --emerald-100: #d1fae5;
      --gray-900:    #111827;
      --gray-700:    #374151;
      --gray-400:    #9ca3af;
      --gray-100:    #f3f4f6;
      --border:      #e5e7eb;
    }

    body        { font-family: 'DM Sans', sans-serif; background: #fafafa; color: var(--gray-900); }
    .jakarta    { font-family: 'Plus Jakarta Sans', sans-serif; }
    .cormorant  { font-family: 'Cormorant Garamond', serif; }

    /* ── Navbar ── */
    #navbar {
      position: fixed; top: 0; width: 100%; z-index: 50;
      background: rgba(255,255,255,0.85);
      backdrop-filter: blur(12px);
      -webkit-backdrop-filter: blur(12px);
      border-bottom: 1px solid transparent;
      transition: border-color .3s, box-shadow .3s;
    }
    #navbar.scrolled {
      border-bottom-color: var(--border);
      box-shadow: 0 1px 12px rgba(0,0,0,0.06);
    }

    /* ── Skeleton shimmer ── */
    @keyframes shimmer {
      0%   { background-position: -600px 0; }
      100% { background-position:  600px 0; }
    }
    .skeleton {
      background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
      background-size: 600px 100%;
      animation: shimmer 1.4s infinite linear;
      border-radius: 8px;
    }

    /* ── Product card ── */
    .product-card {
      background: #fff;
      border: 1px solid var(--border);
      border-radius: 20px;
      overflow: hidden;
      transition: transform .3s cubic-bezier(0.34,1.56,0.64,1), box-shadow .3s ease, border-color .3s;
    }
    .product-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 20px 48px rgba(0,0,0,0.10);
      border-color: var(--emerald-100);
    }
    .product-card:hover .card-img img {
      transform: scale(1.05);
    }
    .card-img {
      overflow: hidden;
      aspect-ratio: 1;
      background: var(--gray-100);
    }
    .card-img img {
      width: 100%; height: 100%;
      object-fit: cover;
      transition: transform .5s ease;
    }

    /* ── Condition badge ── */
    .badge-condition {
      display: inline-flex; align-items: center; gap: 4px;
      padding: 3px 10px;
      border-radius: 99px;
      font-size: 11px; font-weight: 700;
      letter-spacing: .02em;
    }
    .badge-like_new { background: #dcfce7; color: #15803d; }
    .badge-good     { background: #dbeafe; color: #1d4ed8; }
    .badge-fair     { background: #ffedd5; color: #9a3412; }

    /* ── Category chip ── */
    .chip {
      display: inline-flex; align-items: center;
      padding: 6px 14px;
      border: 1.5px solid var(--border);
      border-radius: 99px;
      font-size: 13px; font-weight: 600;
      cursor: pointer;
      text-decoration: none;
      color: var(--gray-700);
      background: #fff;
      transition: all .2s;
      white-space: nowrap;
    }
    .chip:hover  { border-color: var(--emerald); color: var(--emerald-600); background: var(--emerald-50); }
    .chip.active { border-color: var(--emerald-600); background: var(--emerald-600); color: #fff; }

    /* ── Filter select ── */
    .filter-select {
      padding: 8px 14px;
      border: 1.5px solid var(--border);
      border-radius: 10px;
      font-size: 13px; font-weight: 600;
      font-family: 'DM Sans', sans-serif;
      color: var(--gray-700);
      background: #fff;
      outline: none;
      cursor: pointer;
      transition: border-color .2s, box-shadow .2s;
    }
    .filter-select:focus {
      border-color: var(--emerald);
      box-shadow: 0 0 0 3px rgba(16,185,129,.1);
    }

    /* ── Search input ── */
    .search-wrap { position: relative; }
    .search-input {
      width: 100%;
      padding: 10px 16px 10px 42px;
      border: 1.5px solid var(--border);
      border-radius: 12px;
      font-size: 13.5px;
      font-family: 'DM Sans', sans-serif;
      color: var(--gray-900);
      background: #fff;
      outline: none;
      transition: border-color .2s, box-shadow .2s;
    }
    .search-input:focus {
      border-color: var(--emerald);
      box-shadow: 0 0 0 3px rgba(16,185,129,.1);
    }
    .search-icon {
      position: absolute; left: 14px; top: 50%;
      transform: translateY(-50%);
      width: 16px; height: 16px;
      color: var(--gray-400); pointer-events: none;
    }

    /* ── Parallax blob ── */
    .blob-parallax { will-change: transform; pointer-events: none; }

    /* ── Reveal animation ── */
    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(24px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    .fade-up { animation: fadeUp .6s cubic-bezier(0.22,1,0.36,1) both; }
    .card-grid .product-card { opacity: 0; }
    .card-grid .product-card.revealed {
      opacity: 1;
      animation: fadeUp .5s cubic-bezier(0.22,1,0.36,1) both;
    }

    /* ── Button primary ── */
    .btn-emerald {
      display: inline-flex; align-items: center; justify-content: center; gap: 7px;
      padding: 10px 22px;
      background: var(--gray-900); color: #fff;
      border: none; border-radius: 10px;
      font-size: 13.5px; font-weight: 700;
      font-family: 'DM Sans', sans-serif;
      cursor: pointer; text-decoration: none;
      transition: background .2s, transform .15s, box-shadow .2s;
    }
    .btn-emerald:hover {
      background: var(--emerald-600);
      box-shadow: 0 6px 20px rgba(5,150,105,0.3);
      transform: translateY(-1px);
    }
    .btn-emerald:active { transform: translateY(0); }

    /* ── Pagination ── */
    .pagination-wrap nav { display: flex; justify-content: center; }
    .pagination-wrap .page-item .page-link {
      font-size: 13px; font-weight: 600;
    }

    /* ── Empty state ── */
    @keyframes floatEmpty {
      0%, 100% { transform: translateY(0); }
      50%       { transform: translateY(-8px); }
    }
    .empty-float { animation: floatEmpty 3s ease-in-out infinite; }

    /* ── Sold overlay ── */
    .sold-overlay {
      position: absolute; inset: 0;
      background: rgba(0,0,0,0.35);
      display: flex; align-items: center; justify-content: center;
    }
    .sold-tag {
      background: rgba(17,24,39,0.9);
      color: #fff;
      padding: 6px 20px;
      border-radius: 99px;
      font-size: 12px; font-weight: 800;
      letter-spacing: .08em;
      text-transform: uppercase;
    }

    /* ── Scrollbar hide for chip row ── */
    .chip-row {
      display: flex; gap: 8px; overflow-x: auto;
      scrollbar-width: none; padding-bottom: 2px;
    }
    .chip-row::-webkit-scrollbar { display: none; }

    /* ── Result count pill ── */
    .result-pill {
      display: inline-flex; align-items: center; gap: 6px;
      padding: 5px 14px;
      background: var(--emerald-50);
      border: 1px solid var(--emerald-100);
      border-radius: 99px;
      font-size: 12.5px; font-weight: 600;
      color: var(--emerald-600);
    }
    .result-dot { width: 7px; height: 7px; border-radius: 50%; background: var(--emerald); }


    .catalog-toolbar.compact {
      opacity: 0;
      transform: translateY(-10px);
      pointer-events: none;
      max-height: 0;
      overflow: hidden;
      transition: opacity .25s ease, transform .25s ease, max-height .25s ease;
    }
    body.island-mode .catalog-toolbar.compact {
      opacity: 1;
      transform: translateY(0);
      pointer-events: auto;
      max-height: 420px;
    }
    #dynamic-island {
      position: fixed;
      top: 76px;
      left: 50%;
      transform: translateX(-50%) translateY(-12px) scale(.95);
      z-index: 60;
      opacity: 0;
      pointer-events: none;
      transition: opacity .25s ease, transform .25s ease;
    }
    body.island-mode #dynamic-island {
      opacity: 1;
      pointer-events: auto;
      transform: translateX(-50%) translateY(0) scale(1);
    }
    .island-shell {
      background: rgba(17,24,39,.9);
      backdrop-filter: blur(12px);
      border-radius: 999px;
      padding: 6px;
      display: flex;
      align-items: center;
      gap: 6px;
      box-shadow: 0 12px 28px rgba(0,0,0,.2);
    }
    .island-btn {
      width: 36px; height: 36px; border-radius: 999px;
      display:flex; align-items:center; justify-content:center;
      color:#fff; background: transparent; border: none; cursor: pointer;
    }
    .island-btn:hover { background: rgba(255,255,255,.14); }
    .island-panel {
      background: #fff; border: 1px solid var(--border); border-radius: 16px;
      margin-top: 8px; padding: 12px; width: min(92vw, 760px);
      box-shadow: 0 16px 36px rgba(0,0,0,.14);
      display:none;
    }
    #dynamic-island.expanded .island-panel { display:block; }

    /* ── Responsive ── */
    @media (max-width: 640px) {
      .filter-row { flex-direction: column; gap: 10px; }
    }
  </style>
</head>
<body>

  <!-- ══ NAVBAR (identik dengan welcome.blade.php) ══ -->
  <nav id="navbar">
    <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between relative">

      <a href="{{ route('home') }}" class="shrink-0 z-10">
        <img src="{{ asset('images/logo_full.png') }}" alt="PindahTangan" class="h-10 w-auto" />
      </a>

      <div class="hidden md:flex items-center gap-8 text-sm font-medium text-gray-500 absolute left-1/2 -translate-x-1/2">
        <a href="{{ route('home') }}" class="hover:text-gray-900 transition-colors duration-200">Beranda</a>
        <a href="{{ route('produk.index') }}" class="text-emerald-600 font-bold">Katalog</a>
      </div>

      <div class="flex items-center gap-3 z-10">
        @auth
          @if(auth()->user()->isAdmin())
            <a href="{{ route('admin.dashboard') }}"
               class="hidden md:inline-flex text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors duration-200">
              Admin
            </a>
          @endif
          <a href="{{ route('keranjang.index') }}"
             class="relative w-9 h-9 rounded-full bg-white/70 border border-gray-200 flex items-center justify-center text-gray-600 hover:text-emerald-600 hover:border-emerald-200 transition-all duration-200">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
          </a>
          <form method="POST" action="{{ route('logout') }}" class="hidden md:inline">
            @csrf
            <button type="submit" title="Keluar"
              class="w-9 h-9 rounded-full bg-white/70 border border-gray-200 flex items-center justify-center text-gray-600 hover:text-red-500 hover:border-red-200 transition-all duration-200">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
              </svg>
            </button>
          </form>
        @else
          <a href="{{ route('login') }}" title="Masuk"
             class="w-9 h-9 rounded-full bg-white/70 border border-gray-200 flex items-center justify-center text-gray-600 hover:text-gray-900 hover:bg-white transition-all duration-200">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
          </a>
        @endauth

        <a href="{{ route('produk.index') }}"
           class="btn-emerald hidden md:inline-flex text-sm px-4 py-2 rounded-full shadow-sm">
          Mulai Belanja
        </a>
      </div>
    </div>
  </nav>

  <!-- ══ HERO SECTION ══ -->
  <section class="relative pt-28 pb-14 px-6 overflow-hidden bg-white">

    <!-- Parallax blobs -->
    <div class="blob-parallax absolute -top-24 -right-24 w-96 h-96 rounded-full opacity-40 pointer-events-none"
         style="background: radial-gradient(circle, #d1fae5, #ecfdf5); filter: blur(60px);" id="blob1"></div>
    <div class="blob-parallax absolute bottom-0 -left-16 w-72 h-72 rounded-full opacity-30 pointer-events-none"
         style="background: radial-gradient(circle, #a7f3d0, #d1fae5); filter: blur(50px);" id="blob2"></div>

    <div class="max-w-7xl mx-auto relative z-10">
      <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">

        <div class="fade-up">
          <p class="text-xs font-bold tracking-widest uppercase text-emerald-600 mb-3 jakarta">
            — Preloved Berkualitas
          </p>
          <h1 class="text-5xl md:text-6xl font-black tracking-tighter text-gray-900 leading-[0.95] jakarta">
            Katalog<br/>
            <em class="cormorant not-italic font-semibold text-emerald-600" style="font-style:italic;font-size:1.1em;">
              Pilihan Terbaik.
            </em>
          </h1>
          <p class="text-gray-400 text-base mt-4 max-w-md leading-relaxed">
            Barang layak pakai, kondisi transparan, harga lebih hemat.
            Temukan sesuatu yang baru buat kamu.
          </p>
        </div>

        @if($produk->total() > 0)
          <div class="fade-up" style="animation-delay:.1s">
            <div class="result-pill">
              <div class="result-dot"></div>
              {{ number_format($produk->total()) }} barang tersedia
            </div>
          </div>
        @endif

      </div>
    </div>
  </section>

  <!-- ══ FILTER & SEARCH ══ -->
  <section class="sticky top-16 z-40 bg-white/90 backdrop-blur-md border-b border-gray-100 shadow-sm catalog-toolbar" id="catalog-toolbar">
    <div class="max-w-7xl mx-auto px-6 py-3">

      <form method="GET" action="{{ route('produk.index') }}" id="filter-form">

        <!-- Row 1: Search + Sort + Condition -->
        <div class="flex flex-wrap items-center gap-3 mb-3 filter-row">

          <!-- Search -->
          <div class="search-wrap flex-1" style="min-width:200px;">
            <svg class="search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Cari barang..." class="search-input"
                   id="search-input" />
          </div>

          <!-- Condition filter -->
          <select name="condition" class="filter-select" onchange="document.getElementById('filter-form').submit()">
            <option value="">Semua Kondisi</option>
            <option value="like_new" {{ request('condition') === 'like_new' ? 'selected' : '' }}>Like New</option>
            <option value="good"     {{ request('condition') === 'good'     ? 'selected' : '' }}>Good</option>
            <option value="fair"     {{ request('condition') === 'fair'     ? 'selected' : '' }}>Fair</option>
          </select>

          <!-- Sort -->
          <select name="sort" class="filter-select" onchange="document.getElementById('filter-form').submit()">
            <option value="latest"     {{ request('sort','latest') === 'latest'     ? 'selected' : '' }}>Terbaru</option>
            <option value="price_asc"  {{ request('sort') === 'price_asc'           ? 'selected' : '' }}>Harga Terendah</option>
            <option value="price_desc" {{ request('sort') === 'price_desc'          ? 'selected' : '' }}>Harga Tertinggi</option>
            <option value="name"       {{ request('sort') === 'name'                ? 'selected' : '' }}>Nama A–Z</option>
          </select>

          <!-- Submit search -->
          <button type="submit" class="btn-emerald px-4 py-2 text-sm rounded-xl">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            Cari
          </button>

          @if(request()->hasAny(['search','category','condition','sort']))
            <a href="{{ route('produk.index') }}"
               class="flex items-center gap-1.5 text-xs font-semibold text-gray-400 hover:text-red-500 transition-colors duration-200">
              <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
              </svg>
              Reset
            </a>
          @endif

        </div>

        <!-- Row 2: Category chips -->
        <div class="chip-row">
          <a href="{{ route('produk.index', array_merge(request()->except('category','page'), [])) }}"
             class="chip {{ !request('category') ? 'active' : '' }}">
            Semua
          </a>
          @foreach($categories as $cat)
            <a href="{{ route('produk.index', array_merge(request()->except('category','page'), ['category' => $cat->id])) }}"
               class="chip {{ request('category') == $cat->id ? 'active' : '' }}">
              {{ $cat->name }}
            </a>
          @endforeach
        </div>

        <!-- Hidden: pertahankan filter lain saat category chip diklik -->
        @if(request('sort'))    <input type="hidden" name="sort"      value="{{ request('sort') }}"> @endif
        @if(request('condition'))<input type="hidden" name="condition" value="{{ request('condition') }}"> @endif

      </form>
    </div>
  </section>

  <div id="dynamic-island">
    <div class="island-shell">
      <button type="button" class="island-btn" id="island-toggle" title="Buka alat katalog">
        <img src="{{ asset('images/logo_half.png') }}" alt="menu" class="w-6 h-6">
      </button>
      <a href="{{ route('home') }}" class="island-btn" title="Beranda katalog">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l9-9 9 9M9 21V9h6v12"/></svg>
      </a>
      @auth
      <form method="POST" action="{{ route('logout') }}">@csrf<button type="submit" class="island-btn" title="Keluar"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7"/></svg></button></form>
      @endauth
    </div>
    <div class="island-panel">
      <div class="catalog-toolbar compact">
        <form method="GET" action="{{ route('produk.index') }}">
          <div class="flex flex-wrap items-center gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari barang..." class="search-input flex-1"/>
            <select name="condition" class="filter-select">
              <option value="">Semua Kondisi</option><option value="like_new" {{ request('condition') === 'like_new' ? 'selected' : '' }}>Like New</option><option value="good" {{ request('condition') === 'good' ? 'selected' : '' }}>Good</option><option value="fair" {{ request('condition') === 'fair' ? 'selected' : '' }}>Fair</option>
            </select>
            <select name="sort" class="filter-select">
              <option value="latest" {{ request('sort','latest') === 'latest' ? 'selected' : '' }}>Terbaru</option><option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Harga Terendah</option><option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Harga Tertinggi</option><option value="name" {{ request('sort') === 'name' ? 'selected' : '' }}>Nama A–Z</option>
            </select>
            <button type="submit" class="btn-emerald px-4 py-2 text-sm rounded-xl">Terapkan</button>
          </div>
        </form>
      </div>
    </div>
  </div>


  <!-- ══ PRODUCT GRID ══ -->
  <main class="max-w-7xl mx-auto px-6 py-10">

    <!-- Skeleton Loading -->
    <div id="skeleton-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
      @for($i = 0; $i < 8; $i++)
        <div class="rounded-2xl overflow-hidden border border-gray-100 bg-white">
          <div class="skeleton" style="aspect-ratio:1;"></div>
          <div class="p-4 space-y-3">
            <div class="skeleton h-3 w-1/3 rounded"></div>
            <div class="skeleton h-4 w-full rounded"></div>
            <div class="skeleton h-4 w-4/5 rounded"></div>
            <div class="flex justify-between items-center pt-1">
              <div class="skeleton h-5 w-24 rounded"></div>
              <div class="skeleton h-8 w-8 rounded-full"></div>
            </div>
          </div>
        </div>
      @endfor
    </div>

    <!-- Real Content -->
    <div id="real-grid" style="opacity:0;transition:opacity .4s ease;">

      @if($produk->count() > 0)

        <div class="card-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
          @foreach($produk as $p)
            @php
              $condLabel = match($p->condition) {
                'like_new' => 'Like New',
                'good'     => 'Good',
                'fair'     => 'Fair',
                default    => $p->condition,
              };
            @endphp

            <a href="{{ route('produk.show', $p->slug) }}"
               class="product-card group block"
               style="transition-delay: {{ $loop->index * 40 }}ms">

              <!-- Gambar -->
              <div class="card-img relative">
                @if($p->image)
                  <img src="{{ Storage::url($p->image) }}" alt="{{ $p->name }}"
                       loading="lazy" />
                @else
                  <div class="w-full h-full flex items-center justify-center bg-gray-100">
                    <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                  </div>
                @endif

                <!-- Condition badge overlay -->
                <div class="absolute top-3 left-3">
                  <span class="badge-condition badge-{{ $p->condition }}">{{ $condLabel }}</span>
                </div>

                <!-- Arrow hover -->
                <div class="absolute bottom-3 right-3 w-8 h-8 rounded-full bg-white/90 backdrop-blur-sm flex items-center justify-center
                            shadow-sm opacity-0 group-hover:opacity-100 translate-y-2 group-hover:translate-y-0
                            transition-all duration-300">
                  <svg class="w-3.5 h-3.5 text-gray-900" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                  </svg>
                </div>
              </div>

              <!-- Info -->
              <div class="p-4">
                <p class="text-xs font-semibold text-gray-400 mb-1 uppercase tracking-wider">
                  {{ $p->category->name ?? '—' }}
                </p>
                <h3 class="text-sm font-bold text-gray-900 leading-snug mb-3 line-clamp-2 jakarta">
                  {{ $p->name }}
                </h3>
                <div class="flex items-center justify-between">
                  <span class="text-base font-black text-gray-900">
                    Rp {{ number_format($p->price, 0, ',', '.') }}
                  </span>
                  <span class="w-8 h-8 rounded-full bg-emerald-50 flex items-center justify-center
                                text-emerald-600 group-hover:bg-emerald-600 group-hover:text-white
                                transition-colors duration-300">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                    </svg>
                  </span>
                </div>
              </div>
            </a>
          @endforeach
        </div>

        <!-- Pagination -->
        @if($produk->hasPages())
          <div class="mt-10 flex justify-center pagination-wrap">
            {{ $produk->links() }}
          </div>
        @endif

      @else
        <!-- Empty state -->
        <div class="flex flex-col items-center justify-center py-24 text-center">
          <div class="empty-float mb-6">
            <div class="w-20 h-20 rounded-3xl bg-emerald-50 flex items-center justify-center mx-auto">
              <svg class="w-10 h-10 text-emerald-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                  d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
              </svg>
            </div>
          </div>
          <h3 class="text-xl font-black text-gray-900 mb-2 jakarta">Tidak ada produk ditemukan</h3>
          <p class="text-gray-400 text-sm mb-6 max-w-xs leading-relaxed">
            Coba ubah kata kunci atau filter kategori.
            Barang baru datang setiap saat!
          </p>
          <a href="{{ route('produk.index') }}" class="btn-emerald text-sm px-6 py-2.5 rounded-full">
            Lihat Semua Barang
          </a>
        </div>
      @endif

    </div>
  </main>

  <!-- ══ FOOTER ══ -->
  <footer class="bg-white border-t border-gray-100 mt-16">
    <div class="max-w-7xl mx-auto px-6 py-10">
      <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <div class="flex items-center gap-3">
          <img src="{{ asset('images/logo_full.png') }}" alt="PindahTangan" class="h-8 w-auto" />
          <p class="text-sm text-gray-400">Platform preloved berkualitas.</p>
        </div>
        <p class="text-xs text-gray-400">© {{ date('Y') }} PindahTangan. All rights reserved.</p>
      </div>
    </div>
  </footer>

  <script>
  document.addEventListener('DOMContentLoaded', () => {

    // ── 1. Skeleton → Real Content ─────────────────────────────
    const skeleton = document.getElementById('skeleton-grid');
    const real     = document.getElementById('real-grid');

    setTimeout(() => {
      if (skeleton) {
        skeleton.style.opacity = '0';
        skeleton.style.transition = 'opacity .3s ease';
        setTimeout(() => skeleton.remove(), 300);
      }
      if (real) {
        real.style.opacity = '1';
        // Reveal cards staggered
        document.querySelectorAll('.card-grid .product-card').forEach((card, i) => {
          setTimeout(() => card.classList.add('revealed'), i * 50);
        });
      }
    }, 500);

    // ── 2. Navbar scroll ────────────────────────────────────────
    const navbar = document.getElementById('navbar');
    const island = document.getElementById('dynamic-island');
    const toolbar = document.getElementById('catalog-toolbar');
    const toggleIsland = document.getElementById('island-toggle');
    const onScroll = () => {
      const scrolled = window.scrollY > 80;
      navbar.classList.toggle('scrolled', window.scrollY > 10);
      document.body.classList.toggle('island-mode', scrolled);
      toolbar.style.opacity = scrolled ? '0' : '1';
      toolbar.style.pointerEvents = scrolled ? 'none' : 'auto';
      toolbar.style.maxHeight = scrolled ? '0px' : '400px';
      if (!scrolled) island.classList.remove('expanded');
    };
    toggleIsland?.addEventListener('click', () => island.classList.toggle('expanded'));
    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();

    // ── 3. Subtle parallax on blobs (hero only) ─────────────────
    const blob1 = document.getElementById('blob1');
    const blob2 = document.getElementById('blob2');
    let rafPending = false;
    window.addEventListener('scroll', () => {
      if (rafPending) return;
      rafPending = true;
      requestAnimationFrame(() => {
        const sy = window.scrollY;
        if (blob1) blob1.style.transform = `translateY(${sy * 0.08}px)`;
        if (blob2) blob2.style.transform = `translateY(${sy * -0.05}px)`;
        rafPending = false;
      });
    }, { passive: true });

    // ── 4. IntersectionObserver for card reveal on paginate ─────
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('revealed');
          observer.unobserve(entry.target);
        }
      });
    }, { threshold: 0.1 });

    document.querySelectorAll('.product-card').forEach(card => observer.observe(card));

  });
  </script>

</body>
</html>