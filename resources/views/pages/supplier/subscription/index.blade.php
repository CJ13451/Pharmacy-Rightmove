<x-layouts.app title="Subscription Plans">
<div class="max-w-5xl mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-900 mb-2">Subscription Plans</h1>
    <p class="text-gray-600 mb-8">Choose the plan that best fits your business needs.</p>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($tiers as $plan)
            <div class="bg-white rounded-lg shadow-md p-6 {{ $supplier->tier === $plan['tier'] ? 'ring-2 ring-green-500' : '' }}">
                <h2 class="text-xl font-bold text-gray-900 mb-1">{{ $plan['tier']->label() }}</h2>
                <div class="mb-4">
                    @if($plan['price'] === 0)
                        <span class="text-3xl font-bold text-gray-900">Free</span>
                    @else
                        <span class="text-3xl font-bold text-gray-900">&pound;{{ number_format($plan['price'] / 100, 2) }}</span>
                        <span class="text-gray-500">/month</span>
                    @endif
                </div>
                <ul class="space-y-2 mb-6">
                    @foreach($plan['features'] as $feature)
                        <li class="flex items-start gap-2 text-sm text-gray-600">
                            <svg class="w-5 h-5 text-green-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                            {{ $feature }}
                        </li>
                    @endforeach
                </ul>
                @if($supplier->tier === $plan['tier'])
                    <span class="block w-full text-center px-4 py-2 bg-gray-100 text-gray-600 font-semibold rounded-lg">Current Plan</span>
                @elseif($plan['price'] === 0)
                    @if($supplier->tier !== $plan['tier'])
                        <form action="{{ route('supplier.subscription.cancel') }}" method="POST">
                            @csrf
                            <button type="submit" class="w-full px-4 py-2 border border-red-300 text-red-600 font-semibold rounded-lg hover:bg-red-50" onclick="return confirm('Are you sure you want to downgrade to Free?')">Downgrade</button>
                        </form>
                    @endif
                @else
                    <form action="{{ route('supplier.subscription.upgrade') }}" method="POST">
                        @csrf
                        <input type="hidden" name="tier" value="{{ $plan['tier']->value }}">
                        <button type="submit" class="w-full px-4 py-2 bg-green-600 text-white font-semibold rounded-lg hover:bg-green-700">Upgrade</button>
                    </form>
                @endif
            </div>
        @endforeach
    </div>
</div>
</x-layouts.app>
