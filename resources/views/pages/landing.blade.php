<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>P3 Pharmacy - Intelligence. Analysis. Insight.</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800;900&family=Newsreader:ital,wght@0,400;0,500;0,600;0,700;1,400&display=swap" rel="stylesheet">
    <style>
        :root {
            --black: #1a1a1a;
            --grey-900: #111111;
            --grey-800: #222222;
            --grey-700: #444444;
            --grey-600: #666666;
            --grey-500: #888888;
            --grey-400: #aaaaaa;
            --grey-300: #cccccc;
            --grey-200: #e0e0e0;
            --grey-100: #f0f0f0;
            --grey-50: #f8f8f8;
            --white: #ffffff;
            --green: #00875a;
            --orange: #ff6b00;
            --blue: #0066cc;
        }
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', -apple-system, sans-serif; background: var(--white); color: var(--black); font-size: 15px; line-height: 1.6; }
        .container { max-width: 1280px; margin: 0 auto; padding: 0 32px; }
        .header { border-bottom: 1px solid var(--grey-200); }
        .header-top { display: flex; justify-content: space-between; align-items: center; padding: 12px 0; border-bottom: 1px solid var(--grey-100); }
        .header-top-left { display: flex; gap: 24px; font-size: 13px; color: var(--grey-600); }
        .header-top-left a { color: var(--grey-600); text-decoration: none; }
        .header-top-left a:hover { color: var(--black); }
        .header-top-right { display: flex; gap: 16px; align-items: center; }
        .btn { display: inline-flex; align-items: center; gap: 6px; padding: 8px 16px; font-family: inherit; font-size: 13px; font-weight: 600; border-radius: 4px; text-decoration: none; border: none; cursor: pointer; transition: all 0.15s; }
        .btn-text { background: none; color: var(--grey-700); padding: 8px 0; }
        .btn-primary { background: var(--black); color: white; }
        .btn-primary:hover { background: var(--grey-800); }
        .header-main { display: flex; justify-content: space-between; align-items: center; padding: 20px 0; }
        .logo { display: flex; flex-direction: column; }
        .logo-main { display: flex; align-items: baseline; font-family: 'Inter', sans-serif; font-weight: 900; font-size: 32px; letter-spacing: -1px; color: var(--black); }
        .logo-tagline { font-size: 11px; font-weight: 500; color: var(--grey-600); letter-spacing: 0.5px; margin-top: 2px; }
        .header-url { font-size: 13px; color: var(--grey-500); }
        .category-nav {
            display: flex;
            gap: 0;
            background: linear-gradient(to bottom, transparent calc(100% - 3px), var(--black) calc(100% - 3px));
            overflow-x: auto;
            overflow-y: hidden;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: none;
            -ms-overflow-style: none;
        }
        .category-nav::-webkit-scrollbar { display: none; }
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
            box-shadow: inset 0 -3px 0 var(--green);
        }
        .category-nav a.highlight { background: var(--green); color: white; }
        .category-nav a.highlight:hover { background: #006644; }
        .main-layout { display: grid; grid-template-columns: 1fr 340px; gap: 48px; padding: 40px 0; }
        .section { margin-bottom: 40px; }
        .section-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; padding-bottom: 12px; border-bottom: 2px solid var(--black); }
        .section-title { font-family: 'Inter', sans-serif; font-size: 18px; font-weight: 800; color: var(--black); text-transform: uppercase; letter-spacing: 0.5px; }
        .section-link { font-size: 13px; font-weight: 600; color: var(--green); text-decoration: none; }
        .section-link:hover { text-decoration: underline; }
        .featured-story { display: grid; grid-template-columns: 1.2fr 1fr; gap: 32px; padding-bottom: 32px; border-bottom: 1px solid var(--grey-200); margin-bottom: 32px; }
        .featured-image { height: 300px; background: linear-gradient(135deg, #2a4a6a 0%, #1a3050 100%); }
        .featured-content { display: flex; flex-direction: column; justify-content: center; }
        .story-category { font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; color: var(--green); margin-bottom: 12px; }
        .featured-content h2 { font-family: 'Newsreader', serif; font-size: 28px; font-weight: 700; line-height: 1.25; margin-bottom: 16px; }
        .featured-content h2 a { color: var(--black); text-decoration: none; }
        .featured-content h2 a:hover { color: var(--green); }
        .story-excerpt { font-size: 15px; color: var(--grey-700); line-height: 1.6; margin-bottom: 16px; }
        .story-meta { font-size: 13px; color: var(--grey-500); }
        .news-list { display: flex; flex-direction: column; gap: 20px; }
        .news-item { display: grid; grid-template-columns: 140px 1fr; gap: 16px; padding-bottom: 20px; border-bottom: 1px solid var(--grey-100); text-decoration: none; }
        .news-item:last-child { border-bottom: none; }
        .news-thumb { height: 90px; background: var(--grey-100); }
        .news-content .story-category { margin-bottom: 6px; }
        .news-content h3 { font-family: 'Newsreader', serif; font-size: 17px; font-weight: 600; line-height: 1.35; margin-bottom: 6px; color: var(--black); }
        .news-item:hover h3 { color: var(--green); }
        .news-content .story-meta { font-size: 12px; }
        .properties-section { background: var(--grey-50); padding: 28px; margin-bottom: 40px; border: 1px solid var(--grey-200); }
        .properties-grid { display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px; }
        .property-card { background: var(--white); border: 1px solid var(--grey-200); text-decoration: none; transition: all 0.15s; }
        .property-card:hover { border-color: var(--black); }
        .property-image { height: 110px; background: linear-gradient(135deg, #e8e4e0 0%, #d8d4d0 100%); position: relative; }
        .property-badge { position: absolute; top: 8px; left: 8px; background: var(--green); color: white; padding: 2px 8px; font-size: 10px; font-weight: 700; text-transform: uppercase; }
        .property-content { padding: 14px; }
        .property-price { font-family: 'Inter', sans-serif; font-size: 20px; font-weight: 800; color: var(--black); margin-bottom: 4px; }
        .property-title { font-size: 13px; font-weight: 500; color: var(--grey-800); margin-bottom: 4px; line-height: 1.4; }
        .property-location { font-size: 12px; color: var(--grey-500); }
        .sidebar { display: flex; flex-direction: column; gap: 28px; }
        .sidebar-section { border: 1px solid var(--grey-200); padding: 20px; }
        .sidebar-title { font-size: 13px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; color: var(--black); margin-bottom: 16px; padding-bottom: 10px; border-bottom: 2px solid var(--black); }
        .quick-tools { display: flex; flex-direction: column; gap: 10px; }
        .quick-tool { display: flex; gap: 12px; padding: 12px; background: var(--grey-50); text-decoration: none; transition: background 0.15s; }
        .quick-tool:hover { background: var(--grey-100); }
        .quick-tool-icon { width: 36px; height: 36px; background: var(--white); border: 1px solid var(--grey-200); display: flex; align-items: center; justify-content: center; font-size: 16px; flex-shrink: 0; }
        .quick-tool-content h4 { font-size: 13px; font-weight: 600; color: var(--black); margin-bottom: 2px; }
        .quick-tool-content p { font-size: 11px; color: var(--grey-500); }
        .suppliers-widget { display: grid; grid-template-columns: repeat(2, 1fr); gap: 10px; }
        .supplier-item { padding: 14px 10px; background: var(--grey-50); text-align: center; text-decoration: none; transition: background 0.15s; }
        .supplier-item:hover { background: var(--grey-100); }
        .supplier-item-logo { width: 36px; height: 36px; background: var(--white); border: 1px solid var(--grey-200); border-radius: 4px; margin: 0 auto 6px; display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: 700; color: var(--grey-400); }
        .supplier-item-name { font-size: 11px; font-weight: 600; color: var(--black); }
        .supplier-item-cat { font-size: 10px; color: var(--grey-500); }
        .training-list { display: flex; flex-direction: column; gap: 14px; }
        .training-item { display: flex; gap: 10px; text-decoration: none; }
        .training-item:hover h4 { color: var(--green); }
        .training-badge { padding: 3px 6px; background: var(--black); color: white; font-size: 9px; font-weight: 700; text-transform: uppercase; white-space: nowrap; height: fit-content; }
        .training-item h4 { font-size: 13px; font-weight: 600; color: var(--black); line-height: 1.4; }
        .training-item p { font-size: 11px; color: var(--grey-500); margin-top: 2px; }
        .newsletter-widget { background: var(--black); padding: 20px; }
        .newsletter-widget h3 { font-size: 16px; font-weight: 800; color: var(--white); margin-bottom: 6px; }
        .newsletter-widget p { font-size: 13px; color: var(--grey-400); margin-bottom: 14px; }
        .newsletter-widget input { width: 100%; padding: 10px 12px; border: 1px solid var(--grey-700); background: var(--grey-900); color: var(--white); font-family: inherit; font-size: 13px; margin-bottom: 10px; }
        .newsletter-widget input::placeholder { color: var(--grey-500); }
        .newsletter-widget button { width: 100%; padding: 10px; background: var(--white); color: var(--black); border: none; font-family: inherit; font-size: 13px; font-weight: 600; cursor: pointer; }
        .newsletter-widget button:hover { background: var(--grey-100); }
        .resources-full { background: var(--grey-50); padding: 40px 0; border-top: 1px solid var(--grey-200); border-bottom: 1px solid var(--grey-200); }
        .resources-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; }
        .resource-card { background: var(--white); border: 1px solid var(--grey-200); padding: 20px; text-decoration: none; transition: all 0.15s; }
        .resource-card:hover { border-color: var(--black); }
        .resource-icon { font-size: 24px; margin-bottom: 14px; }
        .resource-type { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: var(--grey-500); margin-bottom: 6px; }
        .resource-title { font-size: 14px; font-weight: 700; color: var(--black); line-height: 1.4; margin-bottom: 6px; }
        .resource-desc { font-size: 12px; color: var(--grey-600); }
        .footer { background: var(--black); color: var(--white); padding: 56px 0 28px; }
        .footer-top { display: grid; grid-template-columns: 1.5fr 1fr 1fr 1fr 1fr; gap: 40px; padding-bottom: 40px; border-bottom: 1px solid var(--grey-700); }
        .footer-brand .logo-main { font-size: 24px; color: var(--white); margin-bottom: 4px; }
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
        @media (max-width: 768px) {
            .main-layout { grid-template-columns: 1fr; }
            .featured-story { grid-template-columns: 1fr; }
            .properties-grid { grid-template-columns: 1fr; }
            .resources-grid { grid-template-columns: repeat(2, 1fr); }
            .footer-top { grid-template-columns: 1fr 1fr; }
            .category-nav a { padding: 10px 12px; font-size: 12px; }
            .header-top { display: none; }
        }
    </style>
</head>
<body>
    <header class="header">
        <div class="container">
            <div class="header-top">
                <div class="header-top-left">
                    <span>{{ now()->format('l, j F Y') }}</span>
                    <a href="#">About</a>
                    <a href="#">Advertise</a>
                    <a href="#">Contact</a>
                </div>
                <div class="header-top-right">
                    @auth
                        <span style="font-size:13px;color:var(--grey-600);">{{ auth()->user()->full_name }}</span>
                        @if(auth()->user()->canAccessCms())
                            <a href="/admin" class="btn btn-text">Admin Panel</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-text" style="cursor:pointer;">Sign Out</button>
                        </form>
                    @else
                        <a href="{{ route('login') }}" class="btn btn-text">Sign In</a>
                        <a href="{{ route('register') }}" class="btn btn-primary">Subscribe</a>
                    @endauth
                </div>
            </div>
            <div class="header-main">
                <div class="logo">
                    <div class="logo-main"><span class="logo-p3">p3</span><span class="logo-pharmacy">pharmacy</span></div>
                    <div class="logo-tagline">Intelligence. Analysis. Insight.</div>
                </div>
                <div class="header-url">p3pharmacy.co.uk</div>
            </div>
            <nav class="category-nav">
                <a href="/" class="active">Home</a>
                <a href="{{ route('news.index') }}">News</a>
                <a href="{{ route('listings.index') }}" class="highlight">Pharmacies for Sale</a>
                <a href="{{ route('buying-guide') }}">Buying Guide</a>
                <a href="{{ route('valuations') }}">Valuations</a>
                <a href="{{ route('training.index') }}">Training</a>
                <a href="{{ route('suppliers.index') }}">Suppliers</a>
                <a href="{{ route('resources.index') }}">Resources</a>
            </nav>
        </div>
    </header>

    <main>
        <div class="container">
            <div class="main-layout">
                <div class="main-content">
                    @if($featuredArticle)
                        <div class="featured-story">
                            <div class="featured-image"></div>
                            <div class="featured-content">
                                <div class="story-category">{{ $featuredArticle->category->label() }}</div>
                                <h2><a href="{{ route('news.show', $featuredArticle->slug) }}">{{ $featuredArticle->title }}</a></h2>
                                <p class="story-excerpt">{{ $featuredArticle->excerpt_or_truncated }}</p>
                                <div class="story-meta">By {{ $featuredArticle->author_name }} &middot; {{ $featuredArticle->formatted_date }}</div>
                            </div>
                        </div>
                    @endif

                    @if($featuredListings->isNotEmpty())
                        <div class="properties-section">
                            <div class="section-header" style="border: none; padding: 0; margin-bottom: 16px;">
                                <h2 class="section-title">Pharmacies for Sale</h2>
                                <a href="{{ route('listings.index') }}" class="section-link">View all &rarr;</a>
                            </div>
                            <div class="properties-grid">
                                @foreach($featuredListings as $listing)
                                    <a href="{{ route('listings.show', $listing->slug) }}" class="property-card">
                                        <div class="property-image">
                                            @if($listing->featured)
                                                <span class="property-badge">Featured</span>
                                            @endif
                                        </div>
                                        <div class="property-content">
                                            <div class="property-price">{{ $listing->formatted_price }}</div>
                                            <div class="property-title">{{ $listing->title }}</div>
                                            <div class="property-location">
                                                {{ $listing->town }}@if($listing->county), {{ $listing->county }}@endif
                                                &middot; {{ \Illuminate\Support\Str::title(str_replace('_', ' ', $listing->property_type)) }}
                                                @if($listing->monthly_items)
                                                    &middot; {{ number_format($listing->monthly_items) }} items
                                                @endif
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($latestArticles->isNotEmpty())
                        <section class="section">
                            <div class="section-header">
                                <h2 class="section-title">Latest News</h2>
                                <a href="{{ route('news.index') }}" class="section-link">All news &rarr;</a>
                            </div>
                            <div class="news-list">
                                @foreach($latestArticles as $article)
                                    <a href="{{ route('news.show', $article->slug) }}" class="news-item">
                                        <div class="news-thumb"></div>
                                        <div class="news-content">
                                            <div class="story-category">{{ $article->category->label() }}</div>
                                            <h3>{{ $article->title }}</h3>
                                            <div class="story-meta">{{ $article->formatted_date }} &middot; {{ $article->reading_time_minutes }} min read</div>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </section>
                    @endif
                </div>

                <aside class="sidebar">
                    <div class="sidebar-section">
                        <h3 class="sidebar-title">Tools & Calculators</h3>
                        <div class="quick-tools">
                            <a href="{{ route('resources.index') }}" class="quick-tool">
                                <div class="quick-tool-icon">&#x1F4CA;</div>
                                <div class="quick-tool-content"><h4>Valuation Calculator</h4><p>Estimate pharmacy values</p></div>
                            </a>
                            <a href="{{ route('resources.index') }}" class="quick-tool">
                                <div class="quick-tool-icon">&#x1F4CB;</div>
                                <div class="quick-tool-content"><h4>Due Diligence Checklist</h4><p>Before you make an offer</p></div>
                            </a>
                            <a href="{{ route('resources.index') }}" class="quick-tool">
                                <div class="quick-tool-icon">&#x1F4C8;</div>
                                <div class="quick-tool-content"><h4>Benchmarking Tool</h4><p>Compare your performance</p></div>
                            </a>
                        </div>
                    </div>

                    @if($featuredCourses->isNotEmpty())
                        <div class="sidebar-section">
                            <h3 class="sidebar-title">Training for Buyers</h3>
                            <div class="training-list">
                                @foreach($featuredCourses as $course)
                                    <a href="{{ route('training.show', $course->slug) }}" class="training-item">
                                        <span class="training-badge">{{ $course->cpd_accredited ? 'CPD' : 'Course' }}</span>
                                        <div>
                                            <h4>{{ $course->title }}</h4>
                                            <p>
                                                {{ $course->modules_count }} modules
                                                @if($course->cpd_accredited)
                                                    &middot; CPD accredited
                                                @elseif($course->is_free)
                                                    &middot; Free
                                                @endif
                                            </p>
                                        </div>
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if($directorySuppliers->isNotEmpty())
                        <div class="sidebar-section">
                            <h3 class="sidebar-title">Supplier Directory</h3>
                            <div class="suppliers-widget">
                                @foreach($directorySuppliers as $supplier)
                                    <a href="{{ route('suppliers.show', $supplier->slug) }}" class="supplier-item">
                                        <div class="supplier-item-logo">{{ \Illuminate\Support\Str::upper(\Illuminate\Support\Str::substr(str_replace(' ', '', $supplier->name), 0, 3)) }}</div>
                                        <div class="supplier-item-name">{{ \Illuminate\Support\Str::limit($supplier->name, 16) }}</div>
                                        <div class="supplier-item-cat">{{ $supplier->category->label() }}</div>
                                    </a>
                                @endforeach
                            </div>
                            <a href="{{ route('suppliers.index') }}" class="section-link" style="display: block; margin-top: 14px; text-align: center;">
                                View all {{ $totalSuppliers }}{{ $totalSuppliers > 10 ? '+' : '' }} suppliers &rarr;
                            </a>
                        </div>
                    @endif

                    <div class="newsletter-widget">
                        <h3>Weekly Intelligence</h3>
                        <p>Analysis & insights for pharmacy owners. Every Thursday.</p>
                        <input type="email" placeholder="Your email">
                        <button onclick="window.location.href='{{ route('register') }}'">Subscribe Free</button>
                    </div>
                </aside>
            </div>
        </div>

        @if($featuredResources->isNotEmpty())
            <section class="resources-full">
                <div class="container">
                    <div class="section-header">
                        <h2 class="section-title">Resources & Guides</h2>
                        <a href="{{ route('resources.index') }}" class="section-link">View all &rarr;</a>
                    </div>
                    <div class="resources-grid">
                        @foreach($featuredResources as $resource)
                            <a href="{{ route('resources.show', $resource->slug) }}" class="resource-card">
                                <div class="resource-icon">{{ $resource->type_icon }}</div>
                                <div class="resource-type">{{ $resource->type_label }}</div>
                                <h3 class="resource-title">{{ $resource->title }}</h3>
                                <p class="resource-desc">{{ \Illuminate\Support\Str::limit($resource->description, 90) }}</p>
                            </a>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    </main>

    <footer class="footer">
        <div class="container">
            <div class="footer-top">
                <div class="footer-brand">
                    <div class="logo-main"><span class="logo-p3">p3</span><span class="logo-pharmacy">pharmacy</span></div>
                    <div class="logo-tagline">Intelligence. Analysis. Insight.</div>
                    <p class="footer-desc">The essential resource for UK pharmacy owners and prospective buyers.</p>
                </div>
                <div class="footer-col">
                    <h4>Marketplace</h4>
                    <ul>
                        <li><a href="{{ route('listings.index') }}">For Sale</a></li>
                        <li><a href="{{ route('listings.index') }}">To Let</a></li>
                        <li><a href="{{ route('listings.index') }}">Recently Sold</a></li>
                        <li><a href="{{ route('listings.index') }}">List Property</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Resources</h4>
                    <ul>
                        <li><a href="{{ route('buying-guide') }}">Buying Guide</a></li>
                        <li><a href="{{ route('valuations') }}">Valuations</a></li>
                        <li><a href="{{ route('training.index') }}">Training</a></li>
                        <li><a href="{{ route('resources.index') }}">Templates</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Directory</h4>
                    <ul>
                        <li><a href="{{ route('suppliers.index') }}">Wholesalers</a></li>
                        <li><a href="{{ route('suppliers.index') }}">PMR Systems</a></li>
                        <li><a href="{{ route('suppliers.index') }}">Buying Groups</a></li>
                        <li><a href="{{ route('suppliers.index') }}">All Suppliers</a></li>
                    </ul>
                </div>
                <div class="footer-col">
                    <h4>Company</h4>
                    <ul>
                        <li><a href="#">About</a></li>
                        <li><a href="#">Advertise</a></li>
                        <li><a href="#">Contact</a></li>
                        <li><a href="#">Careers</a></li>
                    </ul>
                </div>
            </div>
            <div class="footer-bottom">
                <span>&copy; {{ date('Y') }} P3 Pharmacy. All rights reserved.</span>
                <span>
                    <a href="{{ route('privacy') }}">Privacy</a>
                    <a href="{{ route('terms') }}">Terms</a>
                    <a href="#">Cookies</a>
                </span>
            </div>
        </div>
    </footer>
</body>
</html>
