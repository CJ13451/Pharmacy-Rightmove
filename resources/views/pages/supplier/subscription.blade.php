<x-layouts.app title="Subscription">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        <div class="flex items-center gap-4 mb-8">
            <a href="{{ route('supplier.dashboard') }}" class="text-gray-500 hover:text-gray-700">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
            </a>
            <h1 class="text-2xl font-bold text-gray-900">Subscription</h1>
        </div>

        @if(session('success'))
            <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg mb-6">
                {{ session('success') }}
            </div>
        @endif

        <!-- Current Plan -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6 mb-8">
            <h2 class="font-bold text-gray-900 mb-4">Current Plan</h2>
            <div class="flex items-center justify-between">
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
                        <p class="font-bold text-gray-900 text-lg">{{ $supplier->tier->label() }}</p>
                        @if($supplier->subscription_status === 'active' && $supplier->subscription_expires_at)
                            <p class="text-sm text-gray-500">Renews {{ $supplier->subscription_expires_at->format('d M Y') }}</p>
                        @elseif($supplier->subscription_status === 'cancelled')
                            <p class="text-sm text-red-500">Cancelled - expires {{ $supplier->subscription_expires_at?->format('d M Y') }}</p>
                        @elseif($supplier->tier->value === 'free')
                            <p class="text-sm text-gray-500">Free forever</p>
                        @endif
                    </div>
                </div>
                @if($supplier->tier->value !== 'free' && $supplier->subscription_status === 'active')
                    <form method="POST" action="{{ route('supplier.subscription.cancel') }}" onsubmit="return confirm('Are you sure you want to cancel? Your listing will remain active until the end of your billing period.')">
                        @csrf
                        <button type="submit" class="text-red-600 hover:text-red-700 text-sm font-medium">
                            Cancel Subscription
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- Plans -->
        <h2 class="font-bold text-gray-900 mb-6">{{ $supplier->tier->value === 'free' ? 'Upgrade Your Plan' : 'Change Plan' }}</h2>

        <div class="grid md:grid-cols-3 gap-6" x-data="{ billing: 'monthly' }">
            <!-- Billing Toggle -->
            <div class="md:col-span-3 flex justify-center mb-4">
                <div class="bg-gray-100 rounded-lg p-1 inline-flex">
                    <button 
                        type="button"
                        @click="billing = 'monthly'"
                        :class="billing === 'monthly' ? 'bg-white shadow' : ''"
                        class="px-4 py-2 rounded-md text-sm font-medium transition"
                    >
                        Monthly
                    </button>
                    <button 
                        type="button"
                        @click="billing = 'annual'"
                        :class="billing === 'annual' ? 'bg-white shadow' : ''"
                        class="px-4 py-2 rounded-md text-sm font-medium transition"
                    >
                        Annual <span class="text-green-600 text-xs">Save 17%</span>
                    </button>
                </div>
            </div>

            <!-- Free Plan -->
            <div class="bg-white rounded-xl border {{ $supplier->tier->value === 'free' ? 'border-green-500 ring-1 ring-green-500' : 'border-gray-200' }} p-6">
                <h3 class="font-bold text-gray-900 mb-2">Free</h3>
                <div class="mb-4">
                    <span class="text-3xl font-bold">£0</span>
                </div>
                <ul class="space-y-3 mb-6 text-sm">
                    <li class="flex items-center gap-2 text-gray-600">
                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Basic company profile
                    </li>
                    <li class="flex items-center gap-2 text-gray-600">
                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Contact information
                    </li>
                    <li class="flex items-center gap-2 text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        No logo or photos
                    </li>
                    <li class="flex items-center gap-2 text-gray-400">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                        </svg>
                        No analytics
                    </li>
                </ul>
                @if($supplier->tier->value === 'free')
                    <span class="block w-full text-center bg-gray-100 text-gray-500 py-2 rounded-lg font-medium">Current Plan</span>
                @endif
            </div>

            <!-- Premium Plan -->
            <div class="bg-white rounded-xl border-2 {{ $supplier->tier->value === 'premium' ? 'border-green-500' : 'border-purple-500' }} p-6 relative">
                <div class="absolute -top-3 left-1/2 -translate-x-1/2">
                    <span class="bg-purple-500 text-white text-xs font-bold px-3 py-1 rounded-full">POPULAR</span>
                </div>
                <h3 class="font-bold text-gray-900 mb-2">Premium</h3>
                <div class="mb-4">
                    <span class="text-3xl font-bold" x-text="billing === 'monthly' ? '£99' : '£82'"></span>
                    <span class="text-gray-500">/mo</span>
                    <p class="text-xs text-gray-500" x-show="billing === 'annual'">Billed annually (£990)</p>
                </div>
                <ul class="space-y-3 mb-6 text-sm">
                    <li class="flex items-center gap-2 text-gray-600">
                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Full company profile
                    </li>
                    <li class="flex items-center gap-2 text-gray-600">
                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Logo + 5 photos
                    </li>
                    <li class="flex items-center gap-2 text-gray-600">
                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Downloadable resources
                    </li>
                    <li class="flex items-center gap-2 text-gray-600">
                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Full analytics
                    </li>
                </ul>
                @if($supplier->tier->value === 'premium')
                    <span class="block w-full text-center bg-purple-100 text-purple-700 py-2 rounded-lg font-medium">Current Plan</span>
                @else
                    <form method="POST" action="{{ route('supplier.subscription.checkout') }}">
                        @csrf
                        <input type="hidden" name="tier" x-bind:value="billing === 'monthly' ? 'premium' : 'premium_annual'">
                        <button type="submit" class="w-full bg-purple-600 hover:bg-purple-700 text-white py-2 rounded-lg font-medium transition">
                            {{ $supplier->tier->value === 'free' ? 'Upgrade' : 'Switch Plan' }}
                        </button>
                    </form>
                @endif
            </div>

            <!-- Featured Plan -->
            <div class="bg-white rounded-xl border {{ $supplier->tier->value === 'featured' ? 'border-green-500 ring-1 ring-green-500' : 'border-gray-200' }} p-6">
                <h3 class="font-bold text-gray-900 mb-2">Featured</h3>
                <div class="mb-4">
                    <span class="text-3xl font-bold" x-text="billing === 'monthly' ? '£199' : '£166'"></span>
                    <span class="text-gray-500">/mo</span>
                    <p class="text-xs text-gray-500" x-show="billing === 'annual'">Billed annually (£1,990)</p>
                </div>
                <ul class="space-y-3 mb-6 text-sm">
                    <li class="flex items-center gap-2 text-gray-600">
                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Everything in Premium
                    </li>
                    <li class="flex items-center gap-2 text-gray-600">
                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Homepage featured
                    </li>
                    <li class="flex items-center gap-2 text-gray-600">
                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        10 photos
                    </li>
                    <li class="flex items-center gap-2 text-gray-600">
                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Newsletter feature
                    </li>
                </ul>
                @if($supplier->tier->value === 'featured')
                    <span class="block w-full text-center bg-amber-100 text-amber-700 py-2 rounded-lg font-medium">Current Plan</span>
                @else
                    <form method="POST" action="{{ route('supplier.subscription.checkout') }}">
                        @csrf
                        <input type="hidden" name="tier" x-bind:value="billing === 'monthly' ? 'featured' : 'featured_annual'">
                        <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-white py-2 rounded-lg font-medium transition">
                            {{ $supplier->tier->value === 'free' ? 'Upgrade' : 'Switch Plan' }}
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <!-- FAQ -->
        <div class="mt-12">
            <h2 class="font-bold text-gray-900 mb-6">Frequently Asked Questions</h2>
            <div class="space-y-4">
                <details class="bg-white rounded-xl border border-gray-200 p-4 group">
                    <summary class="font-medium text-gray-900 cursor-pointer list-none flex items-center justify-between">
                        Can I cancel anytime?
                        <svg class="w-5 h-5 text-gray-400 group-open:rotate-180 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </summary>
                    <p class="mt-3 text-gray-600 text-sm">Yes, you can cancel your subscription at any time. Your listing will remain active until the end of your current billing period.</p>
                </details>
                <details class="bg-white rounded-xl border border-gray-200 p-4 group">
                    <summary class="font-medium text-gray-900 cursor-pointer list-none flex items-center justify-between">
                        What happens if I downgrade?
                        <svg class="w-5 h-5 text-gray-400 group-open:rotate-180 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                        </svg>
                    </summary>
                    <p class="mt-3 text-gray-600 text-sm">If you downgrade, your premium features will remain active until the end of your billing period. After that, your listing will be updated to reflect your new plan's features.</p>
                </details>
            </div>
        </div>
    </div>
</x-layouts.app>
