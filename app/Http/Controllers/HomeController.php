<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\PropertyListing;
use App\Models\Course;
use Illuminate\View\View;

class HomeController extends Controller
{
    /**
     * Public landing page (before login wall)
     */
    public function landing(): View
    {
        return view('pages.landing');
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
