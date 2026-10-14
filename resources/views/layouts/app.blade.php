<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') | School Canteen</title>

    {{-- Browser tab icon: the same knife and fork logo --}}
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 48 48'%3E%3Crect width='48' height='48' rx='10' fill='%23D9731F'/%3E%3Cg fill='white'%3E%3Cpath d='M16.5 10C20.5 10 21.5 14 21.5 20V25H16.5Z'/%3E%3Crect x='17.9' y='24' width='2.2' height='14' rx='1.1'/%3E%3Crect x='26.5' y='10' width='1.8' height='10' rx='.9'/%3E%3Crect x='30.1' y='10' width='1.8' height='10' rx='.9'/%3E%3Crect x='33.7' y='10' width='1.8' height='10' rx='.9'/%3E%3Cpath d='M26.5 18H35.5V21Q35.5 25 31 25Q26.5 25 26.5 21Z'/%3E%3Crect x='29.9' y='24' width='2.2' height='14' rx='1.1'/%3E%3C/g%3E%3C/svg%3E">

    {{-- Apply the saved theme before the page paints, so there is no flash --}}
    <script>
        (function () {
            try {
                var saved = localStorage.getItem('canteen-theme');
                if (saved === 'light' || saved === 'dark') {
                    document.documentElement.setAttribute('data-bs-theme', saved);
                }
            } catch (e) { /* storage blocked: stay on the default theme */ }
        })();
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Figtree:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --bs-body-bg: var(--bg);
            --bs-body-color: var(--ink);
            --bs-body-font-family: 'Figtree', system-ui, -apple-system, 'Segoe UI', sans-serif;
            --bs-border-color: var(--line);
            --bs-secondary-color: var(--muted);
        }

        /* ---------- Dark theme (default): black and matte orange ---------- */
        :root, [data-bs-theme="dark"] {
            --bg: #0D0D0D;
            --surface: #171717;
            --surface-glass: rgba(23, 23, 23, 0.82);
            --field: #101010;
            --line: #2B2B2B;
            --ink: #F1EEE9;
            --muted: #9A958D;

            --orange: #D9731F;
            --orange-hover: #E4822F;
            --orange-dark: #B85E15;
            --on-orange: #111111;
            --orange-text: #F0A060;
            --orange-soft: rgba(217, 115, 31, 0.16);

            --hover: rgba(255, 255, 255, 0.04);
            --row-soft: rgba(255, 255, 255, 0.03);

            --btn-line: #3A3A3A;
            --btn-line-hover: #4A4A4A;
            --btn-hover-bg: #232323;
            --btn-active-bg: #2B2B2B;
            --field-line: #333333;
            --placeholder: #6E6A63;

            --danger-text: #F08A76;
            --danger-border: #7A3526;
            --warn-text: #F2C264;
            --ok-text: #7FC98A;
            --neutral-text: #A8A39B;
            --neutral-bg: rgba(255, 255, 255, 0.08);
            --alert-ok-text: #8FD39A;
            --alert-bad-text: #F59A86;

            /* sidebar and top bar */
            --side-bg: #080808;
            --side-ink: #F1EEE9;
            --side-muted: #9A958D;
            --side-line: #2B2B2B;
            --side-hover: #151515;
            --side-active-bg: rgba(217, 115, 31, 0.16);
            --side-active-text: #F0A060;
            --side-bar: #D9731F;
            --topbar-bg: rgba(13, 13, 13, 0.78);

            /* logo and background glow */
            --logo-tile: #D9731F;
            --logo-rim: #F0A060;
            --glow-color: rgba(217, 115, 31, 0.34);
            --logo-glow-opacity: 0.42;

            --bs-link-color-rgb: 240, 160, 96;
            --bs-link-hover-color-rgb: 246, 183, 130;
        }

        /* ---------- Light theme: soft grey page, white cards, orange shades ---------- */
        [data-bs-theme="light"] {
            --bg: #F5F5F3;
            --surface: #FFFFFF;
            --surface-glass: rgba(255, 255, 255, 0.84);
            --field: #FFFFFF;
            --line: #E8E6E1;
            --ink: #1C1C1A;
            --muted: #6F6D68;

            --orange: #FF8000;
            --orange-hover: #FF9A3C;
            --orange-dark: #E67300;
            --on-orange: #1F1206;
            --orange-text: #A84F00;
            --orange-soft: rgba(255, 128, 0, 0.12);

            --hover: rgba(255, 128, 0, 0.06);
            --row-soft: rgba(255, 128, 0, 0.05);

            --btn-line: #E4E1DA;
            --btn-line-hover: #CFCBC2;
            --btn-hover-bg: #FFF1E6;
            --btn-active-bg: #FFE8D6;
            --field-line: #E0DCD3;
            --placeholder: #A7A39A;

            --danger-text: #B3361C;
            --danger-border: #E9B3A6;
            --warn-text: #8A5A00;
            --ok-text: #2F7A3F;
            --neutral-text: #6B6760;
            --neutral-bg: rgba(28, 28, 26, 0.07);
            --alert-ok-text: #2A6A37;
            --alert-bad-text: #9E2E17;

            /* sidebar and top bar */
            --side-bg: #FFFFFF;
            --side-ink: #1C1C1A;
            --side-muted: #5F5D58;
            --side-line: #E8E6E1;
            --side-hover: #F6F4F0;
            --side-active-bg: #FFE8D6;
            --side-active-text: #7A3D00;
            --side-bar: #FF8000;
            --topbar-bg: rgba(245, 245, 243, 0.8);

            /* logo and background glow */
            --logo-tile: #FF8000;
            --logo-rim: #FFB966;
            --glow-color: rgba(255, 128, 0, 0.26);
            --logo-glow-opacity: 0.4;

            --bs-link-color-rgb: 168, 79, 0;
            --bs-link-hover-color-rgb: 130, 60, 0;
        }

        body { background: var(--bg); color: var(--ink); }
        :focus-visible { outline: 2px solid var(--orange); outline-offset: 2px; }
        .text-danger { color: var(--danger-text) !important; }
        h1, .h3 { font-weight: 600; letter-spacing: -0.01em; }

        /* ---------- Blurred, glowing logo in the background ---------- */
        .bg-glow { position: fixed; inset: 0; z-index: 0; pointer-events: none; overflow: hidden; }
        .bg-glow::before {
            content: "";
            position: absolute;
            right: -14vw; bottom: -22vh;
            width: min(75vw, 980px); height: min(75vw, 980px);
            background: radial-gradient(circle, var(--glow-color) 0%, transparent 62%);
            filter: blur(30px);
        }
        .bg-glow svg {
            position: absolute;
            right: 8vw; bottom: 10vh;
            width: min(40vw, 400px); height: min(40vw, 400px);
            --logo-tile: #FF8000;
            --logo-rim: #FFB966;
            opacity: var(--logo-glow-opacity);
            filter: blur(14px) drop-shadow(0 0 36px rgba(255, 128, 0, 0.85));
        }

        /* ---------- Layout shell ---------- */
        .main { position: relative; z-index: 1; }

        /* ---------- Sidebar ---------- */
        .sidebar {
            position: fixed; top: 0; bottom: 0; left: 0;
            width: 250px;
            background: var(--side-bg);
            border-right: 1px solid var(--side-line);
            display: flex; flex-direction: column;
            padding: 1.25rem 0.75rem;
            transform: translateX(-100%);
            transition: transform 0.2s ease;
            z-index: 1040;
            overflow-y: auto;
        }
        body.menu-open .sidebar { transform: none; }
        .menu-backdrop {
            display: none; position: fixed; inset: 0;
            background: rgba(0, 0, 0, 0.65); z-index: 1030;
        }
        body.menu-open .menu-backdrop { display: block; }

        .brand { padding: 0 0.5rem 1rem; }
        .brand-link { display: flex; align-items: center; gap: 0.65rem; text-decoration: none; }
        .brand-logo { width: 38px; height: 38px; flex: none; }
        .brand-name { display: block; font-weight: 700; font-size: 1.1rem; letter-spacing: -0.01em; color: var(--side-ink); line-height: 1.2; }
        .brand-sub { display: block; color: var(--side-muted); font-size: 0.8rem; }

        .side-group { color: var(--side-muted); font-size: 0.8rem; opacity: 0.85; padding: 1.1rem 0.75rem 0.35rem; }
        .side-nav { list-style: none; padding: 0; margin: 0; display: grid; gap: 2px; }
        .side-link {
            display: flex; align-items: center; gap: 0.75rem;
            padding: 0.55rem 0.75rem;
            border-radius: 8px;
            color: var(--side-muted);
            font-weight: 500;
            text-decoration: none;
        }
        .side-link i { font-size: 1.1rem; width: 1.25rem; text-align: center; }
        .side-link:hover { background: var(--side-hover); color: var(--side-ink); }
        .side-link.active {
            background: var(--side-active-bg);
            color: var(--side-active-text);
            box-shadow: inset 3px 0 0 var(--side-bar);
        }
        .side-link.active i { color: var(--side-bar); }

        .sidebar .btn-outline-secondary {
            --bs-btn-color: var(--side-ink); --bs-btn-border-color: var(--side-line);
            --bs-btn-hover-color: var(--side-ink); --bs-btn-hover-bg: var(--side-hover); --bs-btn-hover-border-color: var(--side-line);
            --bs-btn-active-color: var(--side-ink); --bs-btn-active-bg: var(--side-hover); --bs-btn-active-border-color: var(--side-line);
        }

        /* ---------- Top bar ---------- */
        .topbar {
            position: sticky; top: 0; z-index: 1020;
            display: flex; align-items: center; gap: 0.75rem;
            padding: 0.7rem 1rem;
            background: var(--topbar-bg);
            -webkit-backdrop-filter: blur(10px);
            backdrop-filter: blur(10px);
            border-bottom: 1px solid var(--line);
        }
        .top-search { position: relative; flex: 1 1 auto; max-width: 380px; }
        .top-search i { position: absolute; left: 0.8rem; top: 50%; transform: translateY(-50%); color: var(--muted); pointer-events: none; }
        .top-search input {
            width: 100%;
            padding: 0.5rem 0.8rem 0.5rem 2.3rem;
            background: var(--field);
            border: 1px solid var(--field-line);
            border-radius: 8px;
            color: var(--ink);
        }
        .top-search input::placeholder { color: var(--placeholder); }
        .top-search input:focus { outline: none; border-color: var(--orange); box-shadow: 0 0 0 3px rgba(255, 128, 0, 0.22); }
        .top-actions { margin-left: auto; display: flex; align-items: center; gap: 0.5rem; }
        .icon-btn {
            width: 38px; height: 38px;
            display: inline-flex; align-items: center; justify-content: center;
            background: var(--surface);
            border: 1px solid var(--line);
            border-radius: 8px;
            color: var(--ink);
        }
        .icon-btn:hover { background: var(--btn-hover-bg); }

        /* ---------- Content area ---------- */
        .content { padding: 1.25rem 1rem 3rem; min-height: calc(100vh - 62px); }
        .content-inner { max-width: 1120px; margin: 0 auto; }

        .crumbs { display: flex; flex-wrap: wrap; gap: 0.45rem; font-size: 0.85rem; color: var(--muted); margin-bottom: 0.4rem; }
        .crumbs a { color: var(--muted); text-decoration: none; }
        .crumbs a:hover { color: var(--ink); }
        .crumbs .here { color: var(--ink); }

        @media (min-width: 992px) {
            .sidebar { transform: none; }
            .menu-backdrop { display: none !important; }
            .main { margin-left: 250px; }
            .topbar { padding: 0.75rem 2.5rem; }
            .content { padding: 1.5rem 2.5rem 3rem; }
        }
        @media (prefers-reduced-motion: reduce) {
            .sidebar { transition: none; }
        }

        /* ---------- Cards, tables, lists ---------- */
        .card {
            --bs-card-bg: var(--surface-glass);
            --bs-card-color: var(--ink);
            --bs-card-border-color: var(--line);
            --bs-card-cap-bg: transparent;
            --bs-card-border-radius: 12px;
            --bs-card-inner-border-radius: 11px;
            box-shadow: none;
            -webkit-backdrop-filter: blur(10px);
            backdrop-filter: blur(10px);
        }
        .shadow-sm { box-shadow: none !important; }
        .card-header { background: transparent !important; border-bottom: 1px solid var(--line); }

        .table {
            --bs-table-bg: transparent;
            --bs-table-color: var(--ink);
            --bs-table-border-color: var(--line);
            --bs-table-hover-bg: var(--hover);
            --bs-table-hover-color: var(--ink);
        }
        .table-light {
            --bs-table-bg: transparent;
            --bs-table-color: var(--muted);
            --bs-table-border-color: var(--line);
        }
        tfoot .table-light, tfoot.table-light { --bs-table-color: var(--ink); --bs-table-bg: var(--row-soft); }
        thead th { font-weight: 500; font-size: 0.875rem; }

        .list-group {
            --bs-list-group-bg: transparent;
            --bs-list-group-color: var(--ink);
            --bs-list-group-border-color: var(--line);
        }

        /* ---------- Filter pills ---------- */
        .pill-row { display: flex; flex-wrap: wrap; gap: 0.5rem; }
        .pill {
            padding: 0.3rem 0.95rem;
            border-radius: 999px;
            border: 1px solid var(--line);
            background: var(--surface);
            color: var(--muted);
            font-size: 0.875rem;
            font-weight: 500;
            text-decoration: none;
        }
        .pill:hover { color: var(--ink); background: var(--btn-hover-bg); }
        .pill.active { background: var(--orange); border-color: var(--orange); color: var(--on-orange); }

        /* ---------- Buttons ---------- */
        .btn { border-radius: 8px; font-weight: 500; }

        /* main action: orange with dark text */
        .btn-success {
            --bs-btn-color: var(--on-orange); --bs-btn-bg: var(--orange); --bs-btn-border-color: var(--orange);
            --bs-btn-hover-color: var(--on-orange); --bs-btn-hover-bg: var(--orange-hover); --bs-btn-hover-border-color: var(--orange-hover);
            --bs-btn-active-color: var(--on-orange); --bs-btn-active-bg: var(--orange-dark); --bs-btn-active-border-color: var(--orange-dark);
        }
        /* everything else: quiet outline */
        .btn-outline-primary, .btn-outline-secondary, .btn-outline-success,
        .btn-outline-warning, .btn-warning {
            --bs-btn-color: var(--ink); --bs-btn-bg: var(--surface); --bs-btn-border-color: var(--btn-line);
            --bs-btn-hover-color: var(--ink); --bs-btn-hover-bg: var(--btn-hover-bg); --bs-btn-hover-border-color: var(--btn-line-hover);
            --bs-btn-active-color: var(--ink); --bs-btn-active-bg: var(--btn-active-bg); --bs-btn-active-border-color: var(--btn-line-hover);
        }
        /* delete: quiet until you hover */
        .btn-outline-danger {
            --bs-btn-color: var(--muted); --bs-btn-bg: var(--surface); --bs-btn-border-color: var(--btn-line);
            --bs-btn-hover-color: var(--danger-text); --bs-btn-hover-bg: rgba(224, 72, 43, 0.14); --bs-btn-hover-border-color: var(--danger-border);
            --bs-btn-active-color: var(--danger-text); --bs-btn-active-bg: rgba(224, 72, 43, 0.2); --bs-btn-active-border-color: var(--danger-border);
        }
        .btn-link { color: var(--orange-text); }

        /* ---------- Forms ---------- */
        .form-control, .form-select {
            background-color: var(--field);
            border-color: var(--field-line);
            border-radius: 8px;
            color: var(--ink);
        }
        .form-control::placeholder { color: var(--placeholder); }
        .form-control:focus, .form-select:focus {
            background-color: var(--field);
            color: var(--ink);
            border-color: var(--orange);
            box-shadow: 0 0 0 3px rgba(255, 128, 0, 0.25);
        }
        .input-group-text { background-color: var(--field); border-color: var(--field-line); color: var(--muted); }
        .form-check-input { background-color: var(--field); border-color: var(--field-line); }
        .form-check-input:checked { background-color: var(--orange); border-color: var(--orange); }

        /* ---------- Status colors ---------- */
        .badge { font-weight: 500; border-radius: 6px; }
        .badge.bg-warning { background: rgba(242, 182, 60, 0.2) !important; color: var(--warn-text) !important; }
        .badge.bg-info { background: var(--orange-soft) !important; color: var(--orange-text) !important; }
        .badge.bg-success, .badge.bg-success-subtle { background: rgba(90, 170, 100, 0.18) !important; color: var(--ok-text) !important; }
        .badge.bg-danger { background: rgba(224, 72, 43, 0.16) !important; color: var(--danger-text) !important; }
        .badge.bg-secondary, .badge.bg-secondary-subtle { background: var(--neutral-bg) !important; color: var(--neutral-text) !important; }

        /* ---------- Messages ---------- */
        .alert { border: 0; border-radius: 10px; }
        .alert-success { --bs-alert-bg: rgba(90, 170, 100, 0.16); --bs-alert-color: var(--alert-ok-text); }
        .alert-danger { --bs-alert-bg: rgba(224, 72, 43, 0.14); --bs-alert-color: var(--alert-bad-text); }
        .alert-secondary { --bs-alert-bg: var(--neutral-bg); --bs-alert-color: var(--muted); }

        /* ---------- Pagination ---------- */
        .pagination {
            --bs-pagination-bg: var(--surface);
            --bs-pagination-border-color: var(--line);
            --bs-pagination-color: var(--orange-text);
            --bs-pagination-hover-bg: var(--btn-hover-bg);
            --bs-pagination-hover-color: var(--orange-text);
            --bs-pagination-hover-border-color: var(--line);
            --bs-pagination-focus-bg: var(--btn-hover-bg);
            --bs-pagination-focus-color: var(--orange-text);
            --bs-pagination-active-bg: var(--orange);
            --bs-pagination-active-color: var(--on-orange);
            --bs-pagination-active-border-color: var(--orange);
            --bs-pagination-disabled-bg: var(--surface);
            --bs-pagination-disabled-color: var(--placeholder);
            --bs-pagination-disabled-border-color: var(--line);
        }

        /* ---------- Dashboard ---------- */
        .hero { padding: 0.25rem 0 1.75rem; }
        .hero-title {
            font-size: clamp(1.9rem, 4vw, 2.75rem);
            font-weight: 700;
            letter-spacing: -0.02em;
            line-height: 1.1;
            margin: 0 0 0.5rem;
        }
        .hero-sub { color: var(--muted); max-width: 60ch; margin-bottom: 1rem; }
    </style>
</head>
<body>

{{-- The logo is defined once here and reused with <use> --}}
<svg width="0" height="0" style="position:absolute" aria-hidden="true">
    <symbol id="canteen-logo" viewBox="0 0 48 48">
        <rect width="48" height="48" rx="10" style="fill: var(--logo-rim)"/>
        <rect x="3" y="3" width="42" height="42" rx="7.5" style="fill: var(--logo-tile)"/>
        <g fill="#fff">
            {{-- knife --}}
            <path d="M16.5 10C20.5 10 21.5 14 21.5 20V25H16.5Z"/>
            <rect x="17.9" y="24" width="2.2" height="14" rx="1.1"/>
            {{-- fork --}}
            <rect x="26.5" y="10" width="1.8" height="10" rx=".9"/>
            <rect x="30.1" y="10" width="1.8" height="10" rx=".9"/>
            <rect x="33.7" y="10" width="1.8" height="10" rx=".9"/>
            <path d="M26.5 18H35.5V21Q35.5 25 31 25Q26.5 25 26.5 21Z"/>
            <rect x="29.9" y="24" width="2.2" height="14" rx="1.1"/>
        </g>
    </symbol>
</svg>



<div class="menu-backdrop" data-menu-toggle></div>

<aside class="sidebar" id="sidebar">
    <div class="brand d-flex justify-content-between align-items-start">
        <a href="{{ route('dashboard') }}" class="brand-link">
            <svg class="brand-logo" aria-hidden="true"><use href="#canteen-logo"/></svg>
            <span>
                <span class="brand-name">School Canteen</span>
                <span class="brand-sub">Management System</span>
            </span>
        </a>
        <button type="button" class="btn btn-outline-secondary btn-sm d-lg-none" data-menu-toggle aria-label="Close menu">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    <nav aria-label="Main menu">
        <ul class="side-nav">
            <li>
                <a class="side-link {{ request()->routeIs('dashboard') ? 'active' : '' }}" href="{{ route('dashboard') }}"
                   @if (request()->routeIs('dashboard')) aria-current="page" @endif>
                    <i class="bi bi-speedometer2"></i> Dashboard
                </a>
            </li>
        </ul>

        <div class="side-group">Sales</div>
        <ul class="side-nav">
            <li>
                <a class="side-link {{ request()->routeIs('orders.*') ? 'active' : '' }}" href="{{ route('orders.index') }}"
                   @if (request()->routeIs('orders.*')) aria-current="page" @endif>
                    <i class="bi bi-receipt"></i> Orders
                </a>
            </li>
        </ul>

        <div class="side-group">Catalog</div>
        <ul class="side-nav">
            <li>
                <a class="side-link {{ request()->routeIs('products.*') ? 'active' : '' }}" href="{{ route('products.index') }}"
                   @if (request()->routeIs('products.*')) aria-current="page" @endif>
                    <i class="bi bi-box-seam"></i> Products
                </a>
            </li>
            <li>
                <a class="side-link {{ request()->routeIs('categories.*') ? 'active' : '' }}" href="{{ route('categories.index') }}"
                   @if (request()->routeIs('categories.*')) aria-current="page" @endif>
                    <i class="bi bi-tags"></i> Categories
                </a>
            </li>
            <li>
                <a class="side-link {{ request()->routeIs('suppliers.*') ? 'active' : '' }}" href="{{ route('suppliers.index') }}"
                   @if (request()->routeIs('suppliers.*')) aria-current="page" @endif>
                    <i class="bi bi-truck"></i> Suppliers
                </a>
            </li>
        </ul>
    </nav>
</aside>

<div class="main">
    <header class="topbar">
        <button type="button" class="icon-btn d-lg-none" data-menu-toggle aria-controls="sidebar" aria-label="Open menu">
            <i class="bi bi-list"></i>
        </button>

        <form class="top-search" action="{{ route('products.index') }}" method="GET" role="search">
            <i class="bi bi-search"></i>
            <input type="search" name="q" value="{{ request()->routeIs('products.*') ? request('q') : '' }}"
                   placeholder="Search products..." aria-label="Search products">
        </form>

        <div class="top-actions">
            <button type="button" class="icon-btn" id="theme-toggle">
                <i class="bi bi-sun"></i>
            </button>
            <a href="{{ route('orders.create') }}" class="btn btn-success">
                <i class="bi bi-plus-lg"></i> <span class="d-none d-sm-inline">New order</span>
            </a>
        </div>
    </header>

    <main class="content">
        <div class="content-inner">
            {{-- Breadcrumbs: Dashboard / Section / Page --}}
            @php
                $sections = [
                    'orders' => ['Orders', 'orders.index'],
                    'products' => ['Products', 'products.index'],
                    'categories' => ['Categories', 'categories.index'],
                    'suppliers' => ['Suppliers', 'suppliers.index'],
                ];
                $actionLabels = ['create' => 'Add', 'edit' => 'Edit', 'show' => 'Details'];
                $routeName = request()->route()?->getName();
                $sectionKey = $routeName ? explode('.', $routeName)[0] : null;
                $actionMethod = request()->route()?->getActionMethod();
            @endphp
            @if ($sectionKey && isset($sections[$sectionKey]))
                <nav class="crumbs" aria-label="Breadcrumb">
                    <a href="{{ route('dashboard') }}">Dashboard</a>
                    <span>/</span>
                    @if (isset($actionLabels[$actionMethod]))
                        <a href="{{ route($sections[$sectionKey][1]) }}">{{ $sections[$sectionKey][0] }}</a>
                        <span>/</span>
                        <span class="here">{{ $actionLabels[$actionMethod] }}</span>
                    @else
                        <span class="here">{{ $sections[$sectionKey][0] }}</span>
                    @endif
                </nav>
            @endif

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger" role="alert">
                    <strong>Please fix the following:</strong>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @yield('content')
        </div>
    </main>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    // Open and close the sidebar on phones.
    document.querySelectorAll('[data-menu-toggle]').forEach(function (el) {
        el.addEventListener('click', function () { document.body.classList.toggle('menu-open'); });
    });
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') document.body.classList.remove('menu-open');
    });

    // Dark / light toggle.
    (function () {
        var root = document.documentElement;
        var button = document.getElementById('theme-toggle');

        function refreshLabel() {
            var dark = root.getAttribute('data-bs-theme') === 'dark';
            var label = dark ? 'Switch to light mode' : 'Switch to dark mode';
            button.querySelector('i').className = dark ? 'bi bi-sun' : 'bi bi-moon-stars';
            button.setAttribute('aria-label', label);
            button.setAttribute('title', label);
        }

        button.addEventListener('click', function () {
            var next = root.getAttribute('data-bs-theme') === 'dark' ? 'light' : 'dark';
            root.setAttribute('data-bs-theme', next);
            try { localStorage.setItem('canteen-theme', next); } catch (e) { /* ignore */ }
            refreshLabel();
        });

        refreshLabel();
    })();
</script>
@stack('scripts')
</body>
</html>