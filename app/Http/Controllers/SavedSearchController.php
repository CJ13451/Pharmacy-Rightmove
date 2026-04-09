<?php

namespace App\Http\Controllers;

use App\Models\SavedSearch;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SavedSearchController extends Controller
{
    public function index(): View
    {
        $savedSearches = SavedSearch::where('user_id', auth()->id())
            ->latest()
            ->paginate(10);

        return view('pages.saved-searches.index', compact('savedSearches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'filters' => ['required', 'array'],
            'email_alerts' => ['boolean'],
            'alert_frequency' => ['in:instant,daily,weekly'],
        ]);

        SavedSearch::create([
            'user_id' => auth()->id(),
            'name' => $validated['name'],
            'filters' => $validated['filters'],
            'email_alerts' => $validated['email_alerts'] ?? true,
            'alert_frequency' => $validated['alert_frequency'] ?? 'daily',
        ]);

        return back()->with('success', 'Search saved successfully.');
    }

    public function toggleAlerts(string $id)
    {
        $savedSearch = SavedSearch::where('user_id', auth()->id())
            ->where('id', $id)
            ->firstOrFail();

        $newValue = !$savedSearch->email_alerts;
        $savedSearch->update(['email_alerts' => $newValue]);

        return back()->with('success', $newValue ? 'Email alerts enabled.' : 'Email alerts disabled.');
    }

    public function destroy(string $id)
    {
        $savedSearch = SavedSearch::where('user_id', auth()->id())
            ->where('id', $id)
            ->firstOrFail();

        $savedSearch->delete();

        return back()->with('success', 'Saved search deleted.');
    }
}
