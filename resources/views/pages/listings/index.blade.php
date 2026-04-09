<x-layouts.app title="Pharmacies for Sale">
    <div class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold mb-2">Pharmacies for Sale</h1>
            <p class="text-gray-300">Find your next pharmacy opportunity across the UK.</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Search & Filters -->
        <form method="GET" class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 mb-8">
            <div class="grid md:grid-cols-4 gap-4 mb-4">
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Location</label>
                    <input 
                        type="text" 
                        name="location" 
                        value="{{ request('location') }}"
                        placeholder="Town, city or postcode"
                        class="w-full rounded-lg border-gray-300"
                    >
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Region</label>
                    <select name="region" class="w-full rounded-lg border-gray-300">
                        <option value="">All Regions</option>
                        @foreach(\App\Enums\Region::cases() as $region)
                            <option value="{{ $region->value }}" {{ request('region') === $region->value ? 'selected' : '' }}>
                                {{ $region->label() }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Property Type</label>
                    <select name="property_type" class="w-full rounded-lg border-gray-300">
                        <option value="">All Types</option>
                        <option value="freehold" {{ request('property_type') === 'freehold' ? 'selected' : '' }}>Freehold</option>
                        <option value="leasehold" {{ request('property_type') === 'leasehold' ? 'selected' : '' }}>Leasehold</option>
                    </select>
                </div>
            </div>
            <div class="grid md:grid-cols-4 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Min Price</label>
                    <input 
                        type="number" 
                        name="min_price" 
                        value="{{ request('min_price') }}"
                        placeholder="£ Min"
                        class="w-full rounded-lg border-gray-300"
                    >
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Max Price</label>
                    <input 
                        type="number" 
                        name="max_price" 
                        value="{{ request('max_price') }}"
                        placeholder="£ Max"
                        class="w-full rounded-lg border-gray-300"
                    >
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sort By</label>
                    <select name="sort" class="w-full rounded-lg border-gray-300">
                        <option value="newest" {{ request('sort') === 'newest' ? 'selected' : '' }}>Newest First</option>
                        <option value="price_asc" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Price (Low to High)</option>
                        <option value="price_desc" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price (High to Low)</option>
                        <option value="items_desc" {{ request('sort') === 'items_desc' ? 'selected' : '' }}>Monthly Items</option>
                    </select>
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white px-6 py-2.5 rounded-lg font-medium">
                        Search
                    </button>
                </div>
            </div>
        </form>

        <div class="flex items-center justify-between mb-6">
            <p class="text-gray-600">{{ $listings->total() }} {{ Str::plural('pharmacy', $listings->total()) }} found</p>
            <button 
                type="button"
                onclick="document.getElementById('save-search-modal').classList.remove('hidden')"
                class="text-green-600 hover:text-green-700 text-sm font-medium"
            >
                Save this search
            </button>
        </div>

        <!-- Listings Grid -->
        @if($listings->count() > 0)
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($listings as $listing)
                    <a href="{{ route('listings.show', $listing->slug) }}" class="bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-lg transition group">
                        <div class="h-48 bg-gradient-to-br from-green-500 to-green-600 relative">
                            @if($listing->primary_image)
                                <img src="{{ $listing->primary_image }}" alt="{{ $listing->title }}" class="w-full h-full object-cover">
                            @endif
                            @if($listing->featured)
                                <div class="absolute top-3 left-3">
                                    <span class="bg-amber-400 text-amber-900 text-xs font-bold px-2 py-1 rounded">FEATURED</span>
                                </div>
                            @endif
                            <div class="absolute top-3 right-3">
                                <span class="bg-white/90 text-gray-900 text-xs font-medium px-2 py-1 rounded capitalize">{{ $listing->property_type }}</span>
                            </div>
                        </div>
                        <div class="p-5">
                            <div class="flex items-start justify-between gap-2 mb-2">
                                <div class="text-2xl font-bold text-green-600">{{ $listing->formatted_price }}</div>
                            </div>
                            <h3 class="font-semibold text-gray-900 group-hover:text-green-600 transition line-clamp-1 mb-1">{{ $listing->title }}</h3>
                            <p class="text-gray-500 text-sm mb-3">{{ $listing->location }}</p>
                            
                            <div class="grid grid-cols-2 gap-2 text-sm text-gray-600">
                                @if($listing->monthly_items)
                                    <div class="flex items-center gap-1">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                        </svg>
                                        {{ number_format($listing->monthly_items) }}/mo
                                    </div>
                                @endif
                                @if($listing->annual_turnover)
                                    <div class="flex items-center gap-1">
                                        <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                        </svg>
                                        {{ $listing->formatted_turnover }}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-8">
                {{ $listings->links() }}
            </div>
        @else
            <div class="bg-gray-50 rounded-xl p-12 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">No pharmacies found</h3>
                <p class="text-gray-500 mb-4">Try adjusting your search criteria.</p>
                <a href="{{ route('listings.index') }}" class="text-green-600 hover:text-green-700 font-medium">Clear all filters</a>
            </div>
        @endif
    </div>

    <!-- Save Search Modal (hidden by default) -->
    <div id="save-search-modal" class="hidden fixed inset-0 bg-black/50 flex items-center justify-center z-50 p-4">
        <div class="bg-white rounded-xl max-w-md w-full p-6">
            <h3 class="text-lg font-bold text-gray-900 mb-4">Save This Search</h3>
            <form method="POST" action="{{ route('saved-searches.store') }}">
                @csrf
                <input type="hidden" name="filters" value="{{ json_encode(request()->query()) }}">
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Search Name</label>
                    <input type="text" name="name" required class="w-full rounded-lg border-gray-300" placeholder="e.g. London pharmacies under £500k">
                </div>
                <div class="mb-4">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="email_alerts" value="1" checked class="rounded border-gray-300 text-green-600">
                        <span class="text-sm text-gray-700">Email me when new matches are listed</span>
                    </label>
                </div>
                <div class="flex gap-3">
                    <button type="button" onclick="document.getElementById('save-search-modal').classList.add('hidden')" class="flex-1 px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50">
                        Cancel
                    </button>
                    <button type="submit" class="flex-1 px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">
                        Save Search
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
