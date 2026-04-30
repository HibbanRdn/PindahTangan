<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Checkout — PindahTangan</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <meta name="csrf-token" content="{{ csrf_token() }}" />
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
      --danger:      #ef4444;
      --danger-50:   #fef2f2;
      --danger-100:  #fee2e2;
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

    /* ── Steps indicator ── */
    .steps-bar {
      display: flex; align-items: center; gap: 0;
      background: var(--white);
      border-bottom: 1px solid var(--border);
      padding: 0 24px;
      max-width: 1280px; margin: 0 auto;
    }
    .step-item {
      display: flex; align-items: center; gap: 8px;
      padding: 10px 0; font-size: 12.5px; font-weight: 600;
      color: var(--gray-400);
      position: relative;
    }
    .step-item.active { color: var(--gray-900); }
    .step-item.done   { color: var(--emerald-600); }
    .step-num {
      width: 22px; height: 22px; border-radius: 50%;
      display: flex; align-items: center; justify-content: center;
      font-size: 11px; font-weight: 800;
      background: var(--gray-100); color: var(--gray-400);
      flex-shrink: 0;
    }
    .step-item.active .step-num { background: var(--gray-900); color: #fff; }
    .step-item.done .step-num   { background: var(--emerald-600); color: #fff; }
    .step-sep { width: 32px; height: 1px; background: var(--border); margin: 0 6px; flex-shrink: 0; }

    /* ── Cards ── */
    .checkout-card {
      background: var(--white);
      border: 1px solid var(--border);
      border-radius: 18px;
      overflow: hidden;
    }
    .card-section-header {
      padding: 18px 22px;
      border-bottom: 1px solid var(--gray-100);
      display: flex; align-items: center; gap: 10px;
    }
    .card-section-icon {
      width: 34px; height: 34px; border-radius: 10px;
      background: var(--emerald-50);
      display: flex; align-items: center; justify-content: center;
      flex-shrink: 0;
    }
    .card-section-icon svg { width: 16px; height: 16px; color: var(--emerald-600); }
    .card-section-title {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 14px; font-weight: 700; color: var(--gray-900);
    }
    .card-section-subtitle { font-size: 12px; color: var(--gray-400); margin-top: 1px; }
    .card-body { padding: 22px; }

    /* ── Form fields ── */
    .form-group { margin-bottom: 18px; }
    .form-group:last-child { margin-bottom: 0; }
    .form-label {
      display: block;
      font-size: 12px; font-weight: 700;
      color: var(--gray-500);
      text-transform: uppercase; letter-spacing: 0.05em;
      margin-bottom: 7px;
    }
    .form-label .req { color: var(--danger); margin-left: 2px; }
    .form-input, .form-textarea {
      width: 100%;
      padding: 10px 14px;
      border: 1.5px solid var(--border);
      border-radius: 10px;
      font-size: 14px;
      font-family: 'DM Sans', sans-serif;
      color: var(--gray-900);
      background: var(--white);
      outline: none;
      transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-input:focus, .form-textarea:focus {
      border-color: var(--emerald);
      box-shadow: 0 0 0 3px rgba(16,185,129,0.10);
    }
    .form-input.error { border-color: var(--danger); }
    .form-input.error:focus { box-shadow: 0 0 0 3px rgba(239,68,68,0.10); }
    .form-input.success { border-color: var(--emerald-600); }
    .form-textarea { resize: vertical; min-height: 80px; }
    .form-error-msg { margin-top: 5px; font-size: 12px; color: var(--danger); display: flex; align-items: center; gap: 4px; }
    .form-grid-2 { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }

    /* ── Destination autocomplete ── */
    .dest-wrap { position: relative; }
    .dest-search-icon {
      position: absolute; left: 13px; top: 50%; transform: translateY(-50%);
      width: 15px; height: 15px; color: var(--gray-400); pointer-events: none;
    }
    .dest-input { padding-left: 38px !important; }
    .dest-clear {
      position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
      width: 20px; height: 20px; border-radius: 50%;
      background: var(--gray-100); border: none; cursor: pointer;
      display: none; align-items: center; justify-content: center;
      color: var(--gray-400); transition: background 0.15s, color 0.15s;
    }
    .dest-clear.visible { display: flex; }
    .dest-clear:hover { background: var(--danger-100); color: var(--danger); }
    .dest-clear svg { width: 10px; height: 10px; }

    .dest-dropdown {
      position: absolute; top: calc(100% + 6px); left: 0; right: 0;
      background: var(--white);
      border: 1px solid var(--border);
      border-radius: 12px;
      box-shadow: 0 8px 32px rgba(0,0,0,0.10);
      z-index: 30;
      overflow: hidden;
      display: none;
      max-height: 280px;
      overflow-y: auto;
    }
    .dest-dropdown.open { display: block; }
    .dest-dropdown-item {
      padding: 11px 14px;
      cursor: pointer;
      border-bottom: 1px solid var(--gray-50);
      transition: background 0.12s;
      display: flex; align-items: flex-start; gap: 10px;
    }
    .dest-dropdown-item:last-child { border-bottom: none; }
    .dest-dropdown-item:hover { background: var(--emerald-50); }
    .dest-dropdown-item .dest-icon {
      width: 28px; height: 28px; border-radius: 7px;
      background: var(--emerald-50);
      display: flex; align-items: center; justify-content: center;
      flex-shrink: 0; margin-top: 1px;
    }
    .dest-dropdown-item .dest-icon svg { width: 13px; height: 13px; color: var(--emerald-600); }
    .dest-label { font-size: 13px; font-weight: 600; color: var(--gray-900); line-height: 1.3; }
    .dest-sub { font-size: 11.5px; color: var(--gray-400); margin-top: 2px; }
    .dest-loading, .dest-empty {
      padding: 16px 14px; text-align: center;
      font-size: 13px; color: var(--gray-400);
      display: flex; align-items: center; justify-content: center; gap: 8px;
    }

    /* Selected destination display */
    .dest-selected-box {
      display: none;
      padding: 11px 14px;
      background: var(--emerald-50);
      border: 1.5px solid var(--emerald-100);
      border-radius: 10px;
      margin-top: 8px;
    }
    .dest-selected-box.visible { display: flex; align-items: center; gap: 10px; }
    .dest-selected-box .dest-sel-icon {
      width: 32px; height: 32px; border-radius: 8px;
      background: var(--emerald-100);
      display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .dest-selected-box .dest-sel-icon svg { width: 14px; height: 14px; color: var(--emerald-700); }
    .dest-sel-name { font-size: 13px; font-weight: 700; color: var(--emerald-700); }
    .dest-sel-full  { font-size: 11.5px; color: var(--emerald-600); margin-top: 1px; }

    /* ── Courier cards ── */
    .courier-section {
      display: none;
      margin-top: 0;
    }
    .courier-section.visible { display: block; }
    .courier-loading {
      padding: 24px; text-align: center; color: var(--gray-400);
      font-size: 13px;
      display: flex; align-items: center; justify-content: center; gap: 8px;
    }
    .courier-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
      gap: 10px;
    }
    .courier-card {
      border: 1.5px solid var(--border);
      border-radius: 12px; padding: 14px;
      cursor: pointer;
      transition: all 0.18s;
      position: relative; overflow: hidden;
    }
    .courier-card:hover { border-color: var(--emerald); background: var(--emerald-50); }
    .courier-card.selected {
      border-color: var(--emerald-600);
      background: var(--emerald-50);
      box-shadow: 0 0 0 1px var(--emerald-100);
    }
    .courier-card input[type="radio"] {
      position: absolute; opacity: 0; pointer-events: none;
    }
    .courier-radio-dot {
      width: 16px; height: 16px; border-radius: 50%;
      border: 2px solid var(--border);
      display: flex; align-items: center; justify-content: center;
      position: absolute; top: 12px; right: 12px;
      transition: border-color 0.15s;
    }
    .courier-card.selected .courier-radio-dot {
      border-color: var(--emerald-600);
      background: var(--emerald-600);
    }
    .courier-card.selected .courier-radio-dot::after {
      content: '';
      width: 6px; height: 6px;
      background: #fff;
      border-radius: 50%;
    }
    .courier-name { font-size: 13px; font-weight: 800; color: var(--gray-900); margin-bottom: 2px; }
    .courier-service { font-size: 12px; color: var(--gray-500); margin-bottom: 6px; }
    .courier-etd { font-size: 11px; color: var(--gray-400); display: flex; align-items: center; gap: 4px; }
    .courier-etd svg { width: 11px; height: 11px; }
    .courier-price {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 14px; font-weight: 800;
      color: var(--emerald-600); margin-top: 8px;
    }
    .courier-empty {
      padding: 20px; text-align: center;
      font-size: 13px; color: var(--gray-400);
      background: var(--gray-50); border-radius: 10px;
    }

    /* ── Summary card ── */
    .summary-card {
      background: var(--white);
      border: 1px solid var(--border);
      border-radius: 18px;
      padding: 24px;
      position: sticky; top: 84px;
    }
    .summary-title {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 15px; font-weight: 800;
      color: var(--gray-900); margin: 0 0 18px;
    }
    .summary-items { margin-bottom: 16px; }
    .summary-item {
      display: flex; align-items: center; gap: 10px;
      padding: 10px 0;
      border-bottom: 1px solid var(--gray-50);
    }
    .summary-item:last-child { border-bottom: none; }
    .summary-item-img {
      width: 44px; height: 44px; border-radius: 8px;
      overflow: hidden; background: var(--gray-100);
      border: 1px solid var(--border); flex-shrink: 0;
    }
    .summary-item-img img { width: 100%; height: 100%; object-fit: cover; }
    .summary-item-name {
      font-size: 12.5px; font-weight: 600; color: var(--gray-900);
      line-height: 1.3;
      display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;
    }
    .summary-item-price { font-size: 12px; color: var(--gray-400); margin-top: 2px; }

    .summary-divider { height: 1px; background: var(--border); margin: 14px 0; }
    .summary-row {
      display: flex; justify-content: space-between; align-items: center;
      font-size: 13px; color: var(--gray-500); margin-bottom: 8px;
    }
    .summary-row .val { font-weight: 600; color: var(--gray-700); }
    .summary-row .val.green { color: var(--emerald-600); }
    .summary-row .val.pending { color: var(--gray-400); font-style: italic; }

    .summary-total {
      display: flex; justify-content: space-between; align-items: baseline;
      padding-top: 14px; border-top: 1.5px solid var(--border); margin-top: 6px;
    }
    .summary-total-label { font-size: 14px; font-weight: 700; color: var(--gray-900); }
    .summary-total-amount {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 22px; font-weight: 800; color: var(--gray-900);
    }

    /* ── Buttons ── */
    .btn-submit {
      display: flex; align-items: center; justify-content: center; gap: 9px;
      width: 100%; padding: 14px;
      background: var(--gray-900); color: #fff;
      border: none; border-radius: 12px;
      font-size: 14px; font-weight: 800;
      font-family: 'DM Sans', sans-serif;
      cursor: pointer;
      transition: background 0.2s, transform 0.15s, box-shadow 0.2s;
      margin-top: 18px;
      position: relative; overflow: hidden;
    }
    .btn-submit:hover:not(:disabled) {
      background: var(--emerald-600);
      box-shadow: 0 8px 24px rgba(5,150,105,0.3);
      transform: translateY(-1px);
    }
    .btn-submit:active:not(:disabled) { transform: translateY(0); }
    .btn-submit:disabled {
      background: #d1d5db; color: #9ca3af; cursor: not-allowed;
    }
    .btn-submit svg { width: 16px; height: 16px; }

    /* ── Spinner ── */
    @keyframes spin { to { transform: rotate(360deg); } }
    .spinner {
      width: 16px; height: 16px;
      border: 2px solid rgba(255,255,255,0.3);
      border-top-color: #fff;
      border-radius: 50%;
      animation: spin 0.7s linear infinite;
    }

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

    /* ── Misc ── */
    @keyframes fadeUp { from { opacity: 0; transform: translateY(14px); } to { opacity: 1; transform: translateY(0); } }
    .fade-up { animation: fadeUp .5s cubic-bezier(0.22,1,0.36,1) both; }

    .ongkir-note {
      font-size: 11.5px; color: var(--gray-400);
      display: flex; align-items: center; gap: 5px; margin-top: 5px;
    }
    .ongkir-note svg { width: 12px; height: 12px; flex-shrink: 0; }

    @media (max-width: 768px) {
      .nav-inner { padding: 0 16px; }
      .form-grid-2 { grid-template-columns: 1fr; }
    }
    @media (max-width: 480px) {
      #page-main { padding-left: 14px; padding-right: 14px; }
    }
  </style>
</head>
<body>

<div id="toast-container"></div>

{{-- ══ NAVBAR ══ --}}
<nav id="navbar">
  <div class="nav-inner">
    <a href="/" class="shrink-0">
      <img src="{{ asset('images/logo_full.png') }}" alt="PindahTangan" class="h-10 w-auto" />
    </a>
    <div style="display:flex;align-items:center;gap:8px;">
      <a href="{{ route('keranjang.index') }}"
         style="display:inline-flex;align-items:center;gap:5px;font-size:12.5px;font-weight:600;color:var(--gray-400);text-decoration:none;padding:6px 12px;border:1px solid var(--border);border-radius:8px;transition:all .15s;"
         onmouseover="this.style.color='var(--gray-900)';this.style.borderColor='var(--gray-300)'"
         onmouseout="this.style.color='var(--gray-400)';this.style.borderColor='var(--border)'">
        <svg style="width:13px;height:13px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Keranjang
      </a>
    </div>
  </div>
  {{-- Steps bar --}}
  <div style="border-top:1px solid var(--border);background:var(--white);">
    <div style="max-width:1280px;margin:0 auto;padding:0 24px;display:flex;align-items:center;gap:0;">
      <div class="step-item active">
        <div class="step-num">1</div>
        <span>Alamat & Pengiriman</span>
      </div>
      <div class="step-sep"></div>
      <div class="step-item" id="step2">
        <div class="step-num">2</div>
        <span>Pembayaran</span>
      </div>
      <div class="step-sep"></div>
      <div class="step-item" id="step3">
        <div class="step-num">3</div>
        <span>Selesai</span>
      </div>
    </div>
  </div>
</nav>

{{-- ══ MAIN ══ --}}
<main id="page-main" style="max-width:1280px;margin:0 auto;padding:108px 24px 80px;">

  {{-- Page header --}}
  <div style="margin-bottom:24px;" class="fade-up">
    <h1 class="jakarta" style="font-size:clamp(24px,3.5vw,36px);font-weight:800;letter-spacing:-.03em;margin:0 0 4px;">
      Checkout <em class="cormorant" style="color:var(--emerald-600);font-size:1.1em;">Pesanan.</em>
    </h1>
    <p style="font-size:13px;color:var(--gray-400);margin:0;">
      {{ $availableItems->count() }} item · Isi data pengiriman dan pilih kurir
    </p>
  </div>

  <form method="POST" action="{{ route('checkout.store') }}" id="checkout-form">
    @csrf

    {{-- Hidden: items dari keranjang --}}
    @foreach($availableItems as $item)
      <input type="hidden" name="items[]" value="{{ $item->id }}" />
    @endforeach

    {{-- Hidden: diisi oleh JavaScript --}}
    <input type="hidden" name="destination_id"    id="h_destination_id" />
    <input type="hidden" name="province_name"     id="h_province_name" />
    <input type="hidden" name="city_name"         id="h_city_name" />
    <input type="hidden" name="courier"           id="h_courier" />
    <input type="hidden" name="courier_service"   id="h_courier_service" />
    <input type="hidden" name="shipping_cost"     id="h_shipping_cost" />
    <input type="hidden" name="shipping_estimate" id="h_shipping_estimate" />

    <div style="display:grid;grid-template-columns:1fr 340px;gap:20px;align-items:start;">

      {{-- ── KOLOM KIRI ── --}}
      <div style="display:flex;flex-direction:column;gap:16px;">

        {{-- SECTION 1: Kontak & Penerima --}}
        <div class="checkout-card fade-up" style="animation-delay:.04s">
          <div class="card-section-header">
            <div class="card-section-icon">
              <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
              </svg>
            </div>
            <div>
              <div class="card-section-title">Kontak Penerima</div>
              <div class="card-section-subtitle">Nama dan nomor yang bisa dihubungi kurir</div>
            </div>
          </div>
          <div class="card-body">
            <div class="form-grid-2">
              <div class="form-group">
                <label class="form-label">Nama Penerima <span class="req">*</span></label>
                <input type="text" name="recipient_name"
                       value="{{ old('recipient_name', auth()->user()->name) }}"
                       placeholder="Nama lengkap penerima"
                       class="form-input {{ $errors->has('recipient_name') ? 'error' : '' }}"
                       autocomplete="name" />
                @error('recipient_name')
                  <div class="form-error-msg">
                    <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    {{ $message }}
                  </div>
                @enderror
              </div>
              <div class="form-group">
                <label class="form-label">Nomor Telepon <span class="req">*</span></label>
                <input type="tel" name="phone"
                       value="{{ old('phone') }}"
                       placeholder="contoh: 08123456789"
                       class="form-input {{ $errors->has('phone') ? 'error' : '' }}"
                       autocomplete="tel" />
                @error('phone')
                  <div class="form-error-msg">
                    <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                    {{ $message }}
                  </div>
                @enderror
              </div>
            </div>
          </div>
        </div>

        {{-- SECTION 2: Alamat Pengiriman --}}
        <div class="checkout-card fade-up" style="animation-delay:.08s">
          <div class="card-section-header">
            <div class="card-section-icon">
              <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
              </svg>
            </div>
            <div>
              <div class="card-section-title">Alamat Pengiriman</div>
              <div class="card-section-subtitle">Cari kelurahan atau kecamatan tujuan</div>
            </div>
          </div>
          <div class="card-body">

            {{-- Destination search --}}
            <div class="form-group">
              <label class="form-label">Kelurahan / Kecamatan Tujuan <span class="req">*</span></label>
              <div class="dest-wrap">
                <svg class="dest-search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
                <input type="text" id="dest-search-input"
                       placeholder="Ketik nama kelurahan atau kecamatan..."
                       class="form-input dest-input {{ $errors->has('destination_id') ? 'error' : '' }}"
                       autocomplete="off" />
                <button type="button" class="dest-clear" id="dest-clear-btn" onclick="clearDestination()">
                  <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/>
                  </svg>
                </button>
                <div class="dest-dropdown" id="dest-dropdown"></div>
              </div>
              {{-- Selected destination display --}}
              <div class="dest-selected-box" id="dest-selected-box">
                <div class="dest-sel-icon">
                  <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
                  </svg>
                </div>
                <div style="flex:1;min-width:0;">
                  <div class="dest-sel-name" id="dest-sel-name"></div>
                  <div class="dest-sel-full"  id="dest-sel-full"></div>
                </div>
              </div>
              @error('destination_id')
                <div class="form-error-msg" style="margin-top:5px;">
                  <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                  {{ $message }}
                </div>
              @enderror
            </div>

            {{-- Alamat detail + kode pos --}}
            <div class="form-group">
              <label class="form-label">Detail Alamat <span class="req">*</span></label>
              <textarea name="address_detail"
                        placeholder="Nama jalan, nomor rumah, RT/RW, nama gedung, lantai, dll."
                        class="form-textarea {{ $errors->has('address_detail') ? 'error' : '' }}"
                        rows="3">{{ old('address_detail') }}</textarea>
              @error('address_detail')
                <div class="form-error-msg">{{ $message }}</div>
              @enderror
            </div>

            <div class="form-grid-2">
              <div class="form-group">
                <label class="form-label">Kode Pos <span class="req">*</span></label>
                <input type="text" name="postal_code" id="postal_code_input"
                       value="{{ old('postal_code') }}"
                       placeholder="contoh: 10310"
                       maxlength="10"
                       class="form-input {{ $errors->has('postal_code') ? 'error' : '' }}" />
                @error('postal_code')
                  <div class="form-error-msg">{{ $message }}</div>
                @enderror
              </div>
              <div class="form-group">
                <label class="form-label">Kota / Provinsi</label>
                <input type="text" id="city_province_display"
                       placeholder="Otomatis terisi"
                       class="form-input"
                       readonly
                       style="background:var(--gray-50);color:var(--gray-500);cursor:default;" />
              </div>
            </div>

          </div>
        </div>

        {{-- SECTION 3: Pilih Kurir (muncul setelah destinasi dipilih) --}}
        <div class="checkout-card fade-up courier-section" id="courier-section" style="animation-delay:.12s">
          <div class="card-section-header">
            <div class="card-section-icon">
              <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 17l3 3 7-7M3 12l2.5 2.5M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707"/>
              </svg>
            </div>
            <div>
              <div class="card-section-title">Pilih Kurir & Layanan</div>
              <div class="card-section-subtitle" id="courier-section-subtitle">Menghitung opsi pengiriman...</div>
            </div>
          </div>
          <div class="card-body" id="courier-body">
            <div class="courier-loading" id="courier-loading">
              <div class="spinner" style="border-top-color:var(--emerald);border-color:rgba(16,185,129,0.2);"></div>
              Menghitung ongkos kirim...
            </div>
            <div id="courier-grid" style="display:none;"></div>
          </div>
          @error('courier')
            <div class="form-error-msg" style="padding:0 22px 14px;">{{ $message }}</div>
          @enderror
        </div>

        {{-- SECTION 4: Catatan --}}
        <div class="checkout-card fade-up" style="animation-delay:.16s">
          <div class="card-section-header">
            <div class="card-section-icon">
              <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
              </svg>
            </div>
            <div>
              <div class="card-section-title">Catatan Pesanan</div>
              <div class="card-section-subtitle">Opsional — instruksi khusus untuk pengirim</div>
            </div>
          </div>
          <div class="card-body">
            <textarea name="notes"
                      placeholder="contoh: Tolong bubble wrap ekstra, kemas dengan hati-hati..."
                      class="form-textarea"
                      rows="3">{{ old('notes') }}</textarea>
          </div>
        </div>

      </div>

      {{-- ── KOLOM KANAN: Summary ── --}}
      <div>
        <div class="summary-card fade-up" style="animation-delay:.05s">
          <h2 class="summary-title">Ringkasan Pesanan</h2>

          {{-- Item list --}}
          <div class="summary-items">
            @foreach($availableItems as $item)
              <div class="summary-item">
                <div class="summary-item-img">
                  @if($item->product?->image)
                    <img src="{{ Storage::url($item->product->image) }}" alt="{{ $item->product->name }}" />
                  @else
                    <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;background:var(--gray-100);">
                      <svg style="width:16px;height:16px;color:var(--border);" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                      </svg>
                    </div>
                  @endif
                </div>
                <div style="flex:1;min-width:0;">
                  <div class="summary-item-name">{{ $item->product?->name ?? '—' }}</div>
                  <div class="summary-item-price">Rp {{ number_format($item->product?->price ?? 0, 0, ',', '.') }}</div>
                </div>
              </div>
            @endforeach
          </div>

          <div class="summary-divider"></div>

          {{-- Price breakdown --}}
          <div class="summary-row">
            <span>Subtotal ({{ $availableItems->count() }} item)</span>
            <span class="val">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
          </div>
          <div class="summary-row">
            <span>Ongkos Kirim</span>
            <span class="val pending" id="summary-ongkir">Belum dipilih</span>
          </div>
          <div class="summary-row" style="font-size:11px;color:var(--gray-400);">
            <span>Total berat paket</span>
            <span class="val" style="font-size:11px;color:var(--gray-400);">{{ number_format($totalWeight) }} gram</span>
          </div>

          <div class="summary-total">
            <span class="summary-total-label">Total Pembayaran</span>
            <span class="summary-total-amount" id="summary-total">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
          </div>

          {{-- Ongkir note --}}
          <div class="ongkir-note">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Total belum termasuk ongkir sebelum kurir dipilih
          </div>

          {{-- Submit --}}
          <button type="submit" class="btn-submit" id="btn-submit" disabled>
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
            <span id="btn-submit-label">Pilih kurir terlebih dahulu</span>
          </button>

          {{-- Trust badges --}}
          <div style="margin-top:16px;display:flex;flex-direction:column;gap:6px;">
            @foreach([
              ['icon'=>'M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z', 'text'=>'Data terenkripsi & aman'],
              ['icon'=>'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'text'=>'Kondisi sesuai deskripsi'],
              ['icon'=>'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z', 'text'=>'Pembayaran via Sakurupiah'],
            ] as $b)
              <div style="display:flex;align-items:center;gap:6px;font-size:11.5px;color:var(--gray-400);">
                <svg style="width:14px;height:14px;color:var(--emerald-600);flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $b['icon'] }}"/>
                </svg>
                {{ $b['text'] }}
              </div>
            @endforeach
          </div>

        </div>
      </div>

    </div>
  </form>

</main>

{{-- ══ FOOTER ══ --}}
<footer style="background:var(--white);border-top:1px solid var(--border);margin-top:0;">
  <div style="max-width:1280px;margin:0 auto;padding:20px 24px;display:flex;justify-content:space-between;align-items:center;gap:16px;flex-wrap:wrap;">
    <img src="{{ asset('images/logo_full.png') }}" alt="PindahTangan" style="height:28px;width:auto;" />
    <p style="font-size:11.5px;color:var(--gray-400);margin:0;">© {{ date('Y') }} PindahTangan. All rights reserved.</p>
  </div>
</footer>

<script>
/* ═══════════════════════════════════════════════════════════════
   DATA
═══════════════════════════════════════════════════════════════ */
const TOTAL_WEIGHT = {{ $totalWeight }};
const SUBTOTAL     = {{ $subtotal }};
const ONGKIR_URL   = '{{ route('checkout.ongkir') }}';

/* ═══════════════════════════════════════════════════════════════
   STATE
═══════════════════════════════════════════════════════════════ */
let selectedDestination = null;   // { id, label, province, city, zip_code }
let selectedCourier     = null;   // { code, service, cost, etd, name }
let searchTimeout       = null;

/* ═══════════════════════════════════════════════════════════════
   DESTINATION SEARCH
═══════════════════════════════════════════════════════════════ */
const destInput    = document.getElementById('dest-search-input');
const destDropdown = document.getElementById('dest-dropdown');
const destClearBtn = document.getElementById('dest-clear-btn');

destInput.addEventListener('input', () => {
  const q = destInput.value.trim();
  clearTimeout(searchTimeout);

  if (q.length < 3) {
    closeDropdown();
    return;
  }

  searchTimeout = setTimeout(() => searchDestination(q), 320);
});

// Close dropdown when clicking outside
document.addEventListener('click', e => {
  if (!e.target.closest('.dest-wrap')) closeDropdown();
});

async function searchDestination(query) {
  showDropdownLoading();

  try {
    const res  = await fetch(`${ONGKIR_URL}?search=${encodeURIComponent(query)}`);
    const data = await res.json();

    const items = data?.data ?? [];
    if (items.length === 0) {
      showDropdownEmpty();
    } else {
      renderDropdown(items);
    }
  } catch (err) {
    showDropdownEmpty('Gagal menghubungi server. Coba lagi.');
  }
}

function renderDropdown(items) {
  destDropdown.innerHTML = items.map((item, i) => `
    <div class="dest-dropdown-item" onclick="selectDestination(${i})" data-idx="${i}">
      <div class="dest-icon">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
        </svg>
      </div>
      <div>
        <div class="dest-label">${escHtml(item.label ?? `${item.subdistrict ?? ''}, ${item.district ?? ''}`)}</div>
        <div class="dest-sub">${escHtml([item.city, item.province].filter(Boolean).join(', '))} ${item.zip_code ? '· ' + item.zip_code : ''}</div>
      </div>
    </div>
  `).join('');

  // Store items for later reference
  destDropdown._items = items;
  destDropdown.classList.add('open');
}

function selectDestination(idx) {
  const items = destDropdown._items ?? [];
  const item  = items[idx];
  if (!item) return;

  selectedDestination = item;

  // Populate hidden inputs
  document.getElementById('h_destination_id').value = item.id ?? item.subdistrict_id ?? '';
  document.getElementById('h_province_name').value  = item.province ?? '';
  document.getElementById('h_city_name').value       = `${item.subdistrict ?? ''}, ${item.district ?? ''}, ${item.city ?? ''}`.replace(/^,\s*|,\s*$/g, '');

  // Populate display fields
  const fullLabel = item.label ?? `${item.subdistrict ?? ''}, ${item.district ?? ''}`;
  document.getElementById('dest-sel-name').textContent = fullLabel;
  document.getElementById('dest-sel-full').textContent = [item.city, item.province, item.zip_code ? 'Kode Pos ' + item.zip_code : ''].filter(Boolean).join(' · ');
  document.getElementById('dest-selected-box').classList.add('visible');

  if (item.zip_code) document.getElementById('postal_code_input').value = item.zip_code;
  document.getElementById('city_province_display').value = [item.city, item.province].filter(Boolean).join(', ');

  // Update search input
  destInput.value = fullLabel;
  destClearBtn.classList.add('visible');
  closeDropdown();

  // Reset courier selection
  resetCourier();

  // Load ongkir
  loadOngkir(item.id ?? item.subdistrict_id);
}

function clearDestination() {
  selectedDestination = null;
  destInput.value = '';
  destClearBtn.classList.remove('visible');
  document.getElementById('dest-selected-box').classList.remove('visible');
  document.getElementById('h_destination_id').value = '';
  document.getElementById('h_province_name').value  = '';
  document.getElementById('h_city_name').value      = '';
  document.getElementById('postal_code_input').value = '';
  document.getElementById('city_province_display').value = '';
  resetCourier();
  document.getElementById('courier-section').classList.remove('visible');
  updateSummary();
}

function closeDropdown() {
  destDropdown.classList.remove('open');
}
function showDropdownLoading() {
  destDropdown.innerHTML = `<div class="dest-loading"><div class="spinner" style="width:14px;height:14px;border-top-color:var(--emerald);border-color:rgba(16,185,129,0.2);animation:spin 0.7s linear infinite;border-radius:50%;border-width:2px;"></div>Mencari lokasi...</div>`;
  destDropdown.classList.add('open');
}
function showDropdownEmpty(msg = 'Lokasi tidak ditemukan. Coba kata kunci lain.') {
  destDropdown.innerHTML = `<div class="dest-empty">${msg}</div>`;
  destDropdown.classList.add('open');
}

/* ═══════════════════════════════════════════════════════════════
   ONGKIR / KURIR
═══════════════════════════════════════════════════════════════ */
async function loadOngkir(destinationId) {
  const section  = document.getElementById('courier-section');
  const grid     = document.getElementById('courier-grid');
  const loading  = document.getElementById('courier-loading');
  const subtitle = document.getElementById('courier-section-subtitle');

  section.classList.add('visible');
  loading.style.display = 'flex';
  grid.style.display    = 'none';
  subtitle.textContent  = 'Menghitung opsi pengiriman...';

  try {
    const res  = await fetch(`${ONGKIR_URL}?destination=${encodeURIComponent(destinationId)}&weight=${TOTAL_WEIGHT}`);
    const data = await res.json();

    // 1. Ubah const menjadi let agar array bisa disaring
    let services = data?.data ?? [];

    // 2. Filter Kargo: Jika berat di bawah 5000 gram (5 kg), sembunyikan kargo
    if (TOTAL_WEIGHT < 5000) {
      services = services.filter(s => {
        const kodeLayanan = (s.service || '').toUpperCase();
        const deskripsi   = (s.description || '').toUpperCase();
        
        // Daftar kata kunci kargo dari berbagai kurir (JTR, Gokil SiCepat, dll)
        const isCargo = kodeLayanan.includes('JTR') || 
                        deskripsi.includes('TRUCKING') || 
                        kodeLayanan.includes('GOKIL') || 
                        kodeLayanan.includes('CARGO') || 
                        deskripsi.includes('KARGO');
                        
        return !isCargo; // Kembalikan true HANYA jika bukan kargo
      });
    }

    loading.style.display = 'none';
    grid.style.display    = 'block';

    if (services.length === 0) {
      grid.innerHTML = `<div class="courier-empty">Tidak ada opsi kurir tersedia untuk tujuan ini. Hubungi kami untuk bantuan.</div>`;
      subtitle.textContent = 'Tidak ada kurir tersedia';
      return;
    }

    subtitle.textContent = `${services.length} opsi tersedia`;
    renderCourierGrid(services);

  } catch (err) {
    loading.style.display = 'none';
    grid.style.display    = 'block';
    grid.innerHTML = `<div class="courier-empty">Gagal memuat opsi kurir. <button onclick="loadOngkir('${destinationId}')" style="color:var(--emerald-600);background:none;border:none;cursor:pointer;font-weight:700;text-decoration:underline;">Coba lagi</button></div>`;
    subtitle.textContent = 'Error';
  }
}

function renderCourierGrid(services) {
  const grid = document.getElementById('courier-grid');
  grid.className = 'courier-grid';

  grid.innerHTML = services.map((s, i) => `
    <div class="courier-card" id="courier-card-${i}" onclick="selectCourier(${i}, this)">
      <input type="radio" name="_courier_radio" value="${i}" />
      <div class="courier-radio-dot" id="radio-dot-${i}"></div>
      <div class="courier-name">${escHtml(s.name ?? s.code?.toUpperCase() ?? '—')}</div>
      <div class="courier-service">${escHtml(s.service ?? '')}${s.description ? ' — ' + escHtml(s.description) : ''}</div>
      <div class="courier-etd">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        ${escHtml(s.etd ?? '—').replace(/HARI|hari|DAY|day/ig, '').trim()} Hari
      </div>
      <div class="courier-price">Rp ${Number(s.cost ?? 0).toLocaleString('id-ID')}</div>
    </div>
  `).join('');

  // Store services for later
  grid._services = services;
}

function selectCourier(idx, cardEl) {
  const grid     = document.getElementById('courier-grid');
  const services = grid._services ?? [];
  const s        = services[idx];
  if (!s) return;

  selectedCourier = s;

  // Update card styles
  document.querySelectorAll('.courier-card').forEach(c => c.classList.remove('selected'));
  cardEl.classList.add('selected');

  // Populate hidden inputs
  document.getElementById('h_courier').value           = s.code ?? '';
  document.getElementById('h_courier_service').value   = s.service ?? '';
  document.getElementById('h_shipping_cost').value     = s.cost ?? 0;
  document.getElementById('h_shipping_estimate').value = s.etd ?? '';

  updateSummary();
}

function resetCourier() {
  selectedCourier = null;
  document.getElementById('h_courier').value           = '';
  document.getElementById('h_courier_service').value   = '';
  document.getElementById('h_shipping_cost').value     = '';
  document.getElementById('h_shipping_estimate').value = '';
  document.querySelectorAll('.courier-card').forEach(c => c.classList.remove('selected'));
}

/* ═══════════════════════════════════════════════════════════════
   SUMMARY UPDATE
═══════════════════════════════════════════════════════════════ */
function updateSummary() {
  const ongkirEl  = document.getElementById('summary-ongkir');
  const totalEl   = document.getElementById('summary-total');
  const btnSubmit = document.getElementById('btn-submit');
  const btnLabel  = document.getElementById('btn-submit-label');

  if (selectedCourier) {
    const cost  = Number(selectedCourier.cost ?? 0);
    const total = SUBTOTAL + cost;

    ongkirEl.textContent = 'Rp ' + cost.toLocaleString('id-ID');
    ongkirEl.className   = 'val green';
    totalEl.textContent  = 'Rp ' + total.toLocaleString('id-ID');

    btnSubmit.disabled = false;
    btnLabel.textContent = 'Buat Pesanan';
  } else {
    ongkirEl.textContent = 'Belum dipilih';
    ongkirEl.className   = 'val pending';
    totalEl.textContent  = 'Rp ' + SUBTOTAL.toLocaleString('id-ID');

    btnSubmit.disabled = true;
    btnLabel.textContent = selectedDestination
      ? 'Pilih kurir terlebih dahulu'
      : 'Isi alamat terlebih dahulu';
  }
}

/* ═══════════════════════════════════════════════════════════════
   FORM SUBMIT VALIDATION
═══════════════════════════════════════════════════════════════ */
document.getElementById('checkout-form').addEventListener('submit', function(e) {
  const recipientName = document.querySelector('[name="recipient_name"]').value.trim();
  const phone         = document.querySelector('[name="phone"]').value.trim();
  const addressDetail = document.querySelector('[name="address_detail"]').value.trim();

  if (!recipientName) {
    e.preventDefault();
    showToast('error', 'Lengkapi data', 'Nama penerima wajib diisi.');
    document.querySelector('[name="recipient_name"]').focus();
    return;
  }
  if (!phone) {
    e.preventDefault();
    showToast('error', 'Lengkapi data', 'Nomor telepon wajib diisi.');
    document.querySelector('[name="phone"]').focus();
    return;
  }
  if (!document.getElementById('h_destination_id').value) {
    e.preventDefault();
    showToast('error', 'Pilih destinasi', 'Cari dan pilih kelurahan/kecamatan tujuan.');
    document.getElementById('dest-search-input').focus();
    return;
  }
  if (!addressDetail) {
    e.preventDefault();
    showToast('error', 'Lengkapi data', 'Detail alamat wajib diisi.');
    document.querySelector('[name="address_detail"]').focus();
    return;
  }
  if (!document.getElementById('h_courier').value) {
    e.preventDefault();
    showToast('error', 'Pilih kurir', 'Pilih layanan pengiriman terlebih dahulu.');
    document.getElementById('courier-section').scrollIntoView({ behavior: 'smooth' });
    return;
  }

  // Loading state
  const btn   = document.getElementById('btn-submit');
  const label = document.getElementById('btn-submit-label');
  btn.disabled = true;
  label.innerHTML = '<div class="spinner" style="width:16px;height:16px;border-top-color:#fff;border-color:rgba(255,255,255,0.3);animation:spin 0.7s linear infinite;border-radius:50%;border-width:2.5px;"></div> Membuat pesanan...';
});

/* ═══════════════════════════════════════════════════════════════
   TOAST
═══════════════════════════════════════════════════════════════ */
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
  setTimeout(() => { t.classList.add('hiding'); setTimeout(() => t.remove(), 300); }, 4000);
}

// Auto-show session toasts
@if(session('error'))
  document.addEventListener('DOMContentLoaded', () => showToast('error', 'Error', @json(session('error'))));
@endif

/* ═══════════════════════════════════════════════════════════════
   UTILS
═══════════════════════════════════════════════════════════════ */
function escHtml(str) {
  if (!str) return '';
  return String(str)
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;');
}

// Init summary
updateSummary();
</script>

</body>
</html>