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
     * Authenticated home page (after login)
     */
    public function home(): View
    {
        $featuredListings = PropertyListing::active()
            ->featured()
            ->with('user')
            ->limit(3)
            ->get();

        $latestListings = PropertyListing::active()
            ->with('user')
            ->latest('published_at')
            ->limit(6)
            ->get();

        $latestArticles = Article::published()
            ->with('author')
            ->recent()
            ->limit(4)
            ->get();

        $featuredCourses = Course::published()
            ->limit(3)
            ->get();

        $stats = [
            'listings_count' => PropertyListing::active()->count(),
            'articles_count' => Article::published()->count(),
            'courses_count' => Course::published()->count(),
        ];

        return view('pages.home', compact(
            'featuredListings',
            'latestListings',
            'latestArticles',
            'featuredCourses',
            'stats'
        ));
    }
}
