<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Lupa Password — PindahTangan</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,700&family=Plus+Jakarta+Sans:ital,wght@0,400;0,600;0,700&display=swap" rel="stylesheet">

  <style>
    body { font-family: 'DM Sans', sans-serif; }
    .jakarta { font-family: 'Plus Jakarta Sans', sans-serif; }

    .input-field {
      width: 100%;
      padding: 0.75rem 1rem;
      border: 1.5px solid #e5e7eb;
      border-radius: 0.75rem;
      font-size: 0.9rem;
      color: #111;
      background: #fff;
      transition: border-color 0.2s, box-shadow 0.2s;
      outline: none;
    }
    .input-field:focus {
      border-color: #10b981;
      box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.12);
    }
    .input-field.is-error {
      border-color: #ef4444;
      box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.08);
    }
    .input-field.is-success {
      border-color: #10b981;
    }

    @keyframes fadeSlideUp {
      from { opacity: 0; transform: translateY(20px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes spin { to { transform: rotate(360deg); } }

    .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.22, 1, 0.36, 1) both; }

    .btn-submit { position: relative; overflow: hidden; }
    .btn-submit .btn-text { transition: opacity 0.2s; }
    .btn-submit .btn-spinner {
      position: absolute; inset: 0;
      display: flex; align-items: center; justify-content: center;
      opacity: 0; transition: opacity 0.2s;
    }
    .btn-submit.loading .btn-text   { opacity: 0; }
    .btn-submit.loading .btn-spinner{ opacity: 1; }
    .spinner-ring {
      width: 20px; height: 20px;
      border: 2.5px solid rgba(255,255,255,0.35);
      border-top-color: #fff;
      border-radius: 50%;
      animation: spin 0.7s linear infinite;
    }

    /* Pulsing icon */
    @keyframes pulseRing {
      0%   { transform: scale(1);   opacity: 0.5; }
      100% { transform: scale(1.6); opacity: 0; }
    }
    .pulse-ring       { animation: pulseRing 2.2s cubic-bezier(0.22,1,0.36,1) infinite; }
    .pulse-ring-delay { animation: pulseRing 2.2s cubic-bezier(0.22,1,0.36,1) infinite 0.7s; }
  </style>
</head>
<body class="bg-gray-50 min-h-screen">

  <div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">

    <!-- ── Panel Kiri — Visual ───────────────────────────────────── -->
    <div class="hidden lg:flex flex-col justify-between bg-gray-900 p-12 relative overflow-hidden">

      <div class="absolute inset-0 opacity-5"
           style="background-image: radial-gradient(circle, #fff 1px, transparent 1px); background-size: 24px 24px;"></div>
      <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-emerald-500 rounded-full blur-[120px] opacity-20"></div>
      <div class="absolute top-20 -left-20 w-72 h-72 bg-orange-500 rounded-full blur-[100px] opacity-12"></div>

      <!-- Logo -->
      <div class="relative z-10">
        <a href="/" class="inline-flex items-center gap-2">
          <img src="{{ asset('images/logo_full.png') }}" alt="PindahTangan"
               class="h-15 w-auto brightness-0 invert" />
        </a>
      </div>

      <!-- Ilustrasi tengah -->
      <div class="relative z-10 flex flex-col items-center justify-center my-auto py-8 text-center">

        <!-- Icon besar -->
        <div class="relative inline-flex items-center justify-center mb-8">
          <div class="pulse-ring absolute w-32 h-32 rounded-full bg-emerald-500/20"></div>
          <div class="pulse-ring-delay absolute w-32 h-32 rounded-full bg-emerald-500/20"></div>
          <div class="relative w-28 h-28 rounded-full bg-emerald-500/10 border border-emerald-500/30
                      flex items-center justify-center z-10">
            <svg class="w-12 h-12 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
            </svg>
          </div>
        </div>

        <h2 class="jakarta text-white text-2xl font-semibold leading-snug mb-3">
          Reset password<br/><em class="text-emerald-400">dalam hitungan menit.</em>
        </h2>
        <p class="text-gray-500 text-sm max-w-xs leading-relaxed">
          Masukkan email Anda dan kami akan mengirimkan link untuk membuat password baru.
        </p>

        <!-- Steps visual -->
        <div class="mt-8 space-y-3 text-left w-full max-w-xs">
          <div class="flex items-center gap-3 bg-white/5 border border-white/10 rounded-xl px-4 py-3">
            <div class="w-7 h-7 rounded-full bg-emerald-500/20 text-emerald-400 flex items-center
                        justify-center text-xs font-black shrink-0">1</div>
            <p class="text-gray-400 text-xs">Masukkan email akun Anda</p>
          </div>
          <div class="flex items-center gap-3 bg-white/5 border border-white/10 rounded-xl px-4 py-3">
            <div class="w-7 h-7 rounded-full bg-orange-500/20 text-orange-400 flex items-center
                        justify-center text-xs font-black shrink-0">2</div>
            <p class="text-gray-400 text-xs">Cek email — klik link reset password</p>
          </div>
          <div class="flex items-center gap-3 bg-white/5 border border-white/10 rounded-xl px-4 py-3">
            <div class="w-7 h-7 rounded-full bg-yellow-500/20 text-yellow-400 flex items-center
                        justify-center text-xs font-black shrink-0">3</div>
            <p class="text-gray-400 text-xs">Buat password baru dan masuk kembali</p>
          </div>
        </div>
      </div>

      <!-- Bottom copy -->
      <div class="relative z-10">
        <p class="text-gray-600 text-xs">Link reset password berlaku selama <span class="text-gray-400 font-semibold">60 menit</span>.</p>
      </div>

    </div>

    <!-- ── Panel Kanan — Form ────────────────────────────────────── -->
    <div class="flex flex-col justify-center px-6 py-12 lg:px-16 xl:px-24 bg-white">

      <!-- Back link -->
      <a href="{{ route('login') }}"
         class="inline-flex items-center gap-1.5 text-xs text-gray-400 hover:text-gray-700
                transition-colors duration-200 mb-10 self-start group">
        <svg class="w-3.5 h-3.5 group-hover:-translate-x-0.5 transition-transform duration-200"
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Kembali ke halaman masuk
      </a>

      <!-- Header -->
      <div class="mb-8 animate-in" style="animation-delay:0.05s">
        <div class="inline-flex items-center justify-center w-12 h-12 rounded-2xl bg-emerald-50
                    border border-emerald-100 mb-5">
          <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
          </svg>
        </div>
        <h1 class="text-3xl font-black text-gray-900 tracking-tight mb-2">Lupa password?</h1>
        <p class="text-gray-400 text-sm leading-relaxed">
          Tidak masalah. Masukkan email akun Anda dan kami akan mengirimkan link untuk membuat password baru.
        </p>
      </div>

      <!-- ── Status: Link berhasil dikirim ── -->
      @if (session('status'))
        <div class="mb-6 p-5 bg-emerald-50 border border-emerald-200 rounded-2xl animate-in"
             style="animation-delay:0.0s">
          <div class="flex items-start gap-3">
            <div class="w-8 h-8 rounded-full bg-emerald-100 flex items-center justify-center shrink-0 mt-0.5">
              <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
              </svg>
            </div>
            <div>
              <p class="text-sm font-bold text-emerald-800 mb-1">Email terkirim!</p>
              <p class="text-sm text-emerald-700 leading-relaxed">
                Jika email Anda terdaftar di sistem kami, link reset password
                telah dikirim. Silakan cek inbox atau folder Spam Anda.
              </p>
            </div>
          </div>

          <!-- Info tambahan setelah berhasil -->
          <div class="mt-4 pt-4 border-t border-emerald-200 space-y-2">
            <div class="flex items-center gap-2 text-xs text-emerald-700">
              <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
              </svg>
              Link berlaku selama <strong>60 menit</strong>
            </div>
            <div class="flex items-center gap-2 text-xs text-emerald-700">
              <svg class="w-3.5 h-3.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
              </svg>
              Cek juga folder <strong>Promosi</strong> dan <strong>Spam</strong>
            </div>
          </div>
        </div>
      @endif

      <!-- ── Error Banner ── -->
      @if ($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700
                    animate-in flex items-start gap-3">
          <div class="w-5 h-5 rounded-full bg-red-100 flex items-center justify-center shrink-0 mt-0.5">
            <svg class="w-3 h-3 text-red-600" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd"
                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                clip-rule="evenodd"/>
            </svg>
          </div>
          <div>
            <p class="font-semibold mb-0.5">Terjadi kesalahan</p>
            <p>{{ $errors->first() }}</p>
          </div>
        </div>
      @endif

      <!-- Form -->
      <form id="forgot-form" method="POST" action="{{ route('password.email') }}"
            class="space-y-5 animate-in" style="animation-delay:0.1s">
        @csrf

        <div>
          <label for="email"
                 class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
            Alamat Email
          </label>
          <div class="relative">
            <input
              type="email"
              id="email"
              name="email"
              value="{{ old('email') }}"
              placeholder="email@contoh.com"
              autocomplete="email"
              autofocus
              class="input-field {{ $errors->has('email') ? 'is-error' : '' }}"
              oninput="validateEmailField(this)"
            />
            <span id="email-check" class="absolute right-3 top-1/2 -translate-y-1/2 hidden">
              <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
              </svg>
            </span>
          </div>
          @error('email')
            <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
              <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd"
                  d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                  clip-rule="evenodd"/>
              </svg>
              {{ $message }}
            </p>
          @enderror
        </div>

        <button type="submit" id="submit-btn"
          class="btn-submit w-full py-3.5 bg-gray-900 text-white text-sm font-bold rounded-xl
                 hover:bg-emerald-600 active:scale-[0.98] transition-all duration-200">
          <span class="btn-text flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            Kirim Link Reset Password
          </span>
          <span class="btn-spinner">
            <div class="spinner-ring"></div>
          </span>
        </button>

      </form>

      <!-- Divider -->
      <div class="relative my-6 animate-in" style="animation-delay:0.2s">
        <div class="absolute inset-0 flex items-center">
          <div class="w-full border-t border-gray-100"></div>
        </div>
        <div class="relative flex justify-center">
          <span class="bg-white px-3 text-xs text-gray-400">Ingat password Anda?</span>
        </div>
      </div>

      <a href="{{ route('login') }}"
         class="w-full py-3 text-sm font-semibold text-gray-600 bg-gray-50 border border-gray-200
                rounded-xl hover:bg-gray-100 transition-all duration-200 text-center
                flex items-center justify-center gap-2 animate-in"
         style="animation-delay:0.25s">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
            d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"/>
        </svg>
        Kembali Masuk
      </a>

    </div>
  </div>

  <script>
    function validateEmailField(input) {
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      const check = document.getElementById('email-check');
      const isValid = emailRegex.test(input.value);
      check.classList.toggle('hidden', !isValid);
      input.classList.toggle('is-success', isValid && input.value.length > 0);
      input.classList.remove('is-error');
    }

    document.getElementById('forgot-form').addEventListener('submit', function (e) {
      const emailInput = document.getElementById('email');
      if (!emailInput.value.trim()) {
        e.preventDefault();
        emailInput.classList.add('is-error');
        emailInput.focus();
        return;
      }
      const btn = document.getElementById('submit-btn');
      btn.classList.add('loading');
      btn.disabled = true;
    });
  </script>

</body>
</html>