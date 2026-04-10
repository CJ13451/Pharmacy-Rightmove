<x-layouts.app title="Payment Successful">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    <div class="max-w-3xl mx-auto bg-white rounded-lg shadow-md p-8 text-center">
        <div class="mb-6">
            <svg class="w-16 h-16 mx-auto text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
        </div>
        <h1 class="text-2xl font-bold text-gray-900 mb-2">Payment Successful</h1>
        <p class="text-gray-700 mb-6">Your listing "{{ $listing->title }}" has been submitted for review. It will be published once approved by our team.</p>
        <div class="flex justify-center gap-4">
            <a href="{{ route('agent.listings.edit', $listing->id) }}" class="inline-flex items-center px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700">View Listing</a>
            <a href="{{ route('agent.dashboard') }}" class="inline-flex items-center px-6 py-3 border border-gray-300 text-gray-700 font-semibold rounded-lg hover:bg-gray-50">Back to Dashboard</a>
        </div>
    </div>
</div>
</x-layouts.app>
