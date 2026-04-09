<x-layouts.app title="Home">
    <!-- Welcome Section -->
    <section class="bg-gradient-to-br from-gray-900 to-gray-800 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-3xl font-bold mb-2">Welcome back, {{ auth()->user()->first_name }}</h1>
                    <p class="text-gray-300">Here's what's happening in the pharmacy market today.</p>
                </div>
                <div class="mt-4 md:mt-0 flex gap-3">
                    <a href="{{ route('listings.index') }}" class="bg-green-600 hover:bg-green-700 text-white px-5 py-2.5 rounded-lg font-medium transition">
                        Browse Pharmacies
                    </a>
                    <a href="{{ route('news.index') }}" class="bg-white/10 hover:bg-white/20 text-white px-5 py-2.5 rounded-lg font-medium transition">
                        Latest News
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
        <!-- Stats Overview -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-12">
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <div class="text-3xl font-bold text-gray-900">{{ $stats['listings_count'] ?? 0 }}</div>
                <div class="text-gray-500 text-sm">Active Listings</div>
            </div>
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <div class="text-3xl font-bold text-gray-900">{{ $stats['articles_count'] ?? 0 }}</div>
                <div class="text-gray-500 text-sm">Articles</div>
            </div>
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <div class="text-3xl font-bold text-gray-900">{{ $stats['courses_count'] ?? 0 }}</div>
                <div class="text-gray-500 text-sm">Training Courses</div>
            </div>
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <div class="text-3xl font-bold text-green-600">Free</div>
                <div class="text-gray-500 text-sm">Membership</div>
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Featured Listings -->
                <section>
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-900">Featured Pharmacies</h2>
                        <a href="{{ route('listings.index') }}" class="text-green-600 hover:text-green-700 font-medium text-sm">
                            View all →
                        </a>
                    </div>
                    
                    @if($featuredListings->count() > 0)
                        <div class="grid md:grid-cols-2 gap-4">
                            @foreach($featuredListings as $listing)
                                <a href="{{ route('listings.show', $listing->slug) }}" class="bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-md transition group">
                                    <div class="h-40 bg-gradient-to-br from-green-500 to-green-600 relative">
                                        @if($listing->primary_image)
                                            <img src="{{ $listing->primary_image }}" alt="{{ $listing->title }}" class="w-full h-full object-cover">
                                        @endif
                                        <div class="absolute top-3 left-3">
                                            <span class="bg-amber-400 text-amber-900 text-xs font-bold px-2 py-1 rounded">FEATURED</span>
                                        </div>
                                    </div>
                                    <div class="p-4">
                                        <div class="text-xl font-bold text-green-600 mb-1">{{ $listing->formatted_price }}</div>
                                        <h3 class="font-semibold text-gray-900 group-hover:text-green-600 transition line-clamp-1">{{ $listing->title }}</h3>
                                        <p class="text-gray-500 text-sm mt-1">{{ $listing->location }}</p>
                                        @if($listing->monthly_items)
                                            <p class="text-gray-400 text-xs mt-2">{{ number_format($listing->monthly_items) }} items/month</p>
                                        @endif
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-gray-50 rounded-xl p-8 text-center">
                            <p class="text-gray-500">No featured listings at the moment.</p>
                            <a href="{{ route('listings.index') }}" class="text-green-600 hover:underline text-sm mt-2 inline-block">Browse all listings</a>
                        </div>
                    @endif
                </section>

                <!-- Latest News -->
                <section>
                    <div class="flex items-center justify-between mb-6">
                        <h2 class="text-xl font-bold text-gray-900">Latest News</h2>
                        <a href="{{ route('news.index') }}" class="text-green-600 hover:text-green-700 font-medium text-sm">
                            View all →
                        </a>
                    </div>
                    
                    @if($latestArticles->count() > 0)
                        <div class="space-y-4">
                            @foreach($latestArticles as $article)
                                <a href="{{ route('news.show', $article->slug) }}" class="flex gap-4 bg-white rounded-xl p-4 shadow-sm border border-gray-100 hover:shadow-md transition group">
                                    <div class="w-24 h-24 bg-gray-100 rounded-lg flex-shrink-0 overflow-hidden">
                                        @if($article->featured_image)
                                            <img src="{{ $article->featured_image }}" alt="{{ $article->title }}" class="w-full h-full object-cover">
                                        @else
                                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="flex items-center gap-2 mb-1">
                                            <span class="text-xs font-medium text-green-600 uppercase">{{ $article->type->label() }}</span>
                                            @if($article->is_premium)
                                                <span class="text-xs font-medium text-amber-600 uppercase">Premium</span>
                                            @endif
                                        </div>
                                        <h3 class="font-semibold text-gray-900 group-hover:text-green-600 transition line-clamp-2">{{ $article->title }}</h3>
                                        <p class="text-gray-500 text-sm mt-1">{{ $article->formatted_date }} · {{ $article->reading_time_minutes }} min read</p>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-gray-50 rounded-xl p-8 text-center">
                            <p class="text-gray-500">No articles published yet.</p>
                        </div>
                    @endif
                </section>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Quick Links -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-900 mb-4">Quick Links</h3>
                    <nav class="space-y-2">
                        <a href="{{ route('listings.index') }}" class="flex items-center gap-3 text-gray-600 hover:text-green-600 transition py-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                            Pharmacies for Sale
                        </a>
                        <a href="{{ route('training.index') }}" class="flex items-center gap-3 text-gray-600 hover:text-green-600 transition py-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                            </svg>
                            Training Courses
                        </a>
                        <a href="{{ route('suppliers.index') }}" class="flex items-center gap-3 text-gray-600 hover:text-green-600 transition py-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Supplier Directory
                        </a>
                        <a href="{{ route('resources.index') }}" class="flex items-center gap-3 text-gray-600 hover:text-green-600 transition py-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Guides & Resources
                        </a>
                        <a href="{{ route('valuations') }}" class="flex items-center gap-3 text-gray-600 hover:text-green-600 transition py-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                            </svg>
                            Valuations
                        </a>
                    </nav>
                </div>

                <!-- Featured Courses -->
                @if($featuredCourses->count() > 0)
                    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                        <h3 class="font-bold text-gray-900 mb-4">Popular Courses</h3>
                        <div class="space-y-3">
                            @foreach($featuredCourses as $course)
                                <a href="{{ route('training.show', $course->slug) }}" class="block group">
                                    <h4 class="font-medium text-gray-900 group-hover:text-green-600 transition line-clamp-2">{{ $course->title }}</h4>
                                    <div class="flex items-center gap-2 mt-1 text-sm text-gray-500">
                                        <span>{{ $course->formatted_duration }}</span>
                                        @if($course->cpd_accredited)
                                            <span class="text-green-600">• CPD Accredited</span>
                                        @endif
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        <a href="{{ route('training.index') }}" class="text-green-600 hover:text-green-700 text-sm font-medium mt-4 inline-block">
                            View all courses →
                        </a>
                    </div>
                @endif

                <!-- Profile Completion -->
                @if(!auth()->user()->gphc_number && auth()->user()->job_title?->requiresGphc())
                    <div class="bg-amber-50 border border-amber-200 rounded-xl p-6">
                        <h3 class="font-bold text-amber-900 mb-2">Complete Your Profile</h3>
                        <p class="text-amber-800 text-sm mb-4">Add your GPhC number to unlock all features.</p>
                        <a href="{{ route('account.settings') }}" class="text-amber-900 hover:text-amber-700 text-sm font-medium">
                            Update profile →
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>
