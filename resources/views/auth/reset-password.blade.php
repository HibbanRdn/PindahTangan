<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Reset Password — PindahTangan</title>
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
    .input-field.is-success { border-color: #10b981; }

    @keyframes fadeSlideUp {
      from { opacity: 0; transform: translateY(20px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    @keyframes spin { to { transform: rotate(360deg); } }
    @keyframes shake {
      0%, 100% { transform: translateX(0); }
      20% { transform: translateX(-6px); }
      40% { transform: translateX( 6px); }
      60% { transform: translateX(-4px); }
      80% { transform: translateX( 4px); }
    }

    .animate-in { animation: fadeSlideUp 0.5s cubic-bezier(0.22, 1, 0.36, 1) both; }
    .shake { animation: shake 0.45s cubic-bezier(0.36,0.07,0.19,0.97) both; }

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

    .strength-bar {
      height: 3px;
      border-radius: 2px;
      transition: width 0.4s ease, background-color 0.4s ease;
      width: 0%;
    }

    /* Requirement checklist */
    .req-item { transition: color 0.2s; }
    .req-item.met { color: #059669; }
    .req-item .req-icon-x  { display: inline; }
    .req-item .req-icon-ok { display: none; }
    .req-item.met .req-icon-x  { display: none; }
    .req-item.met .req-icon-ok { display: inline; }
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
               class="h-10 w-auto brightness-0 invert" />
        </a>
      </div>

      <!-- Ilustrasi tengah -->
      <div class="relative z-10 flex flex-col items-center justify-center my-auto py-8 text-center">

        <div class="w-24 h-24 rounded-full bg-emerald-500/10 border border-emerald-500/30
                    flex items-center justify-center mb-6">
          <svg class="w-11 h-11 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
              d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
          </svg>
        </div>

        <h2 class="jakarta text-white text-2xl font-semibold leading-snug mb-3">
          Buat password baru<br/><em class="text-emerald-400">yang lebih kuat.</em>
        </h2>
        <p class="text-gray-500 text-sm max-w-xs leading-relaxed">
          Pilih password yang kuat dan unik. Jangan gunakan password yang sama dengan akun lain.
        </p>

        <!-- Tips keamanan -->
        <div class="mt-8 bg-white/5 border border-white/10 rounded-2xl p-5 text-left w-full max-w-xs">
          <p class="text-gray-400 text-xs font-bold uppercase tracking-widest mb-3">Tips Password Kuat</p>
          <ul class="space-y-2 text-xs text-gray-500">
            <li class="flex items-start gap-2">
              <span class="text-emerald-400 mt-0.5">✓</span>
              Minimal 8 karakter
            </li>
            <li class="flex items-start gap-2">
              <span class="text-emerald-400 mt-0.5">✓</span>
              Kombinasi huruf besar dan kecil
            </li>
            <li class="flex items-start gap-2">
              <span class="text-emerald-400 mt-0.5">✓</span>
              Tambahkan angka atau simbol
            </li>
            <li class="flex items-start gap-2">
              <span class="text-orange-400 mt-0.5">✗</span>
              Jangan gunakan tanggal lahir
            </li>
          </ul>
        </div>
      </div>

      <!-- Bottom copy -->
      <div class="relative z-10">
        <p class="text-gray-600 text-xs">
          Akun Anda dilindungi enkripsi <span class="text-gray-400 font-semibold">bcrypt</span>.
        </p>
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
              d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
          </svg>
        </div>
        <h1 class="text-3xl font-black text-gray-900 tracking-tight mb-2">Buat password baru</h1>
        <p class="text-gray-400 text-sm">
          Masukkan password baru untuk akun
          <span class="text-gray-700 font-semibold">{{ $email }}</span>
        </p>
      </div>

      <!-- Error banner -->
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
            <p class="font-semibold mb-0.5">Gagal mereset password</p>
            <p>{{ $errors->first() }}</p>
          </div>
        </div>
      @endif

      <!-- Form -->
      <form id="reset-form" method="POST" action="{{ route('password.update') }}"
            class="space-y-5 animate-in" style="animation-delay:0.1s">
        @csrf

        <!-- Hidden fields -->
        <input type="hidden" name="token" value="{{ $token }}">
        <input type="hidden" name="email" value="{{ $email }}">

        <!-- Email (read-only, untuk konfirmasi visual) -->
        <div>
          <label class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
            Akun
          </label>
          <div class="flex items-center gap-3 px-4 py-3 bg-gray-50 border border-gray-200
                      rounded-xl text-sm text-gray-600">
            <svg class="w-4 h-4 text-gray-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            <span class="font-medium text-gray-700">{{ $email }}</span>
            <span class="ml-auto text-xs bg-emerald-100 text-emerald-700 px-2 py-0.5 rounded-full font-semibold">
              Terverifikasi
            </span>
          </div>
        </div>

        <!-- Password Baru -->
        <div>
          <label for="password"
                 class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
            Password Baru
          </label>
          <div class="relative">
            <input
              type="password"
              id="password"
              name="password"
              placeholder="Minimal 8 karakter"
              autocomplete="new-password"
              class="input-field pr-11 {{ $errors->has('password') ? 'is-error' : '' }}"
              oninput="handleStrength(this)"
            />
            <button type="button" onclick="togglePw('password', 'eo1', 'ec1')"
              class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600
                     transition-colors duration-200 focus:outline-none">
              <svg id="eo1" class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
              </svg>
              <svg id="ec1" class="w-4.5 h-4.5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
              </svg>
            </button>
          </div>

          <!-- Strength bars -->
          <div id="strength-wrap" class="hidden mt-2 space-y-1.5">
            <div class="flex gap-1">
              <div class="h-1 flex-1 rounded-full bg-gray-100 overflow-hidden">
                <div class="strength-bar" id="sb1"></div>
              </div>
              <div class="h-1 flex-1 rounded-full bg-gray-100 overflow-hidden">
                <div class="strength-bar" id="sb2"></div>
              </div>
              <div class="h-1 flex-1 rounded-full bg-gray-100 overflow-hidden">
                <div class="strength-bar" id="sb3"></div>
              </div>
            </div>
            <p id="strength-lbl" class="text-xs text-gray-400"></p>
          </div>

          <!-- Requirement checklist -->
          <div id="req-wrap" class="hidden mt-3 space-y-1.5">
            <div class="req-item flex items-center gap-2 text-xs text-gray-400" id="req-len">
              <svg class="req-icon-x w-3 h-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
              </svg>
              <svg class="req-icon-ok w-3 h-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
              </svg>
              Minimal 8 karakter
            </div>
            <div class="req-item flex items-center gap-2 text-xs text-gray-400" id="req-case">
              <svg class="req-icon-x w-3 h-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
              </svg>
              <svg class="req-icon-ok w-3 h-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
              </svg>
              Huruf besar &amp; kecil
            </div>
            <div class="req-item flex items-center gap-2 text-xs text-gray-400" id="req-num">
              <svg class="req-icon-x w-3 h-3 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
              </svg>
              <svg class="req-icon-ok w-3 h-3 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>
              </svg>
              Angka atau simbol
            </div>
          </div>

          @error('password')
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

        <!-- Konfirmasi Password -->
        <div>
          <label for="password_confirmation"
                 class="block text-xs font-bold text-gray-500 uppercase tracking-wider mb-1.5">
            Konfirmasi Password
          </label>
          <div class="relative">
            <input
              type="password"
              id="password_confirmation"
              name="password_confirmation"
              placeholder="Ulangi password baru"
              autocomplete="new-password"
              class="input-field pr-11"
              oninput="checkMatch()"
            />
            <button type="button" onclick="togglePw('password_confirmation', 'eo2', 'ec2')"
              class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600
                     transition-colors duration-200 focus:outline-none">
              <svg id="eo2" class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
              </svg>
              <svg id="ec2" class="w-4.5 h-4.5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/>
              </svg>
            </button>
          </div>
          <p id="match-indicator" class="mt-1.5 text-xs hidden"></p>
        </div>

        <!-- Submit -->
        <button type="submit" id="submit-btn"
          class="btn-submit w-full py-3.5 bg-gray-900 text-white text-sm font-bold rounded-xl
                 hover:bg-emerald-600 active:scale-[0.98] transition-all duration-200">
          <span class="btn-text flex items-center justify-center gap-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>
            </svg>
            Simpan Password Baru
          </span>
          <span class="btn-spinner">
            <div class="spinner-ring"></div>
          </span>
        </button>

      </form>

    </div>
  </div>

  <script>
    // Toggle show/hide password
    function togglePw(fieldId, openId, closedId) {
      const input = document.getElementById(fieldId);
      const isText = input.type === 'text';
      input.type = isText ? 'password' : 'text';
      document.getElementById(openId).classList.toggle('hidden', !isText);
      document.getElementById(closedId).classList.toggle('hidden', isText);
    }

    // Strength meter + requirement checklist
    const strengthColors = ['#f87171', '#fb923c', '#10b981'];
    const strengthLabels = ['Lemah', 'Sedang', 'Kuat'];

    function handleStrength(input) {
      const val = input.value;
      const wrap    = document.getElementById('strength-wrap');
      const reqWrap = document.getElementById('req-wrap');
      const lbl     = document.getElementById('strength-lbl');
      const bars    = ['sb1', 'sb2', 'sb3'].map(id => document.getElementById(id));

      if (!val) {
        wrap.classList.add('hidden');
        reqWrap.classList.add('hidden');
        return;
      }
      wrap.classList.remove('hidden');
      reqWrap.classList.remove('hidden');
      input.classList.remove('is-error');

      // Hitung score
      let score = 0;
      if (val.length >= 8) score++;
      if (/[A-Z]/.test(val) && /[a-z]/.test(val)) score++;
      if (/[0-9]/.test(val) || /[^A-Za-z0-9]/.test(val)) score++;

      const color = strengthColors[score - 1] || strengthColors[0];
      bars.forEach((bar, i) => {
        bar.style.width      = i < score ? '100%' : '0%';
        bar.style.background = color;
      });
      lbl.textContent = 'Kekuatan: ' + (strengthLabels[score - 1] || 'Lemah');
      lbl.style.color = color;

      // Requirement checklist
      document.getElementById('req-len').classList.toggle('met', val.length >= 8);
      document.getElementById('req-case').classList.toggle('met', /[A-Z]/.test(val) && /[a-z]/.test(val));
      document.getElementById('req-num').classList.toggle('met', /[0-9]/.test(val) || /[^A-Za-z0-9]/.test(val));

      checkMatch();
    }

    // Match indicator
    function checkMatch() {
      const a   = document.getElementById('password').value;
      const b   = document.getElementById('password_confirmation').value;
      const el  = document.getElementById('match-indicator');
      const inp = document.getElementById('password_confirmation');
      if (!b) { el.classList.add('hidden'); return; }
      el.classList.remove('hidden');
      if (a === b) {
        el.textContent = '✓ Password cocok';
        el.className   = 'mt-1.5 text-xs text-emerald-500';
        inp.classList.add('is-success');
        inp.classList.remove('is-error');
      } else {
        el.textContent = '✗ Password tidak cocok';
        el.className   = 'mt-1.5 text-xs text-red-500';
        inp.classList.add('is-error');
        inp.classList.remove('is-success');
      }
    }

    // Form submit
    document.getElementById('reset-form').addEventListener('submit', function (e) {
      const pw  = document.getElementById('password');
      const pwc = document.getElementById('password_confirmation');
      let hasError = false;

      if (!pw.value.trim()) {
        pw.classList.add('is-error', 'shake');
        setTimeout(() => pw.classList.remove('shake'), 500);
        hasError = true;
      }
      if (!pwc.value.trim() || pw.value !== pwc.value) {
        pwc.classList.add('is-error', 'shake');
        setTimeout(() => pwc.classList.remove('shake'), 500);
        hasError = true;
      }

      if (hasError) { e.preventDefault(); return; }

      const btn = document.getElementById('submit-btn');
      btn.classList.add('loading');
      btn.disabled = true;
    });
  </script>

</body>
</html>