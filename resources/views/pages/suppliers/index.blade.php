<x-layouts.app title="Supplier Directory">
<div class="suppliers-hero">
    <div class="container">
        <div class="suppliers-search">
            <h1>Supplier Directory</h1>
            <p>Find and compare suppliers, wholesalers, and service providers for UK pharmacies.</p>
            <form method="GET" action="{{ route('suppliers.index') }}">
                <div class="search-box">
                    <input type="text" name="search" placeholder="Search suppliers by name or service..." value="{{ request('search') }}">
                    <button type="submit">Search</button>
                </div>
            </form>
            <div class="category-tabs">
                <a href="{{ route('suppliers.index') }}" class="category-tab {{ !request('category') ? 'active' : '' }}">All</a>
                @foreach(\App\Enums\SupplierCategory::cases() as $cat)
                    <a href="{{ route('suppliers.index', ['category' => $cat->value]) }}" class="category-tab {{ request('category') === $cat->value ? 'active' : '' }}">{{ $cat->label() }}</a>
                @endforeach
            </div>
        </div>
    </div>
</div>
<div class="container">
    <div class="suppliers-grid">
        @forelse($suppliers as $supplier)
            <a href="{{ route('suppliers.show', $supplier->slug) }}" class="supplier-card {{ $supplier->is_featured ? 'featured' : '' }}">
                <div class="supplier-logo">{{ strtoupper(substr($supplier->name, 0, 2)) }}</div>
                <h3 class="supplier-name">{{ $supplier->name }}</h3>
                <div class="supplier-category">{{ $supplier->category?->label() ?? '' }}</div>
                <p class="supplier-desc">{{ Str::limit($supplier->short_description, 80) }}</p>
            </a>
        @empty
            <div class="empty-state" style="grid-column:1/-1;">No suppliers found. Check back soon!</div>
        @endforelse
    </div>
    @if($suppliers->hasPages())
        <div style="padding-bottom:40px;">{{ $suppliers->withQueryString()->links() }}</div>
    @endif
</div>
</x-layouts.app>
