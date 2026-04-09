<x-layouts.app title="Resources & Tools">
<div class="resources-hero">
    <div class="container">
        <h1>Resources & Tools</h1>
        <p>Calculators, templates, guides, and checklists to help you buy, run, and grow your pharmacy business.</p>
    </div>
</div>
<div class="resources-categories">
    <div class="container">
        <div class="resources-categories-inner">
            <a href="{{ route('resources.index') }}" class="resource-category-link {{ !request('type') ? 'active' : '' }}">
                <span class="resource-category-icon">&#x1F4C1;</span> All Resources
            </a>
            <a href="{{ route('resources.index', ['type' => 'calculator']) }}" class="resource-category-link {{ request('type') === 'calculator' ? 'active' : '' }}">
                <span class="resource-category-icon">&#x1F4CA;</span> Calculators
            </a>
            <a href="{{ route('resources.index', ['type' => 'template']) }}" class="resource-category-link {{ request('type') === 'template' ? 'active' : '' }}">
                <span class="resource-category-icon">&#x1F4DD;</span> Templates
            </a>
            <a href="{{ route('resources.index', ['type' => 'checklist']) }}" class="resource-category-link {{ request('type') === 'checklist' ? 'active' : '' }}">
                <span class="resource-category-icon">&#x2705;</span> Checklists
            </a>
            <a href="{{ route('resources.index', ['type' => 'guide']) }}" class="resource-category-link {{ request('type') === 'guide' ? 'active' : '' }}">
                <span class="resource-category-icon">&#x1F4D6;</span> Guides
            </a>
        </div>
    </div>
</div>
<div class="container">
    <div class="resources-grid-page">
        @forelse($resources as $resource)
            <a href="{{ route('resources.show', $resource->slug) }}" class="resource-card">
                <div class="resource-icon-lg">&#x1F4CB;</div>
                <div class="resource-type">{{ ucfirst($resource->resource_format ?? 'Guide') }}</div>
                <h3 class="resource-title">{{ $resource->title }}</h3>
                <p class="resource-desc">{{ Str::limit($resource->description, 100) }}</p>
                <div class="resource-meta">
                    <span>{{ $resource->access_level ?? 'Free' }}</span>
                    <span class="resource-cta">View &rarr;</span>
                </div>
            </a>
        @empty
            <div class="empty-state" style="grid-column:1/-1;">No resources available yet.</div>
        @endforelse
    </div>
    @if($resources->hasPages())
        <div style="padding-bottom:40px;">{{ $resources->withQueryString()->links() }}</div>
    @endif
</div>
</x-layouts.app>
