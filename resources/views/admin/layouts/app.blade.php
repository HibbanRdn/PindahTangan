<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'Dashboard') — Admin PindahTangan</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <style>
    /* ── Sidebar transition ── */
    #sidebar { transition: transform 0.3s cubic-bezier(0.22,1,0.36,1); }
    .nav-link { transition: background-color 0.15s ease, color 0.15s ease, padding-left 0.15s ease; }
    .nav-link:hover, .nav-link.active {
      background-color: #f0fdf4;
      color: #059669;
      padding-left: 1.25rem;
    }
    .nav-link.active { font-weight: 700; border-left: 3px solid #059669; }

    /* ── Toast ── */
    @keyframes toastIn  { from { opacity:0; transform:translateX(100%) scale(0.95); } to { opacity:1; transform:translateX(0) scale(1); } }
    @keyframes toastOut { from { opacity:1; } to { opacity:0; transform:translateX(100%); } }
    @keyframes progressBar { from { width:100%; } to { width:0%; } }
    .toast { animation: toastIn 0.4s cubic-bezier(0.22,1,0.36,1) both; overflow:hidden; }
    .toast.hiding { animation: toastOut 0.3s ease forwards; }
    .toast-progress { position:absolute; bottom:0; left:0; height:3px; animation: progressBar 4s linear forwards; }

    /* ── Table hover ── */
    tbody tr { transition: background-color 0.15s ease; }
    tbody tr:hover { background-color: #f9fafb; }

    /* ── Scrollbar kustom ── */
    ::-webkit-scrollbar { width: 5px; height: 5px; }
    ::-webkit-scrollbar-track { background: #f9fafb; }
    ::-webkit-scrollbar-thumb { background: #d1d5db; border-radius: 10px; }
  </style>
</head>
<body class="bg-gray-50 font-sans antialiased">

  <!-- ══ TOAST CONTAINER ══ -->
  <div id="toast-container" class="fixed top-5 right-5 z-[9999] flex flex-col gap-3 pointer-events-none w-80"></div>

  <div class="flex h-screen overflow-hidden">

    <!-- ══ SIDEBAR ══════════════════════════════════════════════ -->
    <aside id="sidebar"
           class="w-64 bg-white border-r border-gray-100 flex flex-col shrink-0 overflow-y-auto
                  fixed lg:static inset-y-0 left-0 z-40
                  -translate-x-full lg:translate-x-0">

      <!-- Logo -->
      <div class="px-6 h-16 flex items-center border-b border-gray-100 shrink-0">
        <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2">
          <img src="{{ asset('images/logo_full.png') }}" alt="PindahTangan" class="h-10 w-auto" />
        </a>
            <!--
            <span class="ml-2 text-[10px] font-black uppercase tracking-widest text-emerald-600 bg-emerald-50 px-1.5 py-0.5 rounded-md">
            Admin
            </span>
            -->
      </div>

      <!-- Nav -->
      <nav class="flex-1 px-3 py-4 space-y-0.5">

        <!-- Dashboard -->
        <a href="{{ route('admin.dashboard') }}"
           class="nav-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm text-gray-600
                  {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
          <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
          </svg>
          Dashboard
        </a>

        <!-- Divider -->
        <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 px-4 pt-4 pb-1">Katalog</p>

        <!-- Produk -->
        <a href="{{ route('admin.produk.index') }}"
           class="nav-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm text-gray-600
                  {{ request()->routeIs('admin.produk.*') ? 'active' : '' }}">
          <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
          </svg>
          Produk
        </a>

        <!-- Divider -->
        <p class="text-[10px] font-black uppercase tracking-widest text-gray-400 px-4 pt-4 pb-1">Transaksi</p>

        <!-- Pesanan -->
        <a href="{{ route('admin.pesanan.index') }}"
           class="nav-link flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm text-gray-600
                  {{ request()->routeIs('admin.pesanan.*') ? 'active' : '' }}">
          <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
              d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
          </svg>
          Pesanan
        </a>

      </nav>

      <!-- Footer sidebar — info user -->
      <div class="px-4 py-4 border-t border-gray-100">
        <div class="flex items-center gap-3">
          <div class="w-8 h-8 rounded-full bg-emerald-600 flex items-center justify-center text-white text-xs font-black shrink-0">
            {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
          </div>
          <div class="min-w-0">
            <p class="text-sm font-bold text-gray-900 truncate">{{ auth()->user()->name }}</p>
            <p class="text-[10px] text-gray-400 uppercase tracking-widest">Admin</p>
          </div>
          <form method="POST" action="{{ route('logout') }}" class="ml-auto shrink-0">
            @csrf
            <button type="submit" title="Keluar"
              class="w-7 h-7 flex items-center justify-center text-gray-400 hover:text-red-500 transition-colors">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
              </svg>
            </button>
          </form>
        </div>
      </div>

    </aside>

    <!-- ══ MAIN CONTENT ══════════════════════════════════════════ -->
    <div class="flex-1 flex flex-col min-w-0 overflow-hidden">

      <!-- Topbar -->
      <header class="bg-white border-b border-gray-100 h-16 flex items-center px-6 gap-4 shrink-0">
        <!-- Hamburger (mobile) -->
        <button onclick="toggleSidebar()"
          class="lg:hidden w-9 h-9 flex items-center justify-center rounded-xl hover:bg-gray-100 transition-colors">
          <svg class="w-5 h-5 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
          </svg>
        </button>

        <!-- Breadcrumb / Page title -->
        <div class="flex items-center gap-2 text-sm text-gray-500">
          <a href="{{ route('admin.dashboard') }}" class="hover:text-gray-900 transition-colors">Admin</a>
          @hasSection('breadcrumb')
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            @yield('breadcrumb')
          @endif
        </div>

        <div class="ml-auto flex items-center gap-3">
          <!-- Link ke storefront -->
          <a href="{{ route('produk.index') }}" target="_blank"
             class="hidden md:inline-flex items-center gap-1.5 text-xs text-gray-500 hover:text-emerald-600 transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
            </svg>
            Lihat Toko
          </a>
        </div>
      </header>

      <!-- Page Content -->
      <main class="flex-1 overflow-y-auto p-6">
        @yield('content')
      </main>

    </div>
  </div>

  <!-- Overlay mobile sidebar -->
  <div id="sidebar-overlay"
       class="fixed inset-0 bg-black/40 z-30 hidden lg:hidden"
       onclick="toggleSidebar()"></div>

  <script>
    // ── Sidebar toggle (mobile) ───────────────────────────────────
    function toggleSidebar() {
      const sidebar  = document.getElementById('sidebar');
      const overlay  = document.getElementById('sidebar-overlay');
      const isOpen   = !sidebar.classList.contains('-translate-x-full');
      sidebar.classList.toggle('-translate-x-full', isOpen);
      overlay.classList.toggle('hidden', isOpen);
    }

    // ── Toast System ──────────────────────────────────────────────
    function showToast(type, title, message = '') {
      const container = document.getElementById('toast-container');
      const cfg = {
        success: { bg: 'bg-white border-emerald-200', icon: 'bg-emerald-500', bar: 'bg-emerald-400',
          svg: `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>` },
        error:   { bg: 'bg-white border-red-200',     icon: 'bg-red-500',     bar: 'bg-red-400',
          svg: `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>` },
        warning: { bg: 'bg-white border-amber-200',   icon: 'bg-amber-500',   bar: 'bg-amber-400',
          svg: `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v4m0 4h.01"/>` },
        info:    { bg: 'bg-white border-blue-200',    icon: 'bg-blue-500',    bar: 'bg-blue-400',
          svg: `<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>` },
      };
      const c = cfg[type] || cfg.info;
      const el = document.createElement('div');
      el.className = `toast pointer-events-auto relative border rounded-2xl p-4 shadow-lg flex items-start gap-3 ${c.bg}`;
      el.innerHTML = `
        <div class="w-8 h-8 rounded-full ${c.icon} flex items-center justify-center shrink-0">
          <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">${c.svg}</svg>
        </div>
        <div class="flex-1 min-w-0">
          <p class="text-sm font-bold text-gray-900">${title}</p>
          ${message ? `<p class="text-xs text-gray-500 mt-0.5 leading-relaxed">${message}</p>` : ''}
        </div>
        <button onclick="dismissToast(this.closest('.toast'))" class="text-gray-300 hover:text-gray-500 transition-colors">
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
          </svg>
        </button>
        <div class="toast-progress ${c.bar} rounded-full"></div>`;
      container.appendChild(el);
      setTimeout(() => dismissToast(el), 4200);
    }

    function dismissToast(el) {
      if (!el || el.classList.contains('hiding')) return;
      el.classList.add('hiding');
      setTimeout(() => el.remove(), 300);
    }

    // ── Auto-show flash session ───────────────────────────────────
    document.addEventListener('DOMContentLoaded', () => {
      @if(session('success'))
        showToast('success', 'Berhasil', @json(session('success')));
      @endif
      @if(session('error'))
        showToast('error', 'Gagal', @json(session('error')));
      @endif
      @if(session('info'))
        showToast('info', 'Info', @json(session('info')));
      @endif
      @if(session('warning'))
        showToast('warning', 'Perhatian', @json(session('warning')));
      @endif
    });
  </script>

  @stack('scripts')
</body>
</html>