<?php

namespace App\Http\Controllers\Agent;

use App\Enums\ListingStatus;
use App\Enums\Region;
use App\Http\Controllers\Controller;
use App\Models\PropertyListing;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ListingController extends Controller
{
    public function index(Request $request): View
    {
        $query = PropertyListing::forUser(auth()->user());

        // Filter by status
        if ($request->filled('status')) {
            $status = ListingStatus::tryFrom($request->status);
            if ($status) {
                $query->where('status', $status);
            }
        }

        $listings = $query->latest()->paginate(10);

        return view('pages.agent.listings.index', compact('listings'));
    }

    public function create(): View
    {
        return view('pages.agent.listings.create', [
            'regions' => Region::options(),
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'price_qualifier' => ['required', 'in:asking,guide,offers_over,poa'],
            'address_line_1' => ['required', 'string', 'max:200'],
            'address_line_2' => ['nullable', 'string', 'max:200'],
            'town' => ['required', 'string', 'max:100'],
            'county' => ['nullable', 'string', 'max:100'],
            'postcode' => ['required', 'string', 'max:10'],
            'region' => ['required', 'string'],
            'property_type' => ['required', 'in:freehold,leasehold,both'],
            'lease_years_remaining' => ['nullable', 'integer', 'min:0'],
            'rent_per_annum' => ['nullable', 'numeric', 'min:0'],
            'monthly_items' => ['nullable', 'integer', 'min:0'],
            'annual_turnover' => ['nullable', 'numeric', 'min:0'],
            'annual_gross_profit' => ['nullable', 'numeric', 'min:0'],
            'staff_count' => ['nullable', 'integer', 'min:0'],
            'nhs_contract' => ['boolean'],
            'has_accommodation' => ['boolean'],
            'accommodation_details' => ['nullable', 'string'],
            'services' => ['nullable', 'array'],
            'agent_name' => ['required', 'string', 'max:100'],
            'agent_company' => ['nullable', 'string', 'max:200'],
            'agent_email' => ['required', 'email'],
            'agent_phone' => ['required', 'string', 'max:20'],
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:5120'],
        ]);

        $user = auth()->user();

        // Convert prices to pence
        $validated['price'] = (int) ($validated['price'] * 100);
        if (isset($validated['rent_per_annum'])) {
            $validated['rent_per_annum'] = (int) ($validated['rent_per_annum'] * 100);
        }
        if (isset($validated['annual_turnover'])) {
            $validated['annual_turnover'] = (int) ($validated['annual_turnover'] * 100);
        }
        if (isset($validated['annual_gross_profit'])) {
            $validated['annual_gross_profit'] = (int) ($validated['annual_gross_profit'] * 100);
        }

        $validated['user_id'] = $user->id;
        $validated['status'] = ListingStatus::DRAFT;

        // TODO: Handle image uploads
        unset($validated['images']);

        $listing = PropertyListing::create($validated);

        // TODO: Redirect to payment flow
        return redirect()->route('agent.listings.edit', $listing->id)
            ->with('success', 'Listing created as draft. Complete payment to publish.');
    }

    public function edit(string $id): View
    {
        $listing = PropertyListing::forUser(auth()->user())
            ->findOrFail($id);

        return view('pages.agent.listings.edit', [
            'listing' => $listing,
            'regions' => Region::options(),
        ]);
    }

    public function update(Request $request, string $id)
    {
        $listing = PropertyListing::forUser(auth()->user())
            ->findOrFail($id);

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'price_qualifier' => ['required', 'in:asking,guide,offers_over,poa'],
            'address_line_1' => ['required', 'string', 'max:200'],
            'address_line_2' => ['nullable', 'string', 'max:200'],
            'town' => ['required', 'string', 'max:100'],
            'county' => ['nullable', 'string', 'max:100'],
            'postcode' => ['required', 'string', 'max:10'],
            'region' => ['required', 'string'],
            'property_type' => ['required', 'in:freehold,leasehold,both'],
            'monthly_items' => ['nullable', 'integer', 'min:0'],
            'annual_turnover' => ['nullable', 'numeric', 'min:0'],
            'agent_name' => ['required', 'string', 'max:100'],
            'agent_company' => ['nullable', 'string', 'max:200'],
            'agent_email' => ['required', 'email'],
            'agent_phone' => ['required', 'string', 'max:20'],
        ]);

        // Convert prices to pence
        $validated['price'] = (int) ($validated['price'] * 100);
        if (isset($validated['annual_turnover'])) {
            $validated['annual_turnover'] = (int) ($validated['annual_turnover'] * 100);
        }

        $listing->update($validated);

        return back()->with('success', 'Listing updated.');
    }

    public function destroy(string $id)
    {
        $listing = PropertyListing::forUser(auth()->user())
            ->findOrFail($id);

        $listing->delete();

        return redirect()->route('agent.listings.index')
            ->with('success', 'Listing deleted.');
    }

    public function analytics(string $id): View
    {
        $listing = PropertyListing::forUser(auth()->user())
            ->withCount('enquiries')
            ->findOrFail($id);

        // Views over time
        $viewsByDay = $listing->views()
            ->selectRaw('DATE(viewed_at) as date, COUNT(*) as count')
            ->where('viewed_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->pluck('count', 'date')
            ->toArray();

        // Enquiries by status
        $enquiriesByStatus = $listing->enquiries()
            ->selectRaw('status, COUNT(*) as count')
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();

        return view('pages.agent.listings.analytics', compact(
            'listing',
            'viewsByDay',
            'enquiriesByStatus'
        ));
    }
}
