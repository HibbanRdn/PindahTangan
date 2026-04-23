<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Verifikasi Email — PindahTangan</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,700&display=swap');
    body { font-family: 'DM Sans', sans-serif; }
    .serif { font-family: 'Instrument Serif', serif; }

    @keyframes pulseRing {
      0%   { transform: scale(1);   opacity: 0.6; }
      100% { transform: scale(1.6); opacity: 0; }
    }
    .pulse-ring {
      animation: pulseRing 2s cubic-bezier(0.22,1,0.36,1) infinite;
    }
    .pulse-ring-delay {
      animation: pulseRing 2s cubic-bezier(0.22,1,0.36,1) infinite 0.6s;
    }

    @keyframes fadeUp {
      from { opacity: 0; transform: translateY(16px); }
      to   { opacity: 1; transform: translateY(0); }
    }
    .fade-up { animation: fadeUp 0.5s cubic-bezier(0.22,1,0.36,1) both; }
  </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col">

  <!-- Navbar minimal -->
  <nav class="bg-white border-b border-gray-100 px-6 h-14 flex items-center justify-between">
    <a href="/">
      <span class="font-black text-gray-900 tracking-tight">Pindah<span class="text-indigo-500">Tangan</span></span>
    </a>
    <form method="POST" action="{{ route('logout') }}">
      @csrf
      <button type="submit" class="text-xs text-gray-400 hover:text-gray-700 transition-colors">Keluar</button>
    </form>
  </nav>

  <!-- Main content -->
  <main class="flex-1 flex items-center justify-center px-6 py-16">
    <div class="max-w-md w-full text-center">

      <!-- Animated email icon -->
      <div class="relative inline-flex items-center justify-center mb-8 fade-up" style="animation-delay:0.05s">
        <div class="pulse-ring absolute w-20 h-20 rounded-full bg-indigo-100"></div>
        <div class="pulse-ring-delay absolute w-20 h-20 rounded-full bg-indigo-100"></div>
        <div class="relative w-20 h-20 rounded-full bg-indigo-600 flex items-center justify-center shadow-xl shadow-indigo-200 z-10">
          <svg class="w-9 h-9 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
              d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
          </svg>
        </div>
      </div>

      <!-- Headline -->
      <h1 class="text-3xl font-black text-gray-900 tracking-tight mb-3 fade-up serif" style="animation-delay:0.1s">
        Satu langkah lagi!
      </h1>
      <p class="text-gray-500 text-base leading-relaxed mb-2 fade-up" style="animation-delay:0.15s">
        Kami telah mengirim link verifikasi ke:
      </p>
      <p class="text-gray-900 font-bold text-base mb-8 fade-up" style="animation-delay:0.2s">
        {{ auth()->user()->email }}
      </p>

      <!-- Steps -->
      <div class="text-left bg-white border border-gray-100 rounded-2xl p-6 mb-8 fade-up space-y-4" style="animation-delay:0.25s">
        <div class="flex gap-4 items-start">
          <div class="w-7 h-7 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-black shrink-0 mt-0.5">1</div>
          <p class="text-sm text-gray-600 leading-relaxed">Buka <span class="font-semibold text-gray-900">inbox atau folder Spam</span> email Anda.</p>
        </div>
        <div class="flex gap-4 items-start">
          <div class="w-7 h-7 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-black shrink-0 mt-0.5">2</div>
          <p class="text-sm text-gray-600 leading-relaxed">Cari email dari <span class="font-semibold text-gray-900">PindahTangan</span> dengan subjek "Verify Email Address".</p>
        </div>
        <div class="flex gap-4 items-start">
          <div class="w-7 h-7 rounded-full bg-indigo-100 text-indigo-600 flex items-center justify-center text-xs font-black shrink-0 mt-0.5">3</div>
          <p class="text-sm text-gray-600 leading-relaxed">Klik tombol <span class="font-semibold text-gray-900">"Verify Email Address"</span> di dalam email tersebut.</p>
        </div>
      </div>

      <!-- Status: resend berhasil -->
      @if (session('status') === 'verification-link-sent')
        <div class="mb-6 p-4 bg-green-50 border border-green-100 rounded-xl text-sm text-green-700 fade-up flex items-center gap-2.5">
          <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
          </svg>
          Email verifikasi baru telah dikirim. Silakan cek inbox Anda.
        </div>
      @endif

      <!-- Resend button -->
      <form method="POST" action="{{ route('verification.send') }}" class="fade-up" style="animation-delay:0.3s">
        @csrf
        <button type="submit"
          class="w-full py-3.5 bg-gray-900 text-white text-sm font-bold rounded-xl hover:bg-indigo-600 active:scale-[0.98] transition-all duration-200 mb-4">
          Kirim Ulang Email Verifikasi
        </button>
      </form>

      <p class="text-xs text-gray-400 fade-up" style="animation-delay:0.35s">
        Email yang salah?
        <form method="POST" action="{{ route('logout') }}" class="inline">
          @csrf
          <button type="submit" class="text-indigo-600 font-semibold hover:underline">
            Keluar dan daftar ulang
          </button>
        </form>
      </p>

    </div>
  </main>

</body>
</html>