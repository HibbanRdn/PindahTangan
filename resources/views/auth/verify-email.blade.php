<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Verifikasi Email — PindahTangan</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,700&family=Plus+Jakarta+Sans:ital,wght@0,400;0,600;0,700;1,400;1,600&display=swap" rel="stylesheet">

  <style>
    body { font-family: 'DM Sans', sans-serif; }
    .jakarta { font-family: 'Plus Jakarta Sans', sans-serif; }

    /* ── Pulse rings ── */
    @keyframes pulseRing {
      0%   { transform: scale(1);   opacity: 0.5; }
      100% { transform: scale(1.7); opacity: 0; }
    }
    .pulse-ring         { animation: pulseRing 2.2s cubic-bezier(0.22,1,0.36,1) infinite; }
    .pulse-ring-delay   { animation: pulseRing 2.2s cubic-bezier(0.22,1,0.36,1) infinite 0.7s; }

    /* ── Fade/slide animations ── */
    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(18px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeSlideDown {
      from { opacity: 0; transform: translateY(-10px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    .fade-up { animation: fadeUp 0.5s cubic-bezier(0.22,1,0.36,1) both; }

    /* ── Toast ── */
    @keyframes toastIn  { from { opacity:0; transform:translateX(100%) scale(0.95); } to { opacity:1; transform:translateX(0) scale(1); } }
    @keyframes toastOut { from { opacity:1; transform:translateX(0) scale(1); } to { opacity:0; transform:translateX(100%) scale(0.95); } }
    @keyframes progressBar { from { width:100%; } to { width:0%; } }

    .toast {
      position: fixed; top: 1.25rem; right: 1.25rem; z-index: 9999;
      min-width: 280px; max-width: 360px;
      border-radius: 0.875rem; padding: 0.875rem 1rem;
      display: flex; align-items: flex-start; gap: 0.75rem;
      box-shadow: 0 8px 32px rgba(0,0,0,0.13);
      animation: toastIn 0.4s cubic-bezier(0.22,1,0.36,1) both;
      overflow: hidden;
    }
    .toast.hiding { animation: toastOut 0.35s cubic-bezier(0.22,1,0.36,1) forwards; }
    .toast-progress {
      position: absolute; bottom: 0; left: 0; height: 3px;
      border-radius: 0 0 0.875rem 0.875rem;
      animation: progressBar 4s linear forwards;
    }

    /* ── Countdown ring ── */
    @keyframes dashShrink {
      from { stroke-dashoffset: 0; }
      to   { stroke-dashoffset: 113; }
    }
    .countdown-ring { animation: dashShrink 60s linear forwards; }

    /* ── Btn loading ── */
    @keyframes spin { to { transform: rotate(360deg); } }
    .spinner-ring {
      width: 18px; height: 18px;
      border: 2.5px solid rgba(255,255,255,0.35);
      border-top-color: #fff;
      border-radius: 50%;
      animation: spin 0.7s linear infinite;
    }
    .btn-submit { position:relative; overflow:hidden; }
    .btn-submit .btn-text { transition: opacity 0.2s; }
    .btn-submit .btn-spinner {
      position:absolute; inset:0; display:flex;
      align-items:center; justify-content:center;
      opacity:0; transition:opacity 0.2s;
    }
    .btn-submit.loading .btn-text   { opacity:0; }
    .btn-submit.loading .btn-spinner{ opacity:1; }

    /* ── Step badge hover ── */
    .step-item { transition: background-color 0.2s, border-color 0.2s; }
    .step-item:hover { background-color: #f0fdf4; border-color: #d1fae5; }

    /* ── Resend cooldown state ── */
    #resend-btn:disabled { opacity: 0.6; cursor: not-allowed; }
  </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

  <!-- ══ TOAST CONTAINER ══ -->
  <div id="toast-container" class="fixed top-5 right-5 z-[9999] flex flex-col gap-3 pointer-events-none"></div>

  <!-- ── Navbar minimal ── -->
  <nav class="bg-white border-b border-gray-100 px-6 h-14 flex items-center justify-between">
    <a href="/" class="inline-flex items-center gap-2">
      <img src="{{ asset('images/logo_pindahtangan.png') }}" alt="PindahTangan" class="h-35 w-auto" />
    </a>
    <form method="POST" action="{{ route('logout') }}" id="logout-nav-form">
      @csrf
      <button type="button" onclick="confirmLogout()"
        class="text-xs text-gray-400 hover:text-gray-700 transition-colors duration-200 flex items-center gap-1.5">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
        </svg>
        Keluar
      </button>
    </form>
  </nav>

  <!-- ── Main ── -->
  <main class="flex-1 flex items-center justify-center px-6 py-16">
    <div class="max-w-md w-full text-center">

      <!-- Animated icon -->
      <div class="relative inline-flex items-center justify-center mb-8 fade-up" style="animation-delay:0.05s">
        <div class="pulse-ring absolute w-20 h-20 rounded-full bg-emerald-100"></div>
        <div class="pulse-ring-delay absolute w-20 h-20 rounded-full bg-emerald-100"></div>
        <div class="relative w-20 h-20 rounded-full bg-emerald-500 flex items-center justify-center shadow-xl shadow-emerald-200 z-10">
          <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
              d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
          </svg>
        </div>
      </div>

      <!-- Headline — Plus Jakarta Sans -->
      <h1 class="jakarta text-3xl font-bold text-gray-900 tracking-tight mb-3 fade-up" style="animation-delay:0.1s">
        Satu langkah lagi!
      </h1>
      <p class="text-gray-500 text-sm leading-relaxed mb-1 fade-up" style="animation-delay:0.15s">
        Kami telah mengirim link verifikasi ke:
      </p>
      <p class="text-gray-900 font-bold text-base mb-8 fade-up" style="animation-delay:0.2s">
        {{ auth()->user()->email }}
      </p>

      <!-- ── Feedback: resend berhasil (server) ── -->
      @if (session('status') === 'verification-link-sent')
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-sm text-emerald-700 fade-up flex items-center gap-3">
          <div class="w-5 h-5 rounded-full bg-emerald-100 flex items-center justify-center shrink-0">
            <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
            </svg>
          </div>
          <span>Email verifikasi baru telah terkirim. Silakan cek inbox Anda.</span>
        </div>
      @endif

      <!-- ── Feedback: error (jika ada) ── -->
      @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700 fade-up flex items-start gap-3">
          <div class="w-5 h-5 rounded-full bg-red-100 flex items-center justify-center shrink-0 mt-0.5">
            <svg class="w-3 h-3 text-red-600" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
          </div>
          <div class="text-left">
            <p class="font-semibold mb-0.5">Terjadi kesalahan</p>
            <p>{{ $errors->first() }}</p>
          </div>
        </div>
      @endif

      <!-- Steps -->
      <div class="text-left bg-white border border-gray-100 rounded-2xl p-6 mb-6 fade-up space-y-4" style="animation-delay:0.25s">
        <div class="step-item flex gap-4 items-start border border-transparent rounded-xl p-3 -mx-1">
          <div class="w-7 h-7 rounded-full bg-emerald-100 text-emerald-700 flex items-center justify-center text-xs font-black shrink-0 mt-0.5">1</div>
          <p class="text-sm text-gray-600 leading-relaxed">Buka <span class="font-semibold text-gray-900">inbox atau folder Spam</span> email Anda.</p>
        </div>
        <div class="step-item flex gap-4 items-start border border-transparent rounded-xl p-3 -mx-1">
          <div class="w-7 h-7 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center text-xs font-black shrink-0 mt-0.5">2</div>
          <p class="text-sm text-gray-600 leading-relaxed">Cari email dari <span class="font-semibold text-gray-900">PindahTangan</span> dengan subjek <span class="font-semibold text-gray-900">"Verify Email Address"</span>.</p>
        </div>
        <div class="step-item flex gap-4 items-start border border-transparent rounded-xl p-3 -mx-1">
          <div class="w-7 h-7 rounded-full bg-yellow-100 text-yellow-700 flex items-center justify-center text-xs font-black shrink-0 mt-0.5">3</div>
          <p class="text-sm text-gray-600 leading-relaxed">Klik tombol <span class="font-semibold text-gray-900">"Verify Email Address"</span> di dalam email tersebut.</p>
        </div>
      </div>

      <!-- Tips card -->
      <div class="bg-amber-50 border border-amber-200 rounded-xl px-4 py-3 mb-6 fade-up flex items-start gap-3 text-left" style="animation-delay:0.28s">
        <svg class="w-4 h-4 text-amber-500 shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
          <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
        </svg>
        <p class="text-xs text-amber-700 leading-relaxed">
          <span class="font-semibold">Tidak menemukan email?</span> Cek folder <span class="font-semibold">Promosi</span> atau <span class="font-semibold">Spam</span>. Email biasanya tiba dalam 1–2 menit.
        </p>
      </div>

      <!-- Resend form -->
      <form method="POST" action="{{ route('verification.send') }}" id="resend-form" class="fade-up" style="animation-delay:0.3s">
        @csrf
        <button type="button" id="resend-btn" onclick="handleResend()"
          class="btn-submit w-full py-3.5 bg-gray-900 text-white text-sm font-bold rounded-xl hover:bg-emerald-600 active:scale-[0.98] transition-all duration-200 mb-4">
          <span class="btn-text flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
            </svg>
            Kirim Ulang Email Verifikasi
          </span>
          <span class="btn-spinner">
            <div class="spinner-ring"></div>
          </span>
        </button>
      </form>

      <!-- Cooldown countdown (hidden by default) -->
      <div id="cooldown-banner" class="hidden mb-4 fade-up">
        <div class="bg-blue-50 border border-blue-200 rounded-xl px-4 py-3 flex items-center gap-3">
          <svg class="w-4 h-4 text-blue-500 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
          <p class="text-xs text-blue-700 flex-1">
            Tunggu <span id="cooldown-timer" class="font-bold text-blue-800">60</span> detik sebelum mengirim ulang.
          </p>
        </div>
      </div>

      <!-- Footer links -->
      <p class="text-xs text-gray-400 fade-up" style="animation-delay:0.35s">
        Email yang salah?
        <button type="button" onclick="confirmLogout()"
          class="text-emerald-600 font-semibold hover:underline ml-1">
          Keluar dan daftar ulang
        </button>
      </p>

    </div>
  </main>

  <!-- ══ SCRIPTS ══ -->
  <script>

  // ── Toast System ─────────────────────────────────────────────────────
  function showToast(type, title, message) {
    const container = document.getElementById('toast-container');
    const colors = {
      success: { bg: 'bg-white', border: 'border-emerald-200', icon: 'bg-emerald-500', progress: 'bg-emerald-400',
        svg: `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>` },
      error:   { bg: 'bg-white', border: 'border-red-200',     icon: 'bg-red-500',     progress: 'bg-red-400',
        svg: `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>` },
      warning: { bg: 'bg-white', border: 'border-amber-200',   icon: 'bg-amber-500',   progress: 'bg-amber-400',
        svg: `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>` },
      info:    { bg: 'bg-white', border: 'border-blue-200',    icon: 'bg-blue-500',    progress: 'bg-blue-400',
        svg: `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>` },
    };
    const c = colors[type] || colors.info;
    const toast = document.createElement('div');
    toast.className = `toast pointer-events-auto border ${c.bg} ${c.border}`;
    toast.innerHTML = `
      <div class="w-8 h-8 rounded-full ${c.icon} flex items-center justify-center shrink-0">
        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">${c.svg}</svg>
      </div>
      <div class="flex-1 min-w-0">
        <p class="text-sm font-bold text-gray-900">${title}</p>
        ${message ? `<p class="text-xs text-gray-500 mt-0.5 leading-relaxed">${message}</p>` : ''}
      </div>
      <button onclick="dismissToast(this.parentElement)" class="text-gray-300 hover:text-gray-500 transition-colors shrink-0 self-start mt-0.5">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
        </svg>
      </button>
      <div class="toast-progress ${c.progress}"></div>`;
    container.appendChild(toast);
    setTimeout(() => dismissToast(toast), 4200);
  }

  function dismissToast(el) {
    if (!el || el.classList.contains('hiding')) return;
    el.classList.add('hiding');
    setTimeout(() => el.remove(), 350);
  }

  // ── Resend with Cooldown ──────────────────────────────────────────────
  let cooldownActive = false;

  function handleResend() {
    if (cooldownActive) return;

    const btn = document.getElementById('resend-btn');
    btn.classList.add('loading');
    btn.disabled = true;

    // Submit form
    document.getElementById('resend-form').submit();

    // Start cooldown UI
    startCooldown(60);
  }

  function startCooldown(seconds) {
    cooldownActive = true;
    const banner = document.getElementById('cooldown-banner');
    const timerEl = document.getElementById('cooldown-timer');
    const btn = document.getElementById('resend-btn');
    banner.classList.remove('hidden');

    let remaining = seconds;
    timerEl.textContent = remaining;

    const interval = setInterval(() => {
      remaining--;
      timerEl.textContent = remaining;
      if (remaining <= 0) {
        clearInterval(interval);
        cooldownActive = false;
        banner.classList.add('hidden');
        btn.classList.remove('loading');
        btn.disabled = false;
      }
    }, 1000);
  }

  // ── Confirm Logout ────────────────────────────────────────────────────
  function confirmLogout() {
    showToast('warning', 'Keluar dari akun?', 'Anda akan diarahkan ke halaman daftar.');
    setTimeout(() => {
      document.getElementById('logout-nav-form').submit();
    }, 1800);
  }

  // ── Auto-toast on page load jika resend berhasil ──────────────────────
  window.addEventListener('DOMContentLoaded', () => {

    // Jika halaman di-reload (misal kembali dari link expired)
    const urlParams = new URLSearchParams(window.location.search);
    if (urlParams.get('expired') === '1') {
      showToast('warning', 'Link kadaluarsa', 'Link verifikasi Anda sudah tidak berlaku. Silakan kirim ulang.');
    }
  });

  </script>

</body>
</html>