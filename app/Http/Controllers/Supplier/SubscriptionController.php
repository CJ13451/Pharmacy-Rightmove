<?php

namespace App\Http\Controllers\Supplier;

use App\Enums\SupplierTier;
use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubscriptionController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        $supplier = Supplier::where('user_id', $user->id)->firstOrFail();

        $tiers = [
            [
                'tier' => SupplierTier::FREE,
                'price' => 0,
                'features' => SupplierTier::FREE->features(),
            ],
            [
                'tier' => SupplierTier::PREMIUM,
                'price' => 4900, // £49/month
                'features' => SupplierTier::PREMIUM->features(),
            ],
            [
                'tier' => SupplierTier::FEATURED,
                'price' => 14900, // £149/month
                'features' => SupplierTier::FEATURED->features(),
            ],
        ];

        return view('pages.supplier.subscription.index', compact('supplier', 'tiers'));
    }

    public function upgrade(Request $request)
    {
        $validated = $request->validate([
            'tier' => ['required', 'in:premium,featured'],
        ]);

        $user = auth()->user();
        $supplier = Supplier::where('user_id', $user->id)->firstOrFail();

        $tier = SupplierTier::from($validated['tier']);

        // TODO: Create Stripe checkout session
        // For now, redirect to a placeholder

        return redirect()->route('supplier.subscription.checkout', [
            'tier' => $tier->value,
        ]);
    }

    public function cancel()
    {
        $user = auth()->user();
        $supplier = Supplier::where('user_id', $user->id)->firstOrFail();

        if ($supplier->tier === SupplierTier::FREE) {
            return back()->with('error', 'No active subscription to cancel.');
        }

        // TODO: Cancel Stripe subscription

        $supplier->update([
            'subscription_status' => 'cancelled',
        ]);

        return back()->with('success', 'Subscription cancelled. Access continues until end of billing period.');
    }
}
