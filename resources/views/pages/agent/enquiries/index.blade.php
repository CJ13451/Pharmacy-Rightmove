<x-layouts.app title="Enquiries">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Enquiries</h1>
                <p class="text-gray-500">Manage enquiries for your listings</p>
            </div>
        </div>

        <!-- Filters -->
        <div class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 mb-6">
            <form method="GET" class="flex flex-wrap gap-4">
                <select name="status" class="rounded-lg border-gray-300 text-sm" onchange="this.form.submit()">
                    <option value="">All Statuses</option>
                    <option value="new" {{ request('status') === 'new' ? 'selected' : '' }}>New</option>
                    <option value="read" {{ request('status') === 'read' ? 'selected' : '' }}>Read</option>
                    <option value="replied" {{ request('status') === 'replied' ? 'selected' : '' }}>Replied</option>
                    <option value="archived" {{ request('status') === 'archived' ? 'selected' : '' }}>Archived</option>
                </select>
                <select name="listing" class="rounded-lg border-gray-300 text-sm" onchange="this.form.submit()">
                    <option value="">All Listings</option>
                    @foreach($listings as $listing)
                        <option value="{{ $listing->id }}" {{ request('listing') == $listing->id ? 'selected' : '' }}>
                            {{ Str::limit($listing->title, 40) }}
                        </option>
                    @endforeach
                </select>
            </form>
        </div>

        @if($enquiries->count() > 0)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 divide-y divide-gray-100">
                @foreach($enquiries as $enquiry)
                    <div class="p-6 hover:bg-gray-50 transition {{ $enquiry->status === 'new' ? 'bg-green-50' : '' }}">
                        <div class="flex items-start gap-6">
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-3 mb-2">
                                    <h3 class="font-semibold text-gray-900">
                                        {{ $enquiry->user->full_name ?? 'Unknown User' }}
                                    </h3>
                                    @if($enquiry->status === 'new')
                                        <span class="bg-green-500 text-white text-xs font-bold px-2 py-0.5 rounded">NEW</span>
                                    @elseif($enquiry->status === 'replied')
                                        <span class="bg-blue-100 text-blue-700 text-xs font-bold px-2 py-0.5 rounded">REPLIED</span>
                                    @endif
                                </div>
                                <p class="text-sm text-gray-500 mb-2">
                                    Re: <a href="{{ route('agent.listings.edit', $enquiry->listing->id) }}" class="text-green-600 hover:underline">{{ $enquiry->listing->title }}</a>
                                </p>
                                <p class="text-gray-700 line-clamp-2">{{ $enquiry->message }}</p>
                                <div class="flex items-center gap-4 mt-3 text-sm text-gray-500">
                                    <span>{{ $enquiry->created_at->format('d M Y, H:i') }}</span>
                                    @if($enquiry->user?->email)
                                        <a href="mailto:{{ $enquiry->user->email }}" class="text-green-600 hover:underline">{{ $enquiry->user->email }}</a>
                                    @endif
                                    @if($enquiry->phone)
                                        <span>{{ $enquiry->phone }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="flex items-center gap-2 flex-shrink-0">
                                <a href="{{ route('agent.enquiries.show', $enquiry->id) }}" class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition">
                                    View & Reply
                                </a>
                                @if($enquiry->status !== 'archived')
                                    <form method="POST" action="{{ route('agent.enquiries.archive', $enquiry->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <button type="submit" class="text-gray-400 hover:text-gray-600 p-2" title="Archive">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                                            </svg>
                                        </button>
                                    </form>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $enquiries->links() }}
            </div>
        @else
            <div class="bg-white rounded-xl p-12 shadow-sm border border-gray-100 text-center">
                <svg class="w-16 h-16 text-gray-300 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900 mb-2">No enquiries yet</h3>
                <p class="text-gray-500">When potential buyers contact you about your listings, their messages will appear here.</p>
            </div>
        @endif
    </div>
</x-layouts.app>
