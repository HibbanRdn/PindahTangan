<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Keranjang — PindahTangan</title>
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

    *, *::before, *::after { box-sizing: border-box; }
    body       { font-family: 'DM Sans', sans-serif; background: #f9fafb; color: var(--gray-900); margin: 0; -webkit-font-smoothing: antialiased; }
    .jakarta   { font-family: 'Plus Jakarta Sans', sans-serif; }
    .cormorant { font-family: 'Cormorant Garamond', serif; }

    /* ── Navbar ── */
    #navbar {
      position: fixed; top: 0; width: 100%; z-index: 50;
      background: rgba(255,255,255,0.92);
      backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px);
      border-bottom: 1px solid var(--border);
      box-shadow: 0 1px 12px rgba(0,0,0,0.04);
    }
    .nav-inner-cart {
      max-width: 1280px;
      margin: 0 auto;
      padding: 0 24px;
      height: 64px;
      display: flex;
      align-items: center;
      justify-content: space-between;
    }

    /* ── Custom Checkbox ── */
    .cart-checkbox-wrap {
      position: relative;
      flex-shrink: 0;
    }
    .cart-checkbox {
      appearance: none;
      -webkit-appearance: none;
      width: 20px;
      height: 20px;
      border: 2px solid var(--border);
      border-radius: 6px;
      background: var(--white);
      cursor: pointer;
      transition: border-color .18s, background .18s, box-shadow .18s;
      display: flex;
      align-items: center;
      justify-content: center;
      position: relative;
    }
    .cart-checkbox:hover {
      border-color: var(--emerald);
      box-shadow: 0 0 0 3px rgba(16,185,129,0.12);
    }
    .cart-checkbox:checked {
      background: var(--emerald-600);
      border-color: var(--emerald-600);
    }
    .cart-checkbox:checked::after {
      content: '';
      position: absolute;
      width: 5px;
      height: 9px;
      border: 2px solid #fff;
      border-top: none;
      border-left: none;
      transform: rotate(45deg) translateY(-1px);
    }
    .cart-checkbox:disabled {
      opacity: 0.4;
      cursor: not-allowed;
    }
    .cart-checkbox:disabled:hover {
      border-color: var(--border);
      box-shadow: none;
    }

    /* Select all bar */
    .select-all-bar {
      background: var(--white);
      border: 1px solid var(--border);
      border-radius: 14px;
      padding: 12px 16px;
      display: flex;
      align-items: center;
      gap: 12px;
    }
    .select-all-label {
      font-size: 13px;
      font-weight: 600;
      color: var(--gray-700);
      cursor: pointer;
      user-select: none;
    }
    .select-count-pill {
      margin-left: auto;
      font-size: 12px;
      font-weight: 700;
      color: var(--emerald-600);
      background: var(--emerald-50);
      border: 1px solid var(--emerald-100);
      padding: 2px 10px;
      border-radius: 99px;
      transition: opacity .2s;
    }

    /* ── Cart item card ── */
    .cart-item {
      background: var(--white);
      border: 1px solid var(--border);
      border-radius: 16px;
      padding: 16px;
      display: flex;
      align-items: center;
      gap: 14px;
      transition: border-color .2s, box-shadow .2s, background .2s;
      cursor: pointer;
    }
    .cart-item:hover:not(.unavailable) {
      border-color: var(--emerald-100);
      box-shadow: 0 4px 20px rgba(0,0,0,0.06);
    }
    .cart-item.selected:not(.unavailable) {
      border-color: var(--emerald);
      background: #f0fdf9;
      box-shadow: 0 0 0 1px var(--emerald-100), 0 4px 16px rgba(16,185,129,0.08);
    }
    .cart-item.unavailable {
      opacity: 0.55;
      border-color: #fecaca;
      background: #fff5f5;
      cursor: default;
    }
    .cart-item-img {
      width: 80px; height: 80px;
      border-radius: 12px;
      overflow: hidden;
      background: var(--gray-100);
      border: 1px solid var(--border);
      flex-shrink: 0;
    }
    .cart-item-img img { width: 100%; height: 100%; object-fit: cover; }

    /* ── Badges ── */
    .badge-condition {
      display: inline-flex; align-items: center; gap: 4px;
      padding: 2px 9px; border-radius: 99px;
      font-size: 11px; font-weight: 700;
    }
    .badge-like_new { background: #dcfce7; color: #15803d; }
    .badge-good     { background: #dbeafe; color: #1d4ed8; }
    .badge-fair     { background: #ffedd5; color: #9a3412; }
    .unavailable-badge {
      display: inline-flex; align-items: center; gap: 4px;
      padding: 2px 9px; border-radius: 99px;
      font-size: 11px; font-weight: 700;
      background: #fee2e2; color: #b91c1c;
    }

    /* ── Summary card ── */
    .summary-card {
      background: var(--white);
      border: 1px solid var(--border);
      border-radius: 20px;
      padding: 24px;
      position: sticky;
      top: 80px;
    }

    /* ── Summary rows ── */
    .summary-row {
      display: flex; justify-content: space-between; align-items: center;
      font-size: 13.5px; color: var(--gray-700);
      padding: 8px 0;
    }
    .summary-row + .summary-row {
      border-top: 1px solid var(--gray-100);
    }
    .summary-subtotal {
      font-size: 15px;
      font-weight: 800;
      color: var(--gray-900);
      padding: 14px 0 0;
      margin-top: 6px;
      border-top: 1.5px solid var(--border) !important;
      display: flex;
      justify-content: space-between;
      align-items: baseline;
    }
    .summary-subtotal .amount {
      font-size: 20px;
      font-weight: 800;
      color: var(--emerald-600);
      font-family: 'Plus Jakarta Sans', sans-serif;
    }
    .ongkir-note {
      font-size: 11px;
      color: var(--gray-400);
      margin-top: 4px;
      text-align: right;
    }

    /* ── Buttons ── */
    .btn-primary {
      display: inline-flex; align-items: center; justify-content: center; gap: 8px;
      padding: 13px 24px;
      background: var(--gray-900); color: #fff;
      border: none; border-radius: 12px;
      font-size: 14px; font-weight: 700;
      font-family: 'DM Sans', sans-serif;
      cursor: pointer; text-decoration: none; width: 100%;
      transition: background .2s, transform .15s, box-shadow .2s;
    }
    .btn-primary:hover:not(:disabled) {
      background: var(--emerald-600);
      box-shadow: 0 8px 24px rgba(5,150,105,0.28);
      transform: translateY(-1px);
    }
    .btn-primary:disabled {
      background: #d1d5db; color: #9ca3af; cursor: not-allowed;
      transform: none; box-shadow: none;
    }
    .btn-delete {
      width: 34px; height: 34px;
      border-radius: 8px;
      display: flex; align-items: center; justify-content: center;
      background: transparent; border: 1.5px solid var(--border);
      color: var(--gray-400); cursor: pointer;
      transition: all .2s; flex-shrink: 0;
    }
    .btn-delete:hover { background: #fef2f2; border-color: #fca5a5; color: #ef4444; }
    .btn-delete svg { width: 14px; height: 14px; }

    /* ── Toast ── */
    @keyframes toastIn  { from { opacity:0; transform:translateX(100%) scale(.95); } to { opacity:1; transform:translateX(0) scale(1); } }
    @keyframes toastOut { from { opacity:1; } to { opacity:0; transform:translateX(100%); } }
    .toast {
      position: fixed; top: 1.25rem; right: 1.25rem; z-index: 9999;
      background: #fff; border: 1px solid var(--border); border-radius: 14px;
      padding: 14px 18px; display: flex; align-items: center; gap: 12px;
      min-width: 260px; box-shadow: 0 8px 32px rgba(0,0,0,0.12);
      animation: toastIn .35s cubic-bezier(0.22,1,0.36,1) both;
    }
    .toast.hiding { animation: toastOut .3s ease forwards; }
    .toast-icon { width: 34px; height: 34px; border-radius: 9px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }

    /* ── Empty state ── */
    @keyframes floatEmpty { 0%,100% { transform:translateY(0);} 50% { transform:translateY(-8px);} }
    .empty-float { animation: floatEmpty 3s ease-in-out infinite; }

    /* ── Fade in ── */
    @keyframes fadeUp { from { opacity:0; transform:translateY(16px); } to { opacity:1; transform:translateY(0); } }
    .fade-up { animation: fadeUp .5s cubic-bezier(0.22,1,0.36,1) both; }

    /* Prevent click propagation dari delete btn ke card */
    .cart-item .btn-delete { position: relative; z-index: 2; }

    @media (max-width: 480px) {
      .nav-inner-cart { padding: 0 14px; }
    }
  </style>
</head>
<body>

<div id="toast-container"></div>

<!-- ══ NAVBAR ══ -->
<nav id="navbar">
  <div class="nav-inner-cart">
    <a href="/" class="shrink-0">
      <img src="{{ asset('images/logo_full.png') }}" alt="PindahTangan" class="h-10 w-auto" />
    </a>
    <div class="flex items-center gap-3">
      <a href="{{ route('produk.index') }}"
         class="hidden md:inline-flex items-center gap-1.5 text-sm font-semibold text-gray-500 hover:text-gray-900 transition-colors duration-200">
        ← Lanjut Belanja
      </a>
      <form method="POST" action="{{ route('logout') }}" class="hidden md:inline">
        @csrf
        <button type="submit"
          class="w-9 h-9 rounded-full border border-gray-200 flex items-center justify-center text-gray-400 hover:text-red-500 hover:border-red-200 transition-all duration-200">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
          </svg>
        </button>
      </form>
    </div>
  </div>
</nav>

<!-- ══ MAIN ══ -->
<main class="max-w-7xl mx-auto px-6 pt-24 pb-20" style="max-width:1280px;">

  <!-- Header -->
  <div class="mb-8 fade-up">
    <h1 class="jakarta" style="font-size:clamp(28px,4vw,40px);font-weight:800;letter-spacing:-0.03em;margin:0 0 6px;">
      Keranjang <em class="cormorant" style="color:var(--emerald-600);font-style:italic;font-weight:600;font-size:1.1em;">Belanja.</em>
    </h1>
    <p style="font-size:13px;color:var(--gray-400);margin:0;">
      @if($cartItems->count() > 0)
        {{ $cartItems->count() }} item · centang item yang ingin di-checkout
      @else
        Keranjang Anda masih kosong
      @endif
    </p>
  </div>

  @if($cartItems->count() > 0)

    {{-- ══ FORM UTAMA: membungkus checkbox + tombol checkout ══ --}}
    <form method="GET" action="{{ route('checkout.index') }}" id="checkout-form">

      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

        <!-- ── Kolom Kiri: Item List ── -->
        <div class="lg:col-span-2 flex flex-col gap-4">

          {{-- Pilih Semua bar --}}
          <div class="select-all-bar fade-up">
            <input
              type="checkbox"
              id="select-all"
              class="cart-checkbox"
              title="Pilih semua"
            />
            <label for="select-all" class="select-all-label">Pilih Semua</label>
            <span class="select-count-pill" id="selected-count-pill" style="opacity:0;">0 dipilih</span>
          </div>

          {{-- Warning unavailable --}}
          @if(count($unavailableIds) > 0)
            <div class="flex items-start gap-3 p-4 fade-up" style="background:#fff5f5;border:1px solid #fecaca;border-radius:16px;">
              <svg class="shrink-0 mt-0.5" style="width:18px;height:18px;color:#ef4444;" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
              </svg>
              <div>
                <p style="font-size:13px;font-weight:700;color:#b91c1c;margin:0 0 2px;">{{ count($unavailableIds) }} item sudah tidak tersedia</p>
                <p style="font-size:12px;color:#dc2626;margin:0;">Item tidak tersedia tidak bisa dipilih. Hapus dari keranjang untuk membersihkan.</p>
              </div>
            </div>
          @endif

          {{-- Item list --}}
          @foreach($cartItems as $item)
            @php
              $isUnavailable = in_array($item->id, $unavailableIds);
              $condLabel = match($item->product?->condition ?? '') {
                'like_new' => 'Like New',
                'good'     => 'Good',
                'fair'     => 'Fair',
                default    => '-',
              };
              $price = $item->product?->price ?? 0;
            @endphp

            <div
              class="cart-item fade-up {{ $isUnavailable ? 'unavailable' : '' }}"
              style="animation-delay:{{ $loop->index * 60 }}ms"
              data-item-id="{{ $item->id }}"
              data-price="{{ $price }}"
              data-available="{{ $isUnavailable ? '0' : '1' }}"
              onclick="handleCardClick(event, this)"
            >

              {{-- Checkbox --}}
              <div class="cart-checkbox-wrap" onclick="event.stopPropagation()">
                <input
                  type="checkbox"
                  name="items[]"
                  value="{{ $item->id }}"
                  class="cart-checkbox item-checkbox"
                  data-price="{{ $price }}"
                  data-item-id="{{ $item->id }}"
                  {{ $isUnavailable ? 'disabled' : '' }}
                  onchange="updateSummary()"
                />
              </div>

              {{-- Foto --}}
              <div class="cart-item-img">
                @if($item->product?->image)
                  <img src="{{ Storage::url($item->product->image) }}" alt="{{ $item->product->name }}" />
                @else
                  <div class="w-full h-full flex items-center justify-center">
                    <svg style="width:28px;height:28px;color:#d1d5db;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                  </div>
                @endif
              </div>

              {{-- Info --}}
              <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2 mb-1 flex-wrap">
                  <span style="font-size:10.5px;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:var(--gray-400);">
                    {{ $item->product?->category?->name ?? '—' }}
                  </span>
                  @if($item->product)
                    <span class="badge-condition badge-{{ $item->product->condition }}">{{ $condLabel }}</span>
                  @endif
                  @if($isUnavailable)
                    <span class="unavailable-badge">
                      <svg style="width:10px;height:10px;" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/>
                      </svg>
                      Tidak tersedia
                    </span>
                  @endif
                </div>

                <a href="{{ $item->product ? route('produk.show', $item->product->slug) : '#' }}"
                   class="jakarta block mb-2"
                   style="font-size:13.5px;font-weight:700;color:var(--gray-900);text-decoration:none;line-height:1.35;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;"
                   onclick="event.stopPropagation()"
                   onmouseover="this.style.color='var(--emerald-600)'"
                   onmouseout="this.style.color='var(--gray-900)'">
                  {{ $item->product?->name ?? '(Produk dihapus)' }}
                </a>

                <p class="jakarta" style="font-size:15px;font-weight:800;color:var(--gray-900);margin:0;">
                  @if($item->product)
                    Rp {{ number_format($price, 0, ',', '.') }}
                  @else —
                  @endif
                </p>
              </div>

              {{-- Hapus --}}
              <form method="POST" action="{{ route('keranjang.destroy', $item->id) }}" onclick="event.stopPropagation()">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-delete" title="Hapus"
                        onclick="return confirm('Hapus \'{{ addslashes($item->product?->name ?? 'item ini') }}\' dari keranjang?')">
                  <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                  </svg>
                </button>
              </form>

            </div>
          @endforeach

          <div class="mt-2">
            <a href="{{ route('produk.index') }}"
               style="display:inline-flex;align-items:center;gap:6px;font-size:13px;font-weight:600;color:var(--gray-400);text-decoration:none;"
               onmouseover="this.style.color='var(--emerald-600)'"
               onmouseout="this.style.color='var(--gray-400)'">
              <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
              </svg>
              Lanjut Belanja
            </a>
          </div>

        </div>

        <!-- ── Kolom Kanan: Summary ── -->
        <div class="summary-card fade-up" style="animation-delay:.15s;">

          <h2 class="jakarta" style="font-size:15px;font-weight:800;color:var(--gray-900);margin:0 0 16px;">Ringkasan Pesanan</h2>

          {{-- Item dipilih --}}
          <div class="summary-row">
            <span style="color:var(--gray-500);">Item dipilih</span>
            <span style="font-weight:700;" id="summary-item-count">0 barang</span>
          </div>

          {{-- Harga masing-masing (dinamis via JS, digenerate saat ada item dipilih) --}}
          <div id="summary-item-list" style="font-size:12.5px;color:var(--gray-500);padding:4px 0 0;display:none;">
            {{-- Diisi JS --}}
          </div>

          {{-- Subtotal --}}
          <div style="padding:14px 0 0;margin-top:8px;border-top:1.5px solid var(--border);">
            <div style="display:flex;justify-content:space-between;align-items:baseline;">
              <span style="font-size:13.5px;font-weight:600;color:var(--gray-700);">Subtotal</span>
              <span class="jakarta" style="font-size:20px;font-weight:800;color:var(--emerald-600);" id="summary-subtotal">Rp 0</span>
            </div>
            <p style="font-size:11px;color:var(--gray-400);margin:4px 0 0;text-align:right;">
              Belum termasuk ongkos kirim
            </p>
          </div>

          {{-- Ongkir info --}}
          <div style="margin-top:10px;padding:10px 12px;background:var(--gray-50);border:1px solid var(--border);border-radius:10px;display:flex;align-items:center;gap:8px;">
            <svg style="width:14px;height:14px;color:var(--gray-400);flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <p style="font-size:11.5px;color:var(--gray-500);margin:0;line-height:1.5;">
              Ongkos kirim dihitung berdasarkan alamat dan berat di halaman checkout.
            </p>
          </div>

          {{-- Checkout button --}}
          <div style="margin-top:20px;">
            <button type="submit" form="checkout-form" class="btn-primary" id="btn-checkout" disabled>
              <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
              </svg>
              <span id="btn-checkout-label">Pilih item terlebih dahulu</span>
            </button>
          </div>

{{-- Info preloved --}}
          <div style="margin-top:16px;padding:12px;background:var(--emerald-50);border:1px solid var(--emerald-100);border-radius:12px;display:flex;align-items:flex-start;gap:8px;">
            <svg style="width:18px;height:18px;color:#059669;flex-shrink:0;margin-top:2px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>
            </svg>
            <p style="font-size:11.5px;color:#065f46;line-height:1.6;margin:0;">
              <span style="font-weight:700;">Info:</span> Stok preloved tidak dikunci saat di keranjang.
              Segera checkout agar tidak didahului pembeli lain.
            </p>
          </div>

          {{-- Trust badges --}}
          <div style="margin-top:14px;display:flex;flex-direction:column;gap:7px;">
            @php
              $trustBadges = [
                [
                  'text' => 'Transaksi Aman & Terenkripsi',
                  'icon' => 'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z'
                ],
                [
                  'text' => 'Packing Rapi & Aman',
                  'icon' => 'M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4'
                ],
                [
                  'text' => 'Kondisi Sesuai Deskripsi',
                  'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'
                ]
              ];
            @endphp
            @foreach($trustBadges as $badge)
              <div style="display:flex;align-items:center;gap:6px;font-size:11.5px;color:var(--gray-500);">
                <svg style="width:16px;height:16px;color:var(--emerald-600);flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $badge['icon'] }}"/>
                </svg>
                <span>{{ $badge['text'] }}</span>
              </div>
            @endforeach
          </div>

        </div>

      </div>

    </form>{{-- /checkout-form --}}

  @else

    <!-- ── Empty State ── -->
    <div class="flex flex-col items-center justify-center py-28 text-center fade-up">
      <div class="empty-float mb-6">
        <div style="width:96px;height:96px;border-radius:28px;background:var(--emerald-50);display:flex;align-items:center;justify-content:center;margin:0 auto;">
          <svg style="width:48px;height:48px;color:#a7f3d0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
          </svg>
        </div>
      </div>
      <h3 class="jakarta" style="font-size:22px;font-weight:800;margin:0 0 8px;">Keranjang masih kosong</h3>
      <p style="font-size:13.5px;color:var(--gray-400);max-width:280px;line-height:1.6;margin:0 0 28px;">
        Temukan barang preloved berkualitas di katalog kami dan mulai berbelanja!
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

  @endif

</main>

<!-- ══ FOOTER ══ -->
<footer class="bg-white border-t border-gray-100 mt-10">
  <div class="max-w-7xl mx-auto px-6 py-8">
    <div class="flex flex-col md:flex-row justify-between items-center gap-4">
      <img src="{{ asset('images/logo_full.png') }}" alt="PindahTangan" class="h-8 w-auto" />
      <p class="text-xs text-gray-400">© {{ date('Y') }} PindahTangan. All rights reserved.</p>
    </div>
  </div>
</footer>

<script>
/* ════════════════════════════════════════════════
   DATA dari server (harga per item)
════════════════════════════════════════════════ */
const itemData = {
  @foreach($cartItems as $item)
  @if(!in_array($item->id, $unavailableIds))
  {{ $item->id }}: {
    name: @json(Str::limit($item->product?->name ?? 'Produk', 30)),
    price: {{ $item->product?->price ?? 0 }},
  },
  @endif
  @endforeach
};

/* ════════════════════════════════════════════════
   UPDATE SUMMARY — dipanggil setiap perubahan checkbox
════════════════════════════════════════════════ */
function updateSummary() {
  const checkboxes   = document.querySelectorAll('.item-checkbox:not(:disabled)');
  const checked      = [...checkboxes].filter(cb => cb.checked);
  const selectAll    = document.getElementById('select-all');
  const countPill    = document.getElementById('selected-count-pill');
  const summaryCount = document.getElementById('summary-item-count');
  const summaryList  = document.getElementById('summary-item-list');
  const subtotalEl   = document.getElementById('summary-subtotal');
  const btnCheckout  = document.getElementById('btn-checkout');
  const btnLabel     = document.getElementById('btn-checkout-label');

  // Hitung subtotal
  let subtotal = 0;
  checked.forEach(cb => {
    const id = parseInt(cb.dataset.itemId);
    subtotal += itemData[id]?.price ?? 0;
  });

  const count = checked.length;

  // Update "Pilih Semua" indeterminate state
  if (count === 0) {
    selectAll.checked       = false;
    selectAll.indeterminate = false;
  } else if (count === checkboxes.length) {
    selectAll.checked       = true;
    selectAll.indeterminate = false;
  } else {
    selectAll.checked       = false;
    selectAll.indeterminate = true;
  }

  // Pill count
  countPill.textContent = `${count} dipilih`;
  countPill.style.opacity = count > 0 ? '1' : '0';

  // Summary count
  summaryCount.textContent = count > 0 ? `${count} barang` : '0 barang';

  // Detail item list (tampil kalau ada yg dipilih)
  if (count > 0) {
    summaryList.style.display = 'block';
    summaryList.innerHTML = checked.map(cb => {
      const id   = parseInt(cb.dataset.itemId);
      const data = itemData[id];
      if (!data) return '';
      return `<div style="display:flex;justify-content:space-between;padding:4px 0;border-top:1px dashed #f3f4f6;">
        <span style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;max-width:60%;color:#6b7280;">${data.name}</span>
        <span style="font-weight:600;color:#374151;flex-shrink:0;margin-left:8px;">Rp ${data.price.toLocaleString('id-ID')}</span>
      </div>`;
    }).join('');
  } else {
    summaryList.style.display = 'none';
    summaryList.innerHTML = '';
  }

  // Subtotal
  subtotalEl.textContent = 'Rp ' + subtotal.toLocaleString('id-ID');

  // Checkout button
  if (count > 0) {
    btnCheckout.disabled = false;
    btnLabel.textContent = `Checkout ${count} Item`;
  } else {
    btnCheckout.disabled = true;
    btnLabel.textContent = 'Pilih item terlebih dahulu';
  }

  // Update visual state kartu (selected class)
  document.querySelectorAll('.cart-item[data-available="1"]').forEach(card => {
    const id = card.dataset.itemId;
    const cb = card.querySelector('.item-checkbox');
    if (cb?.checked) {
      card.classList.add('selected');
    } else {
      card.classList.remove('selected');
    }
  });
}

/* ════════════════════════════════════════════════
   PILIH SEMUA
════════════════════════════════════════════════ */
document.getElementById('select-all')?.addEventListener('change', function() {
  const checkboxes = document.querySelectorAll('.item-checkbox:not(:disabled)');
  checkboxes.forEach(cb => cb.checked = this.checked);
  updateSummary();
});

/* ════════════════════════════════════════════════
   CLICK KARTU → toggle checkbox
════════════════════════════════════════════════ */
function handleCardClick(e, card) {
  // Jangan toggle kalau klik di dalam link/form/button
  if (e.target.closest('a, button, form, .cart-checkbox-wrap')) return;
  if (card.classList.contains('unavailable')) return;

  const cb = card.querySelector('.item-checkbox');
  if (cb) {
    cb.checked = !cb.checked;
    updateSummary();
  }
}

/* ════════════════════════════════════════════════
   FORM VALIDATION sebelum submit
════════════════════════════════════════════════ */
document.getElementById('checkout-form')?.addEventListener('submit', function(e) {
  const checked = document.querySelectorAll('.item-checkbox:checked');
  if (checked.length === 0) {
    e.preventDefault();
    showToast('error', 'Pilih dulu!', 'Centang minimal 1 item yang ingin di-checkout.');
  }
});

/* ════════════════════════════════════════════════
   TOAST
════════════════════════════════════════════════ */
document.addEventListener('DOMContentLoaded', () => {
  updateSummary(); // init state

  @if(session('success'))
    showToast('success', 'Berhasil!', @json(session('success')));
  @endif
  @if(session('error'))
    showToast('error', 'Gagal', @json(session('error')));
  @endif
  @if(session('info'))
    showToast('info', 'Info', @json(session('info')));
  @endif
});

function showToast(type, title, msg) {
  const colors = {
    success: { bg:'#dcfce7', color:'#15803d', icon:'<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>' },
    error:   { bg:'#fee2e2', color:'#b91c1c', icon:'<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>' },
    info:    { bg:'#dbeafe', color:'#1d4ed8', icon:'<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01"/>' },
  };
  const c = colors[type] || colors.info;
  const t = document.createElement('div');
  t.className = 'toast';
  t.innerHTML = `
    <div class="toast-icon" style="background:${c.bg};">
      <svg width="16" height="16" fill="none" stroke="${c.color}" viewBox="0 0 24 24">${c.icon}</svg>
    </div>
    <div>
      <p style="font-size:13px;font-weight:700;color:#111827;margin:0;">${title}</p>
      <p style="font-size:12px;color:#6b7280;margin:2px 0 0;">${msg}</p>
    </div>`;
  document.getElementById('toast-container').appendChild(t);
  setTimeout(() => { t.classList.add('hiding'); setTimeout(() => t.remove(), 300); }, 3800);
}
</script>

</body>
</html>