<x-layouts.app title="Create Listing">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="mb-8">
            <a href="{{ route('agent.listings.index') }}" class="text-gray-500 hover:text-gray-700 text-sm mb-2 inline-flex items-center gap-1">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Back to Listings
            </a>
            <h1 class="text-2xl font-bold text-gray-900">Create New Listing</h1>
        </div>

        <div class="max-w-4xl mx-auto">
        <form method="POST" action="{{ route('agent.listings.store') }}" enctype="multipart/form-data" class="space-y-8">
            @csrf

            <!-- Basic Information -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <h2 class="text-lg font-bold text-gray-900 mb-6">Basic Information</h2>
                
                <div class="space-y-6">
                    <div>
                        <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Listing Title *</label>
                        <input type="text" name="title" id="title" value="{{ old('title') }}" required
                            class="w-full rounded-lg border-gray-300"
                            placeholder="e.g. Well-Established Community Pharmacy in Manchester">
                        @error('title')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label for="property_type" class="block text-sm font-medium text-gray-700 mb-1">Property Type *</label>
                            <select name="property_type" id="property_type" required class="w-full rounded-lg border-gray-300">
                                <option value="freehold" {{ old('property_type') === 'freehold' ? 'selected' : '' }}>Freehold</option>
                                <option value="leasehold" {{ old('property_type') === 'leasehold' ? 'selected' : '' }}>Leasehold</option>
                            </select>
                        </div>
                        <div>
                            <label for="price" class="block text-sm font-medium text-gray-700 mb-1">Asking Price (£) *</label>
                            <input type="number" name="price" id="price" value="{{ old('price') }}" required min="0" step="1"
                                class="w-full rounded-lg border-gray-300"
                                placeholder="500000">
                            @error('price')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label for="description" class="block text-sm font-medium text-gray-700 mb-1">Description *</label>
                        <textarea name="description" id="description" rows="6" required
                            class="w-full rounded-lg border-gray-300"
                            placeholder="Describe the pharmacy, its location, customer base, and any unique selling points...">{{ old('description') }}</textarea>
                        @error('description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Location -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <h2 class="text-lg font-bold text-gray-900 mb-6">Location</h2>
                
                <div class="space-y-6">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label for="town" class="block text-sm font-medium text-gray-700 mb-1">Town/City *</label>
                            <input type="text" name="town" id="town" value="{{ old('town') }}" required
                                class="w-full rounded-lg border-gray-300">
                        </div>
                        <div>
                            <label for="county" class="block text-sm font-medium text-gray-700 mb-1">County</label>
                            <input type="text" name="county" id="county" value="{{ old('county') }}"
                                class="w-full rounded-lg border-gray-300">
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label for="postcode" class="block text-sm font-medium text-gray-700 mb-1">Postcode *</label>
                            <input type="text" name="postcode" id="postcode" value="{{ old('postcode') }}" required
                                class="w-full rounded-lg border-gray-300"
                                placeholder="e.g. M1 1AA">
                        </div>
                        <div>
                            <label for="region" class="block text-sm font-medium text-gray-700 mb-1">Region *</label>
                            <select name="region" id="region" required class="w-full rounded-lg border-gray-300">
                                <option value="">Select region</option>
                                @foreach(\App\Enums\Region::cases() as $region)
                                    <option value="{{ $region->value }}" {{ old('region') === $region->value ? 'selected' : '' }}>
                                        {{ $region->label() }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Business Details -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <h2 class="text-lg font-bold text-gray-900 mb-6">Business Details</h2>
                
                <div class="space-y-6">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label for="monthly_items" class="block text-sm font-medium text-gray-700 mb-1">Monthly Items</label>
                            <input type="number" name="monthly_items" id="monthly_items" value="{{ old('monthly_items') }}" min="0"
                                class="w-full rounded-lg border-gray-300"
                                placeholder="e.g. 8000">
                        </div>
                        <div>
                            <label for="annual_turnover" class="block text-sm font-medium text-gray-700 mb-1">Annual Turnover (£)</label>
                            <input type="number" name="annual_turnover" id="annual_turnover" value="{{ old('annual_turnover') }}" min="0"
                                class="w-full rounded-lg border-gray-300"
                                placeholder="e.g. 1200000">
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label for="annual_gross_profit" class="block text-sm font-medium text-gray-700 mb-1">Annual Gross Profit (£)</label>
                            <input type="number" name="annual_gross_profit" id="annual_gross_profit" value="{{ old('annual_gross_profit') }}" min="0"
                                class="w-full rounded-lg border-gray-300">
                        </div>
                        <div>
                            <label for="staff_count" class="block text-sm font-medium text-gray-700 mb-1">Staff Count</label>
                            <input type="number" name="staff_count" id="staff_count" value="{{ old('staff_count') }}" min="0"
                                class="w-full rounded-lg border-gray-300">
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="nhs_contract" value="1" {{ old('nhs_contract') ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-green-600">
                                <span class="text-sm text-gray-700">Has NHS Contract</span>
                            </label>
                        </div>
                        <div>
                            <label class="flex items-center gap-2">
                                <input type="checkbox" name="has_accommodation" value="1" {{ old('has_accommodation') ? 'checked' : '' }}
                                    class="rounded border-gray-300 text-green-600">
                                <span class="text-sm text-gray-700">Has Accommodation</span>
                            </label>
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6" id="lease-fields" style="{{ old('property_type') === 'freehold' ? 'display: none;' : '' }}">
                        <div>
                            <label for="lease_years_remaining" class="block text-sm font-medium text-gray-700 mb-1">Lease Years Remaining</label>
                            <input type="number" name="lease_years_remaining" id="lease_years_remaining" value="{{ old('lease_years_remaining') }}" min="0"
                                class="w-full rounded-lg border-gray-300">
                        </div>
                        <div>
                            <label for="rent_per_annum" class="block text-sm font-medium text-gray-700 mb-1">Annual Rent (£)</label>
                            <input type="number" name="rent_per_annum" id="rent_per_annum" value="{{ old('rent_per_annum') }}" min="0"
                                class="w-full rounded-lg border-gray-300">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Images -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <h2 class="text-lg font-bold text-gray-900 mb-6">Images</h2>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Upload Photos</label>
                    <div class="border-2 border-dashed border-gray-300 rounded-lg p-8 text-center hover:border-green-400 transition">
                        <input type="file" name="images[]" multiple accept="image/*" class="hidden" id="images-input">
                        <label for="images-input" class="cursor-pointer">
                            <svg class="w-12 h-12 text-gray-400 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <p class="text-gray-600">Click to upload images</p>
                            <p class="text-gray-400 text-sm mt-1">JPG, PNG up to 5MB each</p>
                        </label>
                    </div>
                    <p class="text-sm text-gray-500 mt-2">First image will be the primary listing image</p>
                </div>
            </div>

            <!-- Contact Details -->
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <h2 class="text-lg font-bold text-gray-900 mb-6">Contact Details</h2>
                
                <div class="space-y-6">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label for="agent_name" class="block text-sm font-medium text-gray-700 mb-1">Contact Name *</label>
                            <input type="text" name="agent_name" id="agent_name" value="{{ old('agent_name', auth()->user()->full_name) }}" required
                                class="w-full rounded-lg border-gray-300">
                        </div>
                        <div>
                            <label for="agent_company" class="block text-sm font-medium text-gray-700 mb-1">Company Name</label>
                            <input type="text" name="agent_company" id="agent_company" value="{{ old('agent_company') }}"
                                class="w-full rounded-lg border-gray-300">
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label for="agent_email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                            <input type="email" name="agent_email" id="agent_email" value="{{ old('agent_email', auth()->user()->email) }}" required
                                class="w-full rounded-lg border-gray-300">
                        </div>
                        <div>
                            <label for="agent_phone" class="block text-sm font-medium text-gray-700 mb-1">Phone</label>
                            <input type="tel" name="agent_phone" id="agent_phone" value="{{ old('agent_phone') }}"
                                class="w-full rounded-lg border-gray-300">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Submit -->
            <div class="flex items-center justify-end gap-4">
                <button type="submit" name="action" value="draft" class="px-6 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition">
                    Save as Draft
                </button>
                <button type="submit" name="action" value="submit" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition">
                    Submit for Review
                </button>
            </div>
        </form>
        </div>
    </div>

    <script>
        document.getElementById('property_type').addEventListener('change', function() {
            document.getElementById('lease-fields').style.display = this.value === 'freehold' ? 'none' : '';
        });
    </script>
</x-layouts.app>
