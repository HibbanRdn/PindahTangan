<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Katalog Produk — PindahTangan</title>
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:opsz,wght@9..40,400;9..40,500;9..40,700;9..40,800&family=Plus+Jakarta+Sans:ital,wght@0,400;0,600;0,700;0,800;1,400;1,600&family=Cormorant+Garamond:ital,wght@0,400;0,600;1,400;1,600&display=swap" rel="stylesheet">

  <style>
    /* ─────────────────────────────────────────────────
       TOKENS
    ───────────────────────────────────────────────── */
    :root {
      --emerald:      #10b981;
      --emerald-600:  #059669;
      --emerald-700:  #047857;
      --emerald-50:   #ecfdf5;
      --emerald-100:  #d1fae5;
      --gray-900:     #111827;
      --gray-800:     #1f2937;
      --gray-700:     #374151;
      --gray-500:     #6b7280;
      --gray-400:     #9ca3af;
      --gray-100:     #f3f4f6;
      --gray-50:      #f9fafb;
      --border:       #e5e7eb;
      --border-light: #f3f4f6;
      --white:        #ffffff;

      --nav-height-top:    104px; /* row1 64px + row2 40px */
      --island-height:     52px;
      --island-top:        16px;

      --transition-nav:    220ms cubic-bezier(0.4, 0, 0.2, 1);
      --transition-spring: 380ms cubic-bezier(0.34, 1.56, 0.64, 1);
      --transition-smooth: 300ms cubic-bezier(0.22, 1, 0.36, 1);
    }

    *, *::before, *::after { box-sizing: border-box; }

    html { scroll-behavior: smooth; }

    body {
      font-family: 'DM Sans', sans-serif;
      background: var(--gray-50);
      color: var(--gray-900);
      margin: 0;
      -webkit-font-smoothing: antialiased;
    }

    .jakarta   { font-family: 'Plus Jakarta Sans', sans-serif; }
    .cormorant { font-family: 'Cormorant Garamond', serif; }

    /* ─────────────────────────────────────────────────
       NAVIGATION SYSTEM — TOP STATE
    ───────────────────────────────────────────────── */
    #nav-system {
      position: fixed;
      top: 0;
      left: 0;
      right: 0;
      z-index: 60;
      transition: transform var(--transition-nav), opacity var(--transition-nav);
    }

    #nav-system.state-top {
      transform: translateY(0);
      opacity: 1;
      pointer-events: all;
    }

    #nav-system.state-hidden {
      transform: translateY(-100%);
      opacity: 0;
      pointer-events: none;
    }

    /* Row 1 — main nav bar */
    .nav-row1 {
      height: 64px;
      background: rgba(255, 255, 255, 0.92);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      border-bottom: 1px solid var(--border-light);
      display: flex;
      align-items: center;
      justify-content: center;   /* ← centering outer row */
      padding: 0 24px;
    }

    /* ── NEW: inner wrapper untuk centering & justify konten ── */
    .nav-inner {
      width: 100%;
      max-width: 1280px;
      display: flex;
      align-items: center;
      gap: 12px;
      justify-content: space-between; /* ← logo kiri, actions kanan */
    }

    /* Search wrap flex di tengah */
    .nav-inner .nav-search-wrap {
      flex: 1;
      min-width: 0;
    }

    .nav-logo {
      flex-shrink: 0;
      display: flex;
      align-items: center;
      text-decoration: none;
    }
    .nav-logo img { height: 36px; width: auto; }

    /* Inline search bar */
    .nav-search-wrap {
      flex: 1;
      position: relative;
      max-width: 480px;
    }
    .nav-search-icon {
      position: absolute;
      left: 13px;
      top: 50%;
      transform: translateY(-50%);
      width: 15px;
      height: 15px;
      color: var(--gray-400);
      pointer-events: none;
    }
    .nav-search-input {
      width: 100%;
      padding: 9px 14px 9px 38px;
      background: var(--gray-50);
      border: 1.5px solid var(--border);
      border-radius: 10px;
      font-size: 13.5px;
      font-family: 'DM Sans', sans-serif;
      color: var(--gray-900);
      outline: none;
      transition: border-color 0.2s, box-shadow 0.2s, background 0.2s;
    }
    .nav-search-input::placeholder { color: var(--gray-400); }
    .nav-search-input:focus {
      border-color: var(--emerald);
      background: var(--white);
      box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.10);
    }

    /* Filter controls in nav */
    .nav-controls {
      display: flex;
      align-items: center;
      gap: 8px;
      flex-shrink: 0;
    }

    .nav-select {
      padding: 8px 12px;
      border: 1.5px solid var(--border);
      border-radius: 9px;
      font-size: 12.5px;
      font-weight: 600;
      font-family: 'DM Sans', sans-serif;
      color: var(--gray-700);
      background: var(--white);
      outline: none;
      cursor: pointer;
      transition: border-color 0.2s, box-shadow 0.2s;
      appearance: none;
      -webkit-appearance: none;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%239ca3af' viewBox='0 0 24 24'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 10px center;
      padding-right: 28px;
    }
    .nav-select:focus {
      border-color: var(--emerald);
      box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.10);
    }
    .nav-select.has-value {
      border-color: var(--emerald);
      background-color: var(--emerald-50);
      color: var(--emerald-700);
    }

    .nav-btn-search {
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 8px 16px;
      background: var(--gray-900);
      color: var(--white);
      border: none;
      border-radius: 9px;
      font-size: 12.5px;
      font-weight: 700;
      font-family: 'DM Sans', sans-serif;
      cursor: pointer;
      gap: 6px;
      flex-shrink: 0;
      transition: background 0.2s, transform 0.15s;
    }
    .nav-btn-search:hover { background: var(--emerald-600); transform: translateY(-1px); }
    .nav-btn-search svg { width: 13px; height: 13px; }

    .nav-actions {
      display: flex;
      align-items: center;
      gap: 6px;
      flex-shrink: 0;
      margin-left: 4px;
    }

    .nav-icon-btn {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      background: transparent;
      border: 1.5px solid var(--border);
      color: var(--gray-500);
      cursor: pointer;
      text-decoration: none;
      transition: all 0.2s;
      flex-shrink: 0;
    }
    .nav-icon-btn:hover { background: var(--gray-50); color: var(--gray-900); border-color: var(--gray-300); }
    .nav-icon-btn svg { width: 15px; height: 15px; }

    .nav-reset-link {
      display: flex;
      align-items: center;
      gap: 5px;
      font-size: 12px;
      font-weight: 600;
      color: var(--gray-400);
      text-decoration: none;
      transition: color 0.2s;
      white-space: nowrap;
      padding: 6px 4px;
    }
    .nav-reset-link:hover { color: #ef4444; }
    .nav-reset-link svg { width: 12px; height: 12px; }

    /* Row 2 — category strip */
    .nav-row2 {
      height: 40px;
      background: rgba(255, 255, 255, 0.96);
      backdrop-filter: blur(16px);
      -webkit-backdrop-filter: blur(16px);
      border-bottom: 1px solid var(--border);
      display: flex;
      align-items: center;
      justify-content: center;   /* ← centering outer row */
      overflow: hidden;          /* ← clip, scroll ada di inner */
    }

    /* ── NEW: scrollable inner untuk category chips ── */
    .nav-row2-inner {
      width: 100%;
      max-width: 1280px;
      display: flex;
      align-items: center;
      gap: 8px;
      padding: 0 24px;
      overflow-x: auto;
      scrollbar-width: none;
      -webkit-overflow-scrolling: touch;
    }
    .nav-row2-inner::-webkit-scrollbar { display: none; }

    .cat-chip {
      display: inline-flex;
      align-items: center;
      padding: 4px 14px;
      border: 1.5px solid var(--border);
      border-radius: 99px;
      font-size: 12px;
      font-weight: 600;
      color: var(--gray-700);
      background: var(--white);
      cursor: pointer;
      text-decoration: none;
      white-space: nowrap;
      flex-shrink: 0;            /* ← jangan menyusut, agar scroll aktif */
      transition: all 0.18s;
    }
    .cat-chip:hover {
      border-color: var(--emerald);
      color: var(--emerald-600);
      background: var(--emerald-50);
    }
    .cat-chip.active {
      border-color: var(--emerald-600);
      background: var(--emerald-600);
      color: var(--white);
    }

    /* ─────────────────────────────────────────────────
       DYNAMIC ISLAND
    ───────────────────────────────────────────────── */
    #dynamic-island {
      position: fixed;
      top: var(--island-top);
      left: 50%;
      transform: translateX(-50%) translateY(-80px) scale(0.9);
      z-index: 60;
      opacity: 0;
      pointer-events: none;
      transition:
        transform var(--transition-spring),
        opacity var(--transition-smooth);
    }

    #dynamic-island.visible {
      transform: translateX(-50%) translateY(0) scale(1);
      opacity: 1;
      pointer-events: all;
    }

    .island-pill {
      display: flex;
      align-items: center;
      gap: 4px;
      padding: 6px 10px;
      background: rgba(255, 255, 255, 0.96);     /* ← putih */
      backdrop-filter: blur(20px);
      -webkit-backdrop-filter: blur(20px);
      border-radius: 99px;
      box-shadow:
        0 4px 24px rgba(0, 0, 0, 0.10),
        0 1px 4px rgba(0, 0, 0, 0.06),
        inset 0 1px 0 rgba(255, 255, 255, 0.9);
      border: 1.5px solid var(--border);          /* ← border abu tipis */
    }

    .island-logo {
      display: flex;
      align-items: center;
      padding: 0 6px;
      text-decoration: none;
    }
    .island-logo img {
      height: 22px;
      width: auto;
      /* tidak perlu invert, background sudah putih */
    }

    .island-divider {
      width: 1px;
      height: 20px;
      background: var(--border);          /* ← abu terang di background putih */
      flex-shrink: 0;
      margin: 0 2px;
    }

    .island-btn {
      width: 36px;
      height: 36px;
      border-radius: 50%;
      display: flex;
      align-items: center;
      justify-content: center;
      background: transparent;
      border: none;
      color: var(--gray-500);             /* ← ikon abu di background putih */
      cursor: pointer;
      text-decoration: none;
      transition: background 0.18s, color 0.18s, transform 0.18s;
      position: relative;
      flex-shrink: 0;
    }
    .island-btn:hover {
      background: var(--emerald-50);      /* ← hover hijau muda */
      color: var(--emerald-600);          /* ← ikon hijau saat hover */
      transform: scale(1.08);
    }
    .island-btn:active { transform: scale(0.94); }
    .island-btn svg { width: 16px; height: 16px; }

    .island-btn .dot {
      position: absolute;
      top: 5px;
      right: 5px;
      width: 6px;
      height: 6px;
      border-radius: 50%;
      background: var(--emerald);
      border: 1.5px solid var(--white);   /* ← border putih */
      display: none;
    }
    .island-btn.has-filter .dot { display: block; }

    /* ─────────────────────────────────────────────────
       ISLAND PANELS (Search + Filter dropdowns)
    ───────────────────────────────────────────────── */
    .island-panel-wrap {
      position: fixed;
      top: calc(var(--island-top) + var(--island-height) + 8px);
      left: 50%;
      transform: translateX(-50%);
      z-index: 59;
      width: 420px;
      max-width: calc(100vw - 32px);
    }

    .island-panel {
      background: var(--white);
      border: 1px solid var(--border);
      border-radius: 16px;
      box-shadow:
        0 8px 40px rgba(0, 0, 0, 0.14),
        0 2px 8px rgba(0, 0, 0, 0.06);
      overflow: hidden;
      opacity: 0;
      transform: translateY(-8px) scale(0.97);
      pointer-events: none;
      transition:
        opacity var(--transition-smooth),
        transform var(--transition-smooth);
    }
    .island-panel.open {
      opacity: 1;
      transform: translateY(0) scale(1);
      pointer-events: all;
    }

    .panel-search { padding: 14px; }
    .panel-search-inner { position: relative; }
    .panel-search-icon {
      position: absolute;
      left: 13px;
      top: 50%;
      transform: translateY(-50%);
      width: 15px;
      height: 15px;
      color: var(--gray-400);
      pointer-events: none;
    }
    .panel-search-input {
      width: 100%;
      padding: 10px 14px 10px 40px;
      border: 1.5px solid var(--border);
      border-radius: 10px;
      font-size: 14px;
      font-family: 'DM Sans', sans-serif;
      color: var(--gray-900);
      outline: none;
      transition: border-color 0.2s, box-shadow 0.2s;
    }
    .panel-search-input:focus {
      border-color: var(--emerald);
      box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.10);
    }
    .panel-search-hint {
      font-size: 11.5px;
      color: var(--gray-400);
      margin-top: 8px;
      text-align: center;
    }

    .panel-filter { padding: 16px; }
    .panel-filter-title {
      font-size: 11px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.06em;
      color: var(--gray-400);
      margin-bottom: 10px;
    }
    .panel-chip-row {
      display: flex;
      flex-wrap: wrap;
      gap: 6px;
      margin-bottom: 14px;
    }
    .panel-chip {
      padding: 5px 13px;
      border: 1.5px solid var(--border);
      border-radius: 99px;
      font-size: 12px;
      font-weight: 600;
      color: var(--gray-700);
      background: var(--white);
      cursor: pointer;
      text-decoration: none;
      white-space: nowrap;
      transition: all 0.15s;
    }
    .panel-chip:hover { border-color: var(--emerald); color: var(--emerald-600); background: var(--emerald-50); }
    .panel-chip.active { border-color: var(--emerald-600); background: var(--emerald-600); color: var(--white); }

    .panel-selects {
      display: grid;
      grid-template-columns: 1fr 1fr;
      gap: 8px;
      margin-bottom: 14px;
    }
    .panel-select {
      padding: 8px 12px;
      border: 1.5px solid var(--border);
      border-radius: 9px;
      font-size: 12.5px;
      font-weight: 600;
      font-family: 'DM Sans', sans-serif;
      color: var(--gray-700);
      background: var(--white);
      outline: none;
      cursor: pointer;
      appearance: none;
      -webkit-appearance: none;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%239ca3af' viewBox='0 0 24 24'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 10px center;
      padding-right: 28px;
      transition: border-color 0.2s;
    }
    .panel-select:focus { border-color: var(--emerald); }
    .panel-select.has-value { border-color: var(--emerald); color: var(--emerald-700); background-color: var(--emerald-50); }

    .panel-apply-btn {
      width: 100%;
      padding: 10px;
      background: var(--gray-900);
      color: var(--white);
      border: none;
      border-radius: 10px;
      font-size: 13px;
      font-weight: 700;
      font-family: 'DM Sans', sans-serif;
      cursor: pointer;
      transition: background 0.2s;
    }
    .panel-apply-btn:hover { background: var(--emerald-600); }

    #panel-backdrop {
      position: fixed;
      inset: 0;
      z-index: 58;
      display: none;
    }
    #panel-backdrop.open { display: block; }

    /* ─────────────────────────────────────────────────
       PAGE MAIN
    ───────────────────────────────────────────────── */
    #page-main {
      padding-top: calc(var(--nav-height-top) + 24px);
      max-width: 1280px;
      margin: 0 auto;
      padding-left: 24px;
      padding-right: 24px;
      padding-bottom: 80px;
      transition: padding-top var(--transition-nav);
    }
    #page-main.island-mode {
      padding-top: 40px;
    }

    /* ─────────────────────────────────────────────────
       PAGE HEADER
    ───────────────────────────────────────────────── */
    .page-header {
      display: flex;
      align-items: flex-end;
      justify-content: space-between;
      gap: 16px;
      margin-bottom: 24px;
    }
    .page-header-left h1 {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: clamp(28px, 4vw, 40px);
      font-weight: 800;
      letter-spacing: -0.03em;
      color: var(--gray-900);
      line-height: 1;
      margin: 0 0 6px 0;
    }
    .page-header-left h1 em {
      font-family: 'Cormorant Garamond', serif;
      font-style: italic;
      font-weight: 600;
      color: var(--emerald-600);
      font-size: 1.12em;
    }
    .page-header-left p {
      font-size: 13px;
      color: var(--gray-400);
      margin: 0;
    }

    .result-pill {
      display: inline-flex;
      align-items: center;
      gap: 7px;
      padding: 5px 14px;
      background: var(--emerald-50);
      border: 1px solid var(--emerald-100);
      border-radius: 99px;
      font-size: 12.5px;
      font-weight: 600;
      color: var(--emerald-600);
      white-space: nowrap;
      flex-shrink: 0;
    }
    .result-dot {
      width: 7px;
      height: 7px;
      border-radius: 50%;
      background: var(--emerald);
      animation: pulse-dot 2s ease-in-out infinite;
    }
    @keyframes pulse-dot {
      0%, 100% { opacity: 1; transform: scale(1); }
      50%       { opacity: 0.6; transform: scale(0.8); }
    }

    .active-filters-row {
      display: flex;
      align-items: center;
      gap: 8px;
      margin-bottom: 20px;
      flex-wrap: wrap;
    }
    .active-filter-tag {
      display: inline-flex;
      align-items: center;
      gap: 5px;
      padding: 4px 10px;
      background: var(--emerald-50);
      border: 1px solid var(--emerald-100);
      border-radius: 99px;
      font-size: 12px;
      font-weight: 600;
      color: var(--emerald-600);
    }
    .active-filter-tag a {
      color: var(--emerald-600);
      text-decoration: none;
      display: flex;
      align-items: center;
      opacity: 0.7;
      transition: opacity 0.15s;
    }
    .active-filter-tag a:hover { opacity: 1; }
    .active-filter-tag svg { width: 11px; height: 11px; }

    /* ─────────────────────────────────────────────────
       SKELETON
    ───────────────────────────────────────────────── */
    @keyframes shimmer {
      0%   { background-position: -600px 0; }
      100% { background-position:  600px 0; }
    }
    .skeleton {
      background: linear-gradient(90deg, #efefef 25%, #e3e3e3 50%, #efefef 75%);
      background-size: 600px 100%;
      animation: shimmer 1.4s infinite linear;
      border-radius: 8px;
    }

    /* ─────────────────────────────────────────────────
       PRODUCT CARD
    ───────────────────────────────────────────────── */
    .product-card {
      background: var(--white);
      border: 1px solid var(--border);
      border-radius: 18px;
      overflow: hidden;
      text-decoration: none;
      display: block;
      transition:
        transform 0.28s cubic-bezier(0.34, 1.56, 0.64, 1),
        box-shadow 0.28s ease,
        border-color 0.2s;
      opacity: 0;
      transform: translateY(20px);
    }
    .product-card.revealed {
      opacity: 1;
      transform: translateY(0);
      transition:
        opacity 0.45s cubic-bezier(0.22, 1, 0.36, 1),
        transform 0.45s cubic-bezier(0.22, 1, 0.36, 1),
        box-shadow 0.28s ease,
        border-color 0.2s;
    }
    .product-card.revealed:hover {
      transform: translateY(-5px);
      box-shadow: 0 16px 40px rgba(0, 0, 0, 0.09);
      border-color: var(--emerald-100);
    }
    .product-card.revealed:hover .card-img-inner {
      transform: scale(1.04);
    }

    .card-img {
      aspect-ratio: 1;
      overflow: hidden;
      background: var(--gray-100);
      position: relative;
    }
    .card-img-inner {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.5s ease;
    }
    .card-img-placeholder {
      width: 100%;
      height: 100%;
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .badge-condition {
      position: absolute;
      top: 10px;
      left: 10px;
      display: inline-flex;
      align-items: center;
      padding: 3px 10px;
      border-radius: 99px;
      font-size: 11px;
      font-weight: 700;
      letter-spacing: 0.01em;
      backdrop-filter: blur(4px);
    }
    .badge-like_new { background: rgba(220, 252, 231, 0.9); color: #15803d; }
    .badge-good     { background: rgba(219, 234, 254, 0.9); color: #1d4ed8; }
    .badge-fair     { background: rgba(255, 237, 213, 0.9); color: #9a3412; }

    .card-arrow {
      position: absolute;
      bottom: 10px;
      right: 10px;
      width: 30px;
      height: 30px;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.88);
      backdrop-filter: blur(4px);
      display: flex;
      align-items: center;
      justify-content: center;
      opacity: 0;
      transform: translateY(6px);
      transition: opacity 0.25s ease, transform 0.25s ease;
      box-shadow: 0 2px 8px rgba(0, 0, 0, 0.12);
    }
    .product-card.revealed:hover .card-arrow {
      opacity: 1;
      transform: translateY(0);
    }
    .card-arrow svg { width: 12px; height: 12px; color: var(--gray-900); }

    .card-body { padding: 14px 16px 16px; }
    .card-category {
      font-size: 10.5px;
      font-weight: 700;
      text-transform: uppercase;
      letter-spacing: 0.06em;
      color: var(--gray-400);
      margin-bottom: 5px;
    }
    .card-name {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 13.5px;
      font-weight: 700;
      color: var(--gray-900);
      line-height: 1.35;
      margin-bottom: 10px;
      display: -webkit-box;
      -webkit-line-clamp: 2;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }
    .card-footer {
      display: flex;
      align-items: center;
      justify-content: space-between;
    }
    .card-price {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 15px;
      font-weight: 800;
      color: var(--gray-900);
    }
    .card-cta {
      width: 30px;
      height: 30px;
      border-radius: 50%;
      background: var(--emerald-50);
      display: flex;
      align-items: center;
      justify-content: center;
      color: var(--emerald-600);
      transition: background 0.2s, color 0.2s;
    }
    .product-card.revealed:hover .card-cta {
      background: var(--emerald-600);
      color: var(--white);
    }
    .card-cta svg { width: 13px; height: 13px; }

    /* ─────────────────────────────────────────────────
       EMPTY STATE
    ───────────────────────────────────────────────── */
    @keyframes float-empty {
      0%, 100% { transform: translateY(0); }
      50%       { transform: translateY(-8px); }
    }
    .empty-state {
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      padding: 80px 24px;
      text-align: center;
    }
    .empty-icon-wrap {
      width: 80px;
      height: 80px;
      border-radius: 24px;
      background: var(--emerald-50);
      display: flex;
      align-items: center;
      justify-content: center;
      margin-bottom: 20px;
      animation: float-empty 3s ease-in-out infinite;
    }
    .empty-icon-wrap svg { width: 38px; height: 38px; color: #a7f3d0; }
    .empty-state h3 {
      font-family: 'Plus Jakarta Sans', sans-serif;
      font-size: 18px;
      font-weight: 800;
      color: var(--gray-900);
      margin: 0 0 8px;
    }
    .empty-state p {
      font-size: 13.5px;
      color: var(--gray-400);
      max-width: 280px;
      line-height: 1.6;
      margin: 0 0 24px;
    }
    .btn-reset-catalog {
      display: inline-flex;
      align-items: center;
      gap: 7px;
      padding: 10px 24px;
      background: var(--gray-900);
      color: var(--white);
      border: none;
      border-radius: 99px;
      font-size: 13px;
      font-weight: 700;
      font-family: 'DM Sans', sans-serif;
      cursor: pointer;
      text-decoration: none;
      transition: background 0.2s, transform 0.15s;
    }
    .btn-reset-catalog:hover { background: var(--emerald-600); transform: translateY(-1px); }

    /* ─────────────────────────────────────────────────
       PAGINATION
    ───────────────────────────────────────────────── */
    .pagination-wrap {
      display: flex;
      justify-content: center;
      margin-top: 40px;
    }
    .pagination-wrap nav { display: flex; justify-content: center; }

    /* ─────────────────────────────────────────────────
       FOOTER
    ───────────────────────────────────────────────── */
    footer {
      background: var(--white);
      border-top: 1px solid var(--border-light);
    }
    .footer-inner {
      max-width: 1280px;
      margin: 0 auto;
      padding: 24px;
      display: flex;
      flex-direction: column;
      align-items: center;
      gap: 8px;
    }
    @media (min-width: 640px) {
      .footer-inner {
        flex-direction: row;
        justify-content: space-between;
      }
    }
    .footer-inner img { height: 28px; width: auto; }
    .footer-inner p { font-size: 11.5px; color: var(--gray-400); margin: 0; }

    /* ─────────────────────────────────────────────────
       RESPONSIVE
    ───────────────────────────────────────────────── */
    @media (max-width: 768px) {
      .nav-controls { display: none; }
      .nav-actions .hide-mobile { display: none; }
      .page-header h1 { font-size: 24px; }
    }

    @media (max-width: 480px) {
      .nav-row1 { padding: 0 14px; }
      .nav-row2-inner { padding: 0 14px; }
      #page-main { padding-left: 14px; padding-right: 14px; }
      .island-panel-wrap { width: calc(100vw - 28px); }
    }
  </style>
</head>
<body>

  {{-- ══════════════════════════════════════════════════════
       SINGLE FORM — wraps entire navigation system
  ══════════════════════════════════════════════════════ --}}
  <form method="GET" action="{{ route('produk.index') }}" id="filter-form">

    {{-- ── NAVIGATION SYSTEM ────────────────────────────── --}}
    <div id="nav-system" class="state-top">

      {{-- Row 1: logo + search + controls + actions --}}
      <div class="nav-row1">
        {{-- ↓ nav-inner: menengahkan konten hingga max 1280px --}}
        <div class="nav-inner">

          {{-- Logo --}}
          <a href="{{ route('produk.index') }}" class="nav-logo" title="Kembali ke katalog utama">
            <img src="{{ asset('images/logo_full.png') }}" alt="PindahTangan" />
          </a>

          {{-- Search bar --}}
          <div class="nav-search-wrap">
            <svg class="nav-search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input
              type="text"
              name="search"
              id="nav-search-top"
              value="{{ request('search') }}"
              placeholder="Cari barang..."
              class="nav-search-input"
              autocomplete="off"
            />
          </div>

          {{-- Filter controls --}}
          <div class="nav-controls">

            <select name="condition" id="nav-condition-top"
                    class="nav-select {{ request('condition') ? 'has-value' : '' }}"
                    onchange="document.getElementById('filter-form').submit()">
              <option value="">Semua Kondisi</option>
              <option value="like_new" {{ request('condition') === 'like_new' ? 'selected' : '' }}>Like New</option>
              <option value="good"     {{ request('condition') === 'good'     ? 'selected' : '' }}>Good</option>
              <option value="fair"     {{ request('condition') === 'fair'     ? 'selected' : '' }}>Fair</option>
            </select>

            <select name="sort" id="nav-sort-top"
                    class="nav-select {{ request('sort') && request('sort') !== 'latest' ? 'has-value' : '' }}"
                    onchange="document.getElementById('filter-form').submit()">
              <option value="latest"     {{ request('sort','latest') === 'latest'     ? 'selected' : '' }}>Terbaru</option>
              <option value="price_asc"  {{ request('sort') === 'price_asc'           ? 'selected' : '' }}>Harga Terendah</option>
              <option value="price_desc" {{ request('sort') === 'price_desc'          ? 'selected' : '' }}>Harga Tertinggi</option>
              <option value="name"       {{ request('sort') === 'name'                ? 'selected' : '' }}>Nama A-Z</option>
            </select>

            <button type="submit" class="nav-btn-search">
              <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
              </svg>
              Cari
            </button>

            @if(request()->hasAny(['search', 'category', 'condition']) || (request('sort') && request('sort') !== 'latest'))
              <a href="{{ route('produk.index') }}" class="nav-reset-link" title="Reset semua filter">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
                Reset
              </a>
            @endif

          </div>

          {{-- Auth actions --}}
          <div class="nav-actions">
            @auth
              @if(auth()->user()->isAdmin())
                <a href="{{ route('admin.dashboard') }}" class="nav-icon-btn hide-mobile" title="Admin Panel">
                  <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                  </svg>
                </a>
              @endif
              <a href="{{ route('keranjang.index') }}" class="nav-icon-btn" title="Keranjang">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
              </a>
              <button type="submit" form="logout-form" title="Keluar"
                class="hidden md:inline-flex w-9 h-9 rounded-full bg-white/70 border border-gray-200 items-center justify-center text-gray-600 hover:text-red-500 hover:border-red-200 transition-all duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/>
                </svg>
              </button>
            @else
              <a href="{{ route('login') }}" class="nav-icon-btn" title="Masuk">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
              </a>
            @endauth
          </div>

        </div>{{-- /nav-inner --}}
      </div>{{-- /nav-row1 --}}

      {{-- Row 2: category chips dengan scroll --}}
      <div class="nav-row2">
        {{-- ↓ nav-row2-inner: scrollable, max-width 1280px, terpusat --}}
        <div class="nav-row2-inner">

          <a href="{{ route('produk.index') }}"
             class="cat-chip {{ !request('category') && !request()->hasAny(['search','condition','sort']) ? 'active' : '' }}">
            Semua
          </a>

          @foreach($categories as $cat)
            <a href="{{ route('produk.index', array_merge(
                  request()->only(['sort', 'condition']),
                  ['category' => $cat->id]
               )) }}"
               class="cat-chip {{ request('category') == $cat->id ? 'active' : '' }}">
              {{ $cat->name }}
            </a>
          @endforeach

          {{-- Hidden inputs untuk preserve filter state --}}
          @if(request('sort'))
            <input type="hidden" name="sort" value="{{ request('sort') }}">
          @endif
          @if(request('condition'))
            <input type="hidden" name="condition" value="{{ request('condition') }}">
          @endif

        </div>{{-- /nav-row2-inner --}}
      </div>{{-- /nav-row2 --}}

    </div>{{-- /nav-system --}}

  </form>{{-- /filter-form --}}

  {{-- ══════════════════════════════════════════════════════
       DYNAMIC ISLAND
  ══════════════════════════════════════════════════════ --}}
  <div id="dynamic-island">
    <div class="island-pill">

      <a href="{{ route('produk.index') }}" class="island-logo" title="Katalog utama">
        <img src="{{ asset('images/logo_half.png') }}" alt="PindahTangan" />
      </a>

      <div class="island-divider"></div>

      <button type="button" class="island-btn" id="island-btn-search" title="Cari produk"
              onclick="toggleIslandPanel('search')">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
        </svg>
      </button>

      <button type="button"
              class="island-btn {{ request()->hasAny(['category','condition']) || (request('sort') && request('sort') !== 'latest') ? 'has-filter' : '' }}"
              id="island-btn-filter" title="Filter & Kategori"
              onclick="toggleIslandPanel('filter')">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L13 13.414V19a1 1 0 01-.553.894l-4 2A1 1 0 017 21v-7.586L3.293 6.707A1 1 0 013 6V4z"/>
        </svg>
        <span class="dot"></span>
      </button>

      <a href="{{ route('produk.index') }}" class="island-btn" title="Reset katalog">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
        </svg>
      </a>

      <div class="island-divider"></div>

      @auth
        <a href="{{ route('keranjang.index') }}" class="island-btn" title="Keranjang">
          <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>
          </svg>
        </a>
      @else
        <a href="{{ route('login') }}" class="island-btn" title="Masuk">
          <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
          </svg>
        </a>
      @endauth

    </div>
  </div>{{-- /dynamic-island --}}

  {{-- Island panels --}}
  <div id="panel-backdrop" onclick="closeAllPanels()"></div>

  <div class="island-panel-wrap">

    {{-- Search panel --}}
    <div class="island-panel" id="island-panel-search">
      <form method="GET" action="{{ route('produk.index') }}" id="island-search-form">
        @if(request('sort'))     <input type="hidden" name="sort"      value="{{ request('sort') }}"> @endif
        @if(request('condition'))<input type="hidden" name="condition" value="{{ request('condition') }}"> @endif
        @if(request('category')) <input type="hidden" name="category"  value="{{ request('category') }}"> @endif
        <div class="panel-search">
          <div class="panel-search-inner">
            <svg class="panel-search-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
            </svg>
            <input
              type="text"
              name="search"
              id="island-search-input"
              value="{{ request('search') }}"
              placeholder="Cari nama produk..."
              class="panel-search-input"
              autocomplete="off"
            />
          </div>
          <p class="panel-search-hint">Tekan Enter untuk mencari</p>
        </div>
      </form>
    </div>

    {{-- Filter panel --}}
    <div class="island-panel" id="island-panel-filter">
      <form method="GET" action="{{ route('produk.index') }}" id="island-filter-form">
        @if(request('search'))<input type="hidden" name="search" value="{{ request('search') }}"> @endif
        <div class="panel-filter">

          <p class="panel-filter-title">Kategori</p>
          <div class="panel-chip-row">
            <a href="{{ route('produk.index', array_merge(request()->only(['search','sort','condition']), [])) }}"
               class="panel-chip {{ !request('category') ? 'active' : '' }}">
              Semua
            </a>
            @foreach($categories as $cat)
              <a href="{{ route('produk.index', array_merge(
                    request()->only(['search','sort','condition']),
                    ['category' => $cat->id]
                  )) }}"
                 class="panel-chip {{ request('category') == $cat->id ? 'active' : '' }}"
                 onclick="closeAllPanels()">
                {{ $cat->name }}
              </a>
            @endforeach
          </div>

          <p class="panel-filter-title">Filter</p>
          <div class="panel-selects">
            <select name="condition"
                    class="panel-select {{ request('condition') ? 'has-value' : '' }}">
              <option value="">Semua Kondisi</option>
              <option value="like_new" {{ request('condition') === 'like_new' ? 'selected' : '' }}>Like New</option>
              <option value="good"     {{ request('condition') === 'good'     ? 'selected' : '' }}>Good</option>
              <option value="fair"     {{ request('condition') === 'fair'     ? 'selected' : '' }}>Fair</option>
            </select>
            <select name="sort"
                    class="panel-select {{ request('sort') && request('sort') !== 'latest' ? 'has-value' : '' }}">
              <option value="latest"     {{ request('sort','latest') === 'latest'     ? 'selected' : '' }}>Terbaru</option>
              <option value="price_asc"  {{ request('sort') === 'price_asc'           ? 'selected' : '' }}>Harga Rendah</option>
              <option value="price_desc" {{ request('sort') === 'price_desc'          ? 'selected' : '' }}>Harga Tinggi</option>
              <option value="name"       {{ request('sort') === 'name'                ? 'selected' : '' }}>Nama A-Z</option>
            </select>
          </div>

          @if(request('category'))<input type="hidden" name="category" value="{{ request('category') }}"> @endif

          <button type="submit" class="panel-apply-btn">Terapkan Filter</button>

        </div>
      </form>
    </div>

  </div>{{-- /island-panel-wrap --}}


  {{-- ══════════════════════════════════════════════════════
       PAGE MAIN — Product catalog
  ══════════════════════════════════════════════════════ --}}
  <main id="page-main">

    {{-- Page header --}}
    <div class="page-header">
      <div class="page-header-left">
        <h1 class="jakarta">
          Katalog
          <em class="cormorant">Pilihan Terbaik.</em>
        </h1>
        <p>Barang berkualitas, kondisi transparan, harga lebih hemat.</p>
      </div>
      @if($produk->total() > 0)
        <div class="result-pill">
          <div class="result-dot"></div>
          {{ number_format($produk->total()) }} barang
        </div>
      @endif
    </div>

    {{-- Active filter tags --}}
    @if(request()->hasAny(['search', 'category', 'condition']) || (request('sort') && request('sort') !== 'latest'))
      <div class="active-filters-row">
        @if(request('search'))
          <span class="active-filter-tag">
            Pencarian: "{{ request('search') }}"
            <a href="{{ route('produk.index', request()->except('search')) }}">
              <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </a>
          </span>
        @endif
        @if(request('category'))
          @php $activeCat = $categories->find(request('category')); @endphp
          @if($activeCat)
            <span class="active-filter-tag">
              {{ $activeCat->name }}
              <a href="{{ route('produk.index', request()->except('category')) }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
              </a>
            </span>
          @endif
        @endif
        @if(request('condition'))
          <span class="active-filter-tag">
            {{ ['like_new' => 'Like New', 'good' => 'Good', 'fair' => 'Fair'][request('condition')] ?? request('condition') }}
            <a href="{{ route('produk.index', request()->except('condition')) }}">
              <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </a>
          </span>
        @endif
        @if(request('sort') && request('sort') !== 'latest')
          <span class="active-filter-tag">
            {{ ['price_asc' => 'Harga Terendah', 'price_desc' => 'Harga Tertinggi', 'name' => 'Nama A-Z'][request('sort')] ?? request('sort') }}
            <a href="{{ route('produk.index', request()->except('sort')) }}">
              <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
            </a>
          </span>
        @endif
        <a href="{{ route('produk.index') }}" class="nav-reset-link" style="font-size:12px;">
          <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
          Reset semua
        </a>
      </div>
    @endif

    {{-- Skeleton --}}
    <div id="skeleton-grid"
         class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
      @for($i = 0; $i < 8; $i++)
        <div style="border-radius:18px;overflow:hidden;border:1px solid var(--border-light);background:var(--white);">
          <div class="skeleton" style="aspect-ratio:1;border-radius:0;"></div>
          <div style="padding:14px 16px 16px;">
            <div class="skeleton" style="height:10px;width:40%;margin-bottom:8px;"></div>
            <div class="skeleton" style="height:14px;width:100%;margin-bottom:6px;"></div>
            <div class="skeleton" style="height:14px;width:75%;margin-bottom:12px;"></div>
            <div style="display:flex;justify-content:space-between;align-items:center;">
              <div class="skeleton" style="height:18px;width:36%;"></div>
              <div class="skeleton" style="height:30px;width:30px;border-radius:50%;"></div>
            </div>
          </div>
        </div>
      @endfor
    </div>

    {{-- Real content --}}
    <div id="real-grid" style="opacity:0;transition:opacity 0.35s ease;">

      @if($produk->count() > 0)

        <div class="card-grid grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-5">
          @foreach($produk as $p)
            @php
              $condLabel = match($p->condition) {
                'like_new' => 'Like New',
                'good'     => 'Good',
                'fair'     => 'Fair',
                default    => $p->condition,
              };
            @endphp

            <a href="{{ route('produk.show', $p->slug) }}"
               class="product-card"
               style="transition-delay: {{ $loop->index * 35 }}ms">

              <div class="card-img">
                @if($p->image)
                  <img class="card-img-inner"
                       src="{{ Storage::url($p->image) }}"
                       alt="{{ $p->name }}"
                       loading="lazy" />
                @else
                  <div class="card-img-placeholder">
                    <svg class="w-12 h-12" style="color:#e5e7eb;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                  </div>
                @endif

                <span class="badge-condition badge-{{ $p->condition }}">{{ $condLabel }}</span>

                <div class="card-arrow">
                  <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                  </svg>
                </div>
              </div>

              <div class="card-body">
                <p class="card-category">{{ $p->category->name ?? '—' }}</p>
                <h3 class="card-name">{{ $p->name }}</h3>
                <div class="card-footer">
                  <span class="card-price">Rp {{ number_format($p->price, 0, ',', '.') }}</span>
                  <span class="card-cta">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/>
                    </svg>
                  </span>
                </div>
              </div>

            </a>
          @endforeach
        </div>

        @if($produk->hasPages())
          <div class="pagination-wrap">
            {{ $produk->links() }}
          </div>
        @endif

      @else

        <div class="empty-state">
          <div class="empty-icon-wrap">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
            </svg>
          </div>
          <h3>Tidak ada produk ditemukan</h3>
          <p>Coba ubah kata kunci atau filter kategori. Barang baru datang setiap saat.</p>
          <a href="{{ route('produk.index') }}" class="btn-reset-catalog">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:14px;height:14px;">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
            Reset Filter
          </a>
        </div>

      @endif

    </div>{{-- /real-grid --}}

  </main>


  {{-- ══ FOOTER ══ --}}
  <footer>
    <div class="footer-inner">
      <img src="{{ asset('images/logo_full.png') }}" alt="PindahTangan" />
      <p>Platform preloved berkualitas — © {{ date('Y') }} PindahTangan.</p>
    </div>
  </footer>


  <script>
  (() => {
    'use strict';

    const SCROLL_THRESHOLD = 80;
    const NAV_HEIGHT_TOP   = 104;

    const navSystem    = document.getElementById('nav-system');
    const island       = document.getElementById('dynamic-island');
    const pageMain     = document.getElementById('page-main');
    const skeletonGrid = document.getElementById('skeleton-grid');
    const realGrid     = document.getElementById('real-grid');

    let islandVisible = false;
    let lastScrollY   = 0;
    let rafId         = null;

    /* ── Skeleton → Real ── */
    setTimeout(() => {
      if (skeletonGrid) {
        skeletonGrid.style.transition = 'opacity 0.28s ease';
        skeletonGrid.style.opacity    = '0';
        setTimeout(() => skeletonGrid.remove(), 280);
      }
      if (realGrid) {
        realGrid.style.opacity = '1';
        document.querySelectorAll('.card-grid .product-card').forEach((card, i) => {
          setTimeout(() => card.classList.add('revealed'), i * 45);
        });
      }
    }, 420);

    /* ── Scroll behavior ── */
    function updateNavState() {
      const sy = window.scrollY;

      if (sy > SCROLL_THRESHOLD && !islandVisible) {
        navSystem.classList.remove('state-top');
        navSystem.classList.add('state-hidden');
        island.classList.add('visible');
        pageMain.classList.add('island-mode');
        islandVisible = true;
      } else if (sy <= 0 && islandVisible) {
        navSystem.classList.remove('state-hidden');
        navSystem.classList.add('state-top');
        island.classList.remove('visible');
        pageMain.classList.remove('island-mode');
        islandVisible = false;
        closeAllPanels();
      }

      lastScrollY = sy;
    }

    window.addEventListener('scroll', () => {
      if (rafId) return;
      rafId = requestAnimationFrame(() => {
        updateNavState();
        rafId = null;
      });
    }, { passive: true });

    updateNavState();

    /* ── Island panel toggle ── */
    window.toggleIslandPanel = function(panel) {
      const searchPanel = document.getElementById('island-panel-search');
      const filterPanel = document.getElementById('island-panel-filter');
      const backdrop    = document.getElementById('panel-backdrop');
      const searchBtn   = document.getElementById('island-btn-search');
      const filterBtn   = document.getElementById('island-btn-filter');

      if (panel === 'search') {
        const isOpen = searchPanel.classList.contains('open');
        filterPanel.classList.remove('open');
        filterBtn.style.color = '';
        if (isOpen) {
          searchPanel.classList.remove('open');
          searchBtn.style.color = '';
          backdrop.classList.remove('open');
        } else {
          searchPanel.classList.add('open');
          searchBtn.style.color = 'var(--emerald)';
          backdrop.classList.add('open');
          setTimeout(() => document.getElementById('island-search-input')?.focus(), 80);
        }
      } else if (panel === 'filter') {
        const isOpen = filterPanel.classList.contains('open');
        searchPanel.classList.remove('open');
        searchBtn.style.color = '';
        if (isOpen) {
          filterPanel.classList.remove('open');
          filterBtn.style.color = '';
          backdrop.classList.remove('open');
        } else {
          filterPanel.classList.add('open');
          filterBtn.style.color = 'var(--emerald)';
          backdrop.classList.add('open');
        }
      }
    };

    window.closeAllPanels = function() {
      document.getElementById('island-panel-search')?.classList.remove('open');
      document.getElementById('island-panel-filter')?.classList.remove('open');
      document.getElementById('panel-backdrop')?.classList.remove('open');
      const sb = document.getElementById('island-btn-search');
      const fb = document.getElementById('island-btn-filter');
      if (sb) sb.style.color = '';
      if (fb) fb.style.color = '';
    };

    /* ── Keyboard shortcuts ── */
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') { closeAllPanels(); return; }
      if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
        e.preventDefault();
        if (islandVisible) {
          toggleIslandPanel('search');
        } else {
          document.getElementById('nav-search-top')?.focus();
        }
      }
    });

    /* ── Island search: Enter submits ── */
    document.getElementById('island-search-input')?.addEventListener('keydown', (e) => {
      if (e.key === 'Enter') {
        e.preventDefault();
        document.getElementById('island-search-form')?.submit();
      }
    });

    /* ── IntersectionObserver for card reveal ── */
    const cardObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('revealed');
          cardObserver.unobserve(entry.target);
        }
      });
    }, { threshold: 0.08 });

    document.querySelectorAll('.product-card').forEach(c => cardObserver.observe(c));

  })();
  </script>

  <form id="logout-form" method="POST" action="{{ route('logout') }}" class="hidden">
  @csrf
  </form>

</body>
</html>