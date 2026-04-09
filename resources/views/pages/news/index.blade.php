<x-layouts.app title="News & Analysis">
    <div class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold mb-2">News & Analysis</h1>
            <p class="text-gray-300">Expert coverage of pharmacy policy, market trends, and business insights.</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Filters -->
        <form method="GET" class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 mb-8">
            <div class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[200px]">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="Search articles..."
                        class="w-full rounded-lg border-gray-300 text-sm"
                    >
                </div>
                <select name="type" class="rounded-lg border-gray-300 text-sm">
                    <option value="">All Types</option>
                    @foreach(\App\Enums\ArticleType::cases() as $type)
                        <option value="{{ $type->value }}" {{ request('type') === $type->value ? 'selected' : '' }}>
                            {{ $type->label() }}
                        </option>
                    @endforeach
                </select>
                <select name="category" class="rounded-lg border-gray-300 text-sm">
                    <option value="">All Categories</option>
                    @foreach(\App\Enums\ArticleCategory::cases() as $category)
                        <option value="{{ $category->value }}" {{ request('category') === $category->value ? 'selected' : '' }}>
                            {{ $category->label() }}
                        </option>
                    @endforeach
                </select>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg text-sm font-medium">
                    Filter
                </button>
            </div>
        </form>

        <!-- Featured Articles -->
        @if($featuredArticles->count() > 0 && !request()->hasAny(['search', 'type', 'category']))
            <section class="mb-12">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Featured</h2>
                <div class="grid md:grid-cols-3 gap-6">
                    @foreach($featuredArticles as $article)
                        <a href="{{ route('news.show', $article->slug) }}" class="group">
                            <div class="aspect-video bg-gray-100 rounded-xl overflow-hidden mb-3">
                                @if($article->featured_image)
                                    <img src="{{ $article->featured_image }}" alt="{{ $article->title }}" class="w-full h-full object-cover group-hover:scale-105 transition duration-300">
                                @else
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-green-500 to-green-600">
                                        <svg class="w-12 h-12 text-white/50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"/>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-xs font-semibold text-green-600 uppercase">{{ $article->type->label() }}</span>
                                @if($article->is_premium)
                                    <span class="text-xs font-semibold text-amber-600 uppercase">Premium</span>
                                @endif
                            </div>
                            <h3 class="font-bold text-gray-900 group-hover:text-green-600 transition line-clamp-2">{{ $article->title }}</h3>
                            <p class="text-gray-500 text-sm mt-1">{{ $article->formatted_date }}</p>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif

        <!-- All Articles -->
        <section>
            <h2 class="text-xl font-bold text-gray-900 mb-6">
                {{ request()->hasAny(['search', 'type', 'category']) ? 'Search Results' : 'Latest Articles' }}
            </h2>

            @if($articles->count() > 0)
                <div class="space-y-6">
                    @foreach($articles as $article)
                        <a href="{{ route('news.show', $article->slug) }}" class="flex gap-4 bg-white rounded-xl p-4 shadow-sm border border-gray-100 hover:shadow-md transition group">
                            <div class="w-32 h-24 bg-gray-100 rounded-lg flex-shrink-0 overflow-hidden">
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
                                    <span class="text-xs text-gray-400">{{ $article->category->label() }}</span>
                                    @if($article->is_premium)
                                        <span class="text-xs font-medium text-amber-600 uppercase">Premium</span>
                                    @endif
                                </div>
                                <h3 class="font-semibold text-gray-900 group-hover:text-green-600 transition line-clamp-2">{{ $article->title }}</h3>
                                <p class="text-gray-500 text-sm mt-1 line-clamp-2">{{ $article->excerpt_or_truncated }}</p>
                                <div class="flex items-center gap-3 mt-2 text-xs text-gray-400">
                                    <span>{{ $article->formatted_date }}</span>
                                    <span>{{ $article->reading_time_minutes }} min read</span>
                                    @if($article->author)
                                        <span>By {{ $article->author->full_name }}</span>
                                    @endif
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $articles->links() }}
                </div>
            @else
                <div class="bg-gray-50 rounded-xl p-12 text-center">
                    <svg class="w-12 h-12 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <p class="text-gray-500">No articles found matching your criteria.</p>
                    <a href="{{ route('news.index') }}" class="text-green-600 hover:underline text-sm mt-2 inline-block">Clear filters</a>
                </div>
            @endif
        </section>
    </div>
</x-layouts.app>
