<x-layouts.app :title="$supplier->name">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Breadcrumb -->
        <nav class="mb-6 text-sm">
            <ol class="flex items-center gap-2">
                <li><a href="{{ route('suppliers.index') }}" class="text-gray-500 hover:text-green-600">Supplier Directory</a></li>
                <li class="text-gray-400">/</li>
                <li class="text-gray-900">{{ $supplier->name }}</li>
            </ol>
        </nav>

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Header -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 mb-6">
                    <div class="flex items-start gap-6">
                        <div class="w-24 h-24 bg-gray-100 rounded-xl flex-shrink-0 flex items-center justify-center overflow-hidden">
                            @if($supplier->logo)
                                <img src="{{ $supplier->logo }}" alt="{{ $supplier->name }}" class="w-full h-full object-contain">
                            @else
                                <span class="text-3xl font-bold text-gray-400">{{ substr($supplier->name, 0, 1) }}</span>
                            @endif
                        </div>
                        <div>
                            <div class="flex items-center gap-2 mb-2">
                                <h1 class="text-2xl font-bold text-gray-900">{{ $supplier->name }}</h1>
                                @if($supplier->tier->value === 'featured')
                                    <span class="bg-amber-100 text-amber-700 text-xs font-bold px-2 py-1 rounded">FEATURED</span>
                                @elseif($supplier->tier->value === 'premium')
                                    <span class="bg-purple-100 text-purple-700 text-xs font-bold px-2 py-1 rounded">PREMIUM</span>
                                @endif
                            </div>
                            <p class="text-green-600 font-medium mb-2">{{ $supplier->category->label() }}</p>
                            <p class="text-gray-600">{{ $supplier->short_description }}</p>
                        </div>
                    </div>
                </div>

                <!-- About -->
                @if($supplier->long_description)
                    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 mb-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">About</h2>
                        <div class="prose prose-gray max-w-none">
                            {!! nl2br(e($supplier->long_description)) !!}
                        </div>
                    </div>
                @endif

                <!-- Photos -->
                @if($supplier->photos && count($supplier->photos) > 0)
                    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 mb-6">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Gallery</h2>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($supplier->photos as $photo)
                                <div class="aspect-video bg-gray-100 rounded-lg overflow-hidden">
                                    <img src="{{ $photo }}" alt="{{ $supplier->name }}" class="w-full h-full object-cover">
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

                <!-- Resources -->
                @if($supplier->resources->count() > 0)
                    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                        <h2 class="text-xl font-bold text-gray-900 mb-4">Resources</h2>
                        <div class="space-y-3">
                            @foreach($supplier->resources as $resource)
                                <a href="{{ $resource->file_url }}" target="_blank" class="flex items-center gap-3 p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                                    <div class="w-10 h-10 bg-green-100 text-green-600 rounded-lg flex items-center justify-center">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <p class="font-medium text-gray-900">{{ $resource->title }}</p>
                                        @if($resource->description)
                                            <p class="text-sm text-gray-500">{{ $resource->description }}</p>
                                        @endif
                                    </div>
                                    <span class="text-xs text-gray-400 uppercase">{{ $resource->file_type }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Contact Card -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 sticky top-24">
                    <h3 class="font-bold text-gray-900 mb-4">Contact Information</h3>
                    
                    <div class="space-y-4">
                        @if($supplier->contact_name)
                            <div class="flex items-center gap-3">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                </svg>
                                <span class="text-gray-700">{{ $supplier->contact_name }}</span>
                            </div>
                        @endif

                        @if($supplier->contact_email)
                            <a href="mailto:{{ $supplier->contact_email }}" class="flex items-center gap-3 text-gray-700 hover:text-green-600 transition">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                <span>{{ $supplier->contact_email }}</span>
                            </a>
                        @endif

                        @if($supplier->contact_phone)
                            <a href="tel:{{ $supplier->contact_phone }}" class="flex items-center gap-3 text-gray-700 hover:text-green-600 transition">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                <span>{{ $supplier->contact_phone }}</span>
                            </a>
                        @endif

                        @if($supplier->website)
                            <a href="{{ $supplier->website }}" target="_blank" rel="noopener" onclick="trackClick()" class="flex items-center gap-3 text-gray-700 hover:text-green-600 transition">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                                </svg>
                                <span>Visit Website</span>
                            </a>
                        @endif

                        @if($supplier->address)
                            <div class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                                </svg>
                                <span class="text-gray-700">{{ $supplier->address }}</span>
                            </div>
                        @endif
                    </div>

                    @if($supplier->website)
                        <a 
                            href="{{ $supplier->website }}" 
                            target="_blank" 
                            rel="noopener"
                            class="mt-6 block w-full bg-green-600 hover:bg-green-700 text-white text-center py-3 rounded-lg font-semibold transition"
                        >
                            Visit Website
                        </a>
                    @endif

                    <!-- Social Links -->
                    @if($supplier->social_links && count($supplier->social_links) > 0)
                        <div class="mt-6 pt-6 border-t border-gray-100">
                            <p class="text-sm text-gray-500 mb-3">Follow us</p>
                            <div class="flex gap-3">
                                @foreach($supplier->social_links as $platform => $url)
                                    <a href="{{ $url }}" target="_blank" rel="noopener" class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center text-gray-500 hover:bg-green-100 hover:text-green-600 transition">
                                        @if($platform === 'linkedin')
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                                        @elseif($platform === 'twitter')
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                        @else
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                                        @endif
                                    </a>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if($supplier->website)
    <script>
        function trackClick() {
            fetch('{{ route('suppliers.track-click', $supplier->slug) }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            });
        }
    </script>
    @endif
</x-layouts.app>
