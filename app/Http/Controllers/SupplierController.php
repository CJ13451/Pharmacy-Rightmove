<?php

namespace App\Http\Controllers;

use App\Enums\SupplierCategory;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SupplierController extends Controller
{
    public function index(Request $request): View
    {
        $query = Supplier::active()->orderByTier();

        // Filter by category
        if ($request->filled('category')) {
            $category = SupplierCategory::tryFrom($request->category);
            if ($category) {
                $query->inCategory($category);
            }
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('short_description', 'like', "%{$search}%");
            });
        }

        $suppliers = $query->paginate(24)->withQueryString();

        $featuredSuppliers = Supplier::active()
            ->featured()
            ->limit(6)
            ->get();

        $categories = SupplierCategory::cases();

        return view('pages.suppliers.index', compact(
            'suppliers',
            'featuredSuppliers',
            'categories'
        ));
    }

    public function show(string $slug): View
    {
        $supplier = Supplier::active()
            ->where('slug', $slug)
            ->with('resources')
            ->firstOrFail();

        // Increment views
        $supplier->incrementViews();

        // Similar suppliers (same category)
        $similarSuppliers = Supplier::active()
            ->where('id', '!=', $supplier->id)
            ->inCategory($supplier->category)
            ->orderByTier()
            ->limit(4)
            ->get();

        return view('pages.suppliers.show', compact('supplier', 'similarSuppliers'));
    }

    public function join(): View
    {
        return view('pages.suppliers.join');
    }

    public function trackClick(string $slug)
    {
        $supplier = Supplier::active()
            ->where('slug', $slug)
            ->firstOrFail();

        $supplier->incrementClicks();

        return response()->json(['success' => true]);
    }
}
