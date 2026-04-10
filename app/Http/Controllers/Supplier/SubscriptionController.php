<?php

namespace App\Http\Controllers\Supplier;

use App\Enums\SupplierTier;
use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubscriptionController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $supplier = Supplier::where('user_id', $user->id)->first();

        if (! $supplier) {
            return redirect()->route('supplier.dashboard');
        }

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
        $supplier = Supplier::where('user_id', $user->id)->first();

        if (! $supplier) {
            return redirect()->route('supplier.dashboard');
        }

        $tier = SupplierTier::from($validated['tier']);

        // TODO: Create Stripe checkout session for $tier and redirect
        // to the session URL. Until that's wired up, land the user back
        // on the subscription page with a note so they don't hit a 404.
        return redirect()
            ->route('supplier.subscription.index')
            ->with('info', "Upgrade to the {$tier->label()} plan is not yet self-serve. Please contact hello@pharmacyowner.co.uk and our team will activate it for you.");
    }

    public function success()
    {
        $user = auth()->user();
        $supplier = Supplier::where('user_id', $user->id)->first();

        if (! $supplier) {
            return redirect()->route('supplier.dashboard');
        }

        return view('pages.supplier.subscription.index', [
            'supplier' => $supplier,
            'tiers' => [
                ['tier' => SupplierTier::FREE, 'price' => 0, 'features' => SupplierTier::FREE->features()],
                ['tier' => SupplierTier::PREMIUM, 'price' => 4900, 'features' => SupplierTier::PREMIUM->features()],
                ['tier' => SupplierTier::FEATURED, 'price' => 14900, 'features' => SupplierTier::FEATURED->features()],
            ],
            'subscriptionSuccess' => true,
        ]);
    }

    public function cancel()
    {
        $user = auth()->user();
        $supplier = Supplier::where('user_id', $user->id)->first();

        if (! $supplier) {
            return redirect()->route('supplier.dashboard');
        }

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
