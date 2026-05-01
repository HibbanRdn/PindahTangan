<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>{{ $produk->name }} — PindahTangan</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,700;9..40,800&family=Plus+Jakarta+Sans:ital,wght@0,400;0,600;0,700;0,800;1,400&family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400;1,600&display=swap" rel="stylesheet">

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

    body       { font-family: 'DM Sans', sans-serif; background: #fff; color: var(--gray-900); }
    .jakarta   { font-family: 'Plus Jakarta Sans', sans-serif; }
    .cormorant { font-family: 'Cormorant Garamond', serif; }

    /* ─────────────────────────────────────────────────
       NAVBAR — seragam dengan halaman lain
    ───────────────────────────────────────────────── */
    #navbar {
      position: fixed;
      top: 0;
      width: 100%;
      z-index: 50;
      background: rgba(255, 255, 255, 0.92);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      border-bottom: 1px solid var(--border);
      box-shadow: 0 1px 8px rgba(0, 0, 0, 0.04);
    }

    .nav-inner {
      max-width: 1280px;
      margin: 0 auto;
      padding: 0 24px;
      height: 64px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
    }

    /* Tombol ikon bulat (keranjang, pesanan, login) */
    .nav-icon-btn {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      background: transparent;
      border: 1.5px solid var(--border);
      color: var(--gray-500);
      cursor: pointer;
      text-decoration: none;
      transition: all 0.2s;
      flex-shrink: 0;
    }
    .nav-icon-btn:hover {
      background: var(--gray-50);
      color: var(--gray-900);
      border-color: #d1d5db;
    }
    .nav-icon-btn svg { width: 15px; height: 15px; }

    /* Tombol berlabel "Pesanan" */
    .nav-pesanan-btn {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 7px 13px;
      border: 1.5px solid var(--border);
      border-radius: 9px;
      font-size: 12.5px;
      font-weight: 700;
      color: var(--gray-500);
      background: var(--white);
      text-decoration: none;
      transition: all 0.2s;
      flex-shrink: 0;
      white-space: nowrap;
    }
    .nav-pesanan-btn svg { width: 14px; height: 14px; }
    .nav-pesanan-btn:hover {
      border-color: var(--emerald);
      color: var(--emerald-700);
      background: var(--emerald-50);
    }

    /* Tombol "← Katalog" (pill hitam) */
    .nav-back-btn {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      padding: 7px 16px;
      font-size: 12.5px;
      font-weight: 700;
      color: var(--white);
      background: var(--gray-900);
      border: none;
      border-radius: 99px;
      text-decoration: none;
      transition: background 0.2s, transform 0.15s;
      white-space: nowrap;
      flex-shrink: 0;
    }
    .nav-back-btn:hover {
      background: var(--emerald-600);
      transform: translateY(-1px);
    }
    .nav-back-btn svg { width: 13px; height: 13px; }

    /* Grup kanan navbar */
    .nav-actions {
      display: flex;
      align-items: center;
      gap: 6px;
    }

    @media (max-width: 640px) {
      .nav-inner { padding: 0 16px; }
      .nav-back-btn { display: none; }   /* sembunyikan di mobile, breadcrumb sudah cukup */
      .nav-pesanan-btn { display: none; }
    }

    /* ── Gallery ── */
    .gallery-main {
      aspect-ratio: 1;
      border-radius: 20px;
      overflow: hidden;
      background: var(--gray-100);
      border: 1px solid var(--border);
      position: relative;
    }
    .gallery-main img {
      width: 100%; height: 100%;
      object-fit: cover;
      transition: transform .6s ease;
    }
    .gallery-main:hover img { transform: scale(1.03); }

    .gallery-thumb {
      aspect-ratio: 1; border-radius: 10px; overflow: hidden;
      border: 2px solid var(--border);
      cursor: pointer; transition: border-color .2s;
      background: var(--gray-100);
    }
    .gallery-thumb:hover   { border-color: var(--emerald); }
    .gallery-thumb.active  { border-color: var(--emerald-600); }
    .gallery-thumb img     { width: 100%; height: 100%; object-fit: cover; }

    /* ── Condition badge ── */
    .badge-condition {
      display: inline-flex; align-items: center; gap: 5px;
      padding: 5px 14px; border-radius: 99px;
      font-size: 12px; font-weight: 700;
    }
    .badge-like_new { background: #dcfce7; color: #15803d; }
    .badge-good     { background: #dbeafe; color: #1d4ed8; }
    .badge-fair     { background: #ffedd5; color: #9a3412; }
    .badge-sold     { background: #f1f5f9; color: #475569; }

    /* ── Add to cart button ── */
    .btn-cart {
      width: 100%; padding: 14px 24px;
      background: var(--gray-900); color: #fff;
      border: none; border-radius: 14px;
      font-size: 15px; font-weight: 800;
      font-family: 'DM Sans', sans-serif;
      cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 10px;
      transition: background .2s, transform .15s, box-shadow .2s;
      position: relative; overflow: hidden;
    }
    .btn-cart::before {
      content: '';
      position: absolute; inset: 0;
      background: linear-gradient(135deg, rgba(16,185,129,0), rgba(5,150,105,0.15));
      opacity: 0; transition: opacity .3s;
    }
    .btn-cart:hover::before { opacity: 1; }
    .btn-cart:hover:not(:disabled) {
      background: var(--emerald-600);
      box-shadow: 0 10px 30px rgba(5,150,105,0.35);
      transform: translateY(-2px);
    }
    .btn-cart:active:not(:disabled) { transform: translateY(0); }
    .btn-cart:disabled {
      background: #e5e7eb; color: #9ca3af;
      cursor: not-allowed; box-shadow: none;
    }

    /* ── Info row ── */
    .info-row {
      display: flex; align-items: flex-start; gap: 12px;
      padding: 14px 0; border-bottom: 1px solid var(--gray-100);
    }
    .info-icon {
      width: 36px; height: 36px; border-radius: 9px;
      background: var(--emerald-50);
      display: flex; align-items: center; justify-content: center;
      flex-shrink: 0;
    }
    .info-icon svg { width: 16px; height: 16px; color: var(--emerald-600); }

    /* ── Related product card ── */
    .rel-card {
      border: 1px solid var(--border); border-radius: 16px;
      overflow: hidden; background: #fff;
      transition: transform .3s cubic-bezier(0.34,1.56,0.64,1), border-color .2s, box-shadow .2s;
    }
    .rel-card:hover {
      transform: translateY(-5px);
      border-color: var(--emerald-100);
      box-shadow: 0 16px 40px rgba(0,0,0,0.08);
    }
    .rel-card:hover .rel-img img { transform: scale(1.05); }
    .rel-img { aspect-ratio:1; overflow:hidden; background:var(--gray-100); }
    .rel-img img { width:100%; height:100%; object-fit:cover; transition:transform .5s ease; }

    /* ── Skeleton ── */
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

    /* ── Parallax ── */
    .blob-parallax { will-change: transform; pointer-events: none; }

    /* ── Fade in ── */
    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(20px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    .fade-up { animation: fadeUp .6s cubic-bezier(0.22,1,0.36,1) both; }

    /* ── Toast ── */
    @keyframes toastIn  { from { opacity:0; transform:translateX(100%) scale(.95); } to { opacity:1; transform:translateX(0) scale(1); } }
    @keyframes toastOut { from { opacity:1; transform:translateX(0) scale(1); } to { opacity:0; transform:translateX(100%) scale(.95); } }
    .toast {
      position:fixed; top:1.25rem; right:1.25rem; z-index:9999;
      background:#fff; border:1px solid var(--border); border-radius:14px;
      padding:14px 18px; display:flex; align-items:center; gap:12px;
      min-width:260px; box-shadow:0 8px 32px rgba(0,0,0,0.12);
      animation: toastIn .35s cubic-bezier(0.22,1,0.36,1) both;
    }
    .toast.hiding { animation: toastOut .3s ease forwards; }
    .toast-icon { width:34px; height:34px; border-radius:9px; display:flex; align-items:center; justify-content:center; flex-shrink:0; }

    /* ── Breadcrumb ── */
    .breadcrumb { display:flex; align-items:center; gap:6px; font-size:12.5px; color:var(--gray-400); flex-wrap:wrap; }
    .breadcrumb a { color:var(--gray-400); text-decoration:none; transition:color .15s; }
    .breadcrumb a:hover { color:var(--gray-900); }
    .breadcrumb svg { width:12px; height:12px; flex-shrink:0; }

    /* ── Sold banner ── */
    .sold-banner {
      background: linear-gradient(135deg, #f8fafc, #f1f5f9);
      border: 1px solid #e2e8f0; border-radius: 14px;
      padding: 16px 20px; display: flex; align-items: center; gap: 12px;
    }
  </style>
</head>
<body>

  <!-- Toast container -->
  <div id="toast-container"></div>

  <!-- ══ NAVBAR ══ -->
  <nav id="navbar">
    <div class="nav-inner">

      {{-- Logo --}}
      <a href="{{ route('produk.index') }}" style="flex-shrink:0;">
        <img src="{{ asset('images/logo_full.png') }}" alt="PindahTangan" style="height:40px;width:auto;" />
      </a>

      {{-- Grup kanan --}}
      <div class="nav-actions">

        @auth
          {{-- Tombol Pesanan (berlabel, disembunyikan di mobile via CSS) --}}
          <a href="{{ route('pesanan.index') }}" class="nav-pesanan-btn" title="Riwayat Pesanan">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
            </svg>
            Pesanan
          </a>

          {{-- Keranjang --}}
          <a href="{{ route('keranjang.index') }}" class="nav-icon-btn" title="Keranjang">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
          </a>

          {{-- Logout --}}
          <form method="POST" action="{{ route('logout') }}" style="display:inline;">
            @csrf
            <button type="submit" class="nav-icon-btn" title="Keluar"
              onmouseover="this.style.color='#ef4444';this.style.borderColor='#fca5a5';this.style.background='#fff5f5'"
              onmouseout="this.style.color='';this.style.borderColor='';this.style.background=''">
              <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
              </svg>
            </button>
          </form>

        @else
          {{-- Login --}}
          <a href="{{ route('login') }}" class="nav-icon-btn" title="Masuk">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
          </a>
        @endauth

        {{-- ← Kembali ke Katalog --}}
        <a href="{{ route('produk.index') }}" class="nav-back-btn">
          <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
          </svg>
          Katalog
        </a>

      </div>{{-- /nav-actions --}}

    </div>{{-- /nav-inner --}}
  </nav>

  <!-- ══ PARALLAX BG ══ -->
  <div class="blob-parallax fixed top-20 right-0 w-96 h-96 rounded-full opacity-20 pointer-events-none -z-0"
       style="background: radial-gradient(circle, #d1fae5, transparent); filter:blur(60px);" id="blob1"></div>

  <!-- ══ MAIN CONTENT ══ -->
  <div class="max-w-7xl mx-auto px-6 pt-24 pb-20 relative z-10">

    <!-- Breadcrumb -->
    <nav class="breadcrumb mb-8 fade-up">
      <a href="/">Beranda</a>
      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
      <a href="{{ route('produk.index') }}">Katalog</a>
      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
      <a href="{{ route('produk.index', ['category' => $produk->category_id]) }}">{{ $produk->category->name ?? '—' }}</a>
      <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
      <span style="color:var(--gray-700);font-weight:600;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;max-width:200px;">
        {{ Str::limit($produk->name, 40) }}
      </span>
    </nav>

    <!-- Skeleton -->
    <div id="detail-skeleton" class="grid grid-cols-1 lg:grid-cols-2 gap-12">
      <div>
        <div class="skeleton rounded-2xl" style="aspect-ratio:1;"></div>
        <div class="flex gap-3 mt-4">
          @for($i=0;$i<4;$i++)
            <div class="skeleton rounded-xl flex-1" style="aspect-ratio:1;"></div>
          @endfor
        </div>
      </div>
      <div class="space-y-4 pt-2">
        <div class="skeleton h-3 w-1/4 rounded"></div>
        <div class="skeleton h-8 w-full rounded"></div>
        <div class="skeleton h-8 w-4/5 rounded"></div>
        <div class="skeleton h-6 w-1/3 rounded mt-4"></div>
        <div class="skeleton h-24 w-full rounded mt-6"></div>
        <div class="skeleton h-14 w-full rounded-2xl mt-6"></div>
      </div>
    </div>

    <!-- Real Detail -->
    <div id="detail-real" style="opacity:0;transition:opacity .4s ease;">
      <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16">

        <!-- ── Kolom Kiri: Gallery ── -->
        <div class="fade-up" style="animation-delay:.05s">

          <!-- Main image -->
          <div class="gallery-main mb-4">
            @php
              $mainImg   = $produk->image ? Storage::url($produk->image) : null;
              $allImages = collect();
              if ($produk->image) $allImages->push(['src' => Storage::url($produk->image), 'is_main' => true]);
              foreach ($produk->images->sortBy('sort_order') as $img) {
                $allImages->push(['src' => Storage::url($img->image_path), 'is_main' => false]);
              }
            @endphp
            @if($mainImg)
              <img src="{{ $mainImg }}" alt="{{ $produk->name }}" id="main-gallery-img" />
            @else
              <div class="w-full h-full flex items-center justify-center bg-gray-100 rounded-2xl" style="aspect-ratio:1;">
                <svg class="w-16 h-16 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
              </div>
            @endif

            <!-- Sold overlay -->
            @if($produk->status === 'sold')
              <div class="absolute inset-0 bg-black/40 flex items-center justify-center rounded-2xl">
                <div class="bg-white/90 backdrop-blur-sm px-6 py-3 rounded-full">
                  <span class="text-sm font-black text-gray-900 uppercase tracking-widest">Terjual</span>
                </div>
              </div>
            @endif
          </div>

          <!-- Thumbnails -->
          @if($allImages->count() > 1)
            <div class="flex gap-3 flex-wrap">
              @foreach($allImages as $idx => $img)
                <div class="gallery-thumb {{ $idx === 0 ? 'active' : '' }} w-16 h-16"
                     onclick="switchImage('{{ $img['src'] }}', this)">
                  <img src="{{ $img['src'] }}" alt="Foto {{ $idx+1 }}" />
                </div>
              @endforeach
            </div>
          @endif

        </div>

        <!-- ── Kolom Kanan: Info ── -->
        <div class="fade-up" style="animation-delay:.12s">

          <!-- Category + badges -->
          <div class="flex items-center gap-2 mb-3 flex-wrap">
            <span class="text-xs font-bold text-emerald-600 uppercase tracking-widest">
              {{ $produk->category->name ?? '—' }}
            </span>
            <span class="text-gray-300">·</span>
            @php
              $condLabel = match($produk->condition) {
                'like_new' => 'Like New',
                'good'     => 'Good',
                'fair'     => 'Fair',
                default    => $produk->condition,
              };
            @endphp
            <span class="badge-condition badge-{{ $produk->condition }}">{{ $condLabel }}</span>
            @if($produk->status === 'sold')
              <span class="badge-condition badge-sold">Terjual</span>
            @endif
          </div>

          <!-- Nama -->
          <h1 class="text-3xl md:text-4xl font-black text-gray-900 tracking-tight leading-[1.1] mb-5 jakarta">
            {{ $produk->name }}
          </h1>

          <!-- Harga -->
          <div class="mb-6">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-1">Harga</p>
            <p class="text-4xl font-black text-gray-900 tracking-tight">
              Rp {{ number_format($produk->price, 0, ',', '.') }}
            </p>
          </div>

          <!-- Info rows: berat -->
          <div class="border-t border-gray-100 mb-6">
            <div class="info-row">
              <div class="info-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 6l3 1m0 0l-3 9a5.002 5.002 0 006.001 0M6 7l3 9M6 7l6-2m6 2l3-1m-3 1l-3 9a5.002 5.002 0 006.001 0M18 7l3 9m-3-9l-6-2m0-2v2m0 16V5m0 16H9m3 0h3"/>
                </svg>
              </div>
              <div>
                <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-0.5">Berat</p>
                <p class="text-sm font-bold text-gray-900">{{ number_format($produk->weight) }} gram</p>
              </div>
            </div>
          </div>

          <!-- Deskripsi -->
          <div class="mb-6">
            <p class="text-xs font-semibold text-gray-400 uppercase tracking-widest mb-3">Deskripsi Produk</p>
            <div class="prose prose-sm max-w-none text-gray-600 leading-relaxed text-sm whitespace-pre-line">{{ $produk->description }}</div>
          </div>

          <!-- Catatan kondisi -->
          @if($produk->condition_notes)
            <div class="mb-6 p-4 bg-amber-50 border border-amber-100 rounded-xl">
              <div class="flex items-start gap-3">
                <svg class="w-4 h-4 text-amber-500 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
                </svg>
                <div>
                  <p class="text-xs font-bold text-amber-700 uppercase tracking-wider mb-1">Catatan Kondisi</p>
                  <p class="text-sm text-amber-800 leading-relaxed">{{ $produk->condition_notes }}</p>
                </div>
              </div>
            </div>
          @endif

          <!-- CTA -->
          @if($produk->status === 'sold')
            <div class="sold-banner mb-4">
              <div class="w-10 h-10 rounded-xl bg-gray-200 flex items-center justify-center flex-shrink-0">
                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
              </div>
              <div>
                <p class="text-sm font-bold text-gray-700">Barang ini sudah terjual</p>
                <p class="text-xs text-gray-400 mt-0.5">Lihat produk lain yang tersedia di katalog kami.</p>
              </div>
            </div>
            <a href="{{ route('produk.index', ['category' => $produk->category_id]) }}"
               class="btn-cart" style="text-decoration:none;display:flex;">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
              </svg>
              Lihat Produk Serupa
            </a>

          @elseif(!auth()->check())
            <a href="{{ route('login') }}"
               class="btn-cart" style="text-decoration:none;display:flex;">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
              </svg>
              Masuk untuk Membeli
            </a>

          @elseif(!auth()->user()->hasVerifiedEmail())
            <a href="{{ route('verification.notice') }}"
               class="btn-cart" style="text-decoration:none;display:flex;">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
              </svg>
              Verifikasi Email dulu
            </a>

          @else
            <!-- Add to cart form -->
            <form action="{{ route('keranjang.store') }}" method="POST" id="cart-form">
              @csrf
              <input type="hidden" name="product_id" value="{{ $produk->id }}" />
              <button type="submit" class="btn-cart" id="cart-btn">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
                <span id="cart-btn-text">Tambah ke Keranjang</span>
              </button>
            </form>
          @endif

          <!-- Session messages -->
          @if(session('success'))
            <div class="mt-4 p-3 bg-emerald-50 border border-emerald-100 rounded-xl text-sm text-emerald-700 flex items-center gap-2">
              <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
              </svg>
              {{ session('success') }}
            </div>
          @endif
          @if(session('error') || session('info'))
            <div class="mt-4 p-3 bg-amber-50 border border-amber-100 rounded-xl text-sm text-amber-700">
              {{ session('error') ?? session('info') }}
            </div>
          @endif

          <!-- Trust badges -->
          <div class="mt-6 pt-6 border-t border-gray-100 grid grid-cols-3 gap-3">
            @foreach([
              ['🔒', 'Transaksi Aman'],
              ['📦', 'Packing Rapi'],
              ['✅', 'Kondisi Terverifikasi'],
            ] as [$icon, $label])
              <div class="flex flex-col items-center text-center gap-1.5 p-3 rounded-xl bg-gray-50">
                <span class="text-lg">{{ $icon }}</span>
                <span class="text-xs font-semibold text-gray-500 leading-tight">{{ $label }}</span>
              </div>
            @endforeach
          </div>

        </div>
      </div>

      <!-- ══ RELATED PRODUCTS ══ -->
      @if($related->count() > 0)
        <div class="mt-20 pt-16 border-t border-gray-100">

          <div class="flex items-end justify-between mb-8">
            <div>
              <p class="text-xs font-bold tracking-widest uppercase text-emerald-600 mb-2">Mungkin kamu suka</p>
              <h2 class="text-3xl font-black text-gray-900 tracking-tight jakarta">
                Produk <em class="cormorant font-semibold" style="font-style:italic;font-size:1.15em;color:#059669;">Serupa.</em>
              </h2>
            </div>
            <a href="{{ route('produk.index', ['category' => $produk->category_id]) }}"
               class="hidden md:flex items-center gap-2 text-sm font-bold text-gray-500 hover:text-emerald-600 transition-colors duration-200 group">
              Lihat semua
              <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
              </svg>
            </a>
          </div>

          <div class="grid grid-cols-2 md:grid-cols-4 gap-5">
            @foreach($related as $rel)
              @php
                $relCond = match($rel->condition) { 'like_new' => 'Like New', 'good' => 'Good', 'fair' => 'Fair', default => $rel->condition };
              @endphp
              <a href="{{ route('produk.show', $rel->slug) }}" class="rel-card block group">
                <div class="rel-img relative">
                  @if($rel->image)
                    <img src="{{ Storage::url($rel->image) }}" alt="{{ $rel->name }}" loading="lazy" />
                  @else
                    <div class="w-full h-full flex items-center justify-center">
                      <svg class="w-8 h-8 text-gray-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                      </svg>
                    </div>
                  @endif
                  <div class="absolute top-2 left-2">
                    <span class="badge-condition badge-{{ $rel->condition }} text-[10px] px-2 py-0.5">{{ $relCond }}</span>
                  </div>
                </div>
                <div class="p-3">
                  <p class="text-xs font-black text-gray-900 mb-0.5 truncate jakarta">{{ $rel->name }}</p>
                  <p class="text-xs font-bold text-emerald-600">Rp {{ number_format($rel->price, 0, ',', '.') }}</p>
                </div>
              </a>
            @endforeach
          </div>
        </div>
      @endif

    </div>
  </div>

  <!-- ══ FOOTER ══ -->
  <footer class="bg-white border-t border-gray-100 mt-20">
    <div class="max-w-7xl mx-auto px-6 py-10">
      <div class="flex flex-col md:flex-row justify-between items-center gap-4">
        <img src="{{ asset('images/logo_full.png') }}" alt="PindahTangan" class="h-8 w-auto" />
        <p class="text-xs text-gray-400">© {{ date('Y') }} PindahTangan. All rights reserved.</p>
      </div>
    </div>
  </footer>

  <script>
  document.addEventListener('DOMContentLoaded', () => {

    // ── 1. Skeleton → Real ──────────────────────────────────────
    setTimeout(() => {
      const sk = document.getElementById('detail-skeleton');
      const rl = document.getElementById('detail-real');
      if (sk) { sk.style.opacity = '0'; sk.style.transition = 'opacity .3s'; setTimeout(() => sk.remove(), 300); }
      if (rl) rl.style.opacity = '1';
    }, 450);

    // ── 2. Parallax blob ────────────────────────────────────────
    const blob = document.getElementById('blob1');
    let raf = false;
    window.addEventListener('scroll', () => {
      if (raf) return; raf = true;
      requestAnimationFrame(() => {
        if (blob) blob.style.transform = `translateY(${window.scrollY * 0.07}px)`;
        raf = false;
      });
    }, { passive: true });

  });

  // ── 3. Gallery switcher ─────────────────────────────────────
  function switchImage(src, thumbEl) {
    const mainImg = document.getElementById('main-gallery-img');
    if (mainImg) {
      mainImg.style.opacity = '0';
      mainImg.style.transition = 'opacity .25s ease';
      setTimeout(() => {
        mainImg.src = src;
        mainImg.style.opacity = '1';
      }, 250);
    }
    document.querySelectorAll('.gallery-thumb').forEach(t => t.classList.remove('active'));
    thumbEl.classList.add('active');
  }

  // ── 4. Add to cart: optimistic UX ───────────────────────────
  const cartForm = document.getElementById('cart-form');
  if (cartForm) {
    cartForm.addEventListener('submit', function() {
      const btn  = document.getElementById('cart-btn');
      const text = document.getElementById('cart-btn-text');
      if (btn) {
        btn.disabled = true;
        btn.style.background = '#059669';
        if (text) text.textContent = 'Menambahkan...';
      }
    });
  }

  // ── 5. Auto-show toast dari session ──────────────────────────
  @if(session('success'))
    showToast('success', 'Berhasil!', @json(session('success')));
  @endif
  @if(session('error'))
    showToast('error', 'Gagal', @json(session('error')));
  @endif
  @if(session('info'))
    showToast('info', 'Info', @json(session('info')));
  @endif

  function showToast(type, title, msg) {
    const colors = {
      success: { bg: '#dcfce7', color: '#15803d' },
      error:   { bg: '#fee2e2', color: '#b91c1c' },
      info:    { bg: '#dbeafe', color: '#1d4ed8' },
    };
    const c = colors[type] || colors.info;
    const t = document.createElement('div');
    t.className = 'toast';
    t.innerHTML = `
      <div class="toast-icon" style="background:${c.bg};">
        <svg width="16" height="16" fill="none" stroke="${c.color}" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
            d="${type==='success' ? 'M5 13l4 4L19 7' : type==='error' ? 'M6 18L18 6M6 6l12 12' : 'M13 16h-1v-4h-1m1-4h.01'}"/>
        </svg>
      </div>
      <div>
        <p style="font-size:13px;font-weight:700;color:#111827;">${title}</p>
        <p style="font-size:12px;color:#6b7280;margin-top:2px;">${msg}</p>
      </div>`;
    document.getElementById('toast-container').appendChild(t);
    setTimeout(() => { t.classList.add('hiding'); setTimeout(() => t.remove(), 300); }, 3500);
  }
  </script>

</body>
</html>