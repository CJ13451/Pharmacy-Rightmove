<?php

namespace App\Http\Controllers;

use App\Models\Enrolment;
use App\Models\SavedListing;
use App\Models\SavedSearch;
use Illuminate\Http\Request;
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

        $validated = $request->validate([
            'first_name' => ['required', 'string', 'max:50'],
            'last_name' => ['required', 'string', 'max:50'],
            'current_workplace' => ['nullable', 'string', 'max:255'],
            'newsletter_subscribed' => ['boolean'],
        ]);

        $user->update($validated);

        return back()->with('success', 'Account settings updated.');
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
