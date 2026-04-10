<x-layouts.app title="Pharmacy Valuations">
<div class="resources-hero" style="background:linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);">
    <div class="container">
        <h1>Pharmacy Valuations</h1>
        <p>Understand what pharmacies are worth. Market data, valuation methods, and tools to inform your buying or selling decisions.</p>
    </div>
</div>
<div class="container">
    <div class="resources-grid-page">
        <a href="{{ route('resources.index', ['category' => 'valuation']) }}" class="resource-card">
            <div class="resource-icon-lg">&#x1F4CA;</div>
            <div class="resource-type">Calculator</div>
            <h3 class="resource-title">Pharmacy Valuation Calculator</h3>
            <p class="resource-desc">Estimate the value of any pharmacy based on items, turnover, gross profit, and market factors.</p>
            <div class="resource-meta">
                <span>Free tool</span>
                <span class="resource-cta">Use calculator &rarr;</span>
            </div>
        </a>
        <a href="{{ route('resources.index', ['category' => 'valuation']) }}" class="resource-card">
            <div class="resource-icon-lg">&#x1F4C8;</div>
            <div class="resource-type">Report</div>
            <h3 class="resource-title">Market Valuation Trends Q1 2026</h3>
            <p class="resource-desc">Quarterly analysis of pharmacy transaction data, average multiples, and regional trends.</p>
            <div class="resource-meta">
                <span>PDF Download</span>
                <span class="resource-cta">Download &rarr;</span>
            </div>
        </a>
        <a href="{{ route('resources.index', ['category' => 'valuation']) }}" class="resource-card">
            <div class="resource-icon-lg">&#x1F4D6;</div>
            <div class="resource-type">Guide</div>
            <h3 class="resource-title">Understanding Valuation Methods</h3>
            <p class="resource-desc">A comprehensive guide to the different methods used to value a pharmacy business.</p>
            <div class="resource-meta">
                <span>12 pages</span>
                <span class="resource-cta">Read guide &rarr;</span>
            </div>
        </a>
    </div>
</div>
</x-layouts.app>
