<x-layouts.app title="Edit Profile">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('supplier.dashboard') }}" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-gray-900">Edit Profile</h1>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('supplier.profile.update') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Basic Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-lg font-bold text-gray-900">Basic Information</h2>
                </div>
                <div class="p-6 space-y-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Company Name *</label>
                        <input 
                            type="text" 
                            name="name" 
                            value="{{ old('name', $supplier->name) }}"
                            required
                            class="w-full rounded-lg border-gray-300"
                        >
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Category *</label>
                        <select name="category" required class="w-full rounded-lg border-gray-300">
                            @foreach(\App\Enums\SupplierCategory::cases() as $category)
                                <option value="{{ $category->value }}" {{ old('category', $supplier->category->value) === $category->value ? 'selected' : '' }}>
                                    {{ $category->label() }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Short Description *</label>
                        <input 
                            type="text" 
                            name="short_description" 
                            value="{{ old('short_description', $supplier->short_description) }}"
                            required
                            maxlength="200"
                            class="w-full rounded-lg border-gray-300"
                            placeholder="A brief tagline for your company (max 200 characters)"
                        >
                        @error('short_description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Full Description</label>
                        <textarea 
                            name="long_description" 
                            rows="6"
                            class="w-full rounded-lg border-gray-300"
                            placeholder="Tell potential customers about your company, products, and services..."
                        >{{ old('long_description', $supplier->long_description) }}</textarea>
                        @error('long_description')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>

            <!-- Contact Information -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-lg font-bold text-gray-900">Contact Information</h2>
                </div>
                <div class="p-6 space-y-6">
                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Contact Name</label>
                            <input 
                                type="text" 
                                name="contact_name" 
                                value="{{ old('contact_name', $supplier->contact_name) }}"
                                class="w-full rounded-lg border-gray-300"
                            >
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Contact Email *</label>
                            <input 
                                type="email" 
                                name="contact_email" 
                                value="{{ old('contact_email', $supplier->contact_email) }}"
                                required
                                class="w-full rounded-lg border-gray-300"
                            >
                            @error('contact_email')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Phone Number</label>
                            <input 
                                type="tel" 
                                name="contact_phone" 
                                value="{{ old('contact_phone', $supplier->contact_phone) }}"
                                class="w-full rounded-lg border-gray-300"
                            >
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Website</label>
                            <input 
                                type="url" 
                                name="website" 
                                value="{{ old('website', $supplier->website) }}"
                                class="w-full rounded-lg border-gray-300"
                                placeholder="https://"
                            >
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                        <textarea 
                            name="address" 
                            rows="2"
                            class="w-full rounded-lg border-gray-300"
                        >{{ old('address', $supplier->address) }}</textarea>
                    </div>
                </div>
            </div>

            <!-- Media (Premium/Featured only) -->
            @if($supplier->tier->value !== 'free')
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="p-6 border-b border-gray-100">
                        <h2 class="text-lg font-bold text-gray-900">Media</h2>
                    </div>
                    <div class="p-6 space-y-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Company Logo</label>
                            @if($supplier->logo)
                                <div class="mb-3">
                                    <img src="{{ $supplier->logo }}" alt="Current logo" class="h-20 w-20 object-contain rounded-lg border">
                                </div>
                            @endif
                            <input 
                                type="file" 
                                name="logo" 
                                accept="image/*"
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-green-50 file:text-green-700 hover:file:bg-green-100"
                            >
                            <p class="text-xs text-gray-500 mt-1">Recommended: Square image, at least 400x400px</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Photos (up to {{ $supplier->tier->value === 'featured' ? '10' : '5' }})
                            </label>
                            @if($supplier->photos && count($supplier->photos) > 0)
                                <div class="grid grid-cols-5 gap-2 mb-3">
                                    @foreach($supplier->photos as $index => $photo)
                                        <div class="relative aspect-square">
                                            <img src="{{ $photo }}" alt="Photo {{ $index + 1 }}" class="w-full h-full object-cover rounded-lg">
                                            <button 
                                                type="button" 
                                                onclick="this.closest('div').remove()"
                                                class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center text-xs hover:bg-red-600"
                                            >×</button>
                                            <input type="hidden" name="existing_photos[]" value="{{ $photo }}">
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            <input 
                                type="file" 
                                name="photos[]" 
                                accept="image/*"
                                multiple
                                class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-green-50 file:text-green-700 hover:file:bg-green-100"
                            >
                        </div>
                    </div>
                </div>
            @else
                <div class="bg-amber-50 border border-amber-200 rounded-xl p-6">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-amber-800">Want to add images?</h3>
                            <p class="text-sm text-amber-700 mt-1">Upgrade to Premium or Featured to add your logo and photos to your listing.</p>
                            <a href="{{ route('supplier.subscription') }}" class="inline-block mt-3 text-sm font-medium text-amber-800 hover:text-amber-900">
                                Upgrade Now →
                            </a>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Social Links -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6 border-b border-gray-100">
                    <h2 class="text-lg font-bold text-gray-900">Social Links</h2>
                </div>
                <div class="p-6 space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">LinkedIn</label>
                        <input 
                            type="url" 
                            name="social_links[linkedin]" 
                            value="{{ old('social_links.linkedin', $supplier->social_links['linkedin'] ?? '') }}"
                            class="w-full rounded-lg border-gray-300"
                            placeholder="https://linkedin.com/company/..."
                        >
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">X (Twitter)</label>
                        <input 
                            type="url" 
                            name="social_links[twitter]" 
                            value="{{ old('social_links.twitter', $supplier->social_links['twitter'] ?? '') }}"
                            class="w-full rounded-lg border-gray-300"
                            placeholder="https://x.com/..."
                        >
                    </div>
                </div>
            </div>

            <!-- Submit -->
            <div class="flex justify-end gap-4">
                <a href="{{ route('supplier.dashboard') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition">
                    Cancel
                </a>
                <button type="submit" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white rounded-lg font-medium transition">
                    Save Changes
                </button>
            </div>
        </form>
    </div>
</x-layouts.app>
