<x-layouts.app title="Supplier Directory">
    <div class="bg-gray-900 text-white py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <h1 class="text-3xl font-bold mb-2">Supplier Directory</h1>
            <p class="text-gray-300">Find trusted suppliers, wholesalers, and service providers for your pharmacy.</p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <!-- Search & Filters -->
        <form method="GET" class="bg-white rounded-xl p-4 shadow-sm border border-gray-100 mb-8">
            <div class="flex flex-wrap gap-4">
                <div class="flex-1 min-w-[200px]">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search suppliers..." class="w-full rounded-lg border-gray-300">
                </div>
                <select name="category" class="rounded-lg border-gray-300">
                    <option value="">All Categories</option>
                    @foreach(\App\Enums\SupplierCategory::cases() as $category)
                        <option value="{{ $category->value }}" {{ request('category') === $category->value ? 'selected' : '' }}>{{ $category->label() }}</option>
                    @endforeach
                </select>
                <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-6 py-2 rounded-lg font-medium">Search</button>
            </div>
        </form>

        <!-- Suppliers Grid -->
        @if($suppliers->count() > 0)
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($suppliers as $supplier)
                    <a href="{{ route('suppliers.show', $supplier->slug) }}" class="bg-white rounded-xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition group">
                        <div class="flex items-start gap-4">
                            <div class="w-14 h-14 bg-gray-100 rounded-lg flex-shrink-0 flex items-center justify-center overflow-hidden">
                                @if($supplier->logo)
                                    <img src="{{ $supplier->logo }}" alt="{{ $supplier->name }}" class="w-full h-full object-contain">
                                @else
                                    <span class="text-xl font-bold text-gray-400">{{ substr($supplier->name, 0, 1) }}</span>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-semibold text-gray-900 group-hover:text-green-600 transition line-clamp-1">{{ $supplier->name }}</h3>
                                <p class="text-sm text-green-600">{{ $supplier->category->label() }}</p>
                                <p class="text-gray-500 text-sm mt-1 line-clamp-2">{{ $supplier->short_description }}</p>
                            </div>
                        </div>
                    </a>
                @endforeach
            </div>
            <div class="mt-8">{{ $suppliers->links() }}</div>
        @else
            <div class="bg-gray-50 rounded-xl p-12 text-center">
                <p class="text-gray-500">No suppliers found.</p>
            </div>
        @endif
    </div>
</x-layouts.app>
