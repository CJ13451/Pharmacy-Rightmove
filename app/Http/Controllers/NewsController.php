<?php

namespace App\Http\Controllers;

use App\Enums\ArticleCategory;
use App\Enums\ArticleType;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\View\View;

class NewsController extends Controller
{
    public function index(Request $request): View
    {
        $query = Article::published()->with('author')->recent();

        // Filter by type
        if ($request->filled('type')) {
            $type = ArticleType::tryFrom($request->type);
            if ($type) {
                $query->ofType($type);
            }
        }

        // Filter by category
        if ($request->filled('category')) {
            $category = ArticleCategory::tryFrom($request->category);
            if ($category) {
                $query->inCategory($category);
            }
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        $articles = $query->paginate(12)->withQueryString();

        $featuredArticles = Article::published()
            ->featured()
            ->with('author')
            ->recent()
            ->limit(3)
            ->get();

        return view('pages.news.index', compact('articles', 'featuredArticles'));
    }

    public function show(string $slug): View
    {
        $article = Article::published()
            ->where('slug', $slug)
            ->with('author')
            ->firstOrFail();

        // Check premium access
        if ($article->is_premium && !$this->canAccessPremium()) {
            return view('pages.news.premium-locked', compact('article'));
        }

        // Increment views
        $article->incrementViews();

        // Related articles
        $relatedArticles = Article::published()
            ->where('id', '!=', $article->id)
            ->where('category', $article->category)
            ->with('author')
            ->recent()
            ->limit(3)
            ->get();

        return view('pages.news.show', compact('article', 'relatedArticles'));
    }

    protected function canAccessPremium(): bool
    {
        // For now, all authenticated users can access premium content
        // This can be extended with subscription logic later
        return auth()->check();
    }
}
