<x-layouts.app title="Edit Supplier Profile">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-8">Edit Profile</h1>

    <div class="max-w-4xl mx-auto">
    @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-200 text-green-700 rounded-lg">{{ session('success') }}</div>
    @endif

    <form action="{{ route('supplier.profile.update') }}" method="POST" enctype="multipart/form-data" class="space-y-8">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Basic Information</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Business Name</label>
                    <input type="text" name="name" id="name" value="{{ old('name', $supplier->name) }}" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                    @error('name') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                    <select name="category" id="category" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                        @foreach($categories as $value => $label)
                            <option value="{{ $value }}" {{ old('category', $supplier->category->value) === $value ? 'selected' : '' }}>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('category') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div class="md:col-span-2">
                    <label for="short_description" class="block text-sm font-medium text-gray-700 mb-1">Short Description</label>
                    <textarea name="short_description" id="short_description" rows="3" required maxlength="{{ $supplier->tier->maxDescriptionLength() }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">{{ old('short_description', $supplier->short_description) }}</textarea>
                    @error('short_description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-1">Contact Email</label>
                    <input type="email" name="contact_email" id="contact_email" value="{{ old('contact_email', $supplier->contact_email) }}" required class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                    @error('contact_email') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label for="website" class="block text-sm font-medium text-gray-700 mb-1">Website</label>
                    <input type="url" name="website" id="website" value="{{ old('website', $supplier->website) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                    @error('website') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>

        @if($supplier->is_premium)
        <div class="bg-white rounded-lg shadow-md p-6">
            <h2 class="text-xl font-semibold text-gray-900 mb-4">Premium Details</h2>
            <div class="space-y-6">
                <div>
                    <label for="long_description" class="block text-sm font-medium text-gray-700 mb-1">Full Description</label>
                    <textarea name="long_description" id="long_description" rows="6" maxlength="{{ $supplier->tier->maxDescriptionLength() }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">{{ old('long_description', $supplier->long_description) }}</textarea>
                    @error('long_description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="contact_name" class="block text-sm font-medium text-gray-700 mb-1">Contact Name</label>
                        <input type="text" name="contact_name" id="contact_name" value="{{ old('contact_name', $supplier->contact_name) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                    </div>
                    <div>
                        <label for="contact_phone" class="block text-sm font-medium text-gray-700 mb-1">Contact Phone</label>
                        <input type="text" name="contact_phone" id="contact_phone" value="{{ old('contact_phone', $supplier->contact_phone) }}" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">
                    </div>
                </div>
                <div>
                    <label for="address" class="block text-sm font-medium text-gray-700 mb-1">Address</label>
                    <textarea name="address" id="address" rows="3" class="w-full rounded-lg border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500">{{ old('address', $supplier->address) }}</textarea>
                </div>
                <div>
                    <label for="logo" class="block text-sm font-medium text-gray-700 mb-1">Logo</label>
                    @if($supplier->logo)
                        <img src="{{ $supplier->logo }}" alt="Current logo" class="w-24 h-24 object-contain mb-2 rounded">
                    @endif
                    <input type="file" name="logo" id="logo" accept="image/*" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                    @error('logo') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>
        @endif

        <div class="flex justify-end">
            <button type="submit" class="px-6 py-3 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700">Save Changes</button>
        </div>
    </form>
    </div>
</div>
</x-layouts.app>
