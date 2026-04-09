<?php

namespace App\Http\Controllers;

use App\Models\Resource;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ResourceController extends Controller
{
    public function index(Request $request): View
    {
        $query = Resource::published();

        // Filter by type
        if ($request->filled('type')) {
            $query->ofType($request->type);
        }

        // Filter by category
        if ($request->filled('category')) {
            $query->inCategory($request->category);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $resources = $query->latest()->paginate(12)->withQueryString();

        // Get categories with counts
        $categories = Resource::published()
            ->selectRaw('category, COUNT(*) as count')
            ->groupBy('category')
            ->pluck('count', 'category')
            ->toArray();

        return view('pages.resources.index', compact('resources', 'categories'));
    }

    public function show(string $slug): View
    {
        $resource = Resource::published()
            ->where('slug', $slug)
            ->firstOrFail();

        // Check access
        if (!$resource->isAccessibleBy(auth()->user())) {
            return view('pages.resources.premium-locked', compact('resource'));
        }

        // Related resources
        $relatedResources = Resource::published()
            ->where('id', '!=', $resource->id)
            ->inCategory($resource->category)
            ->limit(4)
            ->get();

        return view('pages.resources.show', compact('resource', 'relatedResources'));
    }

    public function download(string $slug)
    {
        $resource = Resource::published()
            ->where('slug', $slug)
            ->where('resource_format', 'download')
            ->firstOrFail();

        // Check access
        if (!$resource->isAccessibleBy(auth()->user())) {
            abort(403, 'You do not have access to this resource.');
        }

        // Increment downloads
        $resource->incrementDownloads();

        // Redirect to file URL (assuming S3 or similar)
        return redirect($resource->file_url);
    }
}
