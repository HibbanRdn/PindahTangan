<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PindahTangan - Preloved Berkualitas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
      /* ── Parallax & Scroll Styles ── */

      /* Card fan: mulai tumpuk di tengah, mekar saat masuk viewport */
      .fan-card {
        transition: transform 0.9s cubic-bezier(0.34, 1.56, 0.64, 1), box-shadow 0.5s ease;
        transform: rotate(0deg) translateX(0) translateY(0) scale(0.85);
        will-change: transform;
      }
      .fan-card.bloomed {
        /* Setiap card dapat var custom dari inline style */
        transform: var(--bloom-transform) scale(1);
      }
      .fan-card:hover {
        transform: var(--bloom-transform) scale(1.08) translateY(-12px) !important;
        box-shadow: 0 40px 80px rgba(0,0,0,0.25) !important;
        z-index: 50 !important;
      }

      /* Parallax layer — bergerak beda kecepatan scroll */
      .parallax-slow  { will-change: transform; }
      .parallax-med   { will-change: transform; }
      .parallax-fast  { will-change: transform; }

      /* Text split-reveal */
      .split-reveal {
        overflow: hidden;
        display: block;
      }
      .split-reveal .word {
        display: inline-block;
        opacity: 0;
        transform: translateY(100%);
        transition: opacity 0.6s ease, transform 0.6s cubic-bezier(0.22,1,0.36,1);
      }
      .split-reveal.revealed .word {
        opacity: 1;
        transform: translateY(0);
      }

      /* Magnetic button */
      .magnetic {
        transition: transform 0.3s cubic-bezier(0.34,1.56,0.64,1);
      }

      /* Marquee ticker */
      .ticker-wrapper { display: flex; white-space: nowrap; overflow: hidden; }
      .ticker-track   { display: inline-flex; gap: 3rem; padding-right: 3rem; }

      /* Slide-in dari kiri/kanan */
      .slide-left  { opacity: 0; transform: translateX(-60px); transition: opacity 0.8s ease, transform 0.8s cubic-bezier(0.22,1,0.36,1); }
      .slide-right { opacity: 0; transform: translateX( 60px); transition: opacity 0.8s ease, transform 0.8s cubic-bezier(0.22,1,0.36,1); }
      .slide-left.in, .slide-right.in { opacity: 1; transform: translateX(0); }

      /* Scale-in untuk stat cards */
      .scale-in { opacity: 0; transform: scale(0.88); transition: opacity 0.6s ease, transform 0.6s cubic-bezier(0.34,1.56,0.64,1); }
      .scale-in.in { opacity: 1; transform: scale(1); }

      /* Scroll-driven garis progress di navbar */
      #read-progress {
        position: fixed; top: 0; left: 0; height: 2px; z-index: 100;
        background: linear-gradient(90deg, #6366f1, #a855f7);
        width: 0%; transition: width 0.1s linear;
      }

      @keyframes slideDot {
        0%   { left: 0%;  opacity: 0; transform: translateY(-50%) scale(0.8); }
        5%   { opacity: 1; transform: translateY(-50%) scale(1); }
        90%  { left: 96%; opacity: 1; }
        100% { left: 98%; opacity: 0; }
      }

      /* Float badges hero */
      @keyframes floatBubble {
        0%, 100% { transform: translateY(0px); }
        50%       { transform: translateY(-8px); }
      }
      .float-bubble { animation: floatBubble 3s ease-in-out infinite; }
      .float-bubble-delay { animation: floatBubble 3s ease-in-out infinite 1.5s; }
    </style>
  </head>
  <body class="bg-white text-gray-900 font-sans antialiased overflow-x-hidden">

    <!-- Scroll progress bar -->
    <div id="read-progress"></div>

    <!-- ══════════════════════════════════════════
         NAVBAR
    ══════════════════════════════════════════ -->
    <nav id="navbar" class="fixed top-0 w-full z-50 bg-white/80 backdrop-blur-md transition-all duration-300">
      <div class="max-w-7xl mx-auto px-6 h-16 flex items-center justify-between relative">

        <a href="/" class="shrink-0 z-10">
          <img src="{{ asset('images/logo_pindahtangan.png') }}" alt="PindahTangan" class="h-35 w-auto" />
        </a>

        <div class="hidden md:flex items-center gap-8 text-sm font-medium text-gray-500 absolute left-1/2 -translate-x-1/2">
          <a href="#katalog"    class="hover:text-gray-900 transition-colors">Katalog</a>
          <a href="#cara-kerja" class="hover:text-gray-900 transition-colors">Cara Kerja</a>
          <a href="#keunggulan" class="hover:text-gray-900 transition-colors">Keunggulan</a>
        </div>

        <div class="flex items-center gap-3 z-10">
          @auth
            <a href="{{ route('produk.index') }}" class="hidden md:inline-flex text-sm font-medium text-gray-600 hover:text-gray-900 transition-colors">Katalog</a>
            <form method="POST" action="{{ route('logout') }}" class="hidden md:inline">
              @csrf
              <button type="submit" title="Keluar"
                class="w-9 h-9 rounded-full bg-white/70 border border-gray-200 flex items-center justify-center text-gray-600 hover:text-gray-900 hover:bg-white transition-all">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
              </button>
            </form>
          @else
            <a href="{{ route('login') }}" title="Masuk"
               class="w-9 h-9 rounded-full bg-white/70 border border-gray-200 flex items-center justify-center text-gray-600 hover:text-gray-900 hover:bg-white transition-all">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
              </svg>
            </a>
          @endauth

          <a href="{{ route('produk.index') }}"
             class="magnetic inline-flex items-center justify-center px-5 py-2 text-sm font-semibold text-white bg-gray-900 rounded-full hover:bg-indigo-600 transition-all duration-300 shadow-sm">
            Mulai Belanja
          </a>
        </div>
      </div>
    </nav>


    <!-- ══════════════════════════════════════════
         HERO SECTION
    ══════════════════════════════════════════ -->
    <section id="hero" class="relative min-h-screen flex flex-col items-center justify-start pt-32 pb-32 px-6 overflow-hidden">

      <!-- Parallax background blob -->
      <div class="parallax-slow absolute -top-32 left-1/2 -translate-x-1/2 w-[800px] h-[800px] bg-indigo-50 rounded-full blur-3xl opacity-60 pointer-events-none"></div>

      <!-- Headline — split word reveal -->
      <div class="text-center relative z-10 mb-2">
        <h1 id="hero-headline" class="text-6xl md:text-8xl lg:text-[7rem] font-black tracking-tighter text-gray-900 leading-[0.9] max-w-5xl mx-auto">
          <span class="split-reveal"><span class="word">Tempat</span> <span class="word" style="transition-delay:0.08s">terbaik</span></span>
          <span class="split-reveal block"><span class="word" style="transition-delay:0.16s">untuk</span> <span class="word text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600" style="transition-delay:0.24s">preloved.</span></span>
        </h1>
      </div>

      <!-- Subtext + CTA -->
      <div class="reveal opacity-0 translate-y-6 duration-700 delay-500 ease-out text-center mt-8 relative z-10 max-w-xl mx-auto">
        <p class="text-gray-500 text-base md:text-lg leading-relaxed mb-8">
          Barang berkualitas yang siap berpindah tangan. Kondisi transparan, harga lebih hemat, pengiriman ke seluruh Indonesia.
        </p>
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
          <a href="#katalog"
             class="magnetic inline-flex items-center justify-center px-8 py-3.5 text-sm font-bold text-white bg-gray-900 rounded-full hover:bg-indigo-600 shadow-lg hover:shadow-xl transition-all duration-300">
            Belanja Sekarang
          </a>
          <a href="#cara-kerja"
             class="magnetic inline-flex items-center justify-center px-8 py-3.5 text-sm font-bold text-gray-700 bg-white border border-gray-200 rounded-full hover:bg-gray-50 transition-all duration-300">
            Lihat Cara Kerja
          </a>
        </div>
      </div>

      <!-- ── Card Fan — mekar saat masuk viewport ── -->
      <div id="card-fan" class="relative w-full mt-20 flex justify-center items-end" style="height:300px;">

        <!-- Speech bubbles (float animation) -->
        <div class="float-bubble absolute z-40 reveal opacity-0 duration-500 delay-700"
             style="left:calc(50% - 290px); top:10px;">
          <div class="relative bg-indigo-500 text-white px-4 py-2 rounded-2xl text-xs font-bold shadow-md">
            @preloved
            <div class="absolute w-3 h-3 bg-indigo-500 rotate-45 rounded-sm" style="bottom:-4px;left:14px;"></div>
          </div>
        </div>

        <div class="float-bubble-delay absolute z-40 reveal opacity-0 duration-500 delay-700"
             style="right:calc(50% - 290px); top:10px;">
          <div class="relative bg-emerald-500 text-white px-4 py-2 rounded-2xl text-xs font-bold shadow-md">
            @verified
            <div class="absolute w-3 h-3 bg-emerald-500 rotate-45 rounded-sm" style="bottom:-4px;right:14px;"></div>
          </div>
        </div>

        <!-- Card 1 -->
        <div class="fan-card absolute rounded-2xl overflow-hidden shadow-2xl cursor-pointer"
             style="width:160px;height:220px;z-index:10;
                    --bloom-transform: rotate(-18deg) translateX(-310px) translateY(30px);">
          <img src="https://picsum.photos/seed/jacket/400/600" alt="Jacket" class="w-full h-full object-cover" referrerpolicy="no-referrer"/>
          <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
          <div class="absolute bottom-2 left-2 bg-white/90 text-[10px] font-bold px-2 py-0.5 rounded-full">Jacket</div>
        </div>

        <!-- Card 2 -->
        <div class="fan-card absolute rounded-2xl overflow-hidden shadow-2xl cursor-pointer"
             style="width:160px;height:220px;z-index:20;
                    --bloom-transform: rotate(-9deg) translateX(-165px) translateY(10px);">
          <img src="https://picsum.photos/seed/camera/400/600" alt="Kamera" class="w-full h-full object-cover" referrerpolicy="no-referrer"/>
          <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
          <div class="absolute bottom-2 left-2 bg-white/90 text-[10px] font-bold px-2 py-0.5 rounded-full">Kamera</div>
        </div>

        <!-- Card 3 (center) -->
        <div class="fan-card absolute rounded-2xl overflow-hidden cursor-pointer border-2 border-white"
             style="width:185px;height:255px;z-index:30;
                    box-shadow:0 30px 70px rgba(0,0,0,0.22);
                    --bloom-transform: rotate(-2deg);">
          <img src="https://picsum.photos/seed/watch/400/600" alt="Watch" class="w-full h-full object-cover" referrerpolicy="no-referrer"/>
          <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent"></div>
          <div class="absolute top-3 right-3 bg-indigo-600 text-white text-[10px] font-bold px-2 py-0.5 rounded-full">Kondisi 95%</div>
          <div class="absolute bottom-3 left-3">
            <p class="text-white font-bold text-sm">Vintage Watch</p>
            <p class="text-white/80 text-xs">Rp 1.250.000</p>
          </div>
        </div>

        <!-- Card 4 -->
        <div class="fan-card absolute rounded-2xl overflow-hidden shadow-2xl cursor-pointer"
             style="width:160px;height:220px;z-index:20;
                    --bloom-transform: rotate(9deg) translateX(165px) translateY(10px);">
          <img src="https://picsum.photos/seed/bag/400/600" alt="Tote Bag" class="w-full h-full object-cover" referrerpolicy="no-referrer"/>
          <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
          <div class="absolute bottom-2 left-2 bg-white/90 text-[10px] font-bold px-2 py-0.5 rounded-full">Tote Bag</div>
        </div>

        <!-- Card 5 -->
        <div class="fan-card absolute rounded-2xl overflow-hidden shadow-2xl cursor-pointer"
             style="width:160px;height:220px;z-index:10;
                    --bloom-transform: rotate(18deg) translateX(310px) translateY(30px);">
          <img src="https://picsum.photos/seed/shoes/400/600" alt="Sneakers" class="w-full h-full object-cover" referrerpolicy="no-referrer"/>
          <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
          <div class="absolute bottom-2 left-2 bg-white/90 text-[10px] font-bold px-2 py-0.5 rounded-full">Sneakers</div>
        </div>

      </div>
    </section>


    <!-- ══════════════════════════════════════════
         VALUE PROPOSITION
    ══════════════════════════════════════════ -->
    <section id="keunggulan" class="py-28 bg-white">
      <div class="max-w-7xl mx-auto px-6">

        <div class="flex flex-col md:flex-row md:items-end justify-between mb-14">
          <h2 class="split-reveal text-4xl md:text-6xl font-black tracking-tighter text-gray-900 leading-tight">
            <span class="word">Mengapa</span><br/><span class="word" style="transition-delay:0.1s">PindahTangan?</span>
          </h2>
          <p class="slide-right text-gray-500 text-base mt-4 md:mt-0 max-w-xs">
            Kami mendefinisikan ulang cara Anda membeli barang preloved.
          </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">

          <div class="scale-in" style="transition-delay:0.05s">
            <div class="bg-white border border-gray-100 rounded-3xl p-8 h-full hover:-translate-y-2 hover:shadow-xl hover:border-indigo-100 transition-all duration-300 group">
              <div class="w-10 h-10 bg-indigo-100 text-indigo-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-indigo-600 group-hover:text-white transition-colors duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
              </div>
              <h3 class="text-lg font-black text-gray-900 mb-2 tracking-tight">Barang Berkualitas</h3>
              <p class="text-gray-400 text-sm leading-relaxed">Kurasi ketat agar setiap item tetap layak pakai dan bernilai.</p>
            </div>
          </div>

          <div class="scale-in" style="transition-delay:0.15s">
            <div class="bg-white border border-gray-100 rounded-3xl p-8 h-full hover:-translate-y-2 hover:shadow-xl hover:border-orange-100 transition-all duration-300 group">
              <div class="w-10 h-10 bg-orange-100 text-orange-500 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-orange-500 group-hover:text-white transition-colors duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
              </div>
              <h3 class="text-lg font-black text-gray-900 mb-2 tracking-tight">Kondisi Jelas</h3>
              <p class="text-gray-400 text-sm leading-relaxed">Foto asli dan deskripsi detail dari setiap sudut. Tanpa kejutan.</p>
            </div>
          </div>

          <div class="scale-in" style="transition-delay:0.25s">
            <div class="bg-white border border-gray-100 rounded-3xl p-8 h-full hover:-translate-y-2 hover:shadow-xl hover:border-green-100 transition-all duration-300 group">
              <div class="w-10 h-10 bg-green-100 text-green-600 rounded-2xl flex items-center justify-center mb-6 group-hover:bg-green-600 group-hover:text-white transition-colors duration-300">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
              </div>
              <h3 class="text-lg font-black text-gray-900 mb-2 tracking-tight">Harga Hemat</h3>
              <p class="text-gray-400 text-sm leading-relaxed">Branded items jauh di bawah harga ritel baru.</p>
            </div>
          </div>

          <div class="scale-in" style="transition-delay:0.35s">
            <div class="bg-gray-900 rounded-3xl p-8 h-full hover:-translate-y-2 hover:shadow-xl transition-all duration-300">
              <div class="w-10 h-10 bg-white/10 text-white rounded-2xl flex items-center justify-center mb-6">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
              </div>
              <h3 class="text-lg font-black text-white mb-2 tracking-tight">Stok Real-time</h3>
              <p class="text-gray-400 text-sm leading-relaxed">Barang yang tampil = barang yang tersedia saat ini.</p>
            </div>
          </div>

        </div>
      </div>
    </section>


    <!-- ══════════════════════════════════════════
         PRODUCT PREVIEW
    ══════════════════════════════════════════ -->
    <section id="katalog" class="py-28 bg-white">
      <div class="max-w-7xl mx-auto px-6">

        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12">
          <div class="slide-left">
            <p class="text-xs font-bold tracking-widest uppercase text-indigo-600 mb-3">Kurasi Pilihan</p>
            <h2 class="text-4xl md:text-6xl font-black tracking-tighter text-gray-900 leading-tight">Pilihan Terbaik<br/>Minggu Ini.</h2>
          </div>
          <a href="{{ route('produk.index') }}"
             class="slide-right magnetic mt-6 md:mt-0 inline-flex items-center gap-2 text-sm font-bold text-gray-900 hover:text-indigo-600 transition-colors group bg-gray-100 hover:bg-indigo-50 px-5 py-2.5 rounded-full self-start md:self-auto">
            Lihat Semua
            <svg class="w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
          </a>
        </div>

        <!-- Product cards dengan tilt 3D on hover via JS -->
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

          <div class="scale-in tilt-card cursor-pointer group" style="transition-delay:0.05s">
            <div class="w-full h-72 md:h-96 bg-gray-100 rounded-3xl overflow-hidden relative mb-4">
              <img src="https://picsum.photos/seed/sony/600/800" alt="Sony"
                   class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-700" referrerpolicy="no-referrer" />
              <div class="absolute top-4 left-4 bg-white text-gray-900 text-xs font-black px-3 py-1 rounded-full shadow-sm uppercase">Like New</div>
              <div class="absolute top-4 right-4 bg-gray-900 text-white text-xs font-bold px-3 py-1 rounded-full">Rp 2.900k</div>
            </div>
            <div class="flex justify-between items-center px-1">
              <div>
                <h3 class="text-base font-black text-gray-900 tracking-tight">Sony WH-1000XM4</h3>
                <p class="text-sm text-gray-400 mt-0.5">Audio & Elektronik</p>
              </div>
              <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-indigo-600 hover:text-white transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
              </div>
            </div>
          </div>

          <div class="scale-in tilt-card cursor-pointer group" style="transition-delay:0.15s">
            <div class="w-full h-72 md:h-96 bg-gray-100 rounded-3xl overflow-hidden relative mb-4">
              <img src="https://picsum.photos/seed/nike/600/800" alt="Nike"
                   class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-700" referrerpolicy="no-referrer" />
              <div class="absolute top-4 left-4 bg-white text-gray-900 text-xs font-black px-3 py-1 rounded-full shadow-sm uppercase">Min. Defect</div>
              <div class="absolute top-4 right-4 bg-gray-900 text-white text-xs font-bold px-3 py-1 rounded-full">Rp 1.500k</div>
            </div>
            <div class="flex justify-between items-center px-1">
              <div>
                <h3 class="text-base font-black text-gray-900 tracking-tight">Nike Air Jordan 1 High</h3>
                <p class="text-sm text-gray-400 mt-0.5">Sepatu & Sneakers</p>
              </div>
              <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-indigo-600 hover:text-white transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
              </div>
            </div>
          </div>

          <div class="scale-in tilt-card cursor-pointer group" style="transition-delay:0.25s">
            <div class="w-full h-72 md:h-96 bg-gray-100 rounded-3xl overflow-hidden relative mb-4">
              <img src="https://picsum.photos/seed/fujifilm/600/800" alt="Fujifilm"
                   class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-700" referrerpolicy="no-referrer" />
              <div class="absolute top-4 left-4 bg-white text-gray-900 text-xs font-black px-3 py-1 rounded-full shadow-sm uppercase">Good</div>
              <div class="absolute top-4 right-4 bg-gray-900 text-white text-xs font-bold px-3 py-1 rounded-full">Rp 9.200k</div>
            </div>
            <div class="flex justify-between items-center px-1">
              <div>
                <h3 class="text-base font-black text-gray-900 tracking-tight">Fujifilm X-T30 Body</h3>
                <p class="text-sm text-gray-400 mt-0.5">Kamera & Lensa</p>
              </div>
              <div class="w-8 h-8 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-indigo-600 hover:text-white transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>


    <!-- ══════════════════════════════════════════
         HOW IT WORKS — Timeline
    ══════════════════════════════════════════ -->
    <section id="cara-kerja" class="py-28 bg-white">
      <div class="max-w-7xl mx-auto px-6">

        <div class="text-center mb-20 reveal opacity-0 translate-y-6 duration-700 ease-out">
          <p class="text-xs font-bold tracking-widest uppercase text-indigo-600 mb-3">Cara Kerja</p>
          <h2 class="text-4xl md:text-6xl font-black tracking-tighter text-gray-900">Tiga Langkah.<br/>Semudah Itu.</h2>
        </div>

        <div class="relative reveal opacity-0 translate-y-6 duration-700 delay-100 ease-out">

          <!-- Connecting line desktop -->
          <div class="hidden md:block absolute" style="top:32px; left:calc(16.666% + 8px); right:calc(16.666% + 8px); height:2px; z-index:0;">
            <div class="absolute inset-0 bg-gray-200 rounded-full"></div>
            <div class="absolute inset-0 bg-gradient-to-r from-indigo-400 via-indigo-500 to-indigo-400 rounded-full opacity-60"></div>
            <div class="absolute top-1/2 -translate-y-1/2 w-4 h-4 bg-indigo-500 rounded-full shadow-lg shadow-indigo-300"
                 style="animation: slideDot 2.8s cubic-bezier(0.4,0,0.2,1) infinite; left:0;"></div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-3 gap-6 relative z-10">

            <div class="flex flex-col items-center text-center group">
              <div class="relative mb-8">
                <div class="w-16 h-16 rounded-full bg-white border-[3px] border-indigo-200 flex items-center justify-center shadow-md group-hover:border-indigo-500 group-hover:shadow-indigo-100 group-hover:shadow-xl transition-all duration-300 relative z-10">
                  <div class="w-10 h-10 bg-indigo-600 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                  </div>
                </div>
                <span class="absolute -top-2 -right-2 w-6 h-6 bg-gray-900 text-white text-[10px] font-black rounded-full flex items-center justify-center z-20 shadow-sm">01</span>
              </div>
              <div class="md:hidden w-px h-5 bg-indigo-200 mb-5"></div>
              <div class="bg-white border border-gray-100 rounded-3xl p-8 w-full hover:-translate-y-1 hover:shadow-xl transition-all duration-300">
                <h3 class="text-xl font-black text-gray-900 mb-2 tracking-tight">Eksplorasi</h3>
                <p class="text-gray-400 text-sm leading-relaxed">Telusuri katalog dan temukan barang yang Anda cari dengan filter pintar.</p>
              </div>
            </div>

            <div class="flex flex-col items-center text-center group">
              <div class="relative mb-8">
                <div class="w-16 h-16 rounded-full bg-gray-900 border-[3px] border-indigo-500 flex items-center justify-center shadow-xl group-hover:shadow-indigo-500/30 group-hover:shadow-2xl transition-all duration-300 relative z-10">
                  <div class="w-10 h-10 bg-indigo-600 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                  </div>
                </div>
                <span class="absolute -top-2 -right-2 w-6 h-6 bg-indigo-600 text-white text-[10px] font-black rounded-full flex items-center justify-center z-20 shadow-sm">02</span>
              </div>
              <div class="md:hidden w-px h-5 bg-indigo-200 mb-5"></div>
              <div class="bg-gray-900 rounded-3xl p-8 w-full hover:-translate-y-1 hover:shadow-xl transition-all duration-300">
                <h3 class="text-xl font-black text-white mb-2 tracking-tight">Pesan & Bayar</h3>
                <p class="text-gray-400 text-sm leading-relaxed">Bayar aman via Sakurupiah. Dana ditahan sampai barang terkonfirmasi.</p>
              </div>
            </div>

            <div class="flex flex-col items-center text-center group">
              <div class="relative mb-8">
                <div class="w-16 h-16 rounded-full bg-white border-[3px] border-emerald-200 flex items-center justify-center shadow-md group-hover:border-emerald-500 group-hover:shadow-emerald-100 group-hover:shadow-xl transition-all duration-300 relative z-10">
                  <div class="w-10 h-10 bg-emerald-500 rounded-full flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                  </div>
                </div>
                <span class="absolute -top-2 -right-2 w-6 h-6 bg-gray-900 text-white text-[10px] font-black rounded-full flex items-center justify-center z-20 shadow-sm">03</span>
              </div>
              <div class="md:hidden w-px h-5 bg-indigo-200 mb-5"></div>
              <div class="bg-white border border-gray-100 rounded-3xl p-8 w-full hover:-translate-y-1 hover:shadow-xl transition-all duration-300">
                <h3 class="text-xl font-black text-gray-900 mb-2 tracking-tight">Terima</h3>
                <p class="text-gray-400 text-sm leading-relaxed">Barang diantar ke pintu Anda. Cek kondisi, konfirmasi, selesai.</p>
              </div>
            </div>

          </div>
        </div>
      </div>
    </section>


    <!-- ══════════════════════════════════════════
         TRUST SECTION
    ══════════════════════════════════════════ -->
    <section class="py-28 bg-white">
      <div class="max-w-7xl mx-auto px-6">
        <div class="reveal opacity-0 translate-y-6 duration-700 ease-out">
          <div class="bg-gray-900 rounded-[2.5rem] p-10 md:p-16 relative overflow-hidden">
            <div class="parallax-fast absolute -right-24 -top-24 w-96 h-96 bg-indigo-600 rounded-full blur-[120px] opacity-20 pointer-events-none"></div>

            <div class="relative z-10 grid grid-cols-1 md:grid-cols-2 gap-16 items-center">
              <div class="slide-left">
                <p class="text-xs font-bold tracking-widest uppercase text-indigo-400 mb-4">Keamanan Transaksi</p>
                <h2 class="text-4xl md:text-5xl font-black tracking-tighter text-white leading-tight mb-6">
                  Transaksi aman.<br/>Tanpa rasa khawatir.
                </h2>
                <p class="text-gray-400 text-base leading-relaxed mb-10">
                  Setiap transaksi dilindungi sistem escrow. Jika barang tidak sesuai, uang kembali 100%.
                </p>
                <ul class="space-y-4">
                  <li class="flex items-center gap-3 text-white font-medium text-sm">
                    <div class="w-5 h-5 rounded-full bg-green-500/20 text-green-400 flex items-center justify-center shrink-0">
                      <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    Garansi uang kembali
                  </li>
                  <li class="flex items-center gap-3 text-white font-medium text-sm">
                    <div class="w-5 h-5 rounded-full bg-green-500/20 text-green-400 flex items-center justify-center shrink-0">
                      <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    Customer Support 24/7
                  </li>
                  <li class="flex items-center gap-3 text-white font-medium text-sm">
                    <div class="w-5 h-5 rounded-full bg-green-500/20 text-green-400 flex items-center justify-center shrink-0">
                      <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    Verifikasi identitas terproteksi
                  </li>
                </ul>
              </div>

              <div class="slide-right grid grid-cols-2 gap-4">
                <div class="scale-in bg-white/5 border border-white/10 rounded-2xl p-6 hover:bg-white/10 transition-colors" style="transition-delay:0.1s">
                  <p class="text-4xl font-black text-white mb-1">100%</p>
                  <p class="text-gray-400 text-sm">Garansi Uang Kembali</p>
                </div>
                <div class="scale-in bg-indigo-600 rounded-2xl p-6" style="transition-delay:0.2s">
                  <p class="text-4xl font-black text-white mb-1">24/7</p>
                  <p class="text-indigo-200 text-sm">Customer Support</p>
                </div>
                <div class="scale-in bg-white/5 border border-white/10 rounded-2xl p-6 hover:bg-white/10 transition-colors" style="transition-delay:0.3s">
                  <p class="text-4xl font-black text-white mb-1">0%</p>
                  <p class="text-gray-400 text-sm">Barang Tidak Sesuai</p>
                </div>
                <div class="scale-in bg-white/5 border border-white/10 rounded-2xl p-6 hover:bg-white/10 transition-colors" style="transition-delay:0.4s">
                  <p class="text-4xl font-black text-white mb-1">SSL</p>
                  <p class="text-gray-400 text-sm">Enkripsi Penuh</p>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>


    <!-- ══════════════════════════════════════════
         GLOBAL CTA
    ══════════════════════════════════════════ -->
    <section class="py-32 px-6 bg-white text-center">
      <p class="reveal opacity-0 translate-y-6 duration-500 text-xs font-bold tracking-widest uppercase text-indigo-600 mb-4">Bergabung Sekarang</p>
      <h2 class="split-reveal text-5xl md:text-7xl font-black tracking-tighter text-gray-900 mb-6 leading-[0.9]">
        <span class="word">Siap</span> <span class="word" style="transition-delay:0.08s">berburu</span><br/>
        <span class="word" style="transition-delay:0.16s">barang</span> <span class="word" style="transition-delay:0.24s">incaran?</span>
      </h2>
      <p class="reveal opacity-0 translate-y-6 duration-500 delay-300 text-gray-500 text-lg mb-10 max-w-lg mx-auto">
        Bergabung dengan ribuan orang yang sudah menemukan penawaran terbaik di PindahTangan.
      </p>
      <a href="{{ route('produk.index') }}"
         class="reveal opacity-0 translate-y-6 duration-500 delay-500 magnetic inline-flex items-center justify-center px-10 py-4 text-base font-black text-white bg-gray-900 rounded-full hover:bg-indigo-600 shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
        Mulai Eksplorasi Sekarang
      </a>
    </section>


    <!-- ══════════════════════════════════════════
         FOOTER
    ══════════════════════════════════════════ -->
    <footer class="bg-white border-t border-gray-100">
      <div class="max-w-7xl mx-auto px-6 py-12 md:py-16">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-10 md:gap-8">

          <div class="md:col-span-1">
            <img src="{{ asset('images/logo.png') }}" alt="PindahTangan" class="h-7 w-auto mb-4" />
            <p class="text-sm text-gray-400 leading-relaxed">Platform jual beli barang preloved berkualitas. Transparan, aman, dan terpercaya.</p>
          </div>

          <div>
            <h4 class="text-xs font-black text-gray-900 uppercase tracking-widest mb-4">Perusahaan</h4>
            <ul class="space-y-3 text-sm text-gray-400">
              <li><a href="#" class="hover:text-indigo-600 transition-colors">Tentang Kami</a></li>
              <li><a href="#" class="hover:text-indigo-600 transition-colors">Karir</a></li>
              <li><a href="#" class="hover:text-indigo-600 transition-colors">Blog</a></li>
            </ul>
          </div>

          <div>
            <h4 class="text-xs font-black text-gray-900 uppercase tracking-widest mb-4">Bantuan</h4>
            <ul class="space-y-3 text-sm text-gray-400">
              <li><a href="#" class="hover:text-indigo-600 transition-colors">Pusat Bantuan</a></li>
              <li><a href="#" class="hover:text-indigo-600 transition-colors">Syarat & Ketentuan</a></li>
              <li><a href="#" class="hover:text-indigo-600 transition-colors">Kebijakan Privasi</a></li>
            </ul>
          </div>

          <div>
            <h4 class="text-xs font-black text-gray-900 uppercase tracking-widest mb-4">Ikuti Kami</h4>
            <div class="flex gap-3">
              <a href="#" class="w-9 h-9 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 hover:bg-indigo-600 hover:text-white transition-all">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
              </a>
              <a href="#" class="w-9 h-9 rounded-full bg-gray-100 flex items-center justify-center text-gray-500 hover:bg-indigo-600 hover:text-white transition-all">
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
              </a>
            </div>
          </div>

        </div>
        <div class="mt-12 pt-8 border-t border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4">
          <p class="text-xs text-gray-400">© {{ date('Y') }} PindahTangan. All rights reserved.</p>
          <div class="flex gap-3">
            <div class="w-10 h-6 bg-gray-100 rounded border border-gray-200"></div>
            <div class="w-10 h-6 bg-gray-100 rounded border border-gray-200"></div>
            <div class="w-10 h-6 bg-gray-100 rounded border border-gray-200"></div>
          </div>
        </div>
      </div>
    </footer>


    <!-- ══════════════════════════════════════════
         SCRIPTS — Semua efek parallax & interaksi
    ══════════════════════════════════════════ -->
    <script>
    document.addEventListener("DOMContentLoaded", () => {

      // ─── 1. SCROLL PROGRESS BAR ───────────────────────────────
      const progress = document.getElementById('read-progress');
      function updateProgress() {
        const total   = document.documentElement.scrollHeight - window.innerHeight;
        const current = window.scrollY;
        progress.style.width = (current / total * 100) + '%';
      }

      // ─── 2. NAVBAR SHADOW ─────────────────────────────────────
      const nav = document.getElementById('navbar');
      function updateNav() {
        nav.classList.toggle('shadow-sm', window.scrollY > 20);
      }

      // ─── 3. PARALLAX — hanya background blob, bukan fan cards ──
      const heroBlob  = document.querySelector('.parallax-slow');
      const trustBlob = document.querySelector('.parallax-fast');
      function doParallax() {
        const sy = window.scrollY;
        if (heroBlob)  heroBlob.style.transform  = `translateX(-50%) translateY(${sy * 0.1}px)`;
        if (trustBlob) trustBlob.style.transform = `translateY(${sy * -0.06}px)`;
      }

      // ─── 3b. CARD FAN SCROLL-DRIVEN (tutup ↓ / buka ↑) ───────
      // Parameter bloom tiap card (sesuai --bloom-transform di HTML)
      const fanCards = document.querySelectorAll('.fan-card');
      const cardBloomParams = [
        { rotate: -18, tx: -310, ty: 30 },
        { rotate:  -9, tx: -165, ty: 10 },
        { rotate:  -2, tx:    0, ty:  0 },
        { rotate:   9, tx:  165, ty: 10 },
        { rotate:  18, tx:  310, ty: 30 },
      ];

      function updateFanScroll() {
        // Hanya aktif setelah bloom awal selesai
        if (!fanBloomed) return;

        const startClose = 80;   // mulai menutup saat scroll 80px
        const endClose   = 480;  // sepenuhnya tertutup di 480px

        let raw = (window.scrollY - startClose) / (endClose - startClose);
        raw = Math.max(0, Math.min(1, raw)); // clamp 0–1

        // Ease in-out quad
        const p = raw < 0.5
          ? 2 * raw * raw
          : 1 - Math.pow(-2 * raw + 2, 2) / 2;

        fanCards.forEach((card, i) => {
          const b = cardBloomParams[i];
          const rotate = b.rotate * (1 - p);
          const tx     = b.tx     * (1 - p);
          const ty     = b.ty     * (1 - p);

          // Update CSS variable → .bloomed & :hover otomatis ikut
          card.style.setProperty(
            '--bloom-transform',
            `rotate(${rotate}deg) translateX(${tx}px) translateY(${ty}px)`
          );
        });
      }

      // ─── 4. CARD FAN BLOOM (mekar saat masuk viewport) ────────
      const fanSection = document.getElementById('card-fan');
      let fanBloomed = false;
      const fanObserver = new IntersectionObserver(entries => {
        entries.forEach(entry => {
          if (entry.isIntersecting && !fanBloomed) {
            fanBloomed = true;
            document.querySelectorAll('.fan-card').forEach((card, i) => {
              setTimeout(() => card.classList.add('bloomed'), i * 80);
            });
            fanObserver.disconnect();
          }
        });
      }, { threshold: 0.3 });
      if (fanSection) fanObserver.observe(fanSection);

      // ─── 5. SPLIT TEXT REVEAL ─────────────────────────────────
      const splitObserver = new IntersectionObserver(entries => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('revealed');
            splitObserver.unobserve(entry.target);
          }
        });
      }, { threshold: 0.2 });
      document.querySelectorAll('.split-reveal').forEach(el => splitObserver.observe(el));

      // ─── 6. SLIDE LEFT / RIGHT ────────────────────────────────
      const slideObserver = new IntersectionObserver(entries => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('in');
            slideObserver.unobserve(entry.target);
          }
        });
      }, { threshold: 0.15 });
      document.querySelectorAll('.slide-left, .slide-right').forEach(el => slideObserver.observe(el));

      // ─── 7. SCALE IN ──────────────────────────────────────────
      const scaleObserver = new IntersectionObserver(entries => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('in');
            scaleObserver.unobserve(entry.target);
          }
        });
      }, { threshold: 0.1 });
      document.querySelectorAll('.scale-in').forEach(el => scaleObserver.observe(el));

      // ─── 8. GENERIC REVEAL ────────────────────────────────────
      const revealObserver = new IntersectionObserver(entries => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.remove('opacity-0', 'translate-y-6', 'translate-y-10');
            entry.target.classList.add('opacity-100', 'translate-y-0');
            revealObserver.unobserve(entry.target);
          }
        });
      }, { threshold: 0.1 });
      document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));

      // ─── 9. 3D TILT EFFECT pada product cards ─────────────────
      document.querySelectorAll('.tilt-card').forEach(card => {
        const img = card.querySelector('div:first-child');

        card.addEventListener('mousemove', e => {
          const rect = card.getBoundingClientRect();
          const cx   = rect.left + rect.width  / 2;
          const cy   = rect.top  + rect.height / 2;
          const dx   = (e.clientX - cx) / (rect.width  / 2);
          const dy   = (e.clientY - cy) / (rect.height / 2);
          const rotX = -dy * 6;
          const rotY =  dx * 6;
          card.style.transform    = `perspective(800px) rotateX(${rotX}deg) rotateY(${rotY}deg) scale(1.02)`;
          card.style.transition   = 'transform 0.1s ease';
          if (img) img.style.transform = `scale(1.04) translate(${dx*4}px, ${dy*4}px)`;
        });

        card.addEventListener('mouseleave', () => {
          card.style.transform  = 'perspective(800px) rotateX(0) rotateY(0) scale(1)';
          card.style.transition = 'transform 0.6s cubic-bezier(0.34,1.56,0.64,1)';
          if (img) {
            img.style.transform  = '';
            img.style.transition = 'transform 0.6s ease';
          }
        });
      });

      // ─── 10. MAGNETIC BUTTON ──────────────────────────────────
      document.querySelectorAll('.magnetic').forEach(btn => {
        btn.addEventListener('mousemove', e => {
          const rect = btn.getBoundingClientRect();
          const cx   = rect.left + rect.width  / 2;
          const cy   = rect.top  + rect.height / 2;
          const dx   = (e.clientX - cx) * 0.25;
          const dy   = (e.clientY - cy) * 0.25;
          btn.style.transform  = `translate(${dx}px, ${dy}px)`;
          btn.style.transition = 'transform 0.15s ease';
        });
        btn.addEventListener('mouseleave', () => {
          btn.style.transform  = 'translate(0,0)';
          btn.style.transition = 'transform 0.5s cubic-bezier(0.34,1.56,0.64,1)';
        });
      });

      // ─── RAF loop untuk progress + parallax + fan scroll ──────
      let ticking = false;
      window.addEventListener('scroll', () => {
        if (!ticking) {
          requestAnimationFrame(() => {
            updateProgress();
            updateNav();
            doParallax();
            updateFanScroll(); // ← TAMBAHAN: scroll-driven fan
            ticking = false;
          });
          ticking = true;
        }
      }, { passive: true });

      // Init saat load
      updateProgress();
      updateNav();

    });
    </script>

  </body>
</html>