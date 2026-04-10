<x-layouts.app title="Home">
@push('styles')
<style>
    /* ---- Landing-page-specific styles (home + landing routes) ---- */
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
    .property-agent-badge { position: absolute; top: 8px; right: 8px; width: 34px; height: 34px; border-radius: 50%; background: var(--white); border: 2px solid var(--white); box-shadow: 0 2px 6px rgba(0,0,0,0.2); display: flex; align-items: center; justify-content: center; font-family: 'Inter', sans-serif; font-size: 10px; font-weight: 800; color: var(--green); }
    .property-content { padding: 14px; }
    .property-price { font-family: 'Inter', sans-serif; font-size: 20px; font-weight: 800; color: var(--black); margin-bottom: 4px; }
    .property-title { font-size: 13px; font-weight: 500; color: var(--grey-800); margin-bottom: 4px; line-height: 1.4; }
    .property-location { font-size: 12px; color: var(--grey-500); }
    .home-sidebar { display: flex; flex-direction: column; gap: 28px; }
    .home-sidebar-section { border: 1px solid var(--grey-200); padding: 20px; }
    .home-sidebar-title { font-size: 13px; font-weight: 800; text-transform: uppercase; letter-spacing: 0.5px; color: var(--black); margin-bottom: 16px; padding-bottom: 10px; border-bottom: 2px solid var(--black); }
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
    .home-newsletter-widget { background: var(--black); padding: 20px; }
    .home-newsletter-widget h3 { font-size: 16px; font-weight: 800; color: var(--white); margin-bottom: 6px; }
    .home-newsletter-widget p { font-size: 13px; color: var(--grey-400); margin-bottom: 14px; }
    .home-newsletter-widget input { width: 100%; padding: 10px 12px; border: 1px solid var(--grey-700); background: var(--grey-900); color: var(--white); font-family: inherit; font-size: 13px; margin-bottom: 10px; }
    .home-newsletter-widget input::placeholder { color: var(--grey-500); }
    .home-newsletter-widget button { width: 100%; padding: 10px; background: var(--white); color: var(--black); border: none; font-family: inherit; font-size: 13px; font-weight: 600; cursor: pointer; }
    .home-newsletter-widget button:hover { background: var(--grey-100); }
    .resources-full { background: var(--grey-50); padding: 40px 0; border-top: 1px solid var(--grey-200); border-bottom: 1px solid var(--grey-200); margin-top: 24px; }
    .resources-full .resources-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 20px; }
    .resources-full .resource-card { background: var(--white); border: 1px solid var(--grey-200); padding: 20px; text-decoration: none; transition: all 0.15s; }
    .resources-full .resource-card:hover { border-color: var(--black); }
    .resources-full .resource-icon { font-size: 24px; margin-bottom: 14px; }
    .resources-full .resource-type { font-size: 10px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; color: var(--grey-500); margin-bottom: 6px; }
    .resources-full .resource-title { font-size: 14px; font-weight: 700; color: var(--black); line-height: 1.4; margin-bottom: 6px; }
    .resources-full .resource-desc { font-size: 12px; color: var(--grey-600); }
    @media (max-width: 768px) {
        .main-layout { grid-template-columns: 1fr; }
        .featured-story { grid-template-columns: 1fr; }
        .properties-grid { grid-template-columns: 1fr; }
        .resources-full .resources-grid { grid-template-columns: repeat(2, 1fr); }
    }
</style>
@endpush

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
                            @php
                                $agentName = $listing->agent_company ?: $listing->agent_name;
                                $agentInitials = collect(preg_split('/\s+/', trim($agentName)))
                                    ->filter()
                                    ->take(2)
                                    ->map(fn ($w) => mb_strtoupper(mb_substr($w, 0, 1)))
                                    ->join('');
                            @endphp
                            <a href="{{ route('listings.show', $listing->slug) }}" class="property-card">
                                <div class="property-image">
                                    @if($listing->featured)
                                        <span class="property-badge">Featured</span>
                                    @endif
                                    <span class="property-agent-badge" title="{{ $agentName }}">{{ $agentInitials ?: 'P3' }}</span>
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

        <aside class="home-sidebar">
            <div class="home-sidebar-section">
                <h3 class="home-sidebar-title">Tools & Calculators</h3>
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
                <div class="home-sidebar-section">
                    <h3 class="home-sidebar-title">Training for Buyers</h3>
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
                <div class="home-sidebar-section">
                    <h3 class="home-sidebar-title">Supplier Directory</h3>
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

            <div class="home-newsletter-widget">
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
</x-layouts.app>
