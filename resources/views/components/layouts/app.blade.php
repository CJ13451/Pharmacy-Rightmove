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
        .category-nav {
            display: flex;
            gap: 0;
            /* Paint the bottom rule as a background so nothing needs to
               overflow the box. Setting overflow-x: auto alone forces the
               browser to upgrade overflow-y to auto too, which combined
               with anything sticking below the content area would show a
               vertical scrollbar. */
            background: linear-gradient(to bottom, transparent calc(100% - 3px), var(--black) calc(100% - 3px));
            overflow-x: auto;
            overflow-y: hidden;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;    /* Firefox */
            -ms-overflow-style: none; /* legacy Edge / IE */
        }
        .category-nav::-webkit-scrollbar { display: none; } /* Chrome / Safari */
        .category-nav a {
            padding: 12px 18px;
            font-size: 13px;
            font-weight: 600;
            color: var(--grey-700);
            text-decoration: none;
            transition: all 0.15s;
            white-space: nowrap;
            flex-shrink: 0;
        }
        .category-nav a:hover { color: var(--black); background: var(--grey-50); }
        .category-nav a.active {
            color: var(--black);
            /* Inset shadow draws the green indicator inside the anchor's
               box so it isn't clipped by overflow-y: hidden. */
            box-shadow: inset 0 -3px 0 var(--green);
        }
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

        /* Listings Page */
        .listings-layout { display: grid; grid-template-columns: 280px 1fr; gap: 40px; padding: 40px 0; }
        .filters-sidebar { position: sticky; top: 100px; height: fit-content; }
        .filter-section { margin-bottom: 24px; padding-bottom: 24px; border-bottom: 1px solid var(--grey-200); }
        .filter-title { font-size: 12px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: var(--black); margin-bottom: 12px; }
        .filter-input { width: 100%; padding: 10px 12px; border: 1px solid var(--grey-200); font-family: inherit; font-size: 13px; margin-bottom: 8px; }
        .filter-input:focus { outline: none; border-color: var(--black); }
        .filter-row { display: grid; grid-template-columns: 1fr 1fr; gap: 8px; }
        .filter-checkbox { display: flex; align-items: center; gap: 8px; padding: 6px 0; font-size: 13px; color: var(--grey-700); cursor: pointer; }
        .filter-checkbox input { width: 16px; height: 16px; accent-color: var(--green); }
        .listings-results { display: flex; flex-direction: column; gap: 20px; }
        .results-header { display: flex; justify-content: space-between; align-items: center; padding-bottom: 16px; border-bottom: 1px solid var(--grey-200); }
        .results-count { font-size: 14px; color: var(--grey-600); }
        .results-sort select { padding: 8px 12px; border: 1px solid var(--grey-200); font-family: inherit; font-size: 13px; background: var(--white); }
        .listing-card { display: grid; grid-template-columns: 280px 1fr; gap: 24px; padding: 20px; background: var(--white); border: 1px solid var(--grey-200); text-decoration: none; transition: all 0.15s; color: var(--black); }
        .listing-card:hover { border-color: var(--black); box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
        .listing-image { height: 180px; background: linear-gradient(135deg, #e8e4e0 0%, #d8d4d0 100%); position: relative; }
        .listing-image .badge { position: absolute; top: 12px; left: 12px; }
        .listing-content { display: flex; flex-direction: column; justify-content: space-between; }
        .listing-price { font-size: 28px; font-weight: 800; color: var(--black); margin-bottom: 4px; }
        .listing-price-qualifier { font-size: 12px; color: var(--grey-500); font-weight: 500; }
        .listing-title { font-family: 'Newsreader', serif; font-size: 20px; font-weight: 600; color: var(--black); margin: 12px 0 8px; line-height: 1.3; }
        .listing-location { font-size: 14px; color: var(--grey-600); margin-bottom: 12px; }
        .listing-stats { display: flex; gap: 24px; padding: 12px 0; border-top: 1px solid var(--grey-100); }
        .listing-stat { display: flex; flex-direction: column; }
        .listing-stat-value { font-size: 16px; font-weight: 700; color: var(--black); }
        .listing-stat-label { font-size: 11px; color: var(--grey-500); text-transform: uppercase; letter-spacing: 0.5px; }
        .listing-tags { display: flex; gap: 8px; flex-wrap: wrap; }
        .listing-tag { padding: 4px 10px; background: var(--grey-100); font-size: 11px; font-weight: 600; color: var(--grey-700); }

        /* Training Page */
        .training-hero { background: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%); padding: 60px 0; color: var(--white); }
        .training-hero-content { max-width: 600px; }
        .training-hero h1 { font-family: 'Newsreader', serif; font-size: 42px; font-weight: 700; margin-bottom: 16px; }
        .training-hero p { font-size: 18px; color: var(--grey-400); margin-bottom: 24px; }
        .training-stats { display: flex; gap: 40px; margin-top: 32px; padding-top: 32px; border-top: 1px solid var(--grey-700); }
        .training-stat-item { text-align: center; }
        .training-stat-number { font-size: 32px; font-weight: 800; color: var(--green); }
        .training-stat-text { font-size: 12px; color: var(--grey-400); text-transform: uppercase; letter-spacing: 0.5px; }
        .courses-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; padding: 40px 0; }
        .course-card { background: var(--white); border: 1px solid var(--grey-200); text-decoration: none; transition: all 0.15s; color: var(--black); }
        .course-card:hover { border-color: var(--black); transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,0.1); }
        .course-image { height: 160px; background: linear-gradient(135deg, #2a4a6a 0%, #1a3050 100%); position: relative; display: flex; align-items: center; justify-content: center; }
        .course-image-icon { font-size: 48px; opacity: 0.8; }
        .course-badges { position: absolute; top: 12px; left: 12px; display: flex; gap: 6px; }
        .course-content { padding: 20px; }
        .course-category { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: var(--green); margin-bottom: 8px; }
        .course-title { font-family: 'Newsreader', serif; font-size: 20px; font-weight: 600; color: var(--black); margin-bottom: 8px; line-height: 1.3; }
        .course-desc { font-size: 14px; color: var(--grey-600); margin-bottom: 16px; line-height: 1.5; }
        .course-meta { display: flex; justify-content: space-between; align-items: center; padding-top: 16px; border-top: 1px solid var(--grey-100); }
        .course-info { font-size: 12px; color: var(--grey-500); }
        .course-price { font-size: 18px; font-weight: 800; color: var(--black); }
        .course-price-free { color: var(--green); }

        /* Suppliers Page */
        .suppliers-hero { background: var(--grey-50); padding: 40px 0; border-bottom: 1px solid var(--grey-200); }
        .suppliers-search { max-width: 600px; margin: 0 auto; text-align: center; }
        .suppliers-search h1 { font-family: 'Newsreader', serif; font-size: 32px; font-weight: 700; margin-bottom: 8px; }
        .suppliers-search p { color: var(--grey-600); margin-bottom: 24px; }
        .search-box { display: flex; gap: 0; background: var(--white); border: 2px solid var(--black); }
        .search-box input { flex: 1; padding: 14px 16px; border: none; font-family: inherit; font-size: 15px; }
        .search-box input:focus { outline: none; }
        .search-box button { padding: 14px 24px; background: var(--black); color: white; border: none; font-family: inherit; font-size: 14px; font-weight: 600; cursor: pointer; }
        .category-tabs { display: flex; gap: 8px; justify-content: center; margin-top: 24px; flex-wrap: wrap; }
        .category-tab { padding: 8px 16px; background: var(--white); border: 1px solid var(--grey-200); font-size: 13px; font-weight: 600; color: var(--grey-700); text-decoration: none; transition: all 0.15s; }
        .category-tab:hover, .category-tab.active { background: var(--black); color: var(--white); border-color: var(--black); }
        .suppliers-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; padding: 40px 0; }
        .supplier-card { background: var(--white); border: 1px solid var(--grey-200); padding: 24px; text-align: center; text-decoration: none; transition: all 0.15s; color: var(--black); }
        .supplier-card:hover { border-color: var(--black); }
        .supplier-card.featured { border-color: var(--green); border-width: 2px; position: relative; }
        .supplier-card.featured::before { content: 'Featured'; position: absolute; top: -1px; right: -1px; background: var(--green); color: white; padding: 4px 10px; font-size: 10px; font-weight: 700; text-transform: uppercase; }
        .supplier-logo { width: 80px; height: 80px; background: var(--grey-100); border-radius: 8px; margin: 0 auto 16px; display: flex; align-items: center; justify-content: center; font-size: 24px; font-weight: 800; color: var(--grey-400); }
        .supplier-name { font-size: 16px; font-weight: 700; color: var(--black); margin-bottom: 4px; }
        .supplier-category { font-size: 12px; color: var(--grey-500); margin-bottom: 12px; }
        .supplier-desc { font-size: 13px; color: var(--grey-600); line-height: 1.5; }

        /* News Page */
        .news-layout { display: grid; grid-template-columns: 1fr 340px; gap: 48px; padding: 40px 0; }
        .featured-story { display: grid; grid-template-columns: 1.2fr 1fr; gap: 32px; padding-bottom: 32px; border-bottom: 1px solid var(--grey-200); margin-bottom: 32px; }
        .featured-image { height: 320px; background: linear-gradient(135deg, #2a4a6a 0%, #1a3050 100%); }
        .featured-content { display: flex; flex-direction: column; justify-content: center; }
        .story-category { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: var(--green); margin-bottom: 12px; }
        .featured-content h2 { font-family: 'Newsreader', serif; font-size: 32px; font-weight: 700; line-height: 1.25; margin-bottom: 16px; }
        .featured-content h2 a { color: var(--black); text-decoration: none; }
        .story-excerpt { font-size: 16px; color: var(--grey-700); line-height: 1.6; margin-bottom: 16px; }
        .story-meta { font-size: 13px; color: var(--grey-500); }
        .news-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 24px; }
        .news-card { text-decoration: none; color: var(--black); }
        .news-card-image { height: 160px; background: var(--grey-100); margin-bottom: 16px; }
        .news-card h3 { font-family: 'Newsreader', serif; font-size: 18px; font-weight: 600; color: var(--black); margin-bottom: 8px; line-height: 1.35; }
        .news-card:hover h3 { color: var(--green); }
        .sidebar { display: flex; flex-direction: column; gap: 28px; }
        .sidebar-section { border: 1px solid var(--grey-200); padding: 20px; }
        .sidebar-title { font-size: 13px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; color: var(--black); margin-bottom: 16px; padding-bottom: 10px; border-bottom: 2px solid var(--black); }
        .trending-list { display: flex; flex-direction: column; gap: 12px; }
        .trending-item { display: flex; gap: 12px; text-decoration: none; color: var(--black); }
        .trending-number { font-size: 24px; font-weight: 800; color: var(--grey-300); min-width: 32px; }
        .trending-content h4 { font-size: 14px; font-weight: 600; color: var(--black); line-height: 1.4; }
        .trending-item:hover h4 { color: var(--green); }
        .trending-meta { font-size: 11px; color: var(--grey-500); margin-top: 4px; }

        /* Resources Page */
        .resources-hero { background: linear-gradient(135deg, var(--green) 0%, #006644 100%); padding: 60px 0; color: var(--white); }
        .resources-hero h1 { font-family: 'Newsreader', serif; font-size: 42px; font-weight: 700; margin-bottom: 12px; }
        .resources-hero p { font-size: 18px; opacity: 0.9; max-width: 600px; }
        .resources-categories { background: var(--grey-50); padding: 24px 0; border-bottom: 1px solid var(--grey-200); }
        .resources-categories-inner { display: flex; gap: 32px; justify-content: center; }
        .resource-category-link { display: flex; align-items: center; gap: 8px; padding: 12px 20px; background: var(--white); border: 1px solid var(--grey-200); text-decoration: none; color: var(--grey-700); font-size: 14px; font-weight: 600; transition: all 0.15s; }
        .resource-category-link:hover, .resource-category-link.active { border-color: var(--black); color: var(--black); }
        .resource-category-icon { font-size: 20px; }
        .resources-grid-page { display: grid; grid-template-columns: repeat(3, 1fr); gap: 24px; padding: 40px 0; }
        .resource-card { background: var(--white); border: 1px solid var(--grey-200); padding: 24px; text-decoration: none; transition: all 0.15s; color: var(--black); }
        .resource-card:hover { border-color: var(--black); transform: translateY(-2px); box-shadow: 0 8px 24px rgba(0,0,0,0.08); }
        .resource-icon-lg { width: 48px; height: 48px; background: var(--grey-100); display: flex; align-items: center; justify-content: center; font-size: 24px; margin-bottom: 16px; }
        .resource-type { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: var(--grey-500); margin-bottom: 8px; }
        .resource-title { font-size: 16px; font-weight: 700; color: var(--black); margin-bottom: 8px; line-height: 1.4; }
        .resource-desc { font-size: 13px; color: var(--grey-600); line-height: 1.5; margin-bottom: 16px; }
        .resource-meta { display: flex; justify-content: space-between; align-items: center; padding-top: 16px; border-top: 1px solid var(--grey-100); font-size: 12px; color: var(--grey-500); }
        .resource-cta { color: var(--green); font-weight: 600; }

        /* Badges */
        .badge { display: inline-block; padding: 3px 8px; font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; }
        .badge-green { background: var(--green); color: white; }
        .badge-orange { background: var(--orange); color: white; }
        .badge-black { background: var(--black); color: white; }
        .badge-outline { background: transparent; border: 1px solid var(--grey-300); color: var(--grey-600); }

        /* Newsletter Widget */
        .newsletter-widget { background: var(--black); padding: 24px; }
        .newsletter-widget h3 { font-size: 18px; font-weight: 800; color: var(--white); margin-bottom: 8px; }
        .newsletter-widget p { font-size: 14px; color: var(--grey-400); margin-bottom: 16px; }
        .newsletter-widget input { width: 100%; padding: 12px; border: 1px solid var(--grey-700); background: var(--grey-900); color: var(--white); font-family: inherit; font-size: 14px; margin-bottom: 10px; }
        .newsletter-widget button { width: 100%; padding: 12px; background: var(--white); color: var(--black); border: none; font-family: inherit; font-size: 14px; font-weight: 600; cursor: pointer; }

        /* Page Header */
        .page-header { padding: 40px 0 32px; border-bottom: 1px solid var(--grey-200); }

        @media (max-width: 768px) {
            .listings-layout { grid-template-columns: 1fr; }
            .listing-card { grid-template-columns: 1fr; }
            .courses-grid { grid-template-columns: 1fr; }
            .suppliers-grid { grid-template-columns: repeat(2, 1fr); }
            .news-layout { grid-template-columns: 1fr; }
            .featured-story { grid-template-columns: 1fr; }
            .news-grid { grid-template-columns: 1fr; }
            .resources-grid-page { grid-template-columns: 1fr; }
            .resources-categories-inner { flex-wrap: wrap; gap: 8px; }
            .training-stats { flex-wrap: wrap; gap: 20px; }
            /* Leave .container padding at 32px on mobile so the header
               and footer on every authenticated page line up exactly with
               the homepage. The landing page's .container does not drop
               its padding on mobile, so this one must not either. */
            .grid-2, .grid-3, .grid-4 { grid-template-columns: 1fr; }
            .grid-sidebar { grid-template-columns: 1fr; }
            .footer-top { grid-template-columns: 1fr 1fr; gap: 24px; }
            .header-top { display: none; }
            .category-nav a { padding: 10px 12px; font-size: 12px; }
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
                        @if(auth()->user()->canAccessCms())
                            <a href="/admin" style="font-size:13px;font-weight:600;color:var(--green);text-decoration:none;">Admin Panel</a>
                        @endif
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
