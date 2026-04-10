<?php

namespace App\Http\Controllers;

use App\Enums\BuyTimeframe;
use App\Enums\JobTitle;
use App\Models\Enrolment;
use App\Models\SavedListing;
use App\Models\SavedSearch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        $savedListings = SavedListing::where('user_id', $user->id)
            ->with('listing')
            ->latest()
            ->limit(5)
            ->get();

        $savedSearches = SavedSearch::where('user_id', $user->id)
            ->latest()
            ->limit(5)
            ->get();

        $enrolments = Enrolment::where('user_id', $user->id)
            ->with('course')
            ->latest()
            ->limit(5)
            ->get();

        $inProgressCourses = Enrolment::where('user_id', $user->id)
            ->where('status', 'in_progress')
            ->with('course')
            ->get();

        return view('pages.dashboard', compact(
            'savedListings',
            'savedSearches',
            'enrolments',
            'inProgressCourses'
        ));
    }

    public function account(): View
    {
        return view('pages.account.settings', [
            'user' => auth()->user(),
        ]);
    }

    public function updateAccount(Request $request)
    {
        $user = auth()->user();

        $jobTitleValues = array_keys(JobTitle::options());
        $buyTimeframeValues = array_keys(BuyTimeframe::options());

        $validated = $request->validate([
            // Personal
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'job_title' => ['required', Rule::in($jobTitleValues)],
            'gphc_number' => ['nullable', 'string', 'max:20'],

            // Pharmacy context
            'currently_own_pharmacy' => ['nullable', 'boolean'],
            'number_of_pharmacies' => ['nullable', 'integer', 'min:1', 'max:500'],
            'current_workplace' => ['nullable', 'string', 'max:255'],

            // Buyer preferences
            'looking_to_buy' => ['nullable', 'boolean'],
            'buy_location_preference' => ['nullable', 'string', 'max:255'],
            'buy_timeframe' => ['nullable', Rule::in($buyTimeframeValues)],

            // Preferences
            'newsletter_subscribed' => ['nullable', 'boolean'],
        ]);

        // Normalise booleans - unchecked checkboxes don't appear in the
        // request body at all, so default them to false.
        $validated['currently_own_pharmacy'] = (bool) ($validated['currently_own_pharmacy'] ?? false);
        $validated['looking_to_buy'] = (bool) ($validated['looking_to_buy'] ?? false);
        $validated['newsletter_subscribed'] = (bool) ($validated['newsletter_subscribed'] ?? false);

        // GPhC number is only meaningful for roles that require it.
        $jobTitle = JobTitle::from($validated['job_title']);
        if (! $jobTitle->requiresGphc()) {
            $validated['gphc_number'] = null;
        }

        // If they say they're not a pharmacy owner, wipe the number of
        // pharmacies field so we don't keep stale data around.
        if (! $validated['currently_own_pharmacy']) {
            $validated['number_of_pharmacies'] = null;
        }

        // If they say they're not looking to buy, wipe the buyer
        // preference fields for the same reason.
        if (! $validated['looking_to_buy']) {
            $validated['buy_location_preference'] = null;
            $validated['buy_timeframe'] = null;
        }

        $user->update($validated);

        return back()->with('success', 'Account settings updated.');
    }

    public function updatePassword(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::defaults()],
        ], [
            'current_password.current_password' => 'The current password you entered is incorrect.',
        ]);

        $user->forceFill([
            'password' => Hash::make($validated['password']),
        ])->save();

        return back()->with('success', 'Password updated successfully.');
    }

    public function purchases(): View
    {
        $purchases = auth()->user()->coursePurchases()
            ->with('course')
            ->where('status', 'completed')
            ->latest('purchased_at')
            ->paginate(10);

        return view('pages.account.purchases', compact('purchases'));
    }
}
