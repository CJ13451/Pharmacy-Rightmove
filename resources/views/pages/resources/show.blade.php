<x-layouts.app :title="$resource->title">
    <div class="max-w-7xl mx-auto px-8 py-8">
    <div class="max-w-4xl mx-auto">
        <!-- Breadcrumb -->
        <nav class="mb-6 text-sm">
            <ol class="flex items-center gap-2">
                <li><a href="{{ route('resources.index') }}" class="text-gray-500 hover:text-green-600">Resources</a></li>
                <li class="text-gray-400">/</li>
                <li><a href="{{ route('resources.index', ['category' => $resource->category]) }}" class="text-gray-500 hover:text-green-600">{{ $resource->category_label }}</a></li>
                <li class="text-gray-400">/</li>
                <li class="text-gray-900 truncate max-w-xs">{{ $resource->title }}</li>
            </ol>
        </nav>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <!-- Header -->
            <div class="h-64 bg-gradient-to-br from-green-500 to-green-600 flex items-center justify-center relative">
                @if($resource->thumbnail)
                    <img src="{{ $resource->thumbnail }}" alt="{{ $resource->title }}" class="w-full h-full object-cover">
                @else
                    <svg class="w-24 h-24 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                @endif
                @if($resource->is_premium)
                    <div class="absolute top-4 right-4">
                        <span class="bg-amber-400 text-amber-900 text-sm font-bold px-3 py-1.5 rounded">PREMIUM</span>
                    </div>
                @endif
            </div>

            <!-- Content -->
            <div class="p-8">
                <div class="flex items-center gap-3 mb-4">
                    <span class="text-sm font-semibold text-green-600 uppercase">{{ $resource->category_label }}</span>
                    <span class="text-gray-300">·</span>
                    <span class="text-sm text-gray-500 uppercase">{{ $resource->file_type }}</span>
                    @if($resource->file_size)
                        <span class="text-gray-300">·</span>
                        <span class="text-sm text-gray-500">{{ $resource->formatted_file_size }}</span>
                    @endif
                </div>

                <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $resource->title }}</h1>
                
                <p class="text-lg text-gray-600 mb-6">{{ $resource->description }}</p>

                @if($resource->content)
                    <div class="prose prose-green max-w-none mb-8">
                        {!! $resource->content !!}
                    </div>
                @endif

                <!-- Download Section -->
                <div class="bg-gray-50 rounded-xl p-6 mt-8">
                    @if($resource->is_premium && !$hasAccess)
                        <div class="text-center">
                            <div class="w-16 h-16 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center mx-auto mb-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-900 mb-2">Premium Resource</h3>
                            <p class="text-gray-600 mb-4">This resource is available to premium members only. Contact us to enquire about premium access.</p>
                            <a href="mailto:hello@pharmacyowner.co.uk?subject=Premium%20access%20enquiry" class="inline-block bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                                Contact us
                            </a>
                        </div>
                    @else
                        <div class="flex items-center justify-between">
                            <div>
                                <h3 class="font-bold text-gray-900">Ready to download</h3>
                                <p class="text-sm text-gray-500">{{ number_format($resource->downloads_count) }} downloads</p>
                            </div>
                            <a 
                                href="{{ route('resources.download', $resource->slug) }}" 
                                class="inline-flex items-center gap-2 bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold transition"
                            >
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                                </svg>
                                Download {{ strtoupper($resource->file_type) }}
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Related Resources -->
        @if($relatedResources->count() > 0)
            <section class="mt-12">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Related Resources</h2>
                <div class="grid md:grid-cols-3 gap-6">
                    @foreach($relatedResources as $related)
                        <a href="{{ route('resources.show', $related->slug) }}" class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 hover:shadow-md transition group">
                            <div class="flex items-center gap-2 mb-2">
                                <span class="text-xs font-medium text-green-600 uppercase">{{ $related->category_label }}</span>
                            </div>
                            <h3 class="font-semibold text-gray-900 group-hover:text-green-600 transition line-clamp-2">{{ $related->title }}</h3>
                            <p class="text-gray-500 text-sm mt-2">{{ $related->file_type }} · {{ $related->formatted_file_size }}</p>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
    </div>
</x-layouts.app>
