<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Course;
use App\Models\PropertyListing;
use App\Models\Resource;
use App\Models\Supplier;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Public landing page (before login wall)
     */
    public function landing(): View
    {
        $featuredArticle = Article::published()
            ->featured()
            ->with('author')
            ->latest('published_at')
            ->first()
            ?? Article::published()->with('author')->latest('published_at')->first();

        $latestArticles = Article::published()
            ->with('author')
            ->when($featuredArticle, fn ($q) => $q->where('id', '!=', $featuredArticle->id))
            ->latest('published_at')
            ->limit(4)
            ->get();

        $featuredListings = PropertyListing::active()
            ->featured()
            ->latest('published_at')
            ->limit(4)
            ->get();

        if ($featuredListings->count() < 4) {
            $featuredListings = PropertyListing::active()
                ->orderByDesc('featured')
                ->latest('published_at')
                ->limit(4)
                ->get();
        }

        $featuredCourses = Course::published()
            ->orderByDesc('enrolments_count')
            ->limit(3)
            ->get();

        $directorySuppliers = Supplier::active()
            ->orderByTier()
            ->limit(4)
            ->get();

        $totalSuppliers = Supplier::active()->count();

        $featuredResources = Resource::published()
            ->orderByDesc('download_count')
            ->limit(4)
            ->get();

        return view('pages.landing', compact(
            'featuredArticle',
            'latestArticles',
            'featuredListings',
            'featuredCourses',
            'directorySuppliers',
            'totalSuppliers',
            'featuredResources'
        ));
    }

    /**
     * Authenticated home page (after login).
     *
     * Renders the same newspaper-style layout as the public landing page
     * so /home and / look identical. The landing Blade already handles
     * both auth and guest states in its inline header.
     */
    public function home(): View
    {
        return $this->landing();
    }
}
