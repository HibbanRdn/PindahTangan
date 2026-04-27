<!DOCTYPE html>
<html lang="id" class="h-full">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>@yield('title', 'Dashboard') — PindahTangan Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com" />
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet" />
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <style>
    *, *::before, *::after { box-sizing: border-box; }

    :root {
      --sidebar-w: 260px;
      --topbar-h: 60px;
      --sidebar-bg: #0D1117;
      --sidebar-border: rgba(255,255,255,0.06);
      --sidebar-text: #8B949E;
      --sidebar-text-hover: #E6EDF3;
      --sidebar-active-bg: rgba(16,185,129,0.12);
      --sidebar-active-text: #10B981;
      --page-bg: #F1F5F9;
      --card-bg: #FFFFFF;
      --border: #E2E8F0;
      --border-light: #F1F5F9;
      --text-1: #0F172A;
      --text-2: #475569;
      --text-3: #94A3B8;
      --accent: #10B981;
      --accent-50: #ECFDF5;
      --accent-600: #059669;
      --danger: #EF4444;
      --warning: #F59E0B;
      --info: #3B82F6;
      --radius: 10px;
      --shadow-sm: 0 1px 2px 0 rgba(0,0,0,0.05);
      --shadow: 0 1px 3px 0 rgba(0,0,0,0.07), 0 1px 2px -1px rgba(0,0,0,0.07);
      --shadow-md: 0 4px 6px -1px rgba(0,0,0,0.07), 0 2px 4px -2px rgba(0,0,0,0.07);
    }

    html, body { height: 100%; margin: 0; }
    body {
      font-family: 'Plus Jakarta Sans', sans-serif;
      background: var(--page-bg);
      color: var(--text-1);
      -webkit-font-smoothing: antialiased;
    }

    /* ── Layout Shell ─────────────────────────────── */
    .admin-shell { display: flex; height: 100vh; overflow: hidden; }

    /* ── Sidebar ──────────────────────────────────── */
    .sidebar {
      width: var(--sidebar-w);
      background: var(--sidebar-bg);
      display: flex;
      flex-direction: column;
      flex-shrink: 0;
      position: fixed;
      inset: 0 auto 0 0;
      z-index: 40;
      border-right: 1px solid var(--sidebar-border);
      transform: translateX(0);
      transition: transform .28s cubic-bezier(.4,0,.2,1);
      overflow-y: auto;
      overflow-x: hidden;
    }
    .sidebar::-webkit-scrollbar { width: 0; }
    @media (max-width: 1023px) {
      .sidebar { transform: translateX(-100%); }
      .sidebar.open { transform: translateX(0); }
    }

    .sidebar-logo {
      height: var(--topbar-h);
      display: flex;
      align-items: center;
      padding: 0 20px;
      border-bottom: 1px solid var(--sidebar-border);
      flex-shrink: 0;
    }
    .sidebar-logo img { height: 26px; width: auto; filter: brightness(0) invert(1); opacity: .9; }
    .sidebar-badge {
      margin-left: 8px;
      font-size: 9px;
      font-weight: 700;
      letter-spacing: .08em;
      text-transform: uppercase;
      background: rgba(16,185,129,.18);
      color: #10B981;
      padding: 2px 7px;
      border-radius: 20px;
      border: 1px solid rgba(16,185,129,.25);
    }

    .sidebar-nav { flex: 1; padding: 16px 12px; }
    .sidebar-section-label {
      font-size: 10px;
      font-weight: 700;
      letter-spacing: .1em;
      text-transform: uppercase;
      color: rgba(255,255,255,.2);
      padding: 12px 10px 6px;
    }
    .nav-item {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 9px 10px;
      border-radius: 8px;
      font-size: 13.5px;
      font-weight: 500;
      color: var(--sidebar-text);
      text-decoration: none;
      transition: all .15s ease;
      position: relative;
      margin-bottom: 1px;
    }
    .nav-item:hover { background: rgba(255,255,255,.05); color: var(--sidebar-text-hover); }
    .nav-item.active {
      background: var(--sidebar-active-bg);
      color: var(--sidebar-active-text);
      font-weight: 600;
    }
    .nav-item.active::before {
      content: '';
      position: absolute;
      left: 0;
      top: 6px; bottom: 6px;
      width: 2.5px;
      border-radius: 0 2px 2px 0;
      background: var(--sidebar-active-text);
    }
    .nav-item svg { width: 16px; height: 16px; flex-shrink: 0; opacity: .8; }
    .nav-item.active svg { opacity: 1; }

    .sidebar-footer {
      padding: 12px;
      border-top: 1px solid var(--sidebar-border);
      flex-shrink: 0;
    }
    .sidebar-user {
      display: flex;
      align-items: center;
      gap: 10px;
      padding: 8px 10px;
      border-radius: 8px;
    }
    .sidebar-avatar {
      width: 32px; height: 32px;
      border-radius: 50%;
      background: linear-gradient(135deg, #10B981, #059669);
      display: flex; align-items: center; justify-content: center;
      font-size: 13px; font-weight: 700; color: white; flex-shrink: 0;
    }
    .sidebar-user-name { font-size: 13px; font-weight: 600; color: #E6EDF3; line-height: 1.3; }
    .sidebar-user-role { font-size: 10.5px; color: var(--sidebar-text); }
    .btn-logout {
      margin-left: auto;
      width: 30px; height: 30px;
      display: flex; align-items: center; justify-content: center;
      border-radius: 6px;
      color: var(--sidebar-text);
      transition: all .15s;
      cursor: pointer;
      background: transparent;
      border: none;
    }
    .btn-logout:hover { color: #EF4444; background: rgba(239,68,68,.1); }
    .btn-logout svg { width: 15px; height: 15px; }

    /* ── Main Area ────────────────────────────────── */
    .main-area {
      flex: 1;
      display: flex;
      flex-direction: column;
      min-width: 0;
      margin-left: var(--sidebar-w);
      overflow: hidden;
    }
    @media (max-width: 1023px) { .main-area { margin-left: 0; } }

    /* ── Topbar ───────────────────────────────────── */
    .topbar {
      height: var(--topbar-h);
      background: var(--card-bg);
      border-bottom: 1px solid var(--border);
      display: flex;
      align-items: center;
      padding: 0 24px;
      gap: 16px;
      flex-shrink: 0;
    }
    .btn-hamburger {
      display: none;
      align-items: center; justify-content: center;
      width: 36px; height: 36px;
      border-radius: 8px;
      border: none;
      background: transparent;
      cursor: pointer;
      color: var(--text-2);
      transition: background .15s;
    }
    .btn-hamburger:hover { background: var(--page-bg); }
    @media (max-width: 1023px) { .btn-hamburger { display: flex; } }
    .btn-hamburger svg { width: 18px; height: 18px; }

    .breadcrumb {
      display: flex;
      align-items: center;
      gap: 6px;
      font-size: 13px;
      color: var(--text-3);
    }
    .breadcrumb a { color: var(--text-3); text-decoration: none; transition: color .15s; }
    .breadcrumb a:hover { color: var(--text-1); }
    .breadcrumb span { color: var(--text-1); font-weight: 600; }
    .breadcrumb svg { width: 12px; height: 12px; flex-shrink: 0; }

    .topbar-right { margin-left: auto; display: flex; align-items: center; gap: 8px; }
    .topbar-link {
      font-size: 12.5px;
      font-weight: 500;
      color: var(--text-3);
      text-decoration: none;
      display: flex; align-items: center; gap: 5px;
      padding: 6px 12px;
      border-radius: 7px;
      border: 1px solid var(--border);
      transition: all .15s;
    }
    .topbar-link:hover { color: var(--accent); border-color: var(--accent); background: var(--accent-50); }
    .topbar-link svg { width: 13px; height: 13px; }

    /* ── Page Content ─────────────────────────────── */
    .page-content { flex: 1; overflow-y: auto; padding: 28px; }
    .page-content::-webkit-scrollbar { width: 5px; }
    .page-content::-webkit-scrollbar-track { background: transparent; }
    .page-content::-webkit-scrollbar-thumb { background: #CBD5E1; border-radius: 10px; }

    /* ── Cards ────────────────────────────────────── */
    .card {
      background: var(--card-bg);
      border: 1px solid var(--border);
      border-radius: var(--radius);
      box-shadow: var(--shadow-sm);
    }
    .card-header {
      padding: 16px 20px;
      border-bottom: 1px solid var(--border-light);
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 12px;
    }
    .card-title {
      font-size: 13px;
      font-weight: 700;
      color: var(--text-1);
      letter-spacing: .01em;
    }

    /* ── Tables ───────────────────────────────────── */
    .data-table { width: 100%; border-collapse: collapse; font-size: 13.5px; }
    .data-table thead th {
      padding: 11px 16px;
      text-align: left;
      font-size: 11px;
      font-weight: 700;
      letter-spacing: .06em;
      text-transform: uppercase;
      color: var(--text-3);
      background: #FAFBFC;
      border-bottom: 1px solid var(--border);
      white-space: nowrap;
    }
    .data-table tbody tr {
      border-bottom: 1px solid var(--border-light);
      transition: background .1s;
    }
    .data-table tbody tr:last-child { border-bottom: none; }
    .data-table tbody tr:hover { background: #FAFBFC; }
    .data-table tbody td { padding: 13px 16px; color: var(--text-1); vertical-align: middle; }

    /* ── Badges ───────────────────────────────────── */
    .badge {
      display: inline-flex; align-items: center; gap: 4px;
      padding: 3px 9px;
      border-radius: 20px;
      font-size: 11px;
      font-weight: 600;
      line-height: 1.4;
    }
    .badge-green  { background: #DCFCE7; color: #15803D; }
    .badge-gray   { background: #F1F5F9; color: #475569; }
    .badge-red    { background: #FEE2E2; color: #B91C1C; }
    .badge-yellow { background: #FEF9C3; color: #854D0E; }
    .badge-blue   { background: #DBEAFE; color: #1D4ED8; }
    .badge-teal   { background: #CCFBF1; color: #0F766E; }
    .badge-purple { background: #F3E8FF; color: #7E22CE; }
    .badge-orange { background: #FFEDD5; color: #9A3412; }

    /* ── Buttons ──────────────────────────────────── */
    .btn {
      display: inline-flex; align-items: center; gap: 7px;
      padding: 8px 16px;
      border-radius: 8px;
      font-size: 13px;
      font-weight: 600;
      cursor: pointer;
      text-decoration: none;
      transition: all .15s;
      border: none;
      white-space: nowrap;
    }
    .btn svg { width: 15px; height: 15px; flex-shrink: 0; }
    .btn-primary { background: var(--text-1); color: white; }
    .btn-primary:hover { background: var(--accent-600); }
    .btn-ghost { background: transparent; color: var(--text-2); border: 1px solid var(--border); }
    .btn-ghost:hover { background: var(--page-bg); color: var(--text-1); }
    .btn-danger { background: #FEE2E2; color: #B91C1C; border: 1px solid #FECACA; }
    .btn-danger:hover { background: #EF4444; color: white; }
    .btn-sm { padding: 6px 12px; font-size: 12.5px; }
    .btn-icon { padding: 7px; border-radius: 7px; }

    /* ── Form Elements ────────────────────────────── */
    .form-label {
      display: block;
      font-size: 12px;
      font-weight: 600;
      color: var(--text-2);
      margin-bottom: 6px;
      letter-spacing: .01em;
    }
    .form-label .req { color: var(--danger); margin-left: 2px; }
    .form-label .hint { font-weight: 400; color: var(--text-3); }
    .form-input, .form-select, .form-textarea {
      width: 100%;
      padding: 9px 13px;
      border: 1px solid var(--border);
      border-radius: 8px;
      font-size: 13.5px;
      font-family: inherit;
      color: var(--text-1);
      background: var(--card-bg);
      transition: border-color .15s, box-shadow .15s;
      outline: none;
    }
    .form-input:focus, .form-select:focus, .form-textarea:focus {
      border-color: var(--accent);
      box-shadow: 0 0 0 3px rgba(16,185,129,.12);
    }
    .form-input.error, .form-select.error, .form-textarea.error {
      border-color: var(--danger);
    }
    .form-input.error:focus, .form-select.error:focus, .form-textarea.error:focus {
      box-shadow: 0 0 0 3px rgba(239,68,68,.12);
    }
    .form-error { margin-top: 5px; font-size: 12px; color: var(--danger); display: flex; align-items: center; gap: 4px; }
    .form-textarea { resize: vertical; }

    /* ── Skeleton ─────────────────────────────────── */
    @keyframes shimmer {
      0%   { background-position: -600px 0; }
      100% { background-position: 600px 0; }
    }
    .skeleton-block {
      background: linear-gradient(90deg, #F1F5F9 25%, #E8EDF2 50%, #F1F5F9 75%);
      background-size: 600px 100%;
      animation: shimmer 1.4s infinite linear;
      border-radius: 6px;
    }
    .skeleton-row td { padding: 14px 16px; }
    .sk-line { height: 13px; display: block; }
    .sk-avatar { width: 36px; height: 36px; border-radius: 8px; display: inline-block; }
    .sk-badge { width: 64px; height: 22px; border-radius: 20px; display: inline-block; }
    .sk-btn { width: 48px; height: 28px; border-radius: 7px; display: inline-block; }

    /* Real table fade in */
    #real-content { opacity: 0; transition: opacity .3s ease; }
    #real-content.visible { opacity: 1; }
    #skeleton-content { transition: opacity .2s ease; }
    #skeleton-content.hidden { opacity: 0; pointer-events: none; }

    /* ── Toast ────────────────────────────────────── */
    @keyframes slideInRight { from { opacity:0; transform:translateX(20px); } to { opacity:1; transform:translateX(0); } }
    @keyframes slideOutRight { from { opacity:1; transform:translateX(0); } to { opacity:0; transform:translateX(20px); } }
    .toast-container { position: fixed; top: 20px; right: 20px; z-index: 9999; display: flex; flex-direction: column; gap: 10px; pointer-events: none; }
    .toast {
      pointer-events: all;
      background: var(--card-bg);
      border: 1px solid var(--border);
      border-radius: 10px;
      padding: 14px 16px;
      display: flex;
      align-items: flex-start;
      gap: 12px;
      width: 320px;
      box-shadow: var(--shadow-md);
      animation: slideInRight .3s ease both;
      position: relative;
      overflow: hidden;
    }
    .toast.hiding { animation: slideOutRight .25s ease forwards; }
    .toast-icon { width: 32px; height: 32px; border-radius: 8px; display: flex; align-items: center; justify-content: center; flex-shrink: 0; }
    .toast-icon svg { width: 15px; height: 15px; }
    .toast-title { font-size: 13px; font-weight: 700; color: var(--text-1); }
    .toast-msg { font-size: 12.5px; color: var(--text-2); margin-top: 2px; line-height: 1.45; }
    .toast-close { margin-left: auto; flex-shrink: 0; width: 22px; height: 22px; border-radius: 5px; border: none; background: transparent; cursor: pointer; display: flex; align-items: center; justify-content: center; color: var(--text-3); }
    .toast-close:hover { background: var(--page-bg); color: var(--text-1); }
    .toast-close svg { width: 12px; height: 12px; }
    .toast-progress { position: absolute; bottom: 0; left: 0; right: 0; height: 2px; }
    .toast-progress-bar { height: 100%; animation: progressShrink 4s linear forwards; }
    @keyframes progressShrink { from { width: 100%; } to { width: 0%; } }

    /* ── Modal ────────────────────────────────────── */
    .modal-overlay {
      position: fixed; inset: 0;
      background: rgba(0,0,0,.45);
      z-index: 50;
      display: none;
      align-items: center;
      justify-content: center;
      padding: 20px;
    }
    .modal-overlay.open { display: flex; }
    .modal-box {
      background: var(--card-bg);
      border-radius: 14px;
      padding: 28px;
      max-width: 420px;
      width: 100%;
      box-shadow: 0 20px 60px rgba(0,0,0,.15);
      animation: modalIn .2s ease both;
    }
    @keyframes modalIn { from { opacity:0; transform:scale(.96); } to { opacity:1; transform:scale(1); } }

    /* ── Misc Utilities ───────────────────────────── */
    .divider { height: 1px; background: var(--border-light); margin: 0; }
    .text-muted { color: var(--text-3); }
    .text-secondary { color: var(--text-2); }
    .font-mono { font-family: 'SF Mono', 'Fira Code', monospace; }
    .truncate { overflow: hidden; text-overflow: ellipsis; white-space: nowrap; }

    /* ── Sidebar Overlay (mobile) ─────────────────── */
    .sidebar-overlay {
      position: fixed; inset: 0;
      background: rgba(0,0,0,.5);
      z-index: 39;
      display: none;
    }
    .sidebar-overlay.visible { display: block; }
  </style>
</head>
<body>

<div id="toast-container" class="toast-container"></div>

<div class="admin-shell">

  {{-- ══ SIDEBAR ══════════════════════════════════════ --}}
  <aside class="sidebar" id="sidebar">

    <div class="sidebar-logo">
      <a href="{{ route('admin.dashboard') }}" style="display:flex;align-items:center;gap:8px;text-decoration:none;">
        <img src="{{ asset('images/logo_full.png') }}" alt="PindahTangan" height="40" />
      </a>
    </div>

    <nav class="sidebar-nav">

      <a href="{{ route('admin.dashboard') }}"
         class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v5a1 1 0 01-1 1H5a1 1 0 01-1-1V5zm10 0a1 1 0 011-1h4a1 1 0 011 1v2a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zm10-3a1 1 0 011-1h4a1 1 0 011 1v7a1 1 0 01-1 1h-4a1 1 0 01-1-1v-7z"/></svg>
        Dashboard
      </a>

      <div class="sidebar-section-label">Katalog</div>

      <a href="{{ route('admin.produk.index') }}"
         class="nav-item {{ request()->routeIs('admin.produk.*') ? 'active' : '' }}">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
        Produk
      </a>

      <div class="sidebar-section-label">Transaksi</div>

      <a href="{{ route('admin.pesanan.index') }}"
         class="nav-item {{ request()->routeIs('admin.pesanan.*') ? 'active' : '' }}">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        Pesanan
      </a>

    </nav>

    <div class="sidebar-footer">
      <div class="sidebar-user">
        <div class="sidebar-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</div>
        <div style="min-width:0;">
          <div class="sidebar-user-name truncate">{{ auth()->user()->name }}</div>
          <div class="sidebar-user-role">Administrator</div>
        </div>
        <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="btn-logout" title="Keluar">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
          </button>
        </form>
      </div>
    </div>

  </aside>

  {{-- Mobile sidebar overlay --}}
  <div class="sidebar-overlay" id="sidebar-overlay" onclick="closeSidebar()"></div>

  {{-- ══ MAIN AREA ═════════════════════════════════════ --}}
  <div class="main-area">

    {{-- Topbar --}}
    <header class="topbar">
      <button class="btn-hamburger" onclick="toggleSidebar()">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
      </button>

      <nav class="breadcrumb">
        <a href="{{ route('admin.dashboard') }}">Admin</a>
        @hasSection('breadcrumb')
          <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
          @yield('breadcrumb')
        @endif
      </nav>

      <div class="topbar-right">
        <a href="{{ route('produk.index') }}" target="_blank" class="topbar-link">
          <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
          Lihat Toko
        </a>
      </div>
    </header>

    {{-- Page Content --}}
    <main class="page-content">
      @yield('content')
    </main>

  </div>
</div>

<script>
  // ── Sidebar toggle ──────────────────────────────────
  function toggleSidebar() {
    const s = document.getElementById('sidebar');
    const o = document.getElementById('sidebar-overlay');
    s.classList.toggle('open');
    o.classList.toggle('visible');
  }
  function closeSidebar() {
    document.getElementById('sidebar').classList.remove('open');
    document.getElementById('sidebar-overlay').classList.remove('visible');
  }

  // ── Skeleton Loading ────────────────────────────────
  document.addEventListener('DOMContentLoaded', () => {
    const real = document.getElementById('real-content');
    const skel = document.getElementById('skeleton-content');
    if (real && skel) {
      setTimeout(() => {
        skel.classList.add('hidden');
        real.classList.add('visible');
      }, 420);
    }
  });

  // ── Toast System ────────────────────────────────────
  const toastIcons = {
    success: { bg: '#DCFCE7', color: '#15803D', svg: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/>' },
    error:   { bg: '#FEE2E2', color: '#B91C1C', svg: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>' },
    warning: { bg: '#FEF9C3', color: '#854D0E', svg: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 9v4m0 4h.01"/>' },
    info:    { bg: '#DBEAFE', color: '#1D4ED8', svg: '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M13 16h-1v-4h-1m1-4h.01"/>' },
  };

  function showToast(type, title, message = '') {
    const c = toastIcons[type] || toastIcons.info;
    const el = document.createElement('div');
    el.className = 'toast';
    el.innerHTML = `
      <div class="toast-icon" style="background:${c.bg};color:${c.color};">
        <svg fill="none" stroke="${c.color}" viewBox="0 0 24 24">${c.svg}</svg>
      </div>
      <div style="flex:1;min-width:0;">
        <div class="toast-title">${title}</div>
        ${message ? `<div class="toast-msg">${message}</div>` : ''}
      </div>
      <button class="toast-close" onclick="dismissToast(this.closest('.toast'))">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
      </button>
      <div class="toast-progress"><div class="toast-progress-bar" style="background:${c.color}"></div></div>`;
    document.getElementById('toast-container').appendChild(el);
    setTimeout(() => dismissToast(el), 4400);
  }

  function dismissToast(el) {
    if (!el || el.classList.contains('hiding')) return;
    el.classList.add('hiding');
    setTimeout(() => el.remove(), 280);
  }

  document.addEventListener('DOMContentLoaded', () => {
    @if(session('success')) showToast('success', 'Berhasil', @json(session('success'))); @endif
    @if(session('error'))   showToast('error',   'Gagal',    @json(session('error')));   @endif
    @if(session('info'))    showToast('info',     'Info',     @json(session('info')));    @endif
    @if(session('warning')) showToast('warning',  'Perhatian',@json(session('warning'))); @endif
  });
</script>

@stack('scripts')
</body>
</html>