<x-layouts.app title="Listing Analytics">
<div class="max-w-5xl mx-auto px-4 py-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Analytics</h1>
            <p class="text-gray-600 mt-1">{{ $listing->title }}</p>
        </div>
        <a href="{{ route('agent.listings.edit', $listing->id) }}" class="text-sm text-green-600 hover:text-green-700 font-medium">&larr; Back to Listing</a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <div class="bg-white rounded-lg shadow-md p-6">
            <p class="text-sm text-gray-500 mb-1">Total Views</p>
            <p class="text-3xl font-bold text-gray-900">{{ $listing->views_count ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <p class="text-sm text-gray-500 mb-1">Enquiries</p>
            <p class="text-3xl font-bold text-gray-900">{{ $listing->enquiries_count ?? 0 }}</p>
        </div>
        <div class="bg-white rounded-lg shadow-md p-6">
            <p class="text-sm text-gray-500 mb-1">Saves</p>
            <p class="text-3xl font-bold text-gray-900">{{ $listing->saves_count ?? 0 }}</p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow-md p-6 mb-8">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Views (Last 30 Days)</h2>
        @if(count($viewsByDay) > 0)
            <div class="space-y-2">
                @foreach($viewsByDay as $date => $count)
                    <div class="flex items-center gap-4">
                        <span class="text-sm text-gray-500 w-24">{{ \Carbon\Carbon::parse($date)->format('d M') }}</span>
                        <div class="flex-1 bg-gray-100 rounded-full h-4">
                            <div class="bg-green-500 rounded-full h-4" style="width: {{ max(5, min(100, ($count / max(1, max($viewsByDay))) * 100)) }}%"></div>
                        </div>
                        <span class="text-sm font-medium text-gray-700 w-8 text-right">{{ $count }}</span>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-center py-8">No views recorded in the last 30 days.</p>
        @endif
    </div>

    <div class="bg-white rounded-lg shadow-md p-6">
        <h2 class="text-xl font-semibold text-gray-900 mb-4">Enquiries by Status</h2>
        @if(count($enquiriesByStatus) > 0)
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                @foreach($enquiriesByStatus as $status => $count)
                    <div class="text-center p-4 bg-gray-50 rounded-lg">
                        <p class="text-2xl font-bold text-gray-900">{{ $count }}</p>
                        <p class="text-sm text-gray-500 capitalize">{{ $status }}</p>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 text-center py-8">No enquiries received yet.</p>
        @endif
    </div>
</div>
</x-layouts.app>
