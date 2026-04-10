<x-layouts.app title="Agent Dashboard">
    <div class="max-w-7xl mx-auto px-8 py-8">
        <div class="flex items-center justify-between mb-8">
            <h1 class="text-2xl font-bold text-gray-900">Agent Dashboard</h1>
            <a href="{{ route('agent.listings.create') }}" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-medium transition">
                + Create Listing
            </a>
        </div>

        <!-- Stats -->
        <div class="grid md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Active Listings</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $stats['active_listings'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 text-green-600 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total Views</p>
                        <p class="text-3xl font-bold text-gray-900">{{ number_format($stats['total_views']) }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">New Enquiries</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $stats['new_enquiries'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-sm text-gray-500">Total Enquiries</p>
                        <p class="text-3xl font-bold text-gray-900">{{ $stats['total_enquiries'] }}</p>
                    </div>
                    <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-full flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Recent Enquiries -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                        <h2 class="font-bold text-gray-900">Recent Enquiries</h2>
                        <a href="{{ route('agent.enquiries.index') }}" class="text-green-600 hover:text-green-700 text-sm font-medium">View all →</a>
                    </div>
                    @if($recentEnquiries->count() > 0)
                        <div class="divide-y divide-gray-100">
                            @foreach($recentEnquiries as $enquiry)
                                <div class="p-4 hover:bg-gray-50">
                                    <div class="flex items-start justify-between gap-4">
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-2 mb-1">
                                                <p class="font-medium text-gray-900">{{ $enquiry->user->full_name ?? $enquiry->email }}</p>
                                                @if($enquiry->status === 'new')
                                                    <span class="bg-green-100 text-green-700 text-xs font-bold px-2 py-0.5 rounded">NEW</span>
                                                @endif
                                            </div>
                                            <p class="text-sm text-gray-500 line-clamp-1">Re: {{ $enquiry->listing->title }}</p>
                                            <p class="text-sm text-gray-600 line-clamp-2 mt-1">{{ Str::limit($enquiry->message, 100) }}</p>
                                        </div>
                                        <div class="text-right flex-shrink-0">
                                            <p class="text-xs text-gray-400">{{ $enquiry->created_at->diffForHumans() }}</p>
                                            <a href="{{ route('agent.enquiries.show', $enquiry->id) }}" class="text-green-600 hover:text-green-700 text-sm font-medium">View</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-8 text-center text-gray-500">
                            No enquiries yet. They'll appear here when you receive them.
                        </div>
                    @endif
                </div>

                <!-- My Listings -->
                <div class="bg-white rounded-xl shadow-sm border border-gray-100">
                    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
                        <h2 class="font-bold text-gray-900">My Listings</h2>
                        <a href="{{ route('agent.listings.index') }}" class="text-green-600 hover:text-green-700 text-sm font-medium">Manage all →</a>
                    </div>
                    @if($listings->count() > 0)
                        <div class="divide-y divide-gray-100">
                            @foreach($listings as $listing)
                                <div class="p-4 hover:bg-gray-50">
                                    <div class="flex items-center gap-4">
                                        <div class="w-20 h-14 bg-gray-100 rounded-lg overflow-hidden flex-shrink-0">
                                            @if($listing->primary_image)
                                                <img src="{{ $listing->primary_image }}" alt="" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-gray-400">
                                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <div class="flex items-center gap-2">
                                                <p class="font-medium text-gray-900 truncate">{{ $listing->title }}</p>
                                                <span class="text-xs px-2 py-0.5 rounded-full 
                                                    {{ $listing->status->value === 'active' ? 'bg-green-100 text-green-700' : '' }}
                                                    {{ $listing->status->value === 'draft' ? 'bg-gray-100 text-gray-700' : '' }}
                                                    {{ $listing->status->value === 'pending_review' ? 'bg-amber-100 text-amber-700' : '' }}
                                                    {{ $listing->status->value === 'sold' ? 'bg-blue-100 text-blue-700' : '' }}
                                                ">
                                                    {{ $listing->status->label() }}
                                                </span>
                                            </div>
                                            <p class="text-sm text-gray-500">{{ $listing->location }}</p>
                                        </div>
                                        <div class="text-right">
                                            <p class="font-semibold text-green-600">{{ $listing->formatted_price }}</p>
                                            <p class="text-xs text-gray-400">{{ $listing->views_count }} views · {{ $listing->enquiries_count }} enquiries</p>
                                        </div>
                                        <a href="{{ route('agent.listings.edit', $listing->id) }}" class="text-gray-400 hover:text-gray-600">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="p-8 text-center text-gray-500">
                            <p class="mb-4">You don't have any listings yet.</p>
                            <a href="{{ route('agent.listings.create') }}" class="text-green-600 hover:text-green-700 font-medium">Create your first listing →</a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Quick Actions -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-900 mb-4">Quick Actions</h3>
                    <div class="space-y-3">
                        <a href="{{ route('agent.listings.create') }}" class="flex items-center gap-3 text-gray-700 hover:text-green-600 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                            Create New Listing
                        </a>
                        <a href="{{ route('agent.enquiries.index') }}" class="flex items-center gap-3 text-gray-700 hover:text-green-600 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            View All Enquiries
                        </a>
                        <a href="{{ route('agent.listings.index') }}" class="flex items-center gap-3 text-gray-700 hover:text-green-600 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/>
                            </svg>
                            Manage Listings
                        </a>
                    </div>
                </div>

                <!-- Listing Tips -->
                <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6 border border-green-200">
                    <h3 class="font-bold text-green-900 mb-3">💡 Listing Tips</h3>
                    <ul class="space-y-2 text-sm text-green-800">
                        <li>• Add high-quality photos to get 3x more views</li>
                        <li>• Include monthly items and turnover data</li>
                        <li>• Featured listings get 5x more enquiries</li>
                        <li>• Respond to enquiries within 24 hours</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
