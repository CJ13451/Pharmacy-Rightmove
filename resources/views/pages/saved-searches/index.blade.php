<x-layouts.app title="Saved Searches">
    <div class="max-w-7xl mx-auto px-8 py-8">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Saved Searches</h1>
            <a href="{{ route('listings.index') }}" class="text-green-600 hover:text-green-700 font-medium">
                New Search →
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        @if($savedSearches->count() > 0)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 divide-y divide-gray-100">
                @foreach($savedSearches as $search)
                    <div class="p-6">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <h3 class="font-semibold text-gray-900 mb-1">{{ $search->name }}</h3>
                                <p class="text-sm text-gray-500 mb-3">{{ $search->filters_summary }}</p>
                                
                                <div class="flex items-center gap-4 text-sm">
                                    <span class="text-gray-400">Created {{ $search->created_at->diffForHumans() }}</span>
                                    @if($search->last_run_at)
                                        <span class="text-gray-400">Last checked {{ $search->last_run_at->diffForHumans() }}</span>
                                    @endif
                                    @if($search->new_matches_count > 0)
                                        <span class="bg-green-100 text-green-700 px-2 py-0.5 rounded text-xs font-medium">
                                            {{ $search->new_matches_count }} new {{ Str::plural('match', $search->new_matches_count) }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="flex items-center gap-3 ml-4">
                                <!-- Email alerts toggle -->
                                <form method="POST" action="{{ route('saved-searches.toggle-alerts', $search) }}">
                                    @csrf
                                    @method('PATCH')
                                    <button 
                                        type="submit" 
                                        class="flex items-center gap-2 px-3 py-1.5 rounded-lg text-sm font-medium transition
                                            {{ $search->email_alerts ? 'bg-green-100 text-green-700 hover:bg-green-200' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}"
                                        title="{{ $search->email_alerts ? 'Email alerts on' : 'Email alerts off' }}"
                                    >
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                                        </svg>
                                        {{ $search->email_alerts ? 'On' : 'Off' }}
                                    </button>
                                </form>

                                <!-- View results -->
                                <a 
                                    href="{{ route('listings.index', $search->filters ?? []) }}" 
                                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-1.5 rounded-lg text-sm font-medium transition"
                                >
                                    View Results
                                </a>

                                <!-- Delete -->
                                <form method="POST" action="{{ route('saved-searches.destroy', $search) }}" 
                                      onsubmit="return confirm('Delete this saved search?')">
                                    @csrf
                                    @method('DELETE')
                                    <button 
                                        type="submit" 
                                        class="text-gray-400 hover:text-red-600 transition p-1.5"
                                        title="Delete search"
                                    >
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="bg-gray-50 rounded-xl p-12 text-center">
                <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">No saved searches yet</h3>
                <p class="text-gray-500 mb-6">
                    Save your pharmacy searches to get notified when new listings match your criteria.
                </p>
                <a href="{{ route('listings.index') }}" class="inline-block bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-medium transition">
                    Start Searching
                </a>
            </div>
        @endif

        <!-- How it works -->
        <div class="mt-12 bg-white rounded-xl p-6 shadow-sm border border-gray-100">
            <h2 class="font-bold text-gray-900 mb-4">How Saved Searches Work</h2>
            <div class="grid md:grid-cols-3 gap-6">
                <div class="text-center">
                    <div class="w-10 h-10 bg-green-100 text-green-600 rounded-lg flex items-center justify-center mx-auto mb-3">
                        <span class="font-bold">1</span>
                    </div>
                    <h3 class="font-medium text-gray-900 mb-1">Search & Filter</h3>
                    <p class="text-sm text-gray-500">Set your criteria on the listings page</p>
                </div>
                <div class="text-center">
                    <div class="w-10 h-10 bg-green-100 text-green-600 rounded-lg flex items-center justify-center mx-auto mb-3">
                        <span class="font-bold">2</span>
                    </div>
                    <h3 class="font-medium text-gray-900 mb-1">Save Your Search</h3>
                    <p class="text-sm text-gray-500">Click "Save this search" to store your filters</p>
                </div>
                <div class="text-center">
                    <div class="w-10 h-10 bg-green-100 text-green-600 rounded-lg flex items-center justify-center mx-auto mb-3">
                        <span class="font-bold">3</span>
                    </div>
                    <h3 class="font-medium text-gray-900 mb-1">Get Alerts</h3>
                    <p class="text-sm text-gray-500">Receive email notifications for new matches</p>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
