<x-layouts.app title="Pharmacies for Sale">
<div class="container">
    <div class="listings-layout">
        <aside class="filters-sidebar">
            <form method="GET" action="{{ route('listings.index') }}">
                <div class="filter-section">
                    <div class="filter-title">Location</div>
                    <input type="text" name="location" class="filter-input" placeholder="City, postcode or region" value="{{ request('location') }}">
                    <select name="region" class="filter-input">
                        <option value="">All Regions</option>
                        @foreach(\App\Enums\Region::cases() as $region)
                            <option value="{{ $region->value }}" {{ request('region') === $region->value ? 'selected' : '' }}>{{ $region->label() }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="filter-section">
                    <div class="filter-title">Price Range</div>
                    <div class="filter-row">
                        <input type="text" name="min_price" class="filter-input" placeholder="Min &pound;" value="{{ request('min_price') }}">
                        <input type="text" name="max_price" class="filter-input" placeholder="Max &pound;" value="{{ request('max_price') }}">
                    </div>
                </div>
                <div class="filter-section">
                    <div class="filter-title">Monthly Items</div>
                    <div class="filter-row">
                        <input type="text" name="min_items" class="filter-input" placeholder="Min" value="{{ request('min_items') }}">
                        <input type="text" class="filter-input" placeholder="Max" disabled>
                    </div>
                </div>
                <div class="filter-section">
                    <div class="filter-title">Property Type</div>
                    <label class="filter-checkbox"><input type="checkbox" name="property_type" value="freehold" {{ request('property_type') === 'freehold' ? 'checked' : '' }}> Freehold</label>
                    <label class="filter-checkbox"><input type="checkbox" name="property_type" value="leasehold" {{ request('property_type') === 'leasehold' ? 'checked' : '' }}> Leasehold</label>
                </div>
                <button type="submit" class="btn btn-primary" style="width:100%">Apply Filters</button>
            </form>
        </aside>

        <div class="listings-results">
            <div class="results-header">
                <span class="results-count">Showing <strong>{{ $listings->total() }}</strong> pharmacies for sale</span>
                <div class="results-sort">
                    <select onchange="window.location.href=this.value">
                        <option value="{{ route('listings.index', array_merge(request()->query(), ['sort' => 'newest'])) }}" {{ request('sort', 'newest') === 'newest' ? 'selected' : '' }}>Sort: Newest First</option>
                        <option value="{{ route('listings.index', array_merge(request()->query(), ['sort' => 'price_asc'])) }}" {{ request('sort') === 'price_asc' ? 'selected' : '' }}>Price: Low to High</option>
                        <option value="{{ route('listings.index', array_merge(request()->query(), ['sort' => 'price_desc'])) }}" {{ request('sort') === 'price_desc' ? 'selected' : '' }}>Price: High to Low</option>
                        <option value="{{ route('listings.index', array_merge(request()->query(), ['sort' => 'items_desc'])) }}" {{ request('sort') === 'items_desc' ? 'selected' : '' }}>Items: High to Low</option>
                    </select>
                </div>
            </div>

            @forelse($listings as $listing)
                <a href="{{ route('listings.show', $listing->slug) }}" class="listing-card">
                    <div class="listing-image">
                        @if($listing->featured)<span class="badge badge-green">Featured</span>@endif
                        @php
                            $agentName = $listing->agent_company ?: $listing->agent_name;
                            $agentInitials = collect(preg_split('/\s+/', trim($agentName)))
                                ->filter()
                                ->take(2)
                                ->map(fn ($word) => mb_strtoupper(mb_substr($word, 0, 1)))
                                ->join('');
                        @endphp
                        <span class="agent-badge" title="{{ $agentName }}">
                            <span class="agent-initials">{{ $agentInitials ?: 'P3' }}</span>
                        </span>
                    </div>
                    <div class="listing-content">
                        <div>
                            <div class="listing-price">{{ $listing->formatted_price }} <span class="listing-price-qualifier">{{ ucfirst($listing->price_qualifier ?? 'Guide Price') }}</span></div>
                            <h3 class="listing-title">{{ $listing->title }}</h3>
                            <div class="listing-location">{{ $listing->town }}{{ $listing->county ? ', '.$listing->county : '' }}</div>
                        </div>
                        <div class="listing-stats">
                            @if($listing->monthly_items)
                            <div class="listing-stat">
                                <span class="listing-stat-value">{{ number_format($listing->monthly_items) }}</span>
                                <span class="listing-stat-label">Monthly Items</span>
                            </div>
                            @endif
                            <div class="listing-stat">
                                <span class="listing-stat-value">{{ ucfirst($listing->property_type ?? 'N/A') }}</span>
                                <span class="listing-stat-label">Tenure</span>
                            </div>
                        </div>
                    </div>
                </a>
            @empty
                <div class="empty-state">No pharmacies found matching your criteria.</div>
            @endforelse

            <div style="padding-top:20px;">{{ $listings->withQueryString()->links() }}</div>
        </div>
    </div>
</div>
</x-layouts.app>
