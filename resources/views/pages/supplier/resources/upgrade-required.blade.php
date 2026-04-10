<x-layouts.app title="Upgrade Required - Resources">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md p-8 text-center">
        <div class="mb-6">
            <svg class="w-16 h-16 mx-auto text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Upgrade Required</h1>
        <p class="text-gray-700 mb-8">
            Resource uploads are available on Premium and Featured tiers. Upgrade your subscription to share guides, brochures, case studies, and more with pharmacy professionals.
        </p>
        <a href="{{ route('supplier.subscription.index') }}" class="inline-flex items-center px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700">View Plans & Upgrade</a>
        <a href="{{ route('supplier.dashboard') }}" class="inline-block mt-6 text-sm text-gray-500 hover:text-gray-700">&larr; Back to Dashboard</a>
    </div>
</div>
</x-layouts.app>
