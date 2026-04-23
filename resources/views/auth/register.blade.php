<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Daftar — PindahTangan</title>
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
    @keyframes shake {
      0%, 100% { transform: translateX(0); }
      20%       { transform: translateX(-6px); }
      40%       { transform: translateX(6px); }
      60%       { transform: translateX(-4px); }
      80%       { transform: translateX(4px); }
    }
    @keyframes spin { to { transform: rotate(360deg); } }

    .animate-in {
      animation: fadeSlideUp 0.5s cubic-bezier(0.22, 1, 0.36, 1) both;
    }
    .shake { animation: shake 0.45s cubic-bezier(0.36,0.07,0.19,0.97) both; }

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

    /* ── Mosaic float animation ── */
    .mosaic-item {
      animation: floatMosaic 4s ease-in-out infinite;
    }
    .mosaic-item:nth-child(2) { animation-delay: 1s; }
    .mosaic-item:nth-child(3) { animation-delay: 2s; }
    .mosaic-item:nth-child(4) { animation-delay: 0.5s; }
    .mosaic-item:nth-child(5) { animation-delay: 1.5s; }
    @keyframes floatMosaic {
      0%, 100% { transform: translateY(0); }
      50%       { transform: translateY(-6px); }
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

  <div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">

    <!-- ── Panel Kiri — Visual ───────────────────────────────────── -->
    <div class="hidden lg:flex flex-col justify-between bg-gray-900 p-12 relative overflow-hidden">

      <!-- Background texture -->
      <div class="absolute inset-0 opacity-5"
           style="background-image: radial-gradient(circle, #fff 1px, transparent 1px); background-size: 24px 24px;"></div>

      <!-- Decorative blobs — emerald + orange + yellow, konsisten dengan login -->
      <div class="absolute -bottom-32 -left-32 w-96 h-96 bg-emerald-500 rounded-full blur-[120px] opacity-20"></div>
      <div class="absolute -top-16 -right-16 w-72 h-72 bg-orange-500 rounded-full blur-[100px] opacity-15"></div>
      <div class="absolute top-1/2 right-1/4 w-48 h-48 bg-yellow-400 rounded-full blur-[90px] opacity-8"></div>

      <!-- Logo -->
      <div class="relative z-10">
        <a href="/" class="inline-flex items-center gap-2">
          <img src="{{ asset('images/logo_pindahtangan.png') }}" alt="PindahTangan" class="h-35 w-auto brightness-0 invert" />
        </a>
      </div>

      <!-- Mosaic grid foto produk -->
      <div class="relative z-10 grid grid-cols-3 gap-3 my-auto py-8">
        <div class="mosaic-item col-span-2 h-48 rounded-2xl overflow-hidden ring-1 ring-white/10">
          <img src="https://picsum.photos/seed/cloth1/500/400" class="w-full h-full object-cover" alt="" referrerpolicy="no-referrer"/>
        </div>
        <div class="mosaic-item h-48 rounded-2xl overflow-hidden ring-1 ring-white/10" style="animation-delay:0.8s">
          <img src="https://picsum.photos/seed/bag2/300/400" class="w-full h-full object-cover" alt="" referrerpolicy="no-referrer"/>
        </div>
        <div class="mosaic-item h-32 rounded-2xl overflow-hidden ring-1 ring-white/10" style="animation-delay:1.4s">
          <img src="https://picsum.photos/seed/shoe3/300/300" class="w-full h-full object-cover" alt="" referrerpolicy="no-referrer"/>
        </div>
        <div class="mosaic-item col-span-2 h-32 rounded-2xl overflow-hidden ring-1 ring-white/10" style="animation-delay:0.3s">
          <img src="https://picsum.photos/seed/book4/500/300" class="w-full h-full object-cover" alt="" referrerpolicy="no-referrer"/>
        </div>
      </div>

      <!-- Trust badges row — konsisten dengan login -->
      <div class="relative z-10 space-y-5">
        <div class="flex gap-3">
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

        <!-- Copy — Plus Jakarta Sans, konsisten dengan login -->
        <div>
          <h2 class="jakarta text-white text-3xl leading-snug font-semibold">
            Barang bagus<br/>menunggu <em class="text-emerald-400">pemilik baru.</em>
          </h2>
        </div>
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
        <h1 class="text-3xl font-black text-gray-900 tracking-tight mb-1">Buat akun baru</h1>
        <p class="text-gray-400 text-sm">Sudah punya akun?
          <a href="{{ route('login') }}" class="text-emerald-600 font-semibold hover:text-emerald-700 hover:underline transition-colors duration-200">Masuk di sini</a>
        </p>
      </div>

      <!-- Status message -->
      @if (session('status'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-sm text-emerald-700 animate-in flex items-start gap-3">
          <div class="w-5 h-5 rounded-full bg-emerald-100 flex items-center justify-center shrink-0 mt-0.5">
            <svg class="w-3 h-3 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
            </svg>
          </div>
          <span>{{ session('status') }}</span>
        </div>
      @endif

      <!-- ── Form ── -->
      <form id="register-form" method="POST" action="{{ route('register') }}" class="space-y-5 animate-in" style="animation-delay: 0.1s;">
        @csrf

        <!-- Nama -->
        <div>
          <label for="name" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
            Nama Lengkap
          </label>
          <input
            type="text"
            id="name"
            name="name"
            value="{{ old('name') }}"
            placeholder="Nama lengkap Anda"
            autocomplete="name"
            autofocus
            class="input-field {{ $errors->has('name') ? 'is-error' : '' }}"
          />
          @error('name')
            <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
              <svg class="w-3 h-3 shrink-0" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
              </svg>
              {{ $message }}
            </p>
          @enderror
        </div>

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
          <label for="password" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
            Password
          </label>
          <div class="relative">
            <input
              type="password"
              id="password"
              name="password"
              placeholder="Minimal 8 karakter"
              autocomplete="new-password"
              class="input-field pr-11 {{ $errors->has('password') ? 'is-error' : '' }}"
              oninput="handlePasswordStrength(this)"
            />
            <button type="button" onclick="togglePassword('password', 'eye-open-1', 'eye-closed-1')"
              class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors duration-200 focus:outline-none"
              title="Tampilkan / Sembunyikan password">
              <svg id="eye-open-1" class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
              </svg>
              <svg id="eye-closed-1" class="w-4.5 h-4.5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
              </svg>
            </button>
          </div>

          <!-- Password strength indicator -->
          <div class="mt-2 space-y-1" id="strength-container" style="display:none;">
            <div class="flex gap-1">
              <div class="h-1 flex-1 rounded-full bg-gray-100 overflow-hidden">
                <div class="strength-bar" id="bar1" style="width:0%"></div>
              </div>
              <div class="h-1 flex-1 rounded-full bg-gray-100 overflow-hidden">
                <div class="strength-bar" id="bar2" style="width:0%"></div>
              </div>
              <div class="h-1 flex-1 rounded-full bg-gray-100 overflow-hidden">
                <div class="strength-bar" id="bar3" style="width:0%"></div>
              </div>
            </div>
            <p class="text-xs text-gray-400" id="strength-label"></p>
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

        <!-- Konfirmasi Password -->
        <div>
          <label for="password_confirmation" class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
            Konfirmasi Password
          </label>
          <div class="relative">
            <input
              type="password"
              id="password_confirmation"
              name="password_confirmation"
              placeholder="Ulangi password Anda"
              autocomplete="new-password"
              class="input-field pr-11"
              oninput="checkMatch()"
            />
            <button type="button" onclick="togglePassword('password_confirmation', 'eye-open-2', 'eye-closed-2')"
              class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors duration-200 focus:outline-none"
              title="Tampilkan / Sembunyikan password">
              <svg id="eye-open-2" class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
              </svg>
              <svg id="eye-closed-2" class="w-4.5 h-4.5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
              </svg>
            </button>
          </div>
          <!-- Match indicator -->
          <p class="mt-1.5 text-xs hidden" id="match-indicator"></p>
        </div>

        <!-- Submit -->
        <button type="submit" id="submit-btn"
          class="btn-submit w-full py-3.5 bg-gray-900 text-white text-sm font-bold rounded-xl hover:bg-emerald-600 active:scale-[0.98] transition-all duration-200">
          <span class="btn-text">Buat Akun</span>
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
          <span class="bg-white px-3 text-xs text-gray-400">Dengan mendaftar, Anda menyetujui</span>
        </div>
      </div>

      <!-- Terms -->
      <p class="text-center text-xs text-gray-400 leading-relaxed animate-in" style="animation-delay:0.25s;">
        <a href="#" class="text-gray-600 underline underline-offset-2 hover:text-emerald-600 transition-colors duration-200">Syarat &amp; Ketentuan</a>
        dan
        <a href="#" class="text-gray-600 underline underline-offset-2 hover:text-emerald-600 transition-colors duration-200">Kebijakan Privasi</a>
        kami.
      </p>

    </div>
  </div>

  <!-- ══ SCRIPTS ═══════════════════════════════════════════════════ -->
  <script>

  // ── Toggle Password Visibility ──────────────────────────────────────
  function togglePassword(fieldId, eyeOpenId, eyeClosedId) {
    const input = document.getElementById(fieldId);
    const isText = input.type === 'text';
    input.type = isText ? 'password' : 'text';
    document.getElementById(eyeOpenId).classList.toggle('hidden', !isText);
    document.getElementById(eyeClosedId).classList.toggle('hidden', isText);
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

  // ── Password Strength Meter ─────────────────────────────────────────
  const strengthColors = ['#f87171', '#fb923c', '#10b981']; // merah → orange → emerald
  const strengthLabels = ['Lemah', 'Sedang', 'Kuat'];

  function handlePasswordStrength(input) {
    const val = input.value;
    const strengthBox = document.getElementById('strength-container');
    const strengthLbl = document.getElementById('strength-label');
    const bars = [
      document.getElementById('bar1'),
      document.getElementById('bar2'),
      document.getElementById('bar3')
    ];

    if (!val) { strengthBox.style.display = 'none'; return; }
    strengthBox.style.display = 'block';
    input.classList.remove('is-error');

    let score = 0;
    if (val.length >= 8) score++;
    if (/[A-Z]/.test(val) && /[a-z]/.test(val)) score++;
    if (/[0-9]/.test(val) || /[^A-Za-z0-9]/.test(val)) score++;

    const color = strengthColors[score - 1] || strengthColors[0];
    bars.forEach((bar, i) => {
      bar.style.width      = i < score ? '100%' : '0%';
      bar.style.background = color;
    });
    strengthLbl.textContent = 'Kekuatan password: ' + (strengthLabels[score - 1] || 'Lemah');
    strengthLbl.style.color = color;

    checkMatch();
  }

  // ── Password Match Indicator ────────────────────────────────────────
  function checkMatch() {
    const a = document.getElementById('password').value;
    const b = document.getElementById('password_confirmation').value;
    const matchEl = document.getElementById('match-indicator');

    if (!b) { matchEl.classList.add('hidden'); return; }
    matchEl.classList.remove('hidden');

    if (a === b) {
      matchEl.textContent = '✓ Password cocok';
      matchEl.className = 'mt-1.5 text-xs text-emerald-500';
    } else {
      matchEl.textContent = '✗ Password tidak cocok';
      matchEl.className = 'mt-1.5 text-xs text-red-500';
    }
  }

  document.getElementById('password_confirmation').addEventListener('input', checkMatch);

  // ── Form Submit — Loading State + Validasi ──────────────────────────
  document.getElementById('register-form').addEventListener('submit', function(e) {
    const fields = ['name', 'email', 'password', 'password_confirmation'];
    let hasError = false;

    fields.forEach(id => {
      const el = document.getElementById(id);
      if (!el.value.trim()) {
        el.classList.add('is-error');
        el.classList.add('shake');
        setTimeout(() => el.classList.remove('shake'), 500);
        hasError = true;
      }
    });

    // Cek password tidak cocok
    const pw  = document.getElementById('password').value;
    const pwc = document.getElementById('password_confirmation').value;
    if (pw && pwc && pw !== pwc) {
      const pwcEl = document.getElementById('password_confirmation');
      pwcEl.classList.add('is-error');
      pwcEl.classList.add('shake');
      setTimeout(() => pwcEl.classList.remove('shake'), 500);
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