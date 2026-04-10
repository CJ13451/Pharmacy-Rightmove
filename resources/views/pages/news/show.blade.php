<x-layouts.app :title="$article->title">
    <div class="max-w-7xl mx-auto px-8 py-12">
    <article class="max-w-4xl mx-auto">
        <!-- Header -->
        <header class="mb-8">
            <div class="flex items-center gap-2 mb-4">
                <span class="text-sm font-semibold text-green-600 uppercase">{{ $article->type->label() }}</span>
                <span class="text-gray-300">·</span>
                <span class="text-sm text-gray-500">{{ $article->category->label() }}</span>
                @if($article->is_premium)
                    <span class="bg-amber-100 text-amber-700 text-xs font-bold px-2 py-0.5 rounded">PREMIUM</span>
                @endif
            </div>
            
            <h1 class="text-3xl sm:text-4xl font-bold text-gray-900 leading-tight mb-4">{{ $article->title }}</h1>
            
            <div class="flex items-center gap-4 text-sm text-gray-500">
                @if($article->author)
                    <div class="flex items-center gap-2">
                        <div class="w-8 h-8 rounded-full bg-green-100 text-green-700 flex items-center justify-center text-xs font-semibold">
                            {{ $article->author->initials }}
                        </div>
                        <span>{{ $article->author->full_name }}</span>
                    </div>
                @endif
                <span>{{ $article->formatted_date }}</span>
                <span>{{ $article->reading_time_minutes }} min read</span>
            </div>
        </header>

        <!-- Featured Image -->
        @if($article->featured_image)
            <figure class="mb-8 -mx-4 sm:mx-0">
                <img 
                    src="{{ $article->featured_image }}" 
                    alt="{{ $article->title }}"
                    class="w-full rounded-xl"
                >
            </figure>
        @endif

        <!-- Content -->
        <div class="prose prose-lg prose-green max-w-none">
            {!! $article->content !!}
        </div>

        <!-- Tags -->
        @if($article->tags && count($article->tags) > 0)
            <div class="mt-8 pt-8 border-t border-gray-200">
                <div class="flex flex-wrap gap-2">
                    @foreach($article->tags as $tag)
                        <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-sm">{{ $tag }}</span>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Share -->
        <div class="mt-8 pt-8 border-t border-gray-200">
            <div class="flex items-center gap-4">
                <span class="text-sm font-medium text-gray-700">Share:</span>
                <a 
                    href="https://twitter.com/intent/tweet?text={{ urlencode($article->title) }}&url={{ urlencode(request()->url()) }}"
                    target="_blank"
                    class="text-gray-400 hover:text-blue-400 transition"
                >
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                </a>
                <a 
                    href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode(request()->url()) }}&title={{ urlencode($article->title) }}"
                    target="_blank"
                    class="text-gray-400 hover:text-blue-600 transition"
                >
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                </a>
                <button 
                    onclick="navigator.clipboard.writeText(window.location.href); alert('Link copied!');"
                    class="text-gray-400 hover:text-gray-600 transition"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                    </svg>
                </button>
            </div>
        </div>
    </article>
    </div>

    <!-- Related Articles -->
    @if($relatedArticles->count() > 0)
        <section class="bg-gray-50 py-12">
            <div class="max-w-7xl mx-auto px-4">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Related Articles</h2>
                <div class="grid md:grid-cols-3 gap-6">
                    @foreach($relatedArticles as $related)
                        <a href="{{ route('news.show', $related->slug) }}" class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 hover:shadow-md transition group">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-xs font-medium text-green-600 uppercase">{{ $related->type->label() }}</span>
                            </div>
                            <h3 class="font-semibold text-gray-900 group-hover:text-green-600 transition line-clamp-2">{{ $related->title }}</h3>
                            <p class="text-gray-500 text-sm mt-2">{{ $related->formatted_date }}</p>
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
</x-layouts.app>
