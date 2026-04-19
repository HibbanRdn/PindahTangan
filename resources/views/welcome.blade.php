<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>PindahTangan - Preloved Berkualitas</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
  </head>
  <body class="bg-[#FAFAFA] text-gray-900 font-sans antialiased selection:bg-indigo-100 selection:text-indigo-900 overflow-x-hidden">
    
    <!-- Navbar -->
    <nav class="fixed top-0 w-full z-50 bg-[#FAFAFA]/80 backdrop-blur-md border-b border-gray-100 transition-all duration-300">
      <div class="max-w-7xl mx-auto px-6 h-20 flex items-center justify-between">
        <div class="flex items-center gap-2">
          <!-- Logo Mark -->
          <div class="flex items-center">
          <img src="{{ asset('images/logo.png') }}" alt="PindahTangan" class="h-10 w-auto">
        </div>
          <span class="text-xl font-bold tracking-tight">PindahTangan</span>
        </div>
        
        <div class="hidden md:flex items-center gap-8 text-sm font-medium text-gray-600">
          <a href="#katalog" class="hover:text-indigo-600 transition-colors">Katalog</a>
          <a href="#cara-kerja" class="hover:text-indigo-600 transition-colors">Cara Kerja</a>
          <a href="#keunggulan" class="hover:text-indigo-600 transition-colors">Keunggulan</a>
        </div>

        <div class="flex items-center gap-4">
          @auth
            <a href="{{ route('produk.index') }}" class="hidden md:inline-flex text-sm font-medium text-gray-900 hover:text-indigo-600 transition-colors">Katalog</a>
            <form method="POST" action="{{ route('logout') }}" class="hidden md:inline">
              @csrf
              <button type="submit" class="text-sm font-medium text-gray-900 hover:text-indigo-600 transition-colors">Keluar</button>
            </form>
          @else
            <a href="{{ route('login') }}" class="hidden md:inline-flex text-sm font-medium text-gray-900 hover:text-indigo-600 transition-colors">Masuk</a>
          @endauth
          <a href="{{ route('produk.index') }}" class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-medium text-white bg-gray-900 rounded-full hover:bg-indigo-600 shadow-sm hover:shadow-md hover:scale-105 transition-all duration-300">
            Mulai Belanja
          </a>
        </div>
      </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative pt-40 lg:pt-48 pb-20 lg:pb-32 px-6 max-w-7xl mx-auto text-center flex flex-col items-center">
      
      <!-- Badge -->
      <div class="reveal opacity-0 translate-y-8 duration-700 ease-out inline-flex items-center gap-2 px-3 py-1 rounded-full bg-white border border-gray-200 shadow-sm mb-8">
        <span class="flex h-2 w-2 rounded-full bg-green-500"></span>
        <span class="text-xs font-medium text-gray-600">Ribuan produk baru minggu ini</span>
      </div>

      <h1 class="reveal opacity-0 translate-y-8 duration-700 delay-100 ease-out text-5xl md:text-7xl lg:text-8xl font-extrabold tracking-tighter text-gray-900 mb-6 max-w-4xl leading-[1.1]">
        Tempat terbaik untuk <br/>
        <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-purple-600">barang preloved.</span>
      </h1>
      
      <p class="reveal opacity-0 translate-y-8 duration-700 delay-200 ease-out text-lg md:text-xl text-gray-500 max-w-2xl mx-auto mb-10 leading-relaxed">
        PindahTangan mempertemukan barang berkualitas dengan pemilik baru. Harga lebih hemat, kondisi transparan, dan pastinya aman.
      </p>

      <div class="reveal opacity-0 translate-y-8 duration-700 delay-300 ease-out flex flex-col sm:flex-row gap-4 justify-center items-center">
        <a href="#katalog" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 text-base font-semibold text-white bg-gray-900 rounded-full hover:bg-indigo-600 shadow-lg hover:shadow-xl hover:scale-105 transition-all duration-300">
          Belanja Sekarang
        </a>
        <a href="#cara-kerja" class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-4 text-base font-semibold text-gray-900 bg-white border border-gray-200 rounded-full hover:bg-gray-50 shadow-sm hover:shadow-md transition-all duration-300">
          Lihat Cara Kerja
        </a>
      </div>

      <!-- Hero Visual (Overlapping Cards) -->
      <div class="reveal opacity-0 translate-y-12 duration-1000 delay-500 ease-out relative w-full h-[400px] mt-24 mb-10 flex justify-center items-center perspective-1000">
        
        <!-- Background decorative blob -->
        <div class="absolute inset-0 bg-gradient-to-b from-indigo-50 to-transparent rounded-[100%] blur-3xl opacity-50 -z-10"></div>

        <!-- Card 1 (Far Left) -->
        <div class="absolute w-44 h-56 md:w-56 md:h-72 rounded-3xl bg-white p-3 shadow-[0_20px_50px_rgba(0,0,0,0.1)] transform -rotate-12 -translate-x-32 md:-translate-x-60 -translate-y-8 z-10 hover:scale-110 hover:-translate-y-12 hover:z-50 hover:rotate-0 transition-all duration-500 cursor-pointer">
          <div class="w-full h-full rounded-2xl overflow-hidden bg-gray-100 relative">
            <img src="https://picsum.photos/seed/shoes/400/500" alt="Preloved Item" class="object-cover w-full h-full" referrerpolicy="no-referrer" />
            <div class="absolute bottom-2 left-2 bg-white/90 backdrop-blur px-2 py-1 rounded-full text-[10px] font-bold text-gray-900 shadow-sm">Sneakers</div>
          </div>
        </div>

        <!-- Card 2 (Mid Left) -->
        <div class="absolute w-44 h-56 md:w-56 md:h-72 rounded-3xl bg-white p-3 shadow-[0_20px_50px_rgba(0,0,0,0.1)] transform -rotate-6 -translate-x-16 md:-translate-x-32 translate-y-4 z-20 hover:scale-110 hover:translate-y-0 hover:z-50 hover:rotate-0 transition-all duration-500 cursor-pointer">
          <div class="w-full h-full rounded-2xl overflow-hidden bg-gray-100 relative">
            <img src="https://picsum.photos/seed/camera/400/500" alt="Preloved Item" class="object-cover w-full h-full" referrerpolicy="no-referrer" />
            <div class="absolute bottom-2 left-2 bg-white/90 backdrop-blur px-2 py-1 rounded-full text-[10px] font-bold text-gray-900 shadow-sm">Kamera Analog</div>
          </div>
        </div>

        <!-- Card 3 (Center - Focus) -->
        <div class="absolute w-48 h-60 md:w-64 md:h-80 rounded-3xl bg-white p-3 shadow-[0_30px_60px_rgba(0,0,0,0.15)] z-30 hover:scale-110 hover:-translate-y-4 hover:z-50 transition-all duration-500 cursor-pointer border border-gray-50">
          <div class="w-full h-full rounded-2xl overflow-hidden bg-gray-100 relative group">
            <img src="https://picsum.photos/seed/watch/400/500" alt="Preloved Item" class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-700" referrerpolicy="no-referrer" />
            <div class="absolute top-2 right-2 bg-indigo-600 text-white px-2 py-1 rounded-full text-[10px] font-bold shadow-sm">Kondisi 95%</div>
            <div class="absolute bottom-0 inset-x-0 bg-gradient-to-t from-black/60 to-transparent p-4">
              <p class="text-white font-bold text-sm">Vintage Watch</p>
              <p class="text-white/80 text-xs">Rp 1.250.000</p>
            </div>
          </div>
        </div>

        <!-- Card 4 (Mid Right) -->
        <div class="absolute w-44 h-56 md:w-56 md:h-72 rounded-3xl bg-white p-3 shadow-[0_20px_50px_rgba(0,0,0,0.1)] transform rotate-6 translate-x-16 md:translate-x-32 translate-y-4 z-20 hover:scale-110 hover:translate-y-0 hover:z-50 hover:rotate-0 transition-all duration-500 cursor-pointer">
          <div class="w-full h-full rounded-2xl overflow-hidden bg-gray-100 relative">
            <img src="https://picsum.photos/seed/bag/400/500" alt="Preloved Item" class="object-cover w-full h-full" referrerpolicy="no-referrer" />
            <div class="absolute bottom-2 left-2 bg-white/90 backdrop-blur px-2 py-1 rounded-full text-[10px] font-bold text-gray-900 shadow-sm">Tote Bag</div>
          </div>
        </div>

        <!-- Card 5 (Far Right) -->
        <div class="absolute w-44 h-56 md:w-56 md:h-72 rounded-3xl bg-white p-3 shadow-[0_20px_50px_rgba(0,0,0,0.1)] transform rotate-12 translate-x-32 md:translate-x-60 -translate-y-8 z-10 hover:scale-110 hover:-translate-y-12 hover:z-50 hover:rotate-0 transition-all duration-500 cursor-pointer">
          <div class="w-full h-full rounded-2xl overflow-hidden bg-gray-100 relative">
            <img src="https://picsum.photos/seed/jacket/400/500" alt="Preloved Item" class="object-cover w-full h-full" referrerpolicy="no-referrer" />
            <div class="absolute bottom-2 left-2 bg-white/90 backdrop-blur px-2 py-1 rounded-full text-[10px] font-bold text-gray-900 shadow-sm">Denim Jacket</div>
          </div>
        </div>

      </div>
    </section>

    <!-- Value Proposition Section -->
    <section id="keunggulan" class="py-24 bg-white border-y border-gray-100">
      <div class="max-w-7xl mx-auto px-6">
        <div class="text-center mb-16 reveal opacity-0 translate-y-8 duration-700 ease-out">
          <h2 class="text-3xl md:text-5xl font-bold tracking-tight text-gray-900 mb-4">Mengapa PindahTangan?</h2>
          <p class="text-gray-500 text-lg max-w-2xl mx-auto">Kami mendefinisikan ulang cara Anda membeli barang preloved. Lebih terpercaya, lebih transparan.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">

          <!-- Card 1 -->
          <div class="reveal opacity-0 translate-y-8 duration-700 delay-100 ease-out bg-[#FAFAFA] p-8 rounded-3xl hover:-translate-y-2 hover:shadow-xl transition-all duration-300 border border-transparent hover:border-gray-100">
            <div class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-2xl flex items-center justify-center mb-6">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-3">Barang Berkualitas</h3>
            <p class="text-gray-500 text-sm leading-relaxed">Setiap item melewati proses kurasi ketat untuk memastikan kualitas tetap terjaga dan layak pakai.</p>
          </div>

          <!-- Card 2 -->
          <div class="reveal opacity-0 translate-y-8 duration-700 delay-200 ease-out bg-[#FAFAFA] p-8 rounded-3xl hover:-translate-y-2 hover:shadow-xl transition-all duration-300 border border-transparent hover:border-gray-100">
            <div class="w-12 h-12 bg-orange-100 text-orange-600 rounded-2xl flex items-center justify-center mb-6">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-3">Kondisi Jelas</h3>
            <p class="text-gray-500 text-sm leading-relaxed">Dapatkan deskripsi detail dan foto asli dari setiap sudut. Tidak ada yang disembunyikan.</p>
          </div>

          <!-- Card 3 -->
          <div class="reveal opacity-0 translate-y-8 duration-700 delay-300 ease-out bg-[#FAFAFA] p-8 rounded-3xl hover:-translate-y-2 hover:shadow-xl transition-all duration-300 border border-transparent hover:border-gray-100">
            <div class="w-12 h-12 bg-green-100 text-green-600 rounded-2xl flex items-center justify-center mb-6">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-3">Harga Hemat</h3>
            <p class="text-gray-500 text-sm leading-relaxed">Dapatkan barang branded incaran Anda dengan harga jauh di bawah harga ritel baru.</p>
          </div>

          <!-- Card 4 -->
          <div class="reveal opacity-0 translate-y-8 duration-700 delay-400 ease-out bg-[#FAFAFA] p-8 rounded-3xl hover:-translate-y-2 hover:shadow-xl transition-all duration-300 border border-transparent hover:border-gray-100">
            <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-2xl flex items-center justify-center mb-6">
              <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-3">Stok Real-time</h3>
            <p class="text-gray-500 text-sm leading-relaxed">Sistem kami memastikan barang yang Anda lihat adalah barang yang benar-benar tersedia saat ini.</p>
          </div>

        </div>
      </div>
    </section>

    <!-- Product Preview Section -->
    <section id="katalog" class="py-24 bg-[#FAFAFA]">
      <div class="max-w-7xl mx-auto px-6">
        <div class="flex flex-col md:flex-row md:items-end justify-between mb-12 reveal opacity-0 translate-y-8 duration-700 ease-out">
          <div>
            <h2 class="text-3xl md:text-5xl font-bold tracking-tight text-gray-900 mb-4">Pilihan Kurasi Kami</h2>
            <p class="text-gray-500 text-lg">Temukan harta karun yang siap melengkapi gaya Anda.</p>
          </div>
          <a href="{{ route('produk.index') }}" class="mt-6 md:mt-0 inline-flex items-center text-indigo-600 font-semibold hover:text-indigo-800 transition-colors group">
            Lihat Semua Katalog
            <svg class="w-5 h-5 ml-2 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
          </a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

          <!-- Product Item 1 -->
          <div class="reveal opacity-0 translate-y-8 duration-700 delay-100 ease-out group cursor-pointer bg-white rounded-3xl p-4 shadow-sm hover:shadow-xl transition-all duration-300">
            <div class="w-full h-64 md:h-80 bg-gray-100 rounded-2xl overflow-hidden relative mb-4">
              <img src="https://picsum.photos/seed/sony/600/800" alt="Sony Headphones" class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-700" referrerpolicy="no-referrer" />
              <div class="absolute top-3 right-3 bg-white/90 backdrop-blur text-gray-900 text-xs font-bold px-3 py-1 rounded-full shadow-sm">
                Like New
              </div>
            </div>
            <div class="px-2">
              <div class="flex justify-between items-start mb-1">
                <h3 class="text-lg font-bold text-gray-900 line-clamp-1">Sony WH-1000XM4</h3>
                <span class="text-lg font-bold text-indigo-600">Rp 2.900k</span>
              </div>
              <p class="text-sm text-gray-500 mb-4">Audio & Elektronik</p>
              <div class="flex items-center gap-2 text-xs font-medium text-gray-500 bg-gray-50 px-3 py-2 rounded-xl">
                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Telah diverifikasi
              </div>
            </div>
          </div>

          <!-- Product Item 2 -->
          <div class="reveal opacity-0 translate-y-8 duration-700 delay-200 ease-out group cursor-pointer bg-white rounded-3xl p-4 shadow-sm hover:shadow-xl transition-all duration-300">
            <div class="w-full h-64 md:h-80 bg-gray-100 rounded-2xl overflow-hidden relative mb-4">
              <img src="https://picsum.photos/seed/nike/600/800" alt="Nike Jordan" class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-700" referrerpolicy="no-referrer" />
              <div class="absolute top-3 right-3 bg-white/90 backdrop-blur text-gray-900 text-xs font-bold px-3 py-1 rounded-full shadow-sm">
                Min. Defect
              </div>
            </div>
            <div class="px-2">
              <div class="flex justify-between items-start mb-1">
                <h3 class="text-lg font-bold text-gray-900 line-clamp-1">Nike Air Jordan 1 High</h3>
                <span class="text-lg font-bold text-indigo-600">Rp 1.500k</span>
              </div>
              <p class="text-sm text-gray-500 mb-4">Sepatu & Sneakers</p>
              <div class="flex items-center gap-2 text-xs font-medium text-gray-500 bg-gray-50 px-3 py-2 rounded-xl">
                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Telah diverifikasi
              </div>
            </div>
          </div>

          <!-- Product Item 3 -->
          <div class="reveal opacity-0 translate-y-8 duration-700 delay-300 ease-out group cursor-pointer bg-white rounded-3xl p-4 shadow-sm hover:shadow-xl transition-all duration-300">
            <div class="w-full h-64 md:h-80 bg-gray-100 rounded-2xl overflow-hidden relative mb-4">
              <img src="https://picsum.photos/seed/fujifilm/600/800" alt="Fujifilm" class="object-cover w-full h-full group-hover:scale-105 transition-transform duration-700" referrerpolicy="no-referrer" />
              <div class="absolute top-3 right-3 bg-white/90 backdrop-blur text-gray-900 text-xs font-bold px-3 py-1 rounded-full shadow-sm">
                Good
              </div>
            </div>
            <div class="px-2">
              <div class="flex justify-between items-start mb-1">
                <h3 class="text-lg font-bold text-gray-900 line-clamp-1">Fujifilm X-T30 Body</h3>
                <span class="text-lg font-bold text-indigo-600">Rp 9.200k</span>
              </div>
              <p class="text-sm text-gray-500 mb-4">Kamera & Lensa</p>
              <div class="flex items-center gap-2 text-xs font-medium text-gray-500 bg-gray-50 px-3 py-2 rounded-xl">
                <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Telah diverifikasi
              </div>
            </div>
          </div>

        </div>
      </div>
    </section>

    <!-- How It Works Section -->
    <section id="cara-kerja" class="py-24 bg-white border-t border-gray-100 relative overflow-hidden">
      <!-- Decorative background -->
      <div class="absolute top-0 right-0 -mt-20 -mr-20 w-80 h-80 bg-indigo-50 rounded-full blur-3xl opacity-60"></div>
      
      <div class="max-w-7xl mx-auto px-6 relative z-10">
        <div class="text-center mb-16 reveal opacity-0 translate-y-8 duration-700 ease-out">
          <h2 class="text-3xl md:text-5xl font-bold tracking-tight text-gray-900 mb-4">Proses Sederhana</h2>
          <p class="text-gray-500 text-lg max-w-2xl mx-auto">Tiga langkah mudah untuk mendapatkan barang impian Anda.</p>
        </div>

        <div class="relative grid grid-cols-1 md:grid-cols-3 gap-12 text-center">
          <!-- Connecting line for desktop -->
          <div class="hidden md:block absolute top-12 left-[15%] w-[70%] h-[2px] bg-gradient-to-r from-gray-100 via-indigo-200 to-gray-100 -z-10"></div>

          <!-- Step 1 -->
          <div class="reveal opacity-0 translate-y-8 duration-700 delay-100 ease-out relative">
            <div class="w-24 h-24 mx-auto bg-white border-4 border-[#FAFAFA] shadow-xl rounded-full flex items-center justify-center text-3xl font-extrabold text-gray-900 mb-6 relative z-10 transition-transform hover:scale-110 duration-300">
              1
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Eksplorasi</h3>
            <p class="text-gray-500 text-sm px-4">Telusuri katalog kurasi kami dan temukan barang yang Anda cari dengan filter pintar.</p>
          </div>

          <!-- Step 2 -->
          <div class="reveal opacity-0 translate-y-8 duration-700 delay-200 ease-out relative">
            <div class="w-24 h-24 mx-auto bg-indigo-600 border-4 border-indigo-50 shadow-xl shadow-indigo-200 rounded-full flex items-center justify-center text-3xl font-extrabold text-white mb-6 relative z-10 transition-transform hover:scale-110 duration-300">
              2
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Pesan & Bayar</h3>
            <p class="text-gray-500 text-sm px-4">Lakukan pembayaran dengan metode aman. Dana akan ditahan hingga barang diterima.</p>
          </div>

          <!-- Step 3 -->
          <div class="reveal opacity-0 translate-y-8 duration-700 delay-300 ease-out relative">
            <div class="w-24 h-24 mx-auto bg-white border-4 border-[#FAFAFA] shadow-xl rounded-full flex items-center justify-center text-3xl font-extrabold text-gray-900 mb-6 relative z-10 transition-transform hover:scale-110 duration-300">
              3
            </div>
            <h3 class="text-xl font-bold text-gray-900 mb-2">Terima</h3>
            <p class="text-gray-500 text-sm px-4">Barang diantar langsung ke pintu Anda. Cek kondisi, lalu konfirmasi pesanan selesai.</p>
          </div>

        </div>
      </div>
    </section>

    <!-- Trust / Features Section -->
    <section class="py-24 bg-[#FAFAFA]">
      <div class="max-w-7xl mx-auto px-6">
        <div class="bg-gray-900 rounded-[2.5rem] p-8 md:p-16 overflow-hidden relative reveal opacity-0 translate-y-8 duration-700 ease-out shadow-2xl">
          <!-- Background accent -->
          <div class="absolute -right-20 -top-20 w-96 h-96 bg-indigo-500 rounded-full blur-[100px] opacity-30"></div>
          
          <div class="relative z-10 flex flex-col md:flex-row gap-12 items-center">
            <div class="w-full md:w-1/2">
              <h2 class="text-3xl md:text-5xl font-bold tracking-tight text-white mb-6 leading-tight">
                Transaksi aman tanpa rasa khawatir.
              </h2>
              <p class="text-gray-400 text-lg mb-8 leading-relaxed">
                Kami memastikan setiap transaksi dilindungi oleh sistem rekening bersama. Jika barang tidak sesuai deskripsi, uang Anda kembali 100%.
              </p>
              
              <ul class="space-y-4">
                <li class="flex items-center text-white font-medium">
                  <div class="w-6 h-6 rounded-full bg-green-500/20 text-green-400 flex items-center justify-center mr-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                  </div>
                  Garansi uang kembali
                </li>
                <li class="flex items-center text-white font-medium">
                  <div class="w-6 h-6 rounded-full bg-green-500/20 text-green-400 flex items-center justify-center mr-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                  </div>
                  Customer Support 24/7
                </li>
                <li class="flex items-center text-white font-medium">
                  <div class="w-6 h-6 rounded-full bg-green-500/20 text-green-400 flex items-center justify-center mr-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                  </div>
                  Verifikasi identitas penjual
                </li>
              </ul>
            </div>
            
            <!-- Floating Shield Visual -->
            <div class="w-full md:w-1/2 flex justify-center mt-10 md:mt-0">
              <div class="relative w-64 h-64 md:w-80 md:h-80">
                <div class="absolute inset-0 bg-gradient-to-tr from-indigo-500 to-purple-500 rounded-full opacity-20 animate-pulse"></div>
                <div class="absolute inset-4 bg-white/10 backdrop-blur-md rounded-full border border-white/20 flex items-center justify-center shadow-2xl">
                  <svg class="w-32 h-32 text-white/90" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                </div>
                <div class="absolute -top-4 -right-4 bg-white px-4 py-2 rounded-xl shadow-lg border border-gray-100 flex items-center gap-2 transform rotate-6">
                  <span class="text-xs font-bold text-gray-900">100% Aman</span>
                </div>
                <div class="absolute bottom-10 -left-10 bg-white px-4 py-2 rounded-xl shadow-lg border border-gray-100 flex items-center gap-2 transform -rotate-6">
                  <span class="text-xs font-bold text-gray-900">Verified</span>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>

    <!-- Global CTA -->
    <section class="py-32 mb-10 px-6 max-w-5xl mx-auto text-center reveal opacity-0 translate-y-8 duration-700 ease-out">
      <h2 class="text-4xl md:text-6xl font-extrabold tracking-tight text-gray-900 mb-6">
        Siap berburu barang incaran?
      </h2>
      <p class="text-xl text-gray-500 mb-10 max-w-2xl mx-auto">
        Bergabung dengan ribuan orang lainnya yang telah menemukan penawaran terbaik di PindahTangan.
      </p>
      <a href="{{ route('produk.index') }}" class="inline-flex items-center justify-center px-10 py-5 text-lg font-bold text-white bg-indigo-600 rounded-full hover:bg-gray-900 shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
        Mulai Eksplorasi Sekarang
      </a>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t border-gray-200">
      <div class="max-w-7xl mx-auto px-6 py-12 md:py-16">
        <div class="grid grid-cols-1 md:grid-cols-4 gap-12 md:gap-8">
          
          <!-- Brand -->
          <div class="md:col-span-1">
            <div class="flex items-center gap-2 mb-4">
              <div class="w-6 h-6 bg-indigo-600 rounded flex items-center justify-center">
                <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
              </div>
              <span class="text-lg font-bold">PindahTangan</span>
            </div>
            <p class="text-sm text-gray-500 leading-relaxed">
              Platform jual beli barang preloved berkualitas dengan sistem yang transparan dan aman.
            </p>
          </div>

          <!-- Links group 1 -->
          <div>
            <h4 class="text-sm font-bold text-gray-900 mb-4">Perusahaan</h4>
            <ul class="space-y-3 text-sm text-gray-500">
              <li><a href="#" class="hover:text-indigo-600 transition-colors">Tentang Kami</a></li>
              <li><a href="#" class="hover:text-indigo-600 transition-colors">Karir</a></li>
              <li><a href="#" class="hover:text-indigo-600 transition-colors">Blog</a></li>
            </ul>
          </div>

          <!-- Links group 2 -->
          <div>
            <h4 class="text-sm font-bold text-gray-900 mb-4">Bantuan</h4>
            <ul class="space-y-3 text-sm text-gray-500">
              <li><a href="#" class="hover:text-indigo-600 transition-colors">Pusat Bantuan</a></li>
              <li><a href="#" class="hover:text-indigo-600 transition-colors">Syarat & Ketentuan</a></li>
              <li><a href="#" class="hover:text-indigo-600 transition-colors">Kebijakan Privasi</a></li>
            </ul>
          </div>

          <!-- Social -->
          <div>
            <h4 class="text-sm font-bold text-gray-900 mb-4">Ikuti Kami</h4>
            <div class="flex gap-4">
              <a href="#" class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-indigo-100 hover:text-indigo-600 transition-colors">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"/></svg>
              </a>
              <a href="#" class="w-10 h-10 rounded-full bg-gray-100 flex items-center justify-center text-gray-600 hover:bg-indigo-100 hover:text-indigo-600 transition-colors">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
              </a>
            </div>
          </div>

        </div>
        <div class="mt-12 pt-8 border-t border-gray-100 flex flex-col sm:flex-row justify-between items-center gap-4">
          <p class="text-sm text-gray-500">© {{ date('Y') }} PindahTangan. All rights reserved.</p>
          <div class="flex gap-4">
            <div class="w-10 h-6 bg-gray-200 rounded border border-gray-300"></div>
            <div class="w-10 h-6 bg-gray-200 rounded border border-gray-300"></div>
            <div class="w-10 h-6 bg-gray-200 rounded border border-gray-300"></div>
          </div>
        </div>
      </div>
    </footer>

    <!-- Scroll Animation & Navbar Script -->
    <script>
      document.addEventListener("DOMContentLoaded", () => {
        const observerOptions = {
          root: null,
          rootMargin: "0px",
          threshold: 0.15
        };

        const observer = new IntersectionObserver((entries, observer) => {
          entries.forEach(entry => {
            if (entry.isIntersecting) {
              entry.target.classList.remove('opacity-0', 'translate-y-8', 'translate-y-12');
              entry.target.classList.add('opacity-100', 'translate-y-0');
              observer.unobserve(entry.target);
            }
          });
        }, observerOptions);

        document.querySelectorAll('.reveal').forEach(el => {
          observer.observe(el);
        });

        const nav = document.querySelector('nav');
        window.addEventListener('scroll', () => {
          if (window.scrollY > 20) {
            nav.classList.add('shadow-sm');
          } else {
            nav.classList.remove('shadow-sm');
          }
        });
      });
    </script>

  </body>
</html>