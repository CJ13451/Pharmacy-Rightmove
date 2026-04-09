<x-layouts.app title="Dashboard">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <h1 class="text-2xl font-bold text-gray-900 mb-8">Your Dashboard</h1>

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- In Progress Courses -->
                @if($inProgressCourses->count() > 0)
                    <section>
                        <h2 class="text-lg font-bold text-gray-900 mb-4">Continue Learning</h2>
                        <div class="space-y-4">
                            @foreach($inProgressCourses as $enrolment)
                                <a href="{{ route('training.show', $enrolment->course->slug) }}" class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 hover:shadow-md transition flex items-center gap-4 group">
                                    <div class="w-20 h-14 bg-purple-100 rounded-lg flex-shrink-0 flex items-center justify-center">
                                        @if($enrolment->course->thumbnail)
                                            <img src="{{ $enrolment->course->thumbnail }}" alt="" class="w-full h-full object-cover rounded-lg">
                                        @else
                                            <svg class="w-8 h-8 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="font-semibold text-gray-900 group-hover:text-green-600 transition line-clamp-1">{{ $enrolment->course->title }}</h3>
                                        <div class="flex items-center gap-2 mt-2">
                                            <div class="flex-1 bg-gray-200 rounded-full h-2">
                                                <div class="bg-green-600 h-2 rounded-full" style="width: {{ $enrolment->progress_percentage }}%"></div>
                                            </div>
                                            <span class="text-sm text-gray-500">{{ $enrolment->progress_percentage }}%</span>
                                        </div>
                                    </div>
                                    <svg class="w-5 h-5 text-gray-400 group-hover:text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                    </svg>
                                </a>
                            @endforeach
                        </div>
                    </section>
                @endif

                <!-- Saved Listings -->
                <section>
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-bold text-gray-900">Saved Pharmacies</h2>
                        <a href="{{ route('listings.index') }}" class="text-green-600 hover:text-green-700 text-sm font-medium">Browse all →</a>
                    </div>
                    @if($savedListings->count() > 0)
                        <div class="grid md:grid-cols-2 gap-4">
                            @foreach($savedListings as $saved)
                                @if($saved->listing)
                                    <a href="{{ route('listings.show', $saved->listing->slug) }}" class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 hover:shadow-md transition group">
                                        <div class="text-xl font-bold text-green-600 mb-1">{{ $saved->listing->formatted_price }}</div>
                                        <h3 class="font-semibold text-gray-900 group-hover:text-green-600 transition line-clamp-1">{{ $saved->listing->title }}</h3>
                                        <p class="text-gray-500 text-sm">{{ $saved->listing->location }}</p>
                                    </a>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <div class="bg-gray-50 rounded-xl p-8 text-center">
                            <p class="text-gray-500">You haven't saved any pharmacies yet.</p>
                            <a href="{{ route('listings.index') }}" class="text-green-600 hover:underline text-sm mt-2 inline-block">Browse listings</a>
                        </div>
                    @endif
                </section>

                <!-- Saved Searches -->
                <section>
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-bold text-gray-900">Saved Searches</h2>
                        <a href="{{ route('saved-searches.index') }}" class="text-green-600 hover:text-green-700 text-sm font-medium">Manage →</a>
                    </div>
                    @if($savedSearches->count() > 0)
                        <div class="bg-white rounded-xl shadow-sm border border-gray-100 divide-y divide-gray-100">
                            @foreach($savedSearches as $search)
                                <div class="p-4 flex items-center justify-between">
                                    <div>
                                        <h3 class="font-medium text-gray-900">{{ $search->name }}</h3>
                                        <p class="text-sm text-gray-500">{{ $search->filters_summary }}</p>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        @if($search->email_alerts)
                                            <span class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded">Alerts on</span>
                                        @endif
                                        <a href="{{ route('listings.index', $search->filters) }}" class="text-green-600 hover:text-green-700 text-sm font-medium">View</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="bg-gray-50 rounded-xl p-8 text-center">
                            <p class="text-gray-500">No saved searches yet.</p>
                        </div>
                    @endif
                </section>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Quick Links -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-900 mb-4">Quick Links</h3>
                    <nav class="space-y-2">
                        <a href="{{ route('account.settings') }}" class="flex items-center gap-3 text-gray-600 hover:text-green-600 transition py-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>
                            Account Settings
                        </a>
                        <a href="{{ route('account.purchases') }}" class="flex items-center gap-3 text-gray-600 hover:text-green-600 transition py-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                            </svg>
                            Purchase History
                        </a>
                        <a href="{{ route('saved-searches.index') }}" class="flex items-center gap-3 text-gray-600 hover:text-green-600 transition py-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                            </svg>
                            Saved Searches
                        </a>
                    </nav>
                </div>

                <!-- Account Summary -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-900 mb-4">Your Account</h3>
                    <dl class="space-y-3 text-sm">
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Name</dt>
                            <dd class="text-gray-900 font-medium">{{ auth()->user()->full_name }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Email</dt>
                            <dd class="text-gray-900">{{ auth()->user()->email }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Role</dt>
                            <dd class="text-gray-900">{{ auth()->user()->job_title?->label() ?? 'Not set' }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-500">Member since</dt>
                            <dd class="text-gray-900">{{ auth()->user()->created_at->format('M Y') }}</dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
