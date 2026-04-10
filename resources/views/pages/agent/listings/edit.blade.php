<x-layouts.app :title="'Edit: ' . $listing->title">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('agent.listings.index') }}" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Edit Listing</h1>
                <p class="text-gray-500 text-sm">{{ $listing->title }}</p>
            </div>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        <!-- Status Banner -->
        @if($listing->status === 'pending')
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-6 flex items-center gap-4">
                <div class="w-10 h-10 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-amber-800">Awaiting Payment</p>
                    <p class="text-sm text-amber-700">Complete payment to publish your listing.</p>
                </div>
                <a href="{{ route('agent.listings.payment', $listing) }}" class="ml-auto bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-lg font-medium transition">
                    Pay Now
                </a>
            </div>
        @endif

        <div class="max-w-4xl mx-auto">
        <form method="POST" action="{{ route('agent.listings.update', $listing) }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Basic Details -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-lg font-bold text-gray-900">Basic Details</h2>
                </div>
                <div class="p-6 space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Listing Title *</label>
                        <input type="text" name="title" value="{{ old('title', $listing->title) }}" required class="w-full rounded-lg border-gray-300">
                        @error('title')<p class="text-red-500 text-sm mt-1">{{ $message }}</p>@enderror
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Asking Price *</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">£</span>
                                <input type="number" name="price" value="{{ old('price', $listing->price) }}" required min="0" class="w-full rounded-lg border-gray-300 pl-7">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Property Type *</label>
                            <select name="property_type" required class="w-full rounded-lg border-gray-300">
                                <option value="freehold" {{ old('property_type', $listing->property_type) === 'freehold' ? 'selected' : '' }}>Freehold</option>
                                <option value="leasehold" {{ old('property_type', $listing->property_type) === 'leasehold' ? 'selected' : '' }}>Leasehold</option>
                            </select>
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Region *</label>
                        <select name="region" required class="w-full rounded-lg border-gray-300">
                            @foreach(\App\Enums\Region::cases() as $region)
                                <option value="{{ $region->value }}" {{ old('region', $listing->region->value) === $region->value ? 'selected' : '' }}>{{ $region->label() }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Town/City</label>
                        <input type="text" name="town" value="{{ old('town', $listing->town) }}" class="w-full rounded-lg border-gray-300">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Description *</label>
                        <textarea name="description" rows="6" required class="w-full rounded-lg border-gray-300">{{ old('description', $listing->description) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Business Details -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-lg font-bold text-gray-900">Business Details</h2>
                </div>
                <div class="p-6 space-y-6">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Monthly NHS Items</label>
                            <input type="number" name="monthly_items" value="{{ old('monthly_items', $listing->monthly_items) }}" min="0" class="w-full rounded-lg border-gray-300">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Annual Turnover</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">£</span>
                                <input type="number" name="annual_turnover" value="{{ old('annual_turnover', $listing->annual_turnover) }}" min="0" class="w-full rounded-lg border-gray-300 pl-7">
                            </div>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Gross Profit</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">£</span>
                                <input type="number" name="gross_profit" value="{{ old('gross_profit', $listing->gross_profit) }}" min="0" class="w-full rounded-lg border-gray-300 pl-7">
                            </div>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Annual Rent (if leasehold)</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-500">£</span>
                                <input type="number" name="annual_rent" value="{{ old('annual_rent', $listing->annual_rent) }}" min="0" class="w-full rounded-lg border-gray-300 pl-7">
                            </div>
                        </div>
                    </div>

                    <div class="flex items-center gap-6">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="has_accommodation" value="1" {{ old('has_accommodation', $listing->has_accommodation) ? 'checked' : '' }} class="rounded border-gray-300 text-green-600">
                            <span class="text-sm text-gray-700">Includes accommodation</span>
                        </label>
                    </div>
                </div>
            </div>

            <!-- Photos -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-lg font-bold text-gray-900">Photos</h2>
                </div>
                <div class="p-6">
                    @if($listing->photos && count($listing->photos) > 0)
                        <div class="grid grid-cols-4 gap-4 mb-4">
                            @foreach($listing->photos as $index => $photo)
                                <div class="relative aspect-video">
                                    <img src="{{ $photo }}" alt="Photo {{ $index + 1 }}" class="w-full h-full object-cover rounded-lg">
                                    <button type="button" onclick="this.closest('div').remove()" class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center text-xs hover:bg-red-600">×</button>
                                    <input type="hidden" name="existing_photos[]" value="{{ $photo }}">
                                </div>
                            @endforeach
                        </div>
                    @endif
                    <input type="file" name="photos[]" accept="image/*" multiple class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                    <p class="text-xs text-gray-500 mt-1">Upload up to 10 photos. Recommended: 1200x800px minimum.</p>
                </div>
            </div>

            <!-- Status -->
            @if($listing->status === 'active')
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100">
                        <h2 class="text-lg font-bold text-gray-900">Listing Status</h2>
                    </div>
                    <div class="p-6">
                        <select name="status" class="w-full rounded-lg border-gray-300">
                            <option value="active" {{ $listing->status === 'active' ? 'selected' : '' }}>Active - Visible to buyers</option>
                            <option value="under_offer" {{ $listing->status === 'under_offer' ? 'selected' : '' }}>Under Offer</option>
                            <option value="sold" {{ $listing->status === 'sold' ? 'selected' : '' }}>Sold - Mark as complete</option>
                            <option value="withdrawn" {{ $listing->status === 'withdrawn' ? 'selected' : '' }}>Withdrawn - Remove from site</option>
                        </select>
                    </div>
                </div>
            @endif

            <!-- Actions -->
            <div class="flex justify-between">
                <a href="{{ route('listings.show', $listing->slug) }}" target="_blank" class="text-green-600 hover:text-green-700 font-medium flex items-center gap-1">
                    Preview Listing
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                    </svg>
                </a>
                <div class="flex gap-4">
                    <a href="{{ route('agent.listings.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">Cancel</a>
                    <button type="submit" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition">Save Changes</button>
                </div>
            </div>
        </form>

        <!-- Danger Zone -->
        @if(in_array($listing->status, ['draft', 'withdrawn']))
            <div class="mt-12 bg-red-50 border border-red-200 rounded-xl p-6">
                <h3 class="font-bold text-red-800 mb-2">Danger Zone</h3>
                <p class="text-sm text-red-700 mb-4">Permanently delete this listing. This action cannot be undone.</p>
                <form method="POST" action="{{ route('agent.listings.destroy', $listing) }}" onsubmit="return confirm('Are you sure you want to delete this listing? This cannot be undone.')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white px-4 py-2 rounded-lg font-medium transition">Delete Listing</button>
                </form>
            </div>
        @endif
        </div>
    </div>
</x-layouts.app>
