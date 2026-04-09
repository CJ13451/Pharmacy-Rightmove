<x-layouts.app title="Resources & Guides">
    <div class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold mb-2">Resources & Guides</h1>
            <p class="text-gray-300">Expert guides, templates, and tools for pharmacy professionals.</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Categories -->
        <div class="grid md:grid-cols-4 gap-6 mb-12">
            @foreach($categories as $category)
                <a href="{{ route('resources.index', ['category' => $category->value]) }}" 
                   class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition text-center group {{ request('category') === $category->value ? 'ring-2 ring-green-500' : '' }}">
                    <div class="w-12 h-12 bg-green-100 text-green-600 rounded-lg flex items-center justify-center mx-auto mb-3 group-hover:bg-green-600 group-hover:text-white transition">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <h3 class="font-semibold text-gray-900">{{ $category->label() }}</h3>
                    <p class="text-sm text-gray-500 mt-1">{{ $categoryCounts[$category->value] ?? 0 }} resources</p>
                </a>
            @endforeach
        </div>

        <!-- Resources List -->
        <section>
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-gray-900">
                    {{ request('category') ? \App\Enums\ResourceCategory::tryFrom(request('category'))?->label() ?? 'All' : 'All Resources' }}
                </h2>
                @if(request('category'))
                    <a href="{{ route('resources.index') }}" class="text-green-600 hover:text-green-700 text-sm font-medium">
                        View all →
                    </a>
                @endif
            </div>

            @if($resources->count() > 0)
                <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach($resources as $resource)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden hover:shadow-md transition">
                            <div class="h-40 bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center">
                                @if($resource->thumbnail)
                                    <img src="{{ $resource->thumbnail }}" alt="{{ $resource->title }}" class="w-full h-full object-cover">
                                @else
                                    <svg class="w-16 h-16 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                @endif
                            </div>
                            <div class="p-5">
                                <div class="flex items-center gap-2 mb-2">
                                    <span class="text-xs font-medium text-green-600 uppercase">{{ $resource->category->label() }}</span>
                                    <span class="text-xs text-gray-400 uppercase">{{ $resource->file_type }}</span>
                                </div>
                                <h3 class="font-bold text-gray-900 line-clamp-2 mb-2">{{ $resource->title }}</h3>
                                <p class="text-gray-500 text-sm line-clamp-2 mb-4">{{ $resource->description }}</p>
                                
                                <div class="flex items-center justify-between">
                                    @if($resource->is_premium && !auth()->user()?->hasActiveSubscription())
                                        <span class="text-xs font-medium text-amber-600 bg-amber-50 px-2 py-1 rounded">Premium</span>
                                        <a href="{{ route('resources.show', $resource->slug) }}" class="text-green-600 hover:text-green-700 text-sm font-medium">
                                            Learn more →
                                        </a>
                                    @else
                                        <span class="text-xs text-gray-400">{{ number_format($resource->downloads_count) }} downloads</span>
                                        <a href="{{ route('resources.download', $resource->slug) }}" class="inline-flex items-center gap-1 text-green-600 hover:text-green-700 text-sm font-medium">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                            </svg>
                                            Download
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-8">
                    {{ $resources->links() }}
                </div>
            @else
                <div class="bg-gray-50 rounded-xl p-12 text-center">
                    <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3 class="text-lg font-semibold text-gray-900 mb-2">No resources found</h3>
                    <p class="text-gray-500">Check back soon for new resources.</p>
                </div>
            @endif
        </section>
    </div>
</x-layouts.app>
