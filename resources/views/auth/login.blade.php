<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Masuk — PindahTangan</title>
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

    @keyframes fadeSlideUp {
      from { opacity: 0; transform: translateY(20px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    .animate-in {
      animation: fadeSlideUp 0.5s cubic-bezier(0.22, 1, 0.36, 1) both;
    }
  </style>
</head>
<body class="bg-gray-50 min-h-screen">

  <div class="min-h-screen grid grid-cols-1 lg:grid-cols-2">

    <!-- ── Panel Kiri — Visual ───────────────────────────────────── -->
    <div class="hidden lg:flex flex-col justify-between bg-gray-900 p-12 relative overflow-hidden">

      <div class="absolute inset-0 opacity-5"
           style="background-image: radial-gradient(circle, #fff 1px, transparent 1px); background-size: 24px 24px;"></div>
      <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-indigo-600 rounded-full blur-[120px] opacity-20"></div>
      <div class="absolute top-20 -left-20 w-72 h-72 bg-purple-600 rounded-full blur-[100px] opacity-10"></div>

      <!-- Logo -->
      <div class="relative z-10">
        <a href="/">
          <span class="text-white font-black text-xl tracking-tight">Pindah<span class="text-indigo-400">Tangan</span></span>
        </a>
      </div>

      <!-- Testimonial quote kartu -->
      <div class="relative z-10 space-y-4 my-auto py-8">

        <div class="bg-white/5 border border-white/10 rounded-2xl p-6 backdrop-blur-sm">
          <div class="flex gap-1 mb-3">
            @for ($i = 0; $i < 5; $i++)
              <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
              </svg>
            @endfor
          </div>
          <p class="text-gray-300 text-sm leading-relaxed italic serif">
            "Barangnya persis seperti foto, kondisi sangat bagus. Pengiriman cepat dan packing rapi. Pasti repeat order!"
          </p>
          <div class="flex items-center gap-3 mt-4">
            <div class="w-8 h-8 rounded-full bg-indigo-500 flex items-center justify-center text-white text-xs font-bold">A</div>
            <div>
              <p class="text-white text-sm font-semibold">Anisa R.</p>
              <p class="text-gray-500 text-xs">Pembeli terverifikasi</p>
            </div>
          </div>
        </div>

        <div class="bg-indigo-600/20 border border-indigo-500/30 rounded-2xl p-6">
          <div class="flex gap-1 mb-3">
            @for ($i = 0; $i < 5; $i++)
              <svg class="w-4 h-4 text-yellow-400" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
              </svg>
            @endfor
          </div>
          <p class="text-gray-300 text-sm leading-relaxed italic serif">
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

      </div>

      <!-- Copy -->
      <div class="relative z-10">
        <h2 class="serif text-white text-3xl leading-snug">
          Selamat datang<br/>kembali. <em>Kami rindu.</em>
        </h2>
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
      <div class="mb-8 animate-in" style="animation-delay: 0.05s;">
        <h1 class="text-3xl font-black text-gray-900 tracking-tight mb-1">Masuk ke akun Anda</h1>
        <p class="text-gray-400 text-sm">Belum punya akun?
          <a href="{{ route('register') }}" class="text-indigo-600 font-semibold hover:underline">Daftar gratis</a>
        </p>
      </div>

      <!-- Status / info messages -->
      @if (session('status'))
        <div class="mb-6 p-4 bg-green-50 border border-green-100 rounded-xl text-sm text-green-700 animate-in">
          {{ session('status') }}
        </div>
      @endif

      <!-- Error: email belum diverifikasi -->
      @if ($errors->has('email') && str_contains($errors->first('email'), 'belum')  )
        <div class="mb-6 p-4 bg-amber-50 border border-amber-100 rounded-xl text-sm text-amber-700 animate-in">
          <p class="font-semibold mb-1">Email belum diverifikasi</p>
          <p>Silakan cek inbox email Anda dan klik link verifikasi.</p>
          <form method="POST" action="{{ route('verification.send') }}" class="mt-2 inline">
            @csrf
            <button type="submit" class="text-amber-700 underline underline-offset-2 font-semibold text-xs hover:text-amber-900">
              Kirim ulang email verifikasi
            </button>
          </form>
        </div>
      @endif

      <!-- Form -->
      <form method="POST" action="{{ route('login') }}" class="space-y-5 animate-in" style="animation-delay: 0.1s;">
        @csrf

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
            autofocus
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
          <div class="flex justify-between items-center mb-1.5">
            <label for="password" class="block text-xs font-bold text-gray-500 uppercase tracking-wider">
              Password
            </label>
            {{-- Link lupa password bisa ditambahkan di sini nanti --}}
          </div>
          <div class="relative">
            <input
              type="password"
              id="password"
              name="password"
              placeholder="Password Anda"
              autocomplete="current-password"
              class="input-field pr-11 {{ $errors->has('password') ? 'is-error' : '' }}"
            />
            <button type="button" onclick="togglePassword('password', this)"
              class="absolute right-3 top-1/2 -translate-y-1/2 text-gray-400 hover:text-gray-600 transition-colors">
              <svg class="w-4.5 h-4.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
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
            class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 focus:ring-offset-0 cursor-pointer"
          />
          <label for="remember" class="text-sm text-gray-500 cursor-pointer select-none">
            Ingat saya di perangkat ini
          </label>
        </div>

        <!-- Submit -->
        <button type="submit"
          class="w-full py-3.5 bg-gray-900 text-white text-sm font-bold rounded-xl hover:bg-indigo-600 active:scale-[0.98] transition-all duration-200">
          Masuk
        </button>

      </form>

      <!-- Info akun testing (tampilkan hanya di development) -->
      @if (app()->isLocal())
        <details class="mt-8 text-xs text-gray-400 border border-dashed border-gray-200 rounded-xl p-4">
          <summary class="cursor-pointer font-semibold text-gray-500 select-none">Akun Testing (dev only)</summary>
          <div class="mt-3 space-y-2">
            <div class="bg-gray-50 rounded-lg p-3">
              <p class="font-bold text-gray-600 mb-1">Admin</p>
              <p>admin@pindahtangan.test / password</p>
            </div>
            <div class="bg-gray-50 rounded-lg p-3">
              <p class="font-bold text-gray-600 mb-1">User (verified)</p>
              <p>budi@example.test / password</p>
            </div>
            <div class="bg-gray-50 rounded-lg p-3">
              <p class="font-bold text-gray-600 mb-1">User (unverified)</p>
              <p>siti@example.test / password</p>
            </div>
          </div>
        </details>
      @endif

    </div>
  </div>

  <script>
    function togglePassword(fieldId, btn) {
      const input = document.getElementById(fieldId);
      const isText = input.type === 'text';
      input.type = isText ? 'password' : 'text';
      btn.querySelector('svg').style.opacity = isText ? '1' : '0.4';
    }
  </script>

</body>
</html>