<x-layouts.app title="Supplier Profile">
<div class="max-w-7xl mx-auto px-8 py-12">
    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md p-8 text-center">
        <div class="mb-6">
            <svg class="w-16 h-16 mx-auto text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-900 mb-2">No Supplier Profile</h1>
        <p class="text-gray-700 mb-8">You don't have a supplier profile yet. Join our supplier directory to showcase your business to pharmacy professionals across the UK.</p>
        <a href="{{ route('suppliers.join') }}" class="inline-flex items-center px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700">Join Supplier Directory</a>
    </div>
</div>
</x-layouts.app>
