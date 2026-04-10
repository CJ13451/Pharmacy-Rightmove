<x-layouts.app title="Enquiry Details">
    <div class="max-w-7xl mx-auto px-8 py-8">
        <div class="mb-8">
            <a href="{{ route('agent.enquiries.index') }}" class="text-gray-500 hover:text-gray-700 text-sm mb-2 inline-flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Enquiries
            </a>
            <h1 class="text-2xl font-bold text-gray-900">Enquiry Details</h1>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Enquiry Message -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h2 class="font-bold text-gray-900 text-lg">{{ $enquiry->user->full_name ?? 'Unknown User' }}</h2>
                            <p class="text-sm text-gray-500">{{ $enquiry->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <span class="px-3 py-1 rounded-full text-xs font-medium
                            {{ $enquiry->status === 'new' ? 'bg-green-100 text-green-700' : '' }}
                            {{ $enquiry->status === 'read' ? 'bg-gray-100 text-gray-700' : '' }}
                            {{ $enquiry->status === 'replied' ? 'bg-blue-100 text-blue-700' : '' }}
                            {{ $enquiry->status === 'archived' ? 'bg-amber-100 text-amber-700' : '' }}
                        ">
                            {{ ucfirst($enquiry->status) }}
                        </span>
                    </div>

                    <div class="bg-gray-50 rounded-lg p-4 mb-4">
                        <p class="text-sm text-gray-500 mb-1">Regarding:</p>
                        <a href="{{ route('listings.show', $enquiry->listing->slug) }}" target="_blank" class="text-green-600 hover:underline font-medium">
                            {{ $enquiry->listing->title }}
                        </a>
                        <span class="text-gray-500"> · {{ $enquiry->listing->formatted_price }}</span>
                    </div>

                    <div class="prose prose-gray max-w-none">
                        {!! nl2br(e($enquiry->message)) !!}
                    </div>
                </div>

                <!-- Reply Form -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-900 mb-4">Send Reply</h3>
                    <form method="POST" action="{{ route('agent.enquiries.reply', $enquiry->id) }}">
                        @csrf
                        <div class="mb-4">
                            <textarea 
                                name="reply" 
                                rows="6" 
                                required
                                class="w-full rounded-lg border-gray-300"
                                placeholder="Type your reply here..."
                            >{{ old('reply') }}</textarea>
                            @error('reply')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="flex items-center justify-between">
                            <p class="text-sm text-gray-500">
                                Reply will be sent to {{ $enquiry->user?->email ?? 'the enquirer' }}
                            </p>
                            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-medium transition">
                                Send Reply
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Reply History -->
                @if($enquiry->replies->count() > 0)
                    <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                        <h3 class="font-bold text-gray-900 mb-4">Reply History</h3>
                        <div class="space-y-4">
                            @foreach($enquiry->replies as $reply)
                                <div class="border-l-4 border-green-500 pl-4">
                                    <div class="flex items-center justify-between mb-2">
                                        <p class="text-sm font-medium text-gray-900">You replied</p>
                                        <p class="text-xs text-gray-500">{{ $reply->created_at->format('d M Y, H:i') }}</p>
                                    </div>
                                    <p class="text-gray-700">{{ $reply->message }}</p>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Contact Info -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-900 mb-4">Contact Information</h3>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm text-gray-500">Name</dt>
                            <dd class="font-medium text-gray-900">{{ $enquiry->user->full_name ?? 'Unknown' }}</dd>
                        </div>
                        @if($enquiry->user?->email)
                            <div>
                                <dt class="text-sm text-gray-500">Email</dt>
                                <dd>
                                    <a href="mailto:{{ $enquiry->user->email }}" class="text-green-600 hover:underline">
                                        {{ $enquiry->user->email }}
                                    </a>
                                </dd>
                            </div>
                        @endif
                        @if($enquiry->phone)
                            <div>
                                <dt class="text-sm text-gray-500">Phone</dt>
                                <dd>
                                    <a href="tel:{{ $enquiry->phone }}" class="text-green-600 hover:underline">
                                        {{ $enquiry->phone }}
                                    </a>
                                </dd>
                            </div>
                        @endif
                        @if($enquiry->user?->job_title)
                            <div>
                                <dt class="text-sm text-gray-500">Role</dt>
                                <dd class="text-gray-900">{{ $enquiry->user->job_title->label() }}</dd>
                            </div>
                        @endif
                    </dl>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-900 mb-4">Actions</h3>
                    <div class="space-y-3">
                        @if($enquiry->user?->email)
                            <a href="mailto:{{ $enquiry->user->email }}" class="flex items-center gap-3 text-gray-700 hover:text-green-600 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                                </svg>
                                Email Directly
                            </a>
                        @endif
                        @if($enquiry->phone)
                            <a href="tel:{{ $enquiry->phone }}" class="flex items-center gap-3 text-gray-700 hover:text-green-600 transition">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                Call
                            </a>
                        @endif
                        @if($enquiry->status !== 'archived')
                            <form method="POST" action="{{ route('agent.enquiries.archive', $enquiry->id) }}">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="flex items-center gap-3 text-gray-700 hover:text-amber-600 transition w-full">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 8h14M5 8a2 2 0 110-4h14a2 2 0 110 4M5 8v10a2 2 0 002 2h10a2 2 0 002-2V8m-9 4h4"/>
                                    </svg>
                                    Archive Enquiry
                                </button>
                            </form>
                        @endif
                    </div>
                </div>

                <!-- Listing Info -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-900 mb-4">Listing</h3>
                    <a href="{{ route('agent.listings.edit', $enquiry->listing->id) }}" class="block group">
                        <div class="aspect-video bg-gray-100 rounded-lg overflow-hidden mb-3">
                            @if($enquiry->listing->primary_image)
                                <img src="{{ $enquiry->listing->primary_image }}" alt="" class="w-full h-full object-cover">
                            @endif
                        </div>
                        <p class="font-medium text-gray-900 group-hover:text-green-600 transition">{{ $enquiry->listing->title }}</p>
                        <p class="text-green-600 font-semibold">{{ $enquiry->listing->formatted_price }}</p>
                        <p class="text-sm text-gray-500">{{ $enquiry->listing->location }}</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
