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
      --emerald-50:  #ecfdf5;
      --emerald-100: #d1fae5;
      --gray-900:    #111827;
      --gray-700:    #374151;
      --gray-400:    #9ca3af;
      --gray-100:    #f3f4f6;
      --border:      #e5e7eb;
    }

    body       { font-family: 'DM Sans', sans-serif; background: #fafafa; color: var(--gray-900); }
    .jakarta   { font-family: 'Plus Jakarta Sans', sans-serif; }
    .cormorant { font-family: 'Cormorant Garamond', serif; }

    /* ── Navbar ── */
    #navbar {
      position: fixed; top: 0; width: 100%; z-index: 50;
      background: rgba(255,255,255,0.88);
      backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);
      border-bottom: 1px solid var(--border);
      box-shadow: 0 1px 12px rgba(0,0,0,0.05);
    }

    /* ── Cart item card ── */
    .cart-item {
      background: #fff;
      border: 1px solid var(--border);
      border-radius: 16px;
      padding: 16px;
      display: flex;
      align-items: center;
      gap: 16px;
      transition: border-color .2s, box-shadow .2s;
    }
    .cart-item:hover { border-color: var(--emerald-100); box-shadow: 0 4px 20px rgba(0,0,0,0.06); }
    .cart-item.unavailable {
      opacity: 0.6;
      border-color: #fecaca;
      background: #fff5f5;
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

    /* ── Condition badge ── */
    .badge-condition {
      display: inline-flex; align-items: center; gap: 4px;
      padding: 2px 9px; border-radius: 99px;
      font-size: 11px; font-weight: 700;
    }
    .badge-like_new { background: #dcfce7; color: #15803d; }
    .badge-good     { background: #dbeafe; color: #1d4ed8; }
    .badge-fair     { background: #ffedd5; color: #9a3412; }

    /* ── Summary card ── */
    .summary-card {
      background: #fff;
      border: 1px solid var(--border);
      border-radius: 20px;
      padding: 24px;
      position: sticky;
      top: 84px;
    }

    /* ── Buttons ── */
    .btn-primary {
      display: inline-flex; align-items: center; justify-content: center; gap: 8px;
      padding: 12px 24px;
      background: var(--gray-900); color: #fff;
      border: none; border-radius: 12px;
      font-size: 14px; font-weight: 700;
      font-family: 'DM Sans', sans-serif;
      cursor: pointer; text-decoration: none; width: 100%;
      transition: background .2s, transform .15s, box-shadow .2s;
    }
    .btn-primary:hover {
      background: var(--emerald-600);
      box-shadow: 0 8px 24px rgba(5,150,105,0.3);
      transform: translateY(-1px);
    }
    .btn-primary:disabled {
      background: #d1d5db; color: #9ca3af; cursor: not-allowed;
      transform: none; box-shadow: none;
    }
    .btn-ghost {
      display: inline-flex; align-items: center; justify-content: center; gap: 6px;
      padding: 8px 16px;
      background: transparent; color: var(--gray-700);
      border: 1.5px solid var(--border); border-radius: 10px;
      font-size: 12.5px; font-weight: 600;
      font-family: 'DM Sans', sans-serif;
      cursor: pointer; text-decoration: none;
      transition: all .2s;
    }
    .btn-ghost:hover { border-color: #ef4444; color: #ef4444; background: #fff5f5; }
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
    @keyframes floatEmpty {
      0%, 100% { transform: translateY(0); }
      50%       { transform: translateY(-8px); }
    }
    .empty-float { animation: floatEmpty 3s ease-in-out infinite; }

    /* ── Fade in ── */
    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(16px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    .fade-up { animation: fadeUp .5s cubic-bezier(0.22,1,0.36,1) both; }

    /* ── Unavailable warning badge ── */
    .unavailable-badge {
      display: inline-flex; align-items: center; gap: 4px;
      padding: 2px 9px; border-radius: 99px;
      font-size: 11px; font-weight: 700;
      background: #fee2e2; color: #b91c1c;
    }

    /* ── Divider row ── */
    .summary-row {
      display: flex; justify-content: space-between; align-items: center;
      font-size: 13.5px; color: var(--gray-700);
      padding: 8px 0;
    }
    .summary-row.total {
      font-size: 16px; font-weight: 800; color: var(--gray-900);
      border-top: 1px solid var(--border); padding-top: 14px; margin-top: 6px;
    }
  </style>
</head>
<body>

<div id="toast-container"></div>

<!-- ══ NAVBAR ══ -->
<nav id="navbar">
  <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between">
    <a href="/" class="shrink-0">
      <img src="{{ asset('images/logo_full.png') }}" alt="PindahTangan" class="h-10 w-auto" />
    </a>
    <div class="flex items-center gap-3">
      <a href="{{ route('produk.index') }}"
         class="hidden md:inline-flex items-center gap-1.5 text-sm font-medium text-gray-500 hover:text-gray-900 transition-colors duration-200">
        ← Lanjut Belanja
      </a>
      <form method="POST" action="{{ route('logout') }}" class="hidden md:inline">
        @csrf
        <button type="submit"
          class="w-9 h-9 rounded-full bg-white/70 border border-gray-200 flex items-center justify-center text-gray-500 hover:text-red-500 transition-all duration-200">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
          </svg>
        </button>
      </form>
    </div>
  </div>
</nav>

<!-- ══ MAIN ══ -->
<main class="max-w-7xl mx-auto px-6 pt-24 pb-20">

  <!-- Header -->
  <div class="mb-8 fade-up">
    <h1 class="text-4xl font-black text-gray-900 tracking-tight jakarta mb-1">
      Keranjang Belanja
    </h1>
    <p class="text-gray-400 text-sm">
      @if($cartItems->count() > 0)
        {{ $cartItems->count() }} item · hanya barang <em>available</em> yang bisa di-checkout
      @else
        Keranjang Anda masih kosong
      @endif
    </p>
  </div>

  @if($cartItems->count() > 0)

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 items-start">

      <!-- ── Kolom Kiri: Item List ── -->
      <div class="lg:col-span-2 flex flex-col gap-4">

        {{-- Warning jika ada item yang tidak tersedia --}}
        @if(count($unavailableIds) > 0)
          <div class="flex items-start gap-3 p-4 bg-red-50 border border-red-200 rounded-2xl fade-up">
            <svg class="w-5 h-5 text-red-500 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            <div>
              <p class="text-sm font-bold text-red-700">{{ count($unavailableIds) }} item sudah tidak tersedia</p>
              <p class="text-xs text-red-600 mt-0.5">Item yang tidak tersedia tidak akan ikut di-checkout. Hapus dari keranjang untuk membersihkan.</p>
            </div>
          </div>
        @endif

        @foreach($cartItems as $item)
          @php
            $isUnavailable = in_array($item->id, $unavailableIds);
            $condLabel = match($item->product?->condition ?? '') {
              'like_new' => 'Like New',
              'good'     => 'Good',
              'fair'     => 'Fair',
              default    => '-',
            };
          @endphp

          <div class="cart-item fade-up {{ $isUnavailable ? 'unavailable' : '' }}" style="animation-delay: {{ $loop->index * 60 }}ms">

            <!-- Foto produk -->
            <div class="cart-item-img">
              @if($item->product?->image)
                <img src="{{ Storage::url($item->product->image) }}" alt="{{ $item->product->name }}" />
              @else
                <div class="w-full h-full flex items-center justify-center">
                  <svg class="w-8 h-8 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                  </svg>
                </div>
              @endif
            </div>

            <!-- Info produk -->
            <div class="flex-1 min-w-0">
              <div class="flex items-start gap-2 mb-1 flex-wrap">
                <span class="text-xs font-semibold text-gray-400 uppercase tracking-wider">
                  {{ $item->product?->category?->name ?? '—' }}
                </span>
                @if($item->product)
                  <span class="badge-condition badge-{{ $item->product->condition }}">{{ $condLabel }}</span>
                @endif
                @if($isUnavailable)
                  <span class="unavailable-badge">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd"/></svg>
                    Tidak tersedia
                  </span>
                @endif
              </div>

              <a href="{{ $item->product ? route('produk.show', $item->product->slug) : '#' }}"
                 class="text-sm font-bold text-gray-900 hover:text-emerald-600 transition-colors duration-200 line-clamp-2 block jakarta mb-2">
                {{ $item->product?->name ?? '(Produk dihapus)' }}
              </a>

              <p class="text-base font-black text-gray-900">
                @if($item->product)
                  Rp {{ number_format($item->product->price, 0, ',', '.') }}
                @else
                  —
                @endif
              </p>
            </div>

            <!-- Hapus button -->
            <form method="POST" action="{{ route('keranjang.destroy', $item->id) }}" class="shrink-0">
              @csrf
              @method('DELETE')
              <button type="submit" class="btn-delete" title="Hapus dari keranjang"
                      onclick="return confirm('Hapus item ini dari keranjang?')">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
              </button>
            </form>

          </div>
        @endforeach

        <!-- Lanjut belanja link -->
        <div class="mt-2">
          <a href="{{ route('produk.index') }}"
             class="inline-flex items-center gap-2 text-sm font-semibold text-gray-400 hover:text-emerald-600 transition-colors duration-200">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
            </svg>
            Lanjut Belanja
          </a>
        </div>

      </div>

      <!-- ── Kolom Kanan: Summary ── -->
      <div class="summary-card fade-up" style="animation-delay:.15s">

        <h2 class="text-base font-black text-gray-900 jakarta mb-5">Ringkasan Pesanan</h2>

        <!-- Item available -->
        @php
          $availableItems = $cartItems->filter(fn($i) => !in_array($i->id, $unavailableIds));
          $availableCount = $availableItems->count();
        @endphp

        <div class="summary-row">
          <span class="text-gray-500">Item tersedia</span>
          <span class="font-semibold">{{ $availableCount }} barang</span>
        </div>

        <div class="summary-row">
          <span class="text-gray-500">Subtotal</span>
          <span class="font-semibold">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
        </div>

        <div class="summary-row">
          <span class="text-gray-500">Ongkos kirim</span>
          <span class="text-xs text-gray-400">Dihitung saat checkout</span>
        </div>

        <div class="summary-row total">
          <span>Total Estimasi</span>
          <span class="text-emerald-600">Rp {{ number_format($subtotal, 0, ',', '.') }}</span>
        </div>

        <div class="mt-6">
          @if($availableCount > 0)
            <a href="{{ route('checkout.index') }}" class="btn-primary">
              <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
              </svg>
              Lanjut ke Checkout
            </a>
          @else
            <button disabled class="btn-primary">
              Tidak ada item tersedia
            </button>
          @endif
        </div>

        <!-- Info: preloved note -->
        <div class="mt-4 p-3 bg-emerald-50 border border-emerald-100 rounded-xl">
          <p class="text-xs text-emerald-700 leading-relaxed">
            <span class="font-bold">💡 Info:</span> Stok barang preloved tidak dikunci saat di keranjang.
            Selesaikan checkout segera agar tidak didahului pembeli lain.
          </p>
        </div>

        <!-- Trust badges -->
        <div class="mt-4 flex flex-col gap-2">
          @foreach(['🔒 Transaksi Aman & Terenkripsi', '📦 Packing Rapi & Aman', '✅ Kondisi Sesuai Deskripsi'] as $badge)
            <div class="flex items-center gap-2 text-xs text-gray-500">
              <span>{{ $badge }}</span>
            </div>
          @endforeach
        </div>

      </div>

    </div>

  @else

    <!-- ── Empty State ── -->
    <div class="flex flex-col items-center justify-center py-28 text-center fade-up">
      <div class="empty-float mb-6">
        <div class="w-24 h-24 rounded-3xl bg-emerald-50 flex items-center justify-center mx-auto">
          <svg class="w-12 h-12 text-emerald-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
          </svg>
        </div>
      </div>
      <h3 class="text-2xl font-black text-gray-900 mb-2 jakarta">Keranjang masih kosong</h3>
      <p class="text-gray-400 text-sm mb-8 max-w-xs leading-relaxed">
        Temukan barang preloved berkualitas di katalog kami dan mulai berbelanja!
      </p>
      <a href="{{ route('produk.index') }}"
         class="inline-flex items-center gap-2 px-8 py-3.5 text-sm font-bold text-white bg-gray-900 rounded-full hover:bg-emerald-600 transition-colors duration-200 shadow-lg">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
document.addEventListener('DOMContentLoaded', () => {
  // Auto-show toast dari session
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
    success: { bg: '#dcfce7', color: '#15803d', icon: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>' },
    error:   { bg: '#fee2e2', color: '#b91c1c', icon: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>' },
    info:    { bg: '#dbeafe', color: '#1d4ed8', icon: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01"/>' },
  };
  const c = colors[type] || colors.info;
  const t = document.createElement('div');
  t.className = 'toast';
  t.innerHTML = `
    <div class="toast-icon" style="background:${c.bg};">
      <svg width="16" height="16" fill="none" stroke="${c.color}" viewBox="0 0 24 24">${c.icon}</svg>
    </div>
    <div>
      <p style="font-size:13px;font-weight:700;color:#111827;">${title}</p>
      <p style="font-size:12px;color:#6b7280;margin-top:2px;">${msg}</p>
    </div>`;
  document.getElementById('toast-container').appendChild(t);
  setTimeout(() => { t.classList.add('hiding'); setTimeout(() => t.remove(), 300); }, 3800);
}
</script>

</body>
</html>