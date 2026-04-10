<x-layouts.app :title="$listing->title">
    <div class="max-w-7xl mx-auto px-8 py-8">
        <!-- Breadcrumb -->
        <nav class="mb-6 text-sm">
            <ol class="flex items-center gap-2">
                <li><a href="{{ route('listings.index') }}" class="text-gray-500 hover:text-green-600">Pharmacies for Sale</a></li>
                <li class="text-gray-400">/</li>
                <li class="text-gray-900">{{ $listing->town }}</li>
            </ol>
        </nav>

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Image Gallery -->
                <div class="bg-gradient-to-br from-green-500 to-green-600 rounded-xl h-96 mb-6 relative overflow-hidden">
                    @if($listing->primary_image)
                        <img src="{{ $listing->primary_image }}" alt="{{ $listing->title }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center">
                            <svg class="w-24 h-24 text-white/30" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                    @endif
                    @if($listing->featured)
                        <div class="absolute top-4 left-4">
                            <span class="bg-amber-400 text-amber-900 text-sm font-bold px-3 py-1.5 rounded">FEATURED</span>
                        </div>
                    @endif
                    @php
                        $agentName = $listing->agent_company ?: $listing->agent_name;
                        $agentInitials = collect(preg_split('/\s+/', trim($agentName)))
                            ->filter()
                            ->take(2)
                            ->map(fn ($w) => mb_strtoupper(mb_substr($w, 0, 1)))
                            ->join('');
                    @endphp
                    <div class="absolute top-4 right-4 flex items-center gap-2 bg-white/95 backdrop-blur rounded-full pl-2 pr-4 py-2 shadow-lg" title="{{ $agentName }}">
                        <div class="w-10 h-10 rounded-full bg-white border border-gray-200 flex items-center justify-center text-green-600 font-extrabold text-xs">
                            {{ $agentInitials ?: 'P3' }}
                        </div>
                        <div class="text-xs leading-tight">
                            <div class="font-semibold text-gray-500 uppercase tracking-wide">Marketed by</div>
                            <div class="font-bold text-gray-900">{{ \Illuminate\Support\Str::limit($agentName, 22) }}</div>
                        </div>
                    </div>
                </div>

                <!-- Key Details -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 mb-6">
                    <div class="flex items-start justify-between mb-4">
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900 mb-1">{{ $listing->title }}</h1>
                            <p class="text-gray-500">{{ $listing->full_address }}</p>
                        </div>
                        <div class="text-right">
                            <div class="text-3xl font-bold text-green-600">{{ $listing->formatted_price }}</div>
                            <div class="text-sm text-gray-500 capitalize">{{ str_replace('_', ' ', $listing->price_qualifier) }}</div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 pt-4 border-t border-gray-100">
                        <div>
                            <div class="text-sm text-gray-500">Property Type</div>
                            <div class="font-semibold text-gray-900 capitalize">{{ $listing->property_type }}</div>
                        </div>
                        @if($listing->monthly_items)
                            <div>
                                <div class="text-sm text-gray-500">Monthly Items</div>
                                <div class="font-semibold text-gray-900">{{ number_format($listing->monthly_items) }}</div>
                            </div>
                        @endif
                        @if($listing->annual_turnover)
                            <div>
                                <div class="text-sm text-gray-500">Annual Turnover</div>
                                <div class="font-semibold text-gray-900">{{ $listing->formatted_turnover }}</div>
                            </div>
                        @endif
                        @if($listing->annual_gross_profit)
                            <div>
                                <div class="text-sm text-gray-500">Gross Profit</div>
                                <div class="font-semibold text-gray-900">{{ $listing->formatted_gross_profit }}</div>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Description -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 mb-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Description</h2>
                    <div class="prose prose-gray max-w-none">
                        {!! nl2br(e($listing->description)) !!}
                    </div>
                </div>

                <!-- Business Details -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 mb-6">
                    <h2 class="text-xl font-bold text-gray-900 mb-4">Business Details</h2>
                    <dl class="grid md:grid-cols-2 gap-4">
                        @if($listing->staff_count)
                            <div class="flex justify-between py-2 border-b border-gray-100">
                                <dt class="text-gray-500">Staff Count</dt>
                                <dd class="font-medium text-gray-900">{{ $listing->staff_count }}</dd>
                            </div>
                        @endif
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <dt class="text-gray-500">NHS Contract</dt>
                            <dd class="font-medium text-gray-900">{{ $listing->nhs_contract ? 'Yes' : 'No' }}</dd>
                        </div>
                        @if($listing->property_type !== 'freehold' && $listing->lease_years_remaining)
                            <div class="flex justify-between py-2 border-b border-gray-100">
                                <dt class="text-gray-500">Lease Remaining</dt>
                                <dd class="font-medium text-gray-900">{{ $listing->lease_years_remaining }} years</dd>
                            </div>
                        @endif
                        @if($listing->rent_per_annum)
                            <div class="flex justify-between py-2 border-b border-gray-100">
                                <dt class="text-gray-500">Annual Rent</dt>
                                <dd class="font-medium text-gray-900">{{ $listing->formatted_rent }}</dd>
                            </div>
                        @endif
                        <div class="flex justify-between py-2 border-b border-gray-100">
                            <dt class="text-gray-500">Accommodation</dt>
                            <dd class="font-medium text-gray-900">{{ $listing->has_accommodation ? 'Yes' : 'No' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="lg:col-span-1">
                <!-- Agent Card -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 sticky top-24">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-12 h-12 bg-green-100 text-green-700 rounded-full flex items-center justify-center font-bold">
                            {{ substr($listing->agent_name, 0, 1) }}
                        </div>
                        <div>
                            <div class="font-semibold text-gray-900">{{ $listing->agent_name }}</div>
                            @if($listing->agent_company)
                                <div class="text-sm text-gray-500">{{ $listing->agent_company }}</div>
                            @endif
                        </div>
                    </div>

                    <!-- Enquiry Form -->
                    <form method="POST" action="{{ route('listings.enquire', $listing->slug) }}" class="space-y-4">
                        @csrf
                        <div>
                            <textarea 
                                name="message" 
                                rows="4" 
                                required
                                class="w-full rounded-lg border-gray-300"
                                placeholder="I'm interested in this pharmacy and would like more information..."
                            >{{ old('message') }}</textarea>
                            @error('message')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <input 
                                type="tel" 
                                name="phone"
                                value="{{ old('phone') }}"
                                class="w-full rounded-lg border-gray-300"
                                placeholder="Your phone number (optional)"
                            >
                        </div>
                        <button type="submit" class="w-full bg-green-600 hover:bg-green-700 text-white py-3 rounded-lg font-semibold transition">
                            Send Enquiry
                        </button>
                    </form>

                    <!-- Save Button -->
                    <form method="POST" action="{{ route('listings.toggle-save', $listing->slug) }}" class="mt-3">
                        @csrf
                        <button type="submit" class="w-full border border-gray-300 hover:border-green-600 text-gray-700 hover:text-green-600 py-3 rounded-lg font-medium transition flex items-center justify-center gap-2">
                            @if($isSaved)
                                <svg class="w-5 h-5 text-red-500" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                                </svg>
                                Saved
                            @else
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                                </svg>
                                Save Listing
                            @endif
                        </button>
                    </form>

                    <div class="mt-4 pt-4 border-t border-gray-100 text-center">
                        <p class="text-sm text-gray-500">
                            Listed {{ $listing->published_at?->diffForHumans() ?? 'recently' }}
                            · {{ number_format($listing->views_count) }} views
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Similar Listings -->
        @if($similarListings->count() > 0)
            <section class="mt-12">
                <h2 class="text-xl font-bold text-gray-900 mb-6">Similar Pharmacies</h2>
                <div class="grid md:grid-cols-3 gap-6">
                    @foreach($similarListings as $similar)
                        <a href="{{ route('listings.show', $similar->slug) }}" class="bg-white rounded-xl overflow-hidden shadow-sm border border-gray-100 hover:shadow-md transition group">
                            <div class="h-40 bg-gradient-to-br from-green-500 to-green-600">
                                @if($similar->primary_image)
                                    <img src="{{ $similar->primary_image }}" alt="{{ $similar->title }}" class="w-full h-full object-cover">
                                @endif
                            </div>
                            <div class="p-4">
                                <div class="text-xl font-bold text-green-600 mb-1">{{ $similar->formatted_price }}</div>
                                <h3 class="font-semibold text-gray-900 group-hover:text-green-600 transition line-clamp-1">{{ $similar->title }}</h3>
                                <p class="text-gray-500 text-sm">{{ $similar->location }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
</x-layouts.app>
