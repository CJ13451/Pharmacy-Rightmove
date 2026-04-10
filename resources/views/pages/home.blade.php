<x-layouts.app title="Home">
<div class="container">
    <div class="page-content">
        <div style="background:var(--grey-50);padding:24px;border:1px solid var(--grey-200);margin-bottom:32px;">
            <div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:16px;">
                <div>
                    <h1 style="font-family:'Newsreader',serif;font-size:28px;font-weight:700;">Welcome back, {{ auth()->user()->first_name }}</h1>
                    <p style="font-size:14px;color:var(--grey-600);">Here's what's happening in the pharmacy market today.</p>
                </div>
                <div style="display:flex;gap:10px;">
                    <a href="{{ route('listings.index') }}" class="btn btn-green">Browse Pharmacies</a>
                    <a href="{{ route('news.index') }}" class="btn btn-outline">Latest News</a>
                </div>
            </div>
        </div>

        <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-bottom:40px;">
            <div class="card" style="text-align:center;">
                <div style="font-size:28px;font-weight:800;">{{ $stats['listings_count'] ?? 0 }}</div>
                <div style="font-size:12px;color:var(--grey-500);">Active Listings</div>
            </div>
            <div class="card" style="text-align:center;">
                <div style="font-size:28px;font-weight:800;">{{ $stats['articles_count'] ?? 0 }}</div>
                <div style="font-size:12px;color:var(--grey-500);">Articles</div>
            </div>
            <div class="card" style="text-align:center;">
                <div style="font-size:28px;font-weight:800;">{{ $stats['courses_count'] ?? 0 }}</div>
                <div style="font-size:12px;color:var(--grey-500);">Training Courses</div>
            </div>
            <div class="card" style="text-align:center;">
                <div style="font-size:28px;font-weight:800;color:var(--green);">Free</div>
                <div style="font-size:12px;color:var(--grey-500);">Membership</div>
            </div>
        </div>

        <div class="grid-sidebar">
            <div>
                <section style="margin-bottom:40px;">
                    <div class="section-header">
                        <h2 class="section-title">Featured Pharmacies</h2>
                        <a href="{{ route('listings.index') }}" class="section-link">View all &rarr;</a>
                    </div>
                    @if($featuredListings->count() > 0)
                        <div class="grid-2">
                            @foreach($featuredListings as $listing)
                                <a href="{{ route('listings.show', $listing->slug) }}" class="card" style="text-decoration:none;padding:0;">
                                    <div style="height:120px;background:linear-gradient(135deg,#e8e4e0,#d8d4d0);position:relative;">
                                        @if($listing->primary_image)
                                            <img src="{{ $listing->primary_image }}" alt="{{ $listing->title }}" style="width:100%;height:100%;object-fit:cover;">
                                        @endif
                                        <span class="tag tag-green" style="position:absolute;top:8px;left:8px;">Featured</span>
                                    </div>
                                    <div style="padding:14px;">
                                        <div style="font-size:20px;font-weight:800;margin-bottom:4px;">{{ $listing->formatted_price }}</div>
                                        <div style="font-size:13px;font-weight:500;color:var(--grey-800);margin-bottom:4px;">{{ $listing->title }}</div>
                                        <div style="font-size:12px;color:var(--grey-500);">{{ $listing->location }}</div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="empty-state">No featured listings at the moment.</div>
                    @endif
                </section>

                <section>
                    <div class="section-header">
                        <h2 class="section-title">Latest News</h2>
                        <a href="{{ route('news.index') }}" class="section-link">All news &rarr;</a>
                    </div>
                    @if($latestArticles->count() > 0)
                        @foreach($latestArticles as $article)
                            <a href="{{ route('news.show', $article->slug) }}" style="display:grid;grid-template-columns:120px 1fr;gap:16px;padding-bottom:16px;margin-bottom:16px;border-bottom:1px solid var(--grey-100);text-decoration:none;">
                                <div style="height:80px;background:var(--grey-100);"></div>
                                <div>
                                    <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:var(--green);margin-bottom:4px;">{{ $article->type?->label() ?? 'News' }}</div>
                                    <div style="font-family:'Newsreader',serif;font-size:17px;font-weight:600;color:var(--black);line-height:1.35;">{{ $article->title }}</div>
                                    <div style="font-size:12px;color:var(--grey-500);margin-top:4px;">{{ $article->formatted_date }}</div>
                                </div>
                            </a>
                        @endforeach
                    @else
                        <div class="empty-state">No articles published yet.</div>
                    @endif
                </section>
            </div>

            <aside>
                <div class="card">
                    <h3 style="font-size:13px;font-weight:800;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:16px;padding-bottom:10px;border-bottom:2px solid var(--black);">Quick Links</h3>
                    <div style="display:flex;flex-direction:column;gap:8px;">
                        <a href="{{ route('listings.index') }}" style="display:flex;gap:10px;padding:10px;background:var(--grey-50);text-decoration:none;font-size:13px;font-weight:600;color:var(--black);">&#x1F3E0; Pharmacies for Sale</a>
                        <a href="{{ route('training.index') }}" style="display:flex;gap:10px;padding:10px;background:var(--grey-50);text-decoration:none;font-size:13px;font-weight:600;color:var(--black);">&#x1F393; Training Courses</a>
                        <a href="{{ route('suppliers.index') }}" style="display:flex;gap:10px;padding:10px;background:var(--grey-50);text-decoration:none;font-size:13px;font-weight:600;color:var(--black);">&#x1F4BC; Supplier Directory</a>
                        <a href="{{ route('resources.index') }}" style="display:flex;gap:10px;padding:10px;background:var(--grey-50);text-decoration:none;font-size:13px;font-weight:600;color:var(--black);">&#x1F4CB; Guides & Resources</a>
                        <a href="{{ route('valuations') }}" style="display:flex;gap:10px;padding:10px;background:var(--grey-50);text-decoration:none;font-size:13px;font-weight:600;color:var(--black);">&#x1F4CA; Valuations</a>
                    </div>
                </div>

                @if($featuredCourses->count() > 0)
                <div class="card" style="margin-top:20px;">
                    <h3 style="font-size:13px;font-weight:800;text-transform:uppercase;letter-spacing:0.5px;margin-bottom:16px;padding-bottom:10px;border-bottom:2px solid var(--black);">Popular Courses</h3>
                    @foreach($featuredCourses as $course)
                        <a href="{{ route('training.show', $course->slug) }}" style="display:block;text-decoration:none;margin-bottom:12px;">
                            <div style="font-size:13px;font-weight:600;color:var(--black);">{{ $course->title }}</div>
                            <div style="font-size:11px;color:var(--grey-500);margin-top:2px;">
                                {{ $course->formatted_duration }}
                                @if($course->cpd_accredited) &middot; <span style="color:var(--green);">CPD Accredited</span> @endif
                            </div>
                        </a>
                    @endforeach
                </div>
                @endif

                @if(!auth()->user()->gphc_number && auth()->user()->job_title?->requiresGphc())
                <div style="background:#fffbeb;border:1px solid #fde68a;padding:20px;margin-top:20px;">
                    <h3 style="font-size:14px;font-weight:700;color:#92400e;margin-bottom:6px;">Complete Your Profile</h3>
                    <p style="font-size:12px;color:#a16207;margin-bottom:10px;">Add your GPhC number to unlock all features.</p>
                    <a href="{{ route('account.settings') }}" style="font-size:12px;font-weight:600;color:#92400e;">Update profile &rarr;</a>
                </div>
                @endif
            </aside>
        </div>
    </div>
</div>
</x-layouts.app>
