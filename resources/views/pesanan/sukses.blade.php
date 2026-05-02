<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Pesanan Diterima — PindahTangan</title>
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
      min-height: 100vh;
    }
    .jakarta   { font-family: 'Plus Jakarta Sans', sans-serif; }
    .cormorant { font-family: 'Cormorant Garamond', serif; }

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

    @keyframes scaleIn {
      0%   { transform: scale(0); opacity: 0; }
      60%  { transform: scale(1.15); }
      100% { transform: scale(1); opacity: 1; }
    }
    @keyframes checkDraw {
      from { stroke-dashoffset: 60; }
      to   { stroke-dashoffset: 0; }
    }
    @keyframes ripple {
      0%   { transform: scale(0.8); opacity: 1; }
      100% { transform: scale(2.2); opacity: 0; }
    }
    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(20px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes spin { to { transform: rotate(360deg); } }

    .success-icon-wrap {
      position: relative; width: 96px; height: 96px; margin: 0 auto 28px;
    }
    .success-ripple {
      position: absolute; inset: 0; border-radius: 50%;
      background: var(--emerald-100); animation: ripple 1.8s ease-out infinite;
    }
    .success-circle {
      position: absolute; inset: 0; border-radius: 50%;
      background: var(--emerald-600);
      display: flex; align-items: center; justify-content: center;
      animation: scaleIn .6s cubic-bezier(0.22,1,0.36,1) both;
    }
    .success-check {
      stroke-dasharray: 60; stroke-dashoffset: 60;
      animation: checkDraw .5s ease-out .5s forwards;
    }

    .sukses-card {
      background: var(--white); border: 1px solid var(--border);
      border-radius: 24px; padding: 48px 40px;
      max-width: 520px; margin: 0 auto; text-align: center;
      animation: fadeUp .6s cubic-bezier(0.22,1,0.36,1) both;
    }

    .info-box {
      background: var(--gray-50); border: 1px solid var(--border);
      border-radius: 14px; padding: 16px 20px; margin: 24px 0; text-align: left;
    }
    .info-row {
      display: flex; justify-content: space-between; align-items: center;
      padding: 7px 0; border-bottom: 1px solid var(--border); font-size: 13px; gap: 12px;
    }
    .info-row:last-child { border-bottom: none; }
    .info-label { color: var(--gray-400); font-weight: 500; }
    .info-value { font-weight: 700; color: var(--gray-900); text-align: right; }

    .status-pending-box {
      background: #fef9c3; border: 1px solid #fde047; border-radius: 12px;
      padding: 12px 16px; display: flex; align-items: center; gap: 10px; margin: 20px 0; text-align: left;
    }
    .status-paid-box {
      background: var(--emerald-50); border: 1px solid var(--emerald-100); border-radius: 12px;
      padding: 12px 16px; display: flex; align-items: center; gap: 10px; margin: 20px 0; text-align: left;
    }

    .btn-primary {
      display: inline-flex; align-items: center; justify-content: center; gap: 8px;
      padding: 13px 24px; width: 100%; font-size: 14px; font-weight: 800;
      font-family: 'Plus Jakarta Sans', sans-serif;
      color: #fff; background: var(--gray-900); border: none; border-radius: 12px;
      text-decoration: none; transition: background .2s, transform .15s, box-shadow .2s;
    }
    .btn-primary:hover {
      background: var(--emerald-600); box-shadow: 0 8px 24px rgba(5,150,105,0.3); transform: translateY(-1px);
    }
    .btn-secondary {
      display: inline-flex; align-items: center; justify-content: center; gap: 8px;
      padding: 12px 24px; width: 100%; font-size: 13.5px; font-weight: 700;
      color: var(--gray-700); background: var(--white);
      border: 1.5px solid var(--border); border-radius: 12px;
      text-decoration: none; transition: all .18s;
    }
    .btn-secondary:hover { border-color: var(--emerald); color: var(--emerald-600); background: var(--emerald-50); }

    .spinner-sm {
      width: 13px; height: 13px; border: 2px solid #fde047; border-top-color: #854d0e;
      border-radius: 50%; animation: spin 0.8s linear infinite; flex-shrink: 0;
    }

    .dots-bg { position: fixed; inset: 0; pointer-events: none; z-index: 0; overflow: hidden; }
    .dot { position: absolute; border-radius: 50%; opacity: 0; animation: dotFloat linear infinite; }
    @keyframes dotFloat {
      0%   { transform: translateY(110vh) rotate(0deg); opacity: 0; }
      10%  { opacity: .7; }
      90%  { opacity: .7; }
      100% { transform: translateY(-10vh) rotate(720deg); opacity: 0; }
    }

    @media (max-width: 600px) {
      .nav-inner { padding: 0 16px; }
      .sukses-card { padding: 36px 24px; }
    }
  </style>
</head>
<body>

<div class="dots-bg" aria-hidden="true">
  <div class="dot" style="width:8px;height:8px;background:#a7f3d0;left:10%;animation-duration:8s;animation-delay:0s;"></div>
  <div class="dot" style="width:6px;height:6px;background:#6ee7b7;left:25%;animation-duration:10s;animation-delay:1.5s;"></div>
  <div class="dot" style="width:10px;height:10px;background:#d1fae5;left:45%;animation-duration:9s;animation-delay:0.8s;"></div>
  <div class="dot" style="width:7px;height:7px;background:#a7f3d0;left:65%;animation-duration:11s;animation-delay:2s;"></div>
  <div class="dot" style="width:9px;height:9px;background:#6ee7b7;left:80%;animation-duration:7s;animation-delay:0.3s;"></div>
  <div class="dot" style="width:5px;height:5px;background:#d1fae5;left:90%;animation-duration:12s;animation-delay:3s;"></div>
</div>

{{-- ══ NAVBAR ══ --}}
<nav id="navbar" style="position:relative;z-index:50;">
  <div class="nav-inner">
    <a href="/">
      <img src="{{ asset('images/logo_full.png') }}" alt="PindahTangan" style="height:40px;width:auto;" />
    </a>
    <div style="display:flex;align-items:center;gap:16px;">
      <a href="{{ route('pesanan.index') }}"
         style="font-size:12.5px;font-weight:600;color:var(--gray-400);text-decoration:none;transition:color .15s;"
         onmouseover="this.style.color='var(--gray-900)'"
         onmouseout="this.style.color='var(--gray-400)'">
        ← Riwayat Pesanan
      </a>
      <a href="{{ route('produk.index') }}"
         style="font-size:12.5px;font-weight:600;color:var(--gray-400);text-decoration:none;transition:color .15s;"
         onmouseover="this.style.color='var(--gray-900)'"
         onmouseout="this.style.color='var(--gray-400)'">
        Lanjut Belanja →
      </a>
    </div>
  </div>
</nav>

{{-- ══ MAIN ══ --}}
<main style="position:relative;z-index:1;min-height:calc(100vh - 64px);display:flex;align-items:center;justify-content:center;padding:80px 24px 60px;">

  @php
    $payment  = $order->payment;
    $isPaid   = $payment?->status === 'paid';
    $canCancel = $order->status === 'pending' && ($payment?->status ?? 'pending') === 'pending';
  @endphp

  <div class="sukses-card">

    <div class="success-icon-wrap">
      <div class="success-ripple"></div>
      <div class="success-circle">
        <svg width="44" height="44" fill="none" stroke="white" viewBox="0 0 24 24" stroke-width="2.5">
          <polyline class="success-check" points="20 6 9 17 4 12" stroke-linecap="round" stroke-linejoin="round"/>
        </svg>
      </div>
    </div>

    <h1 class="jakarta" style="font-size:clamp(24px,4vw,32px);font-weight:800;letter-spacing:-.03em;margin:0 0 6px;">
      Pesanan <em class="cormorant" style="color:var(--emerald-600);font-size:1.1em;">Diterima!</em>
    </h1>
    <p style="font-size:14px;color:var(--gray-500);margin:0 0 4px;">
      Terima kasih, <strong style="color:var(--gray-900);">{{ auth()->user()->name }}</strong>.
    </p>
    <p style="font-size:13px;color:var(--gray-400);margin:0;">
      Pesanan Anda telah kami terima dan sedang menunggu konfirmasi pembayaran.
    </p>

    @if($isPaid)
      <div class="status-paid-box">
        <svg style="width:20px;height:20px;color:var(--emerald-600);flex-shrink:0;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
        </svg>
        <div>
          <div style="font-size:13px;font-weight:700;color:var(--emerald-700);">Pembayaran Lunas ✓</div>
          <div style="font-size:12px;color:var(--emerald-600);margin-top:1px;">Pesanan Anda sedang diproses oleh tim kami.</div>
        </div>
      </div>
    @else
      <div class="status-pending-box">
        <div class="spinner-sm"></div>
        <div>
          <div style="font-size:13px;font-weight:700;color:#854d0e;">Menunggu Konfirmasi Pembayaran</div>
          <div style="font-size:12px;color:#92400e;margin-top:1px;">
            Jika Anda sudah membayar, konfirmasi akan otomatis masuk dalam beberapa menit.
          </div>
        </div>
      </div>
    @endif

    <div class="info-box">
      <div class="info-row">
        <span class="info-label">Nomor Pesanan</span>
        <span class="info-value" style="font-size:12.5px;letter-spacing:.02em;">{{ $order->order_code }}</span>
      </div>
      <div class="info-row">
        <span class="info-label">Tanggal</span>
        <span class="info-value">{{ $order->created_at->format('d M Y, H:i') }} WIB</span>
      </div>
      <div class="info-row">
        <span class="info-label">{{ $order->items->count() }} Item</span>
        <span class="info-value">
          {{ $order->items->pluck('product_name')->take(1)->first() }}
          @if($order->items->count() > 1)
            <span style="font-weight:500;color:var(--gray-400);">+{{ $order->items->count() - 1 }} lainnya</span>
          @endif
        </span>
      </div>
      <div class="info-row">
        <span class="info-label">Kurir</span>
        <span class="info-value" style="text-transform:uppercase;">{{ $order->courier }} · {{ $order->courier_service }}</span>
      </div>
      <div class="info-row">
        <span class="info-label">Total Pembayaran</span>
        <span class="info-value" style="color:var(--emerald-700);font-size:15px;">
          Rp {{ number_format($order->total_amount, 0, ',', '.') }}
        </span>
      </div>
    </div>

    <div style="background:var(--gray-50);border:1px solid var(--border);border-radius:12px;padding:14px 16px;margin-bottom:24px;display:flex;align-items:flex-start;gap:10px;text-align:left;">
      <svg style="width:16px;height:16px;color:var(--gray-400);flex-shrink:0;margin-top:1px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
      </svg>
      <p style="font-size:12px;color:var(--gray-500);margin:0;line-height:1.6;">
        Pantau status pesanan Anda di halaman <strong>Riwayat Pesanan</strong>.
        Kami akan memperbarui status secara otomatis setelah pembayaran dikonfirmasi.
      </p>
    </div>

    {{-- Action buttons --}}
    <div style="display:flex;flex-direction:column;gap:10px;">
      <a href="{{ route('pesanan.show', $order->order_code) }}" class="btn-primary">
        <svg style="width:15px;height:15px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
        </svg>
        Lihat Detail Pesanan
      </a>
      <a href="{{ route('produk.index') }}" class="btn-secondary">
        <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
        Lanjut Belanja
      </a>

      {{-- Tombol batalkan — hanya muncul jika order & payment masih pending --}}
      @if($canCancel)
        <form method="POST" action="{{ route('pesanan.cancel', $order->order_code) }}"
              onsubmit="return confirm('Yakin ingin membatalkan pesanan ini? Tindakan tidak bisa dibatalkan.')">
          @csrf
          @method('DELETE')
          <button type="submit"
                  style="display:inline-flex;align-items:center;justify-content:center;gap:8px;
                         padding:12px 24px;width:100%;font-size:13px;font-weight:700;
                         color:#b91c1c;background:#fff5f5;border:1.5px solid #fecaca;
                         border-radius:12px;cursor:pointer;transition:all .18s;
                         font-family:'DM Sans',sans-serif;"
                  onmouseover="this.style.background='#fee2e2';this.style.borderColor='#f87171'"
                  onmouseout="this.style.background='#fff5f5';this.style.borderColor='#fecaca'">
            <svg style="width:14px;height:14px;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            Batalkan Pesanan
          </button>
        </form>
      @endif
    </div>

    <p style="font-size:11.5px;color:var(--gray-400);margin:20px 0 0;line-height:1.6;">
      Pertanyaan? Hubungi kami melalui email atau media sosial PindahTangan.
    </p>

  </div>
</main>

@if(!$isPaid)
  <script>
    let reloadCount = 0;
    const maxReloads = 10;
    const autoReload = setInterval(() => {
      reloadCount++;
      if (reloadCount >= maxReloads) { clearInterval(autoReload); return; }
      window.location.reload();
    }, 30000);
    window.addEventListener('beforeunload', () => clearInterval(autoReload));
  </script>
@endif

</body>
</html>