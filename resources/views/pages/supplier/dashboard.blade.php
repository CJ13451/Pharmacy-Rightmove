<x-layouts.app title="Supplier Dashboard">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex items-center justify-between mb-8">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Supplier Dashboard</h1>
                <p class="text-gray-500 mt-1">{{ $supplier->name }}</p>
            </div>
            <a href="{{ route('suppliers.show', $supplier->slug) }}" target="_blank" class="text-green-600 hover:text-green-700 font-medium flex items-center gap-1">
                View Public Profile
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
            </a>
        </div>

        <!-- Status Banner -->
        @if($supplier->status === 'pending')
            <div class="bg-amber-50 border border-amber-200 rounded-xl p-4 mb-8 flex items-center gap-4">
                <div class="w-10 h-10 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p class="font-semibold text-amber-800">Profile Under Review</p>
                    <p class="text-sm text-amber-700">Your listing is being reviewed and will be live within 24 hours.</p>
                </div>
            </div>
        @endif

        <!-- Stats Overview -->
        <div class="grid md:grid-cols-4 gap-6 mb-8">
            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-blue-100 text-blue-600 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Profile Views</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($supplier->views_count) }}</p>
                    </div>
                </div>
                @if($viewsChange !== null)
                    <p class="mt-3 text-sm {{ $viewsChange >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $viewsChange >= 0 ? '+' : '' }}{{ $viewsChange }}% vs last month
                    </p>
                @endif
            </div>

            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-green-100 text-green-600 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Website Clicks</p>
                        <p class="text-2xl font-bold text-gray-900">{{ number_format($supplier->clicks_count) }}</p>
                    </div>
                </div>
                @if($clicksChange !== null)
                    <p class="mt-3 text-sm {{ $clicksChange >= 0 ? 'text-green-600' : 'text-red-600' }}">
                        {{ $clicksChange >= 0 ? '+' : '' }}{{ $clicksChange }}% vs last month
                    </p>
                @endif
            </div>

            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Resources</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $supplier->resources->count() }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 rounded-lg flex items-center justify-center
                        {{ $supplier->tier->value === 'featured' ? 'bg-amber-100 text-amber-600' : '' }}
                        {{ $supplier->tier->value === 'premium' ? 'bg-purple-100 text-purple-600' : '' }}
                        {{ $supplier->tier->value === 'free' ? 'bg-gray-100 text-gray-600' : '' }}">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-gray-500">Current Plan</p>
                        <p class="text-2xl font-bold text-gray-900">{{ $supplier->tier->label() }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Quick Actions -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <h2 class="font-bold text-gray-900 mb-4">Quick Actions</h2>
                    <div class="grid md:grid-cols-3 gap-4">
                        <a href="{{ route('supplier.profile') }}" class="flex items-center gap-3 p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                            <div class="w-10 h-10 bg-green-100 text-green-600 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Edit Profile</p>
                                <p class="text-xs text-gray-500">Update your listing</p>
                            </div>
                        </a>
                        <a href="{{ route('supplier.resources') }}" class="flex items-center gap-3 p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                            <div class="w-10 h-10 bg-purple-100 text-purple-600 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Manage Resources</p>
                                <p class="text-xs text-gray-500">Add downloads</p>
                            </div>
                        </a>
                        <a href="{{ route('supplier.subscription') }}" class="flex items-center gap-3 p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition">
                            <div class="w-10 h-10 bg-amber-100 text-amber-600 rounded-lg flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="font-medium text-gray-900">Subscription</p>
                                <p class="text-xs text-gray-500">Manage plan</p>
                            </div>
                        </a>
                    </div>
                </div>

                <!-- Profile Completeness -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="font-bold text-gray-900">Profile Completeness</h2>
                        <span class="text-sm font-medium text-green-600">{{ $profileCompleteness }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-2 mb-4">
                        <div class="bg-green-600 h-2 rounded-full transition-all" style="width: {{ $profileCompleteness }}%"></div>
                    </div>
                    @if($profileCompleteness < 100)
                        <div class="space-y-2">
                            @foreach($missingFields as $field)
                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                    <svg class="w-4 h-4 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                    </svg>
                                    Add {{ $field }}
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-green-600 flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            Your profile is complete!
                        </p>
                    @endif
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-6">
                <!-- Subscription Status -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-900 mb-4">Subscription</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between text-sm">
                            <span class="text-gray-500">Plan</span>
                            <span class="font-medium text-gray-900">{{ $supplier->tier->label() }}</span>
                        </div>
                        @if($supplier->subscription_status === 'active')
                            <div class="flex justify-between text-sm">
                                <span class="text-gray-500">Status</span>
                                <span class="text-green-600 font-medium">Active</span>
                            </div>
                            @if($supplier->subscription_expires_at)
                                <div class="flex justify-between text-sm">
                                    <span class="text-gray-500">Renews</span>
                                    <span class="text-gray-900">{{ $supplier->subscription_expires_at->format('d M Y') }}</span>
                                </div>
                            @endif
                        @endif
                    </div>

                    @if($supplier->tier->value === 'free')
                        <a href="{{ route('supplier.subscription') }}" class="mt-4 block w-full text-center bg-green-600 hover:bg-green-700 text-white py-2 rounded-lg font-medium transition">
                            Upgrade Now
                        </a>
                    @else
                        <a href="{{ route('supplier.subscription') }}" class="mt-4 block w-full text-center border border-gray-300 text-gray-700 hover:bg-gray-50 py-2 rounded-lg font-medium transition">
                            Manage Subscription
                        </a>
                    @endif
                </div>

                <!-- Recent Activity -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100">
                    <h3 class="font-bold text-gray-900 mb-4">Tips to Improve</h3>
                    <ul class="space-y-3 text-sm">
                        @if($supplier->tier->value === 'free')
                            <li class="flex items-start gap-2 text-gray-600">
                                <svg class="w-4 h-4 text-amber-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                                </svg>
                                Upgrade to add your logo and photos
                            </li>
                        @endif
                        @if(!$supplier->long_description)
                            <li class="flex items-start gap-2 text-gray-600">
                                <svg class="w-4 h-4 text-blue-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                </svg>
                                Add a detailed company description
                            </li>
                        @endif
                        @if($supplier->resources->count() === 0)
                            <li class="flex items-start gap-2 text-gray-600">
                                <svg class="w-4 h-4 text-purple-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m-3-3v6m5 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Upload resources for better engagement
                            </li>
                        @endif
                        <li class="flex items-start gap-2 text-gray-600">
                            <svg class="w-4 h-4 text-green-500 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"/>
                            </svg>
                            Share your profile on social media
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
