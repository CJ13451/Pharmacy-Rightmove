<x-layouts.app title="News & Analysis">
<div class="container">
    <div class="news-layout">
        <div class="news-main">
            @if($featuredArticles->count() > 0)
                @php $featured = $featuredArticles->first(); @endphp
                <div class="featured-story">
                    <div class="featured-image"></div>
                    <div class="featured-content">
                        <div class="story-category">{{ $featured->type->label() }}</div>
                        <h2><a href="{{ route('news.show', $featured->slug) }}">{{ $featured->title }}</a></h2>
                        <p class="story-excerpt">{{ Str::limit($featured->excerpt, 160) }}</p>
                        <div class="story-meta">{{ $featured->formatted_date }} &middot; {{ $featured->reading_time_minutes ?? 4 }} min read</div>
                    </div>
                </div>
            @endif

            <div class="section">
                <div class="section-header">
                    <h2 class="section-title">Latest News</h2>
                </div>
                <div class="news-grid">
                    @forelse($articles as $article)
                        <a href="{{ route('news.show', $article->slug) }}" class="news-card">
                            <div class="news-card-image"></div>
                            <div class="story-category">{{ $article->type->label() }}</div>
                            <h3>{{ $article->title }}</h3>
                            <div class="story-meta">{{ $article->formatted_date }} &middot; {{ $article->reading_time_minutes ?? 4 }} min read</div>
                        </a>
                    @empty
                        <div class="empty-state" style="grid-column:1/-1;">No articles published yet.</div>
                    @endforelse
                </div>
                @if($articles->hasPages())
                    <div style="padding-top:20px;">{{ $articles->withQueryString()->links() }}</div>
                @endif
            </div>
        </div>

        <aside class="sidebar">
            <div class="sidebar-section">
                <h3 class="sidebar-title">Trending</h3>
                <div class="trending-list">
                    @foreach($featuredArticles->take(4) as $i => $trending)
                        <a href="{{ route('news.show', $trending->slug) }}" class="trending-item">
                            <span class="trending-number">{{ $i + 1 }}</span>
                            <div class="trending-content">
                                <h4>{{ $trending->title }}</h4>
                                <div class="trending-meta">{{ $trending->views_count ?? 0 }} views</div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="newsletter-widget">
                <h3>Weekly Intelligence</h3>
                <p>Analysis & insights for pharmacy owners. Every Thursday.</p>
                <input type="email" placeholder="Your email">
                <button>Subscribe Free</button>
            </div>
        </aside>
    </div>
</div>
</x-layouts.app>
