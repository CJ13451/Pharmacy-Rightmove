@props(['title' => null])

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ? "{$title} — P3 Pharmacy" : 'P3 Pharmacy — Intelligence. Analysis. Insight.' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Newsreader:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config = { theme: { extend: { colors: { brand: { DEFAULT: '#00875a', 50: '#e6f7f0', 500: '#00875a', 600: '#007a52', 700: '#006644' } } } } }</script>
    @livewireStyles
    @stack('styles')
    <style>
        :root { --black: #1a1a1a; --grey-900: #111; --grey-800: #222; --grey-700: #444; --grey-600: #666; --grey-500: #888; --grey-400: #aaa; --grey-300: #ccc; --grey-200: #e0e0e0; --grey-100: #f0f0f0; --grey-50: #f8f8f8; --white: #fff; --green: #00875a; }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', -apple-system, sans-serif; background: var(--white); color: var(--black); font-size: 15px; line-height: 1.6; }
        .container { max-width: 1280px; margin: 0 auto; padding: 0 32px; }
        a { color: inherit; }

        /* Header */
        .header { border-bottom: 1px solid var(--grey-200); }
        .header-top { display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px solid var(--grey-100); font-size: 13px; color: var(--grey-600); }
        .header-top a { color: var(--grey-600); text-decoration: none; margin-left: 20px; }
        .header-top a:hover { color: var(--black); }
        .header-top-right { display: flex; gap: 16px; align-items: center; }
        .header-main { display: flex; justify-content: space-between; align-items: center; padding: 20px 0; }
        .logo-main { font-weight: 900; font-size: 32px; letter-spacing: -1px; color: var(--black); text-decoration: none; }
        .logo-tagline { font-size: 11px; font-weight: 500; color: var(--grey-600); letter-spacing: 0.5px; margin-top: 2px; }

        /* Nav */
        .category-nav { display: flex; gap: 0; border-bottom: 3px solid var(--black); overflow-x: auto; }
        .category-nav a { padding: 12px 18px; font-size: 13px; font-weight: 600; color: var(--grey-700); text-decoration: none; transition: all 0.15s; position: relative; white-space: nowrap; }
        .category-nav a:hover { color: var(--black); background: var(--grey-50); }
        .category-nav a.active { color: var(--black); }
        .category-nav a.active::after { content: ''; position: absolute; bottom: -3px; left: 0; right: 0; height: 3px; background: var(--green); }
        .category-nav a.highlight { background: var(--green); color: white; }
        .category-nav a.highlight:hover { background: #006644; }

        /* Buttons */
        .btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; font-family: inherit; font-size: 13px; font-weight: 600; border-radius: 4px; text-decoration: none; border: none; cursor: pointer; transition: all 0.15s; }
        .btn-text { background: none; color: var(--grey-700); padding: 8px 0; }
        .btn-primary { background: var(--black); color: white; }
        .btn-primary:hover { background: var(--grey-800); }
        .btn-green { background: var(--green); color: white; }
        .btn-green:hover { background: #006644; }
        .btn-outline { background: none; border: 1px solid var(--grey-300); color: var(--grey-700); }
        .btn-outline:hover { border-color: var(--black); color: var(--black); }

        /* Sections */
        .section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 12px; border-bottom: 2px solid var(--black); }
        .section-title { font-size: 18px; font-weight: 800; color: var(--black); text-transform: uppercase; letter-spacing: 0.5px; }
        .section-link { font-size: 13px; font-weight: 600; color: var(--green); text-decoration: none; }
        .section-link:hover { text-decoration: underline; }

        /* Flash Messages */
        .flash { padding: 12px 20px; margin: 20px 0; font-size: 14px; border: 1px solid; }
        .flash-success { background: #f0fdf4; border-color: #bbf7d0; color: #166534; }
        .flash-error { background: #fef2f2; border-color: #fecaca; color: #991b1b; }
        .flash-info { background: #eff6ff; border-color: #bfdbfe; color: #1e40af; }

        /* Page Content */
        .page-content { padding: 40px 0; }
        .page-title { font-family: 'Newsreader', serif; font-size: 32px; font-weight: 700; margin-bottom: 8px; }
        .page-subtitle { font-size: 15px; color: var(--grey-600); margin-bottom: 32px; }

        /* Cards */
        .card { background: var(--white); border: 1px solid var(--grey-200); padding: 20px; margin-bottom: 16px; }
        .card:hover { border-color: var(--grey-400); }
        .card-title { font-size: 16px; font-weight: 700; margin-bottom: 8px; }

        /* Forms */
        .form-group { margin-bottom: 20px; }
        .form-label { display: block; font-size: 13px; font-weight: 600; color: var(--grey-700); margin-bottom: 6px; }
        .form-input { width: 100%; padding: 10px 12px; border: 1px solid var(--grey-300); font-family: inherit; font-size: 14px; transition: border-color 0.15s; }
        .form-input:focus { outline: none; border-color: var(--green); }
        .form-error { font-size: 12px; color: #dc2626; margin-top: 4px; }
        .form-select { width: 100%; padding: 10px 12px; border: 1px solid var(--grey-300); font-family: inherit; font-size: 14px; background: white; }
        textarea.form-input { resize: vertical; min-height: 100px; }

        /* Tables */
        .table-wrap { overflow-x: auto; }
        table { width: 100%; border-collapse: collapse; font-size: 14px; }
        th { text-align: left; padding: 10px 14px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: var(--grey-500); border-bottom: 2px solid var(--black); }
        td { padding: 12px 14px; border-bottom: 1px solid var(--grey-100); }
        tr:hover td { background: var(--grey-50); }

        /* Grid Layouts */
        .grid-2 { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; }
        .grid-3 { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }
        .grid-4 { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; }
        .grid-sidebar { display: grid; grid-template-columns: 1fr 340px; gap: 48px; }

        /* User Menu */
        .user-menu { position: relative; }
        .user-menu-btn { display: flex; align-items: center; gap: 8px; cursor: pointer; background: none; border: none; font-family: inherit; font-size: 13px; font-weight: 600; color: var(--grey-700); }
        .user-menu-btn:hover { color: var(--black); }
        .user-avatar { width: 32px; height: 32px; background: var(--green); color: white; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: 700; }
        .user-dropdown { display: none; position: absolute; right: 0; top: 100%; margin-top: 8px; background: var(--white); border: 1px solid var(--grey-200); min-width: 200px; z-index: 100; box-shadow: 0 4px 12px rgba(0,0,0,0.1); }
        .user-dropdown.open { display: block; }
        .user-dropdown a, .user-dropdown button { display: block; width: 100%; text-align: left; padding: 10px 16px; font-size: 13px; color: var(--grey-700); text-decoration: none; border: none; background: none; font-family: inherit; cursor: pointer; }
        .user-dropdown a:hover, .user-dropdown button:hover { background: var(--grey-50); color: var(--black); }
        .user-dropdown-divider { border-top: 1px solid var(--grey-100); margin: 4px 0; }

        /* Footer */
        .footer { background: var(--black); color: var(--white); padding: 56px 0 28px; margin-top: 60px; }
        .footer-top { display: grid; grid-template-columns: 1.5fr 1fr 1fr 1fr 1fr; gap: 40px; padding-bottom: 40px; border-bottom: 1px solid var(--grey-700); }
        .footer-brand .logo-main { font-size: 24px; color: var(--white); }
        .footer-brand .logo-tagline { color: var(--grey-400); margin-bottom: 12px; }
        .footer-desc { font-size: 13px; color: var(--grey-400); line-height: 1.6; }
        .footer-col h4 { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: var(--grey-400); margin-bottom: 14px; }
        .footer-col ul { list-style: none; }
        .footer-col li { margin-bottom: 8px; }
        .footer-col a { font-size: 13px; color: var(--grey-300); text-decoration: none; }
        .footer-col a:hover { color: var(--white); }
        .footer-bottom { padding-top: 20px; display: flex; justify-content: space-between; font-size: 12px; color: var(--grey-500); }
        .footer-bottom a { color: var(--grey-500); text-decoration: none; margin-left: 20px; }
        .footer-bottom a:hover { color: var(--grey-300); }

        /* Utility */
        .text-green { color: var(--green); }
        .text-grey { color: var(--grey-500); }
        .text-small { font-size: 13px; }
        .text-xs { font-size: 11px; }
        .font-bold { font-weight: 700; }
        .mt-1 { margin-top: 8px; }
        .mt-2 { margin-top: 16px; }
        .mt-3 { margin-top: 24px; }
        .mb-1 { margin-bottom: 8px; }
        .mb-2 { margin-bottom: 16px; }
        .mb-3 { margin-bottom: 24px; }
        .tag { display: inline-block; padding: 2px 8px; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
        .tag-green { background: var(--green); color: white; }
        .tag-black { background: var(--black); color: white; }
        .tag-grey { background: var(--grey-100); color: var(--grey-600); }
        .empty-state { padding: 40px; text-align: center; color: var(--grey-500); background: var(--grey-50); border: 1px solid var(--grey-200); }

        @media (max-width: 768px) {
            .container { padding: 0 16px; }
            .grid-2, .grid-3, .grid-4 { grid-template-columns: 1fr; }
            .grid-sidebar { grid-template-columns: 1fr; }
            .footer-top { grid-template-columns: 1fr 1fr; gap: 24px; }
            .header-top { display: none; }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="header-top">
                <div>
                    <span>{{ now()->format('l, j F Y') }}</span>
                    <a href="#">About</a>
                    <a href="#">Advertise</a>
                    <a href="#">Contact</a>
                </div>
                <div class="header-top-right">
                    @auth
                        <span style="font-size:13px;color:var(--grey-600)">{{ auth()->user()->full_name }}</span>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-text">Sign In</a>
                        <a href="{{ route('register') }}" class="btn btn-primary">Subscribe</a>
                    @endauth
                </div>
            </div>
            <div class="header-main">
                <div>
                    <a href="{{ auth()->check() ? route('home') : route('landing') }}" class="logo-main" style="text-decoration:none">p3pharmacy</a>
                    <div class="logo-tagline">Intelligence. Analysis. Insight.</div>
                </div>
                @auth
                    <div class="user-menu" x-data="{ open: false }">
                        <button class="user-menu-btn" x-on:click="open = !open">
                            <div class="user-avatar">{{ auth()->user()->initials }}</div>
                            <span>{{ auth()->user()->first_name }}</span>
                        </button>
                        <div class="user-dropdown" x-bind:class="open ? 'open' : ''" x-on:click.away="open = false">
                            <a href="{{ route('dashboard') }}">Dashboard</a>
                            <a href="{{ route('account.settings') }}">Account Settings</a>
                            @if(auth()->user()->canAccessCms())
                                <div class="user-dropdown-divider"></div>
                                <a href="/admin">Admin Panel</a>
                            @endif
                            @if(auth()->user()->isEstateAgent())
                                <div class="user-dropdown-divider"></div>
                                <a href="{{ route('agent.dashboard') }}">Agent Dashboard</a>
                            @endif
                            @if(auth()->user()->isSupplier())
                                <div class="user-dropdown-divider"></div>
                                <a href="{{ route('supplier.dashboard') }}">Supplier Dashboard</a>
                            @endif
                            <div class="user-dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit">Sign Out</button>
                            </form>
                        </div>
                    </div>
                @endauth
            </div>
            <nav class="category-nav">
                <a href="{{ route('home') }}" class="{{ request()->routeIs('home', 'landing') ? 'active' : '' }}">Home</a>
                <a href="{{ route('news.index') }}" class="{{ request()->routeIs('news.*') ? 'active' : '' }}">News</a>
                <a href="{{ route('listings.index') }}" class="highlight">Pharmacies for Sale</a>
                <a href="{{ route('buying-guide') }}" class="{{ request()->routeIs('buying-guide') ? 'active' : '' }}">Buying Guide</a>
                <a href="{{ route('valuations') }}" class="{{ request()->routeIs('valuations') ? 'active' : '' }}">Valuations</a>
                <a href="{{ route('training.index') }}" class="{{ request()->routeIs('training.*') ? 'active' : '' }}">Training</a>
                <a href="{{ route('suppliers.index') }}" class="{{ request()->routeIs('suppliers.*') ? 'active' : '' }}">Suppliers</a>
                <a href="{{ route('resources.index') }}" class="{{ request()->routeIs('resources.*') ? 'active' : '' }}">Resources</a>
            </nav>
        </div>
    </header>

    <div class="container">
        @if(session('success'))
            <div class="flash flash-success">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="flash flash-error">{{ session('error') }}</div>
        @endif
        @if(session('info'))
            <div class="flash flash-info">{{ session('info') }}</div>
        @endif
    </div>

    <main>
        {{ $slot }}
    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer-top">
                <div class="footer-brand">
                    <div class="logo-main">p3pharmacy</div>
                    <div class="logo-tagline">Intelligence. Analysis. Insight.</div>
                    <p class="footer-desc">The essential resource for UK pharmacy owners and prospective buyers.</p>
                </div>
                <div class="footer-col">
                    <h4>Marketplace</h4>
                    <ul>
                        <li><a href="{{ route('listings.index') }}">For Sale</a></li>
                        <li><a href="{{ route('valuations') }}">Valuations</a></li>
                        <li><a href="{{ route('buying-guide') }}">Buying Guide</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Resources</h4>
                    <ul>
                        <li><a href="{{ route('news.index') }}">News</a></li>
                        <li><a href="{{ route('training.index') }}">Training</a></li>
                        <li><a href="{{ route('resources.index') }}">Guides</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Directory</h4>
                    <ul>
                        <li><a href="{{ route('suppliers.index') }}">All Suppliers</a></li>
                        <li><a href="{{ route('suppliers.join') }}">Add Business</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Company</h4>
                    <ul>
                        <li><a href="#">About</a></li>
                        <li><a href="#">Contact</a></li>
                        <li><a href="{{ route('terms') }}">Terms</a></li>
                        <li><a href="{{ route('privacy') }}">Privacy</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <span>&copy; {{ date('Y') }} P3 Pharmacy. All rights reserved.</span>
                <span>
                    <a href="{{ route('privacy') }}">Privacy</a>
                    <a href="{{ route('terms') }}">Terms</a>
                </span>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    @livewireScripts
    @stack('scripts')
</body>
</html>
