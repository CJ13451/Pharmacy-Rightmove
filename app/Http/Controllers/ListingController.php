<?php

namespace App\Http\Controllers;

use App\Enums\Region;
use App\Models\Enquiry;
use App\Models\PropertyListing;
use App\Models\SavedListing;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ListingController extends Controller
{
    public function index(Request $request): View
    {
        $query = PropertyListing::active()->with('user');

        // Location search
        if ($request->filled('location')) {
            $location = $request->location;
            $query->where(function ($q) use ($location) {
                $q->where('town', 'like', "%{$location}%")
                  ->orWhere('postcode', 'like', "%{$location}%")
                  ->orWhere('county', 'like', "%{$location}%");
            });
        }

        // Region filter
        if ($request->filled('region')) {
            $region = Region::tryFrom($request->region);
            if ($region) {
                $query->inRegion($region);
            }
        }

        // Price range
        if ($request->filled('min_price')) {
            $query->where('price', '>=', (int) $request->min_price * 100);
        }
        if ($request->filled('max_price')) {
            $query->where('price', '<=', (int) $request->max_price * 100);
        }

        // Property type
        if ($request->filled('property_type')) {
            $query->propertyType($request->property_type);
        }

        // Monthly items
        if ($request->filled('min_items')) {
            $query->where('monthly_items', '>=', (int) $request->min_items);
        }

        // Sorting
        $sort = $request->get('sort', 'newest');
        $query = match($sort) {
            'price_asc' => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            'items_desc' => $query->orderBy('monthly_items', 'desc'),
            default => $query->latest('published_at'),
        };

        // Featured first
        $query->orderBy('featured', 'desc');

        $listings = $query->paginate(12)->withQueryString();

        $featuredListings = PropertyListing::active()
            ->featured()
            ->limit(3)
            ->get();

        return view('pages.listings.index', compact('listings', 'featuredListings'));
    }

    public function show(string $slug): View
    {
        $listing = PropertyListing::where('slug', $slug)
            ->public()
            ->with('user')
            ->firstOrFail();

        // Increment views
        $listing->incrementViews(auth()->user());

        // Check if saved
        $isSaved = false;
        if (auth()->check()) {
            $isSaved = SavedListing::where('user_id', auth()->id())
                ->where('listing_id', $listing->id)
                ->exists();
        }

        // Similar listings
        $similarListings = PropertyListing::active()
            ->where('id', '!=', $listing->id)
            ->inRegion($listing->region)
            ->limit(3)
            ->get();

        return view('pages.listings.show', compact('listing', 'isSaved', 'similarListings'));
    }

    public function enquire(Request $request, string $slug)
    {
        $listing = PropertyListing::where('slug', $slug)
            ->public()
            ->firstOrFail();

        $validated = $request->validate([
            'message' => ['required', 'string', 'max:2000'],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $user = auth()->user();

        Enquiry::create([
            'listing_id' => $listing->id,
            'user_id' => $user->id,
            'name' => $user->full_name,
            'email' => $user->email,
            'phone' => $validated['phone'] ?? null,
            'message' => $validated['message'],
            'status' => 'new',
        ]);

        $listing->increment('enquiries_count');

        // TODO: Send email notification to agent

        return back()->with('success', 'Your enquiry has been sent to the agent.');
    }

    public function toggleSave(string $slug)
    {
        $listing = PropertyListing::where('slug', $slug)
            ->public()
            ->firstOrFail();

        $user = auth()->user();

        $existing = SavedListing::where('user_id', $user->id)
            ->where('listing_id', $listing->id)
            ->first();

        if ($existing) {
            $existing->delete();
            $listing->decrement('saves_count');
            $message = 'Listing removed from saved.';
        } else {
            SavedListing::create([
                'user_id' => $user->id,
                'listing_id' => $listing->id,
            ]);
            $listing->increment('saves_count');
            $message = 'Listing saved.';
        }

        if (request()->wantsJson()) {
            return response()->json(['message' => $message, 'saved' => !$existing]);
        }

        return back()->with('success', $message);
    }
}
