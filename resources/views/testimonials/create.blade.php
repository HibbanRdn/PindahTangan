<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tulis Testimoni — PindahTangan</title>
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
      --star:        #f59e0b;
      --star-empty:  #e5e7eb;
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
    .btn-back {
      display: inline-flex; align-items: center; gap: 5px;
      font-size: 12.5px; font-weight: 600;
      color: var(--gray-400); text-decoration: none;
      padding: 6px 12px; border: 1px solid var(--border); border-radius: 8px;
      transition: all .15s;
    }
    .btn-back:hover { color: var(--gray-900); border-color: var(--gray-300); background: var(--white); }

    /* ── Main card ── */
    .form-card {
      background: var(--white);
      border: 1px solid var(--border);
      border-radius: 20px;
      overflow: hidden;
    }
    .card-head {
      padding: 20px 24px;
      border-bottom: 1px solid var(--gray-100);
      display: flex; align-items: center; gap: 12px;
    }
    .card-icon {
      width: 38px; height: 38px; border-radius: 12px;
      background: #fef9c3;
      display: flex; align-items: center; justify-content: center; flex-shrink: 0;
    }
    .card-icon svg { width: 18px; height: 18px; color: #d97706; }
    .card-body { padding: 28px 24px; }

    /* ── Order summary ── */
    .order-preview {
      display: flex; align-items: center; gap: 12px;
      background: var(--gray-50);
      border: 1px solid var(--border);
      border-radius: 14px;
      padding: 14px 16px;
      margin-bottom: 28px;
    }
    .order-preview-img {
      width: 56px; height: 56px; border-radius: 10px;
      overflow: hidden; border: 1px solid var(--border);
      background: var(--gray-100); flex-shrink: 0;
    }
    .order-preview-img img { width: 100%; height: 100%; object-fit: cover; }

    /* ── Star rating ── */
    .star-section { margin-bottom: 28px; text-align: center; }
    .star-section-label {
      font-size: 13px; font-weight: 700; color: var(--gray-500);
      text-transform: uppercase; letter-spacing: .05em;
      margin-bottom: 14px;
    }
    .stars-wrap {
      display: inline-flex; gap: 8px;
      cursor: pointer;
    }
    .star-btn {
      background: none; border: none; padding: 0; cursor: pointer;
      transition: transform .15s;
    }
    .star-btn:hover { transform: scale(1.15); }
    .star-btn svg {
      width: 44px; height: 44px;
      fill: var(--star-empty);
      stroke: var(--star-empty);
      transition: fill .15s, stroke .15s, transform .15s;
      filter: drop-shadow(0 0 0 transparent);
    }
    .star-btn.active svg,
    .star-btn.hover svg {
      fill: var(--star);
      stroke: var(--star);
      filter: drop-shadow(0 2px 6px rgba(245,158,11,.35));
    }
    .star-label {
      margin-top: 12px; min-height: 22px;
      font-size: 14px; font-weight: 700;
      color: var(--gray-900);
      transition: all .2s;
    }

    /* ── Form fields ── */
    .form-group { margin-bottom: 22px; }
    .form-label {
      display: block;
      font-size: 12px; font-weight: 700;
      color: var(--gray-500);
      text-transform: uppercase; letter-spacing: .05em;
      margin-bottom: 8px;
    }
    .form-label .req { color: #ef4444; margin-left: 2px; }
    .form-textarea {
      width: 100%;
      padding: 12px 14px;
      border: 1.5px solid var(--border);
      border-radius: 12px;
      font-size: 14px; font-family: 'DM Sans', sans-serif;
      color: var(--gray-900); background: var(--white);
      outline: none; resize: vertical;
      min-height: 120px;
      transition: border-color .2s, box-shadow .2s;
      line-height: 1.6;
    }
    .form-textarea:focus {
      border-color: var(--emerald);
      box-shadow: 0 0 0 3px rgba(16,185,129,.1);
    }
    .char-count {
      text-align: right; font-size: 11.5px;
      color: var(--gray-400); margin-top: 5px;
    }
    .char-count.warn { color: #f59e0b; }
    .char-count.over { color: #ef4444; }
    .form-error-msg {
      display: flex; align-items: center; gap: 4px;
      margin-top: 5px; font-size: 12px; color: #ef4444;
    }

    /* ── Photo upload ── */
    .photo-upload-area {
      border: 2px dashed var(--border);
      border-radius: 14px;
      padding: 20px;
      text-align: center;
      cursor: pointer;
      transition: border-color .2s, background .2s;
      position: relative;
    }
    .photo-upload-area:hover,
    .photo-upload-area.drag-over {
      border-color: var(--emerald);
      background: var(--emerald-50);
    }
    .photo-upload-area input[type="file"] {
      position: absolute; inset: 0; opacity: 0; cursor: pointer; width: 100%; height: 100%;
    }
    .upload-icon { margin: 0 auto 8px; width: 36px; height: 36px; color: var(--gray-400); }
    .upload-text { font-size: 13px; font-weight: 600; color: var(--gray-500); }
    .upload-hint { font-size: 11.5px; color: var(--gray-400); margin-top: 3px; }

    /* ── Photo previews ── */
    .photo-previews {
      display: flex; gap: 10px; flex-wrap: wrap;
      margin-top: 12px;
    }
    .photo-preview-item {
      position: relative;
      width: 80px; height: 80px;
      border-radius: 10px; overflow: hidden;
      border: 1px solid var(--border);
      background: var(--gray-100);
    }
    .photo-preview-item img { width: 100%; height: 100%; object-fit: cover; }
    .photo-preview-remove {
      position: absolute; top: 4px; right: 4px;
      width: 20px; height: 20px; border-radius: 50%;
      background: rgba(0,0,0,.55); border: none;
      cursor: pointer; display: flex; align-items: center; justify-content: center;
      color: #fff; transition: background .15s;
    }
    .photo-preview-remove:hover { background: #ef4444; }
    .photo-preview-remove svg { width: 10px; height: 10px; }

    /* ── Submit button ── */
    .btn-submit {
      display: flex; align-items: center; justify-content: center; gap: 9px;
      width: 100%; padding: 14px;
      background: var(--gray-900); color: #fff;
      border: none; border-radius: 12px;
      font-size: 14px; font-weight: 800; font-family: 'DM Sans', sans-serif;
      cursor: pointer;
      transition: background .2s, transform .15s, box-shadow .2s;
    }
    .btn-submit:hover:not(:disabled) {
      background: var(--emerald-600);
      box-shadow: 0 8px 24px rgba(5,150,105,.3);
      transform: translateY(-1px);
    }
    .btn-submit:disabled { background: #d1d5db; color: #9ca3af; cursor: not-allowed; }

    /* ── Validation errors box ── */
    .error-box {
      background: #fef2f2; border: 1.5px solid #fca5a5;
      border-radius: 14px; padding: 16px 20px; margin-bottom: 24px;
    }

    /* ── Animations ── */
    @keyframes fadeUp { from { opacity: 0; transform: translateY(16px); } to { opacity: 1; transform: translateY(0); } }
    .fade-up { animation: fadeUp .5s cubic-bezier(0.22,1,0.36,1) both; }

    @keyframes starBounce { 0%,100% { transform: scale(1); } 50% { transform: scale(1.3); } }
    .star-bounce { animation: starBounce .3s ease; }

    @media (max-width: 640px) {
      .nav-inner { padding: 0 16px; }
      .card-body { padding: 20px 16px; }
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
    <a href="{{ route('pesanan.show', $order->order_code) }}" class="btn-back">
      <svg style="width:13px;height:13px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
      </svg>
      Detail Pesanan
    </a>
  </div>
</nav>

{{-- ══ MAIN ══ --}}
<main style="max-width:580px;margin:0 auto;padding:88px 20px 80px;">

  {{-- Header --}}
  <div style="margin-bottom:24px;" class="fade-up">
    <h1 class="jakarta" style="font-size:clamp(24px,4vw,34px);font-weight:800;letter-spacing:-.03em;margin:0 0 5px;">
      Bagikan <em class="cormorant" style="color:#d97706;font-size:1.1em;">Pengalaman.</em>
    </h1>
    <p style="font-size:13px;color:var(--gray-400);margin:0;">
      Testimoni Anda membantu pembeli lain memilih dengan lebih percaya diri
    </p>
  </div>

  @if($errors->any())
    <div class="error-box fade-up" style="animation-delay:.02s">
      <div style="display:flex;align-items:center;gap:8px;color:#b91c1c;font-weight:700;margin-bottom:8px;font-size:13.5px;">
        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
        </svg>
        Ada yang perlu diperbaiki
      </div>
      <ul style="margin:0;padding-left:20px;color:#dc2626;font-size:12.5px;line-height:1.8;">
        @foreach($errors->all() as $error)
          <li>{{ $error }}</li>
        @endforeach
      </ul>
    </div>
  @endif

  <form method="POST" action="{{ route('testimoni.store', $order->order_code) }}" enctype="multipart/form-data" id="form-testimoni">
    @csrf

    {{-- CARD 1: Produk yang direview --}}
    <div class="form-card fade-up" style="margin-bottom:16px;animation-delay:.04s;">
      <div class="card-head">
        <div class="card-icon">
          <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
          </svg>
        </div>
        <div>
          <div class="jakarta" style="font-size:14px;font-weight:700;">Pesanan yang Direview</div>
          <div style="font-size:12px;color:var(--gray-400);">{{ $order->order_code }}</div>
        </div>
      </div>
      <div style="padding:16px 20px;display:flex;flex-direction:column;gap:10px;">
        @foreach($order->items as $item)
          <div class="order-preview">
            <div class="order-preview-img">
              @if($item->product?->image)
                <img src="{{ Storage::url($item->product->image) }}" alt="{{ $item->product_name }}" />
              @else
                <div style="width:100%;height:100%;display:flex;align-items:center;justify-content:center;">
                  <svg style="width:22px;height:22px;color:#d1d5db;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                  </svg>
                </div>
              @endif
            </div>
            <div style="flex:1;min-width:0;">
              <div class="jakarta" style="font-size:13px;font-weight:700;color:var(--gray-900);line-height:1.3;overflow:hidden;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;">
                {{ $item->product_name }}
              </div>
              @php
                $condLabel = match($item->product_condition ?? '') {
                  'like_new' => 'Like New', 'good' => 'Good', 'fair' => 'Fair', default => null,
                };
              @endphp
              @if($condLabel)
                <span style="font-size:11px;font-weight:700;background:#dbeafe;color:#1d4ed8;padding:2px 8px;border-radius:99px;display:inline-block;margin-top:4px;">{{ $condLabel }}</span>
              @endif
            </div>
            <div class="jakarta" style="font-size:13px;font-weight:800;color:var(--gray-700);flex-shrink:0;">
              Rp {{ number_format($item->product_price, 0, ',', '.') }}
            </div>
          </div>
        @endforeach
      </div>
    </div>

    {{-- CARD 2: Rating bintang --}}
    <div class="form-card fade-up" style="margin-bottom:16px;animation-delay:.08s;">
      <div class="card-head">
        <div class="card-icon">
          <svg fill="currentColor" viewBox="0 0 20 20">
            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
          </svg>
        </div>
        <div>
          <div class="jakarta" style="font-size:14px;font-weight:700;">Rating Keseluruhan</div>
          <div style="font-size:12px;color:var(--gray-400);">Seberapa puas Anda dengan pembelian ini?</div>
        </div>
      </div>
      <div class="card-body">
        <input type="hidden" name="rating" id="rating-input" value="{{ old('rating') }}" />
        <div class="star-section">
          <div class="stars-wrap" id="stars-wrap" role="group" aria-label="Rating bintang">
            @for($i = 1; $i <= 5; $i++)
              <button type="button" class="star-btn {{ old('rating', 0) >= $i ? 'active' : '' }}"
                      data-value="{{ $i }}"
                      aria-label="{{ $i }} bintang"
                      onclick="setRating({{ $i }})"
                      onmouseenter="hoverRating({{ $i }})"
                      onmouseleave="unhoverRating()">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" stroke-width="0"/>
                </svg>
              </button>
            @endfor
          </div>
          <div class="star-label" id="star-label">
            {{ old('rating') ? '' : 'Ketuk bintang untuk memberi rating' }}
          </div>
        </div>
        @error('rating')
          <div class="form-error-msg" style="justify-content:center;">
            <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
            {{ $message }}
          </div>
        @enderror
      </div>
    </div>

    {{-- CARD 3: Komentar --}}
    <div class="form-card fade-up" style="margin-bottom:16px;animation-delay:.12s;">
      <div class="card-head">
        <div class="card-icon" style="background:#ede9fe;">
          <svg fill="none" stroke="#7c3aed" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/>
          </svg>
        </div>
        <div>
          <div class="jakarta" style="font-size:14px;font-weight:700;">Cerita Pengalaman Anda</div>
          <div style="font-size:12px;color:var(--gray-400);">Kondisi barang, packing, kesesuaian deskripsi, dll.</div>
        </div>
      </div>
      <div class="card-body">
        <div class="form-group" style="margin-bottom:0;">
          <label class="form-label">Komentar <span class="req">*</span></label>
          <textarea
            name="comment"
            id="comment"
            placeholder="Contoh: Barang datang dalam kondisi sangat baik, packing aman dan rapi. Kondisi sesuai deskripsi, warna dan ukuran cocok. Seller responsif dan pengiriman cepat. Sangat puas!"
            class="form-textarea {{ $errors->has('comment') ? 'border-red-400' : '' }}"
            maxlength="1000"
            oninput="updateCharCount()"
            rows="5">{{ old('comment') }}</textarea>
          <div class="char-count" id="char-count">0 / 1000 karakter</div>
          @error('comment')
            <div class="form-error-msg">
              <svg width="12" height="12" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
              {{ $message }}
            </div>
          @enderror
        </div>
      </div>
    </div>

    {{-- CARD 4: Foto (opsional) --}}
    <div class="form-card fade-up" style="margin-bottom:24px;animation-delay:.16s;">
      <div class="card-head">
        <div class="card-icon" style="background:#fff7ed;">
          <svg fill="none" stroke="#ea580c" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
            <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
          </svg>
        </div>
        <div>
          <div class="jakarta" style="font-size:14px;font-weight:700;">Tambah Foto <span style="font-size:11px;font-weight:400;color:var(--gray-400);">Opsional</span></div>
          <div style="font-size:12px;color:var(--gray-400);">Maksimal 3 foto, JPEG/PNG/WEBP, maks 2 MB/foto</div>
        </div>
      </div>
      <div class="card-body">
        <div class="photo-upload-area" id="upload-area"
             ondragover="event.preventDefault();this.classList.add('drag-over')"
             ondragleave="this.classList.remove('drag-over')"
             ondrop="handleDrop(event)">
          <input type="file" name="images[]" id="photo-input" multiple accept="image/jpeg,image/jpg,image/png,image/webp" onchange="handleFileChange(this)" />
          <div class="upload-icon">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/>
            </svg>
          </div>
          <p class="upload-text">Seret foto ke sini atau klik untuk memilih</p>
          <p class="upload-hint">JPEG · PNG · WEBP — maks 2 MB per foto</p>
        </div>
        <div class="photo-previews" id="photo-previews"></div>
        @error('images.*')
          <div class="form-error-msg" style="margin-top:8px;">{{ $message }}</div>
        @enderror
      </div>
    </div>

    {{-- Submit --}}
    <div class="fade-up" style="animation-delay:.2s;">
      <button type="submit" class="btn-submit" id="btn-submit">
        <svg style="width:16px;height:16px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
        </svg>
        Kirim Testimoni
      </button>
      <p style="text-align:center;font-size:11.5px;color:var(--gray-400);margin-top:12px;">
        Testimoni akan direview oleh tim kami sebelum ditampilkan
      </p>
    </div>

  </form>

</main>

{{-- FOOTER --}}
<footer style="background:var(--white);border-top:1px solid var(--border);">
  <div style="max-width:580px;margin:0 auto;padding:20px 24px;display:flex;justify-content:space-between;align-items:center;gap:16px;flex-wrap:wrap;">
    <img src="{{ asset('images/logo_full.png') }}" alt="PindahTangan" style="height:28px;width:auto;" />
    <p style="font-size:11.5px;color:var(--gray-400);margin:0;">© {{ date('Y') }} PindahTangan.</p>
  </div>
</footer>

<script>
/* ════════ STAR RATING ════════ */
const labels = ['', 'Tidak Puas 😞', 'Kurang Memuaskan 😕', 'Cukup Baik 😊', 'Sangat Baik 😄', 'Luar Biasa! 🤩'];
let currentRating = {{ old('rating', 0) }};

function setRating(val) {
  currentRating = val;
  document.getElementById('rating-input').value = val;
  updateStars(val);
  document.getElementById('star-label').textContent = labels[val];
  // animate
  const btn = document.querySelectorAll('.star-btn')[val - 1];
  btn.classList.add('star-bounce');
  setTimeout(() => btn.classList.remove('star-bounce'), 300);
}
function hoverRating(val) { updateStars(val, true); }
function unhoverRating() { updateStars(currentRating); }
function updateStars(val, isHover = false) {
  document.querySelectorAll('.star-btn').forEach((btn, i) => {
    btn.classList.toggle(isHover ? 'hover' : 'active', i < val);
    if (!isHover) btn.classList.remove('hover');
  });
}
// Init
if (currentRating > 0) {
  updateStars(currentRating);
  document.getElementById('star-label').textContent = labels[currentRating];
}

/* ════════ CHAR COUNT ════════ */
function updateCharCount() {
  const el  = document.getElementById('comment');
  const cnt = document.getElementById('char-count');
  const len = el.value.length;
  cnt.textContent = `${len} / 1000 karakter`;
  cnt.className   = 'char-count' + (len > 900 ? (len >= 1000 ? ' over' : ' warn') : '');
}
updateCharCount();

/* ════════ PHOTO UPLOAD ════════ */
let selectedFiles = [];

function handleFileChange(input) {
  const files = Array.from(input.files);
  addFiles(files);
}
function handleDrop(e) {
  e.preventDefault();
  document.getElementById('upload-area').classList.remove('drag-over');
  const files = Array.from(e.dataTransfer.files).filter(f => f.type.startsWith('image/'));
  addFiles(files);
}
function addFiles(files) {
  const remaining = 3 - selectedFiles.length;
  if (remaining <= 0) return;

  files.slice(0, remaining).forEach(file => {
    if (file.size > 2 * 1024 * 1024) {
      alert(`${file.name} melebihi batas 2 MB.`);
      return;
    }
    selectedFiles.push(file);
    renderPreview(file, selectedFiles.length - 1);
  });
  syncFileInput();
}
function renderPreview(file, idx) {
  const reader = new FileReader();
  reader.onload = e => {
    const wrap = document.getElementById('photo-previews');
    const div  = document.createElement('div');
    div.className = 'photo-preview-item';
    div.dataset.idx = idx;
    div.innerHTML = `
      <img src="${e.target.result}" />
      <button type="button" class="photo-preview-remove" onclick="removePhoto(${idx})">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M6 18L18 6M6 6l12 12"/>
        </svg>
      </button>`;
    wrap.appendChild(div);
  };
  reader.readAsDataURL(file);
}
function removePhoto(idx) {
  selectedFiles.splice(idx, 1);
  document.querySelectorAll('.photo-preview-item').forEach(el => el.remove());
  selectedFiles.forEach((f, i) => renderPreview(f, i));
  syncFileInput();
}
function syncFileInput() {
  const dt = new DataTransfer();
  selectedFiles.forEach(f => dt.items.add(f));
  document.getElementById('photo-input').files = dt.files;
}

/* ════════ SUBMIT ════════ */
document.getElementById('form-testimoni').addEventListener('submit', function(e) {
  if (!currentRating) {
    e.preventDefault();
    document.getElementById('stars-wrap').scrollIntoView({ behavior: 'smooth', block: 'center' });
    document.getElementById('star-label').textContent = '⚠️ Pilih rating terlebih dahulu';
    document.getElementById('star-label').style.color = '#ef4444';
    return;
  }
  const btn = document.getElementById('btn-submit');
  btn.disabled = true;
  btn.innerHTML = '<div style="width:16px;height:16px;border:2px solid rgba(255,255,255,.3);border-top-color:#fff;border-radius:50%;animation:spin .7s linear infinite;"></div> Mengirim...';
});

</script>
<style>
  @keyframes spin { to { transform: rotate(360deg); } }
</style>
</body>
</html>