<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Masuk — PindahTangan</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,700&family=Plus+Jakarta+Sans:ital,wght@0,400;0,600;0,700;1,400;1,600&display=swap" rel="stylesheet">

  <style>
    body { font-family: 'DM Sans', sans-serif; }
    .jakarta { font-family: 'Plus Jakarta Sans', sans-serif; }

    /* ── Input Fields ── */
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

    /* ── Animations ── */
    @keyframes fadeSlideUp {
      from { opacity: 0; transform: translateY(20px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes fadeSlideDown {
      from { opacity: 0; transform: translateY(-10px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes shake {
      0%, 100% { transform: translateX(0); }
      20%       { transform: translateX(-6px); }
      40%       { transform: translateX(6px); }
      60%       { transform: translateX(-4px); }
      80%       { transform: translateX(4px); }
    }
    @keyframes toastIn {
      from { opacity: 0; transform: translateX(100%) scale(0.95); }
      to   { opacity: 1; transform: translateX(0) scale(1); }
    }
    @keyframes toastOut {
      from { opacity: 1; transform: translateX(0) scale(1); }
      to   { opacity: 0; transform: translateX(100%) scale(0.95); }
    }
    @keyframes progressBar {
      from { width: 100%; }
      to   { width: 0%; }
    }

    .animate-in {
      animation: fadeSlideUp 0.5s cubic-bezier(0.22, 1, 0.36, 1) both;
    }
    .shake { animation: shake 0.45s cubic-bezier(0.36,0.07,0.19,0.97) both; }

    /* ── Toast Notification ── */
    .toast {
      position: fixed;
      top: 1.25rem;
      right: 1.25rem;
      z-index: 9999;
      min-width: 280px;
      max-width: 360px;
      border-radius: 0.875rem;
      padding: 0.875rem 1rem;
      display: flex;
      align-items: flex-start;
      gap: 0.75rem;
      box-shadow: 0 8px 32px rgba(0,0,0,0.14);
      animation: toastIn 0.4s cubic-bezier(0.22, 1, 0.36, 1) both;
      overflow: hidden;
    }
    .toast.hiding {
      animation: toastOut 0.35s cubic-bezier(0.22, 1, 0.36, 1) forwards;
    }
    .toast-progress {
      position: absolute;
      bottom: 0; left: 0;
      height: 3px;
      border-radius: 0 0 0.875rem 0.875rem;
      animation: progressBar 4s linear forwards;
    }

    /* ── Submit button loading ── */
    .btn-submit {
      position: relative;
      overflow: hidden;
    }
    .btn-submit .btn-text { transition: opacity 0.2s; }
    .btn-submit .btn-spinner {
      position: absolute; inset: 0;
      display: flex; align-items: center; justify-content: center;
      opacity: 0; transition: opacity 0.2s;
    }
    .btn-submit.loading .btn-text { opacity: 0; }
    .btn-submit.loading .btn-spinner { opacity: 1; }

    @keyframes spin { to { transform: rotate(360deg); } }
    .spinner-ring {
      width: 20px; height: 20px;
      border: 2.5px solid rgba(255,255,255,0.35);
      border-top-color: #fff;
      border-radius: 50%;
      animation: spin 0.7s linear infinite;
    }

    /* ── Password strength bar ── */
    .strength-bar {
      height: 3px;
      border-radius: 2px;
      transition: width 0.4s ease, background-color 0.4s ease;
      width: 0%;
    }

    /* ── Checkbox custom ── */
    .custom-checkbox {
      appearance: none;
      width: 1.1rem; height: 1.1rem;
      border: 1.5px solid #d1d5db;
      border-radius: 0.35rem;
      cursor: pointer;
      transition: border-color 0.2s, background-color 0.2s;
      position: relative;
      flex-shrink: 0;
    }
    .custom-checkbox:checked {
      background-color: #10b981;
      border-color: #10b981;
      background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 16 16' fill='white' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M12.207 4.793a1 1 0 010 1.414l-5 5a1 1 0 01-1.414 0l-2-2a1 1 0 011.414-1.414L6.5 9.086l4.293-4.293a1 1 0 011.414 0z'/%3E%3C/svg%3E");
      background-size: 100%; background-position: center; background-repeat: no-repeat;
    }
    .custom-checkbox:focus {
      outline: none;
      box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.15);
    }
  </style>
</head>
<body class="bg-gray-50 min-h-screen">

  <!-- ══ TOAST CONTAINER ══════════════════════════════════════════ -->
  <div id="toast-container" class="fixed top-5 right-5 z-[9999] flex flex-col gap-3 pointer-events-none"></div>

  <div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">

    <!-- ── Panel Kiri — Visual ───────────────────────────────────── -->
    <div class="hidden lg:flex flex-col justify-between bg-gray-900 p-12 relative overflow-hidden">

      <!-- Background texture -->
      <div class="absolute inset-0 opacity-5"
           style="background-image: radial-gradient(circle, #fff 1px, transparent 1px); background-size: 24px 24px;"></div>

      <!-- Decorative blobs — emerald + orange untuk kesan friendly -->
      <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-emerald-500 rounded-full blur-[120px] opacity-20"></div>
      <div class="absolute top-20 -left-20 w-72 h-72 bg-orange-500 rounded-full blur-[100px] opacity-12"></div>
      <div class="absolute top-1/2 left-1/4 w-48 h-48 bg-yellow-400 rounded-full blur-[90px] opacity-8"></div>

      <!-- Logo -->
      <div class="relative z-10">
        <a href="/" class="inline-flex items-center gap-2">
          <img src="{{ asset('images/logo_full.png') }}" alt="PindahTangan" class="h-15 w-auto brightness-0 invert" />
        </a>
      </div>

      <!-- Testimonial cards -->
      <div class="relative z-10 space-y-4 my-auto py-8">

        <div class="bg-white/5 border border-white/10 rounded-2xl p-6 backdrop-blur-sm hover:bg-white/8 transition-colors duration-300">
          <div class="flex gap-1 mb-3">
            @for ($i = 0; $i < 5; $i++)
              <svg class="w-3.5 h-3.5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
              </svg>
            @endfor
          </div>
          <p class="text-gray-300 text-sm leading-relaxed jakarta italic">
            "Barangnya persis seperti foto, kondisi sangat bagus. Pengiriman cepat dan packing rapi. Pasti repeat order!"
          </p>
          <div class="flex items-center gap-3 mt-4">
            <div class="w-8 h-8 rounded-full bg-orange-500 flex items-center justify-center text-white text-xs font-bold">A</div>
            <div>
              <p class="text-white text-sm font-semibold">Anisa R.</p>
              <p class="text-gray-500 text-xs">Pembeli terverifikasi</p>
            </div>
          </div>
        </div>

        <div class="bg-emerald-600/15 border border-emerald-500/25 rounded-2xl p-6 hover:bg-emerald-600/20 transition-colors duration-300">
          <div class="flex gap-1 mb-3">
            @for ($i = 0; $i < 5; $i++)
              <svg class="w-3.5 h-3.5 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
              </svg>
            @endfor
          </div>
          <p class="text-gray-300 text-sm leading-relaxed jakarta italic">
            "Akhirnya nemu jaket yang udah lama dicari, harganya setengah dari harga baru. Worth it banget!"
          </p>
          <div class="flex items-center gap-3 mt-4">
            <div class="w-8 h-8 rounded-full bg-emerald-500 flex items-center justify-center text-white text-xs font-bold">D</div>
            <div>
              <p class="text-white text-sm font-semibold">Dimas P.</p>
              <p class="text-gray-500 text-xs">Pembeli terverifikasi</p>
            </div>
          </div>
        </div>

        <!-- Trust badges row -->
        <div class="flex gap-3 pt-1">
          <div class="flex items-center gap-1.5 bg-white/5 border border-white/10 rounded-full px-3 py-1.5">
            <div class="w-1.5 h-1.5 rounded-full bg-emerald-400"></div>
            <span class="text-gray-400 text-[10px] font-medium">Escrow Aman</span>
          </div>
          <div class="flex items-center gap-1.5 bg-white/5 border border-white/10 rounded-full px-3 py-1.5">
            <div class="w-1.5 h-1.5 rounded-full bg-orange-400"></div>
            <span class="text-gray-400 text-[10px] font-medium">Barang Terverifikasi</span>
          </div>
          <div class="flex items-center gap-1.5 bg-white/5 border border-white/10 rounded-full px-3 py-1.5">
            <div class="w-1.5 h-1.5 rounded-full bg-yellow-400"></div>
            <span class="text-gray-400 text-[10px] font-medium">Garansi Kembali</span>
          </div>
        </div>

      </div>

      <!-- Copy — Plus Jakarta Sans -->
      <div class="relative z-10">
        <h2 class="jakarta text-white text-3xl leading-snug font-semibold">
          Selamat datang<br/>kembali. <em class="text-emerald-400">Kami rindu.</em>
        </h2>
      </div>

    </div>

    <!-- ── Panel Kanan — Form ────────────────────────────────────── -->
    <div class="flex flex-col justify-center px-6 py-12 lg:px-16 xl:px-24 bg-white">

      <!-- Back link -->
      <a href="/" class="inline-flex items-center gap-1.5 text-xs text-gray-400 hover:text-gray-700 transition-colors duration-200 mb-10 self-start group">
        <svg class="w-3.5 h-3.5 group-hover:-translate-x-0.5 transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Kembali ke beranda
      </a>

      <!-- Header -->
      <div class="mb-8 animate-in" style="animation-delay: 0.05s;">
        <h1 class="text-3xl font-black text-gray-900 tracking-tight mb-1">Masuk ke akun Anda</h1>
        <p class="text-gray-400 text-sm">Belum punya akun?
          <a href="{{ route('register') }}" class="text-emerald-600 font-semibold hover:text-emerald-700 hover:underline transition-colors duration-200">Daftar gratis</a>
        </p>
      </div>

      <!-- ── Feedback: Session Status ── -->
      @if (session('status'))
        <div id="inline-success"
             class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-sm text-emerald-700 animate-in flex items-start gap-3"
             style="animation-delay: 0.0s;">
          <div class="w-5 h-5 rounded-full bg-emerald-100 flex items-center justify-center shrink-0 mt-0.5">
            <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
            </svg>
          </div>
          <span>{{ session('status') }}</span>
        </div>
      @endif

      <!-- ── Feedback: Email belum diverifikasi ── -->
      @if ($errors->has('email') && str_contains($errors->first('email'), 'belum'))
        <div class="mb-6 p-4 bg-amber-50 border border-amber-200 rounded-xl text-sm text-amber-800 animate-in flex items-start gap-3">
          <div class="w-5 h-5 rounded-full bg-amber-100 flex items-center justify-center shrink-0 mt-0.5">
            <svg class="w-3 h-3 text-amber-600" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
          </div>
          <div>
            <p class="font-semibold mb-0.5">Email belum diverifikasi</p>
            <p class="text-amber-700">Silakan cek inbox email Anda dan klik link verifikasi.</p>
            <form method="POST" action="{{ route('verification.send') }}" class="mt-2 inline">
              @csrf
              <button type="submit" class="text-amber-800 underline underline-offset-2 font-semibold text-xs hover:text-amber-900 transition-colors">
                Kirim ulang email verifikasi →
              </button>
            </form>
          </div>
        </div>
      @endif

      <!-- ── Feedback: Error umum (credential salah) ── -->
      @if ($errors->any() && !str_contains($errors->first('email') ?? '', 'belum'))
        <div id="error-banner"
             class="mb-6 p-4 bg-red-50 border border-red-200 rounded-xl text-sm text-red-700 animate-in flex items-start gap-3">
          <div class="w-5 h-5 rounded-full bg-red-100 flex items-center justify-center shrink-0 mt-0.5">
            <svg class="w-3 h-3 text-red-600" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
          </div>
          <div>
            <p class="font-semibold mb-0.5">Login gagal</p>
            <p>Email atau password yang Anda masukkan tidak sesuai.</p>
          </div>
        </div>
      @endif

      <!-- ── Form ── -->
      <form id="login-form" method="POST" action="{{ route('login') }}" class="space-y-5 animate-in" style="animation-delay: 0.1s;">
        @csrf

        <!-- Email -->
        <div>
          <label for="email" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
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
              oninput="validateEmail(this)"
            />
            <!-- Ikon validasi email -->
            <span id="email-check" class="absolute right-3 top-1/2 -translate-y-1/2 hidden">
              <svg class="w-4 h-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
              </svg>
            </span>
          </div>
          @error('email')
            <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
              <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
              </svg>
              {{ $message }}
            </p>
          @enderror
        </div>

        <!-- Password -->
        <div>
          <div class="flex justify-between items-center mb-1.5">
            <label for="password" class="block text-xs font-bold text-gray-500 uppercase tracking-wider">
              Password
            </label>
              <a href="{{ route('password.request') }}"
                class="text-xs text-gray-400 hover:text-emerald-600 transition-colors duration-200">
                Lupa password?
              </a>
          </div>
          <div class="relative">
            <input
              type="password"
              id="password"
              name="password"
              placeholder="Password Anda"
              autocomplete="current-password"
              class="input-field pr-11 {{ $errors->has('password') ? 'is-error' : '' }}"
              oninput="handlePasswordInput(this)"
            />
            <button type="button" onclick="togglePassword('password', this)"
              class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors duration-200 focus:outline-none"
              title="Tampilkan / Sembunyikan password">
              <!-- Eye open -->
              <svg id="eye-open" class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
              </svg>
              <!-- Eye closed -->
              <svg id="eye-closed" class="w-4.5 h-4.5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
              </svg>
            </button>
          </div>

          @error('password')
            <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
              <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
              </svg>
              {{ $message }}
            </p>
          @enderror
        </div>

        <!-- Remember me -->
        <div class="flex items-center gap-2.5">
          <input
            type="checkbox"
            id="remember"
            name="remember"
            class="custom-checkbox"
          />
          <label for="remember" class="text-sm text-gray-500 cursor-pointer select-none">
            Ingat saya di perangkat ini
          </label>
        </div>

        <!-- Submit -->
        <button type="submit" id="submit-btn"
          class="btn-submit w-full py-3.5 bg-gray-900 text-white text-sm font-bold rounded-xl hover:bg-emerald-600 active:scale-[0.98] transition-all duration-200">
          <span class="btn-text">Masuk</span>
          <span class="btn-spinner">
            <div class="spinner-ring"></div>
          </span>
        </button>

      </form>

      <!-- Divider -->
      <div class="relative my-6 animate-in" style="animation-delay:0.2s;">
        <div class="absolute inset-0 flex items-center">
          <div class="w-full border-t border-gray-100"></div>
        </div>
        <div class="relative flex justify-center">
          <span class="bg-white px-3 text-xs text-gray-400">Butuh bantuan?</span>
        </div>
      </div>

      <!-- Help links -->
      <div class="flex justify-center gap-4 text-xs animate-in" style="animation-delay:0.25s;">
        <a href="#" class="text-gray-400 hover:text-emerald-600 transition-colors duration-200 flex items-center gap-1">
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
          </svg>
          Pusat Bantuan
        </a>
        <span class="text-gray-200">|</span>
        <a href="#" class="text-gray-400 hover:text-orange-500 transition-colors duration-200 flex items-center gap-1">
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
          </svg>
          Hubungi Kami
        </a>
      </div>

      <!-- ── Dev only: Akun Testing ── -->
      @if (app()->isLocal())
        <details class="mt-8 text-xs text-gray-400 border border-dashed border-gray-200 rounded-xl p-4 animate-in" style="animation-delay:0.3s;">
          <summary class="cursor-pointer font-semibold text-gray-500 select-none flex items-center gap-1.5">
            <span class="w-2 h-2 rounded-full bg-orange-400 inline-block"></span>
            Akun Testing (dev only)
          </summary>
          <div class="mt-3 space-y-2">
            <div class="bg-gray-50 rounded-lg p-3 cursor-pointer hover:bg-emerald-50 hover:border-emerald-200 border border-transparent transition-all duration-200 group"
                 onclick="fillCredentials('admin@pindahtangan.test','password')" title="Klik untuk isi otomatis">
              <p class="font-bold text-gray-600 mb-1 flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-red-400"></span> Admin
                <span class="ml-auto text-[10px] text-emerald-500 opacity-0 group-hover:opacity-100 transition-opacity">Klik untuk isi →</span>
              </p>
              <p class="text-gray-400">admin@pindahtangan.test / password</p>
            </div>
            <div class="bg-gray-50 rounded-lg p-3 cursor-pointer hover:bg-emerald-50 hover:border-emerald-200 border border-transparent transition-all duration-200 group"
                 onclick="fillCredentials('budi@example.test','password')" title="Klik untuk isi otomatis">
              <p class="font-bold text-gray-600 mb-1 flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-emerald-400"></span> User (verified)
                <span class="ml-auto text-[10px] text-emerald-500 opacity-0 group-hover:opacity-100 transition-opacity">Klik untuk isi →</span>
              </p>
              <p class="text-gray-400">budi@example.test / password</p>
            </div>
            <div class="bg-gray-50 rounded-lg p-3 cursor-pointer hover:bg-amber-50 hover:border-amber-200 border border-transparent transition-all duration-200 group"
                 onclick="fillCredentials('siti@example.test','password')" title="Klik untuk isi otomatis">
              <p class="font-bold text-gray-600 mb-1 flex items-center gap-1.5">
                <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span> User (unverified)
                <span class="ml-auto text-[10px] text-amber-500 opacity-0 group-hover:opacity-100 transition-opacity">Klik untuk isi →</span>
              </p>
              <p class="text-gray-400">siti@example.test / password</p>
            </div>
          </div>
        </details>
      @endif

    </div>
  </div>


  <!-- ══ SCRIPTS ═══════════════════════════════════════════════════ -->
  <script>

  // ── Toggle Password Visibility ──────────────────────────────────────
  function togglePassword(fieldId, btn) {
    const input = document.getElementById(fieldId);
    const isText = input.type === 'text';
    input.type = isText ? 'password' : 'text';
    document.getElementById('eye-open').classList.toggle('hidden', !isText);
    document.getElementById('eye-closed').classList.toggle('hidden', isText);
  }

  // ── Email Real-time Validation ──────────────────────────────────────
  function validateEmail(input) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const check = document.getElementById('email-check');
    const isValid = emailRegex.test(input.value);
    check.classList.toggle('hidden', !isValid);
    input.classList.toggle('is-success', isValid && input.value.length > 0);
    input.classList.remove('is-error');
  }

  // ── Password Input Handler ──────────────────────────────────────────
  function handlePasswordInput(input) {
    if (input.value.length > 0) {
      input.classList.remove('is-error');
    }
  }

  // ── Dev: Fill Credentials ───────────────────────────────────────────
  function fillCredentials(email, password) {
    const emailInput = document.getElementById('email');
    const passInput  = document.getElementById('password');
    emailInput.value = email;
    passInput.value  = password;
    emailInput.dispatchEvent(new Event('input'));
  }

  // ── Form Submit — Loading State ─────────────────────────────────────
  document.getElementById('login-form').addEventListener('submit', function(e) {
    const emailInput = document.getElementById('email');
    const passInput  = document.getElementById('password');
    let hasError = false;

    // Validasi kosong
    if (!emailInput.value.trim()) {
      emailInput.classList.add('is-error');
      emailInput.classList.add('shake');
      setTimeout(() => emailInput.classList.remove('shake'), 500);
      hasError = true;
    }
    if (!passInput.value.trim()) {
      passInput.classList.add('is-error');
      passInput.classList.add('shake');
      setTimeout(() => passInput.classList.remove('shake'), 500);
      hasError = true;
    }

    if (hasError) {
      e.preventDefault();
      return;
    }

    // Aktifkan loading state
    const btn = document.getElementById('submit-btn');
    btn.classList.add('loading');
    btn.disabled = true;
  });

  </script>

</body>
</html>