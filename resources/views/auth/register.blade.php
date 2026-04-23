<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Daftar — PindahTangan</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,700&display=swap');

    body { font-family: 'DM Sans', sans-serif; }
    .serif { font-family: 'Instrument Serif', serif; }

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
      border-color: #6366f1;
      box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
    }
    .input-field.is-error {
      border-color: #ef4444;
      box-shadow: 0 0 0 3px rgba(239,68,68,0.08);
    }

    /* Password strength bar */
    .strength-bar { height: 3px; border-radius: 99px; transition: width 0.4s ease, background 0.4s ease; }

    /* Panel kiri — mosaik barang preloved */
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
  </style>
</head>
<body class="bg-gray-50 min-h-screen">

  <div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">

    <!-- ── Panel Kiri — Visual ───────────────────────────────────── -->
    <div class="hidden lg:flex flex-col justify-between bg-gray-900 p-12 relative overflow-hidden">

      <!-- Background texture -->
      <div class="absolute inset-0 opacity-5"
           style="background-image: radial-gradient(circle, #fff 1px, transparent 1px); background-size: 24px 24px;"></div>
      <div class="absolute -bottom-32 -left-32 w-96 h-96 bg-indigo-600 rounded-full blur-[120px] opacity-20"></div>
      <div class="absolute -top-16 -right-16 w-72 h-72 bg-purple-600 rounded-full blur-[100px] opacity-15"></div>

      <!-- Logo -->
      <div class="relative z-10">
        <a href="/" class="inline-block">
          <span class="text-white font-black text-xl tracking-tight">Pindah<span class="text-indigo-400">Tangan</span></span>
        </a>
      </div>

      <!-- Mosaic grid foto produk -->
      <div class="relative z-10 grid grid-cols-3 gap-3 my-auto py-8">
        <div class="mosaic-item col-span-2 h-48 rounded-2xl overflow-hidden">
          <img src="https://picsum.photos/seed/cloth1/500/400" class="w-full h-full object-cover" alt="" referrerpolicy="no-referrer"/>
        </div>
        <div class="mosaic-item h-48 rounded-2xl overflow-hidden" style="animation-delay:0.8s">
          <img src="https://picsum.photos/seed/bag2/300/400" class="w-full h-full object-cover" alt="" referrerpolicy="no-referrer"/>
        </div>
        <div class="mosaic-item h-32 rounded-2xl overflow-hidden" style="animation-delay:1.4s">
          <img src="https://picsum.photos/seed/shoe3/300/300" class="w-full h-full object-cover" alt="" referrerpolicy="no-referrer"/>
        </div>
        <div class="mosaic-item col-span-2 h-32 rounded-2xl overflow-hidden" style="animation-delay:0.3s">
          <img src="https://picsum.photos/seed/book4/500/300" class="w-full h-full object-cover" alt="" referrerpolicy="no-referrer"/>
        </div>
      </div>

      <!-- Copy -->
      <div class="relative z-10">
        <p class="text-gray-400 text-xs font-bold tracking-widest uppercase mb-3">Bergabung dengan komunitas</p>
        <h2 class="serif text-white text-4xl leading-snug mb-4">
          Barang bagus<br/>menunggu<br/><em>pemilik baru.</em>
        </h2>
        <p class="text-gray-500 text-sm leading-relaxed max-w-xs">
          Daftar sekarang dan temukan ribuan barang preloved berkualitas dengan harga terbaik.
        </p>
      </div>

    </div>

    <!-- ── Panel Kanan — Form ────────────────────────────────────── -->
    <div class="flex flex-col justify-center px-6 py-12 lg:px-16 xl:px-24 bg-white">

      <!-- Back link -->
      <a href="/" class="inline-flex items-center gap-1.5 text-xs text-gray-400 hover:text-gray-700 transition-colors mb-10 self-start">
        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
        </svg>
        Kembali ke beranda
      </a>

      <!-- Header -->
      <div class="mb-8">
        <h1 class="text-3xl font-black text-gray-900 tracking-tight mb-1">Buat akun baru</h1>
        <p class="text-gray-400 text-sm">Sudah punya akun?
          <a href="{{ route('login') }}" class="text-indigo-600 font-semibold hover:underline">Masuk di sini</a>
        </p>
      </div>

      <!-- Status message (jika ada) -->
      @if (session('status'))
        <div class="mb-6 p-4 bg-green-50 border border-green-100 rounded-xl text-sm text-green-700">
          {{ session('status') }}
        </div>
      @endif

      <!-- Form -->
      <form method="POST" action="{{ route('register') }}" class="space-y-5" id="register-form">
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
          <input
            type="email"
            id="email"
            name="email"
            value="{{ old('email') }}"
            placeholder="email@contoh.com"
            autocomplete="email"
            class="input-field {{ $errors->has('email') ? 'is-error' : '' }}"
          />
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
            />
            <button type="button" onclick="togglePassword('password', this)"
              class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
              <svg class="w-4.5 h-4.5 eye-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
              </svg>
            </button>
          </div>
          <!-- Password strength indicator -->
          <div class="mt-2 space-y-1" id="strength-container" style="display:none;">
            <div class="flex gap-1">
              <div class="h-1 flex-1 rounded-full bg-gray-100 overflow-hidden">
                <div class="strength-bar bg-red-400" id="bar1" style="width:0%"></div>
              </div>
              <div class="h-1 flex-1 rounded-full bg-gray-100 overflow-hidden">
                <div class="strength-bar bg-orange-400" id="bar2" style="width:0%"></div>
              </div>
              <div class="h-1 flex-1 rounded-full bg-gray-100 overflow-hidden">
                <div class="strength-bar bg-green-400" id="bar3" style="width:0%"></div>
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
            />
            <button type="button" onclick="togglePassword('password_confirmation', this)"
              class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
              <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
              </svg>
            </button>
          </div>
          <!-- Match indicator -->
          <p class="mt-1.5 text-xs hidden" id="match-indicator"></p>
        </div>

        <!-- Submit -->
        <button type="submit"
          class="w-full py-3.5 bg-gray-900 text-white text-sm font-bold rounded-xl hover:bg-indigo-600 active:scale-[0.98] transition-all duration-200 mt-2">
          Buat Akun
        </button>

      </form>

      <!-- Divider -->
      <div class="flex items-center gap-3 my-6">
        <div class="flex-1 h-px bg-gray-100"></div>
        <span class="text-xs text-gray-400">atau</span>
        <div class="flex-1 h-px bg-gray-100"></div>
      </div>

      <p class="text-center text-xs text-gray-400 leading-relaxed">
        Dengan mendaftar, Anda menyetujui
        <a href="#" class="text-gray-600 underline underline-offset-2 hover:text-indigo-600">Syarat & Ketentuan</a>
        dan
        <a href="#" class="text-gray-600 underline underline-offset-2 hover:text-indigo-600">Kebijakan Privasi</a>
        kami.
      </p>

    </div>
  </div>

  <script>
    // Toggle show/hide password
    function togglePassword(fieldId, btn) {
      const input = document.getElementById(fieldId);
      const isText = input.type === 'text';
      input.type = isText ? 'password' : 'text';
      btn.querySelector('svg').style.opacity = isText ? '1' : '0.4';
    }

    // Password strength meter
    const pwInput     = document.getElementById('password');
    const pwConfirm   = document.getElementById('password_confirmation');
    const strengthBox = document.getElementById('strength-container');
    const strengthLbl = document.getElementById('strength-label');
    const bars        = [document.getElementById('bar1'), document.getElementById('bar2'), document.getElementById('bar3')];
    const matchEl     = document.getElementById('match-indicator');

    pwInput.addEventListener('input', () => {
      const val = pwInput.value;
      if (!val) { strengthBox.style.display = 'none'; return; }
      strengthBox.style.display = 'block';

      let score = 0;
      if (val.length >= 8) score++;
      if (/[A-Z]/.test(val) && /[a-z]/.test(val)) score++;
      if (/[0-9]/.test(val) || /[^A-Za-z0-9]/.test(val)) score++;

      const labels = ['Lemah', 'Sedang', 'Kuat'];
      const colors = ['#f87171', '#fb923c', '#4ade80'];

      bars.forEach((bar, i) => {
        bar.style.width  = i < score ? '100%' : '0%';
        bar.style.background = colors[score - 1] || '#f87171';
      });
      strengthLbl.textContent = 'Kekuatan password: ' + (labels[score - 1] || 'Lemah');
      strengthLbl.style.color = colors[score - 1] || '#f87171';

      checkMatch();
    });

    pwConfirm.addEventListener('input', checkMatch);

    function checkMatch() {
      const a = pwInput.value;
      const b = pwConfirm.value;
      if (!b) { matchEl.classList.add('hidden'); return; }
      matchEl.classList.remove('hidden');
      if (a === b) {
        matchEl.textContent = '✓ Password cocok';
        matchEl.className = 'mt-1.5 text-xs text-green-500';
      } else {
        matchEl.textContent = '✗ Password tidak cocok';
        matchEl.className = 'mt-1.5 text-xs text-red-500';
      }
    }
  </script>

</body>
</html>