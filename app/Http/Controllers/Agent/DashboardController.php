<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use App\Models\PropertyListing;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        $listings = PropertyListing::forUser($user)
            ->latest()
            ->limit(5)
            ->get();

        $recentEnquiries = Enquiry::whereHas('listing', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })
            ->with(['listing', 'user'])
            ->latest()
            ->limit(10)
            ->get();

        $stats = [
            'total_listings' => PropertyListing::forUser($user)->count(),
            'active_listings' => PropertyListing::forUser($user)->active()->count(),
            'total_views' => PropertyListing::forUser($user)->sum('views_count'),
            'total_enquiries' => PropertyListing::forUser($user)->sum('enquiries_count'),
            'unread_enquiries' => Enquiry::whereHas('listing', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })->where('status', 'new')->count(),
        ];

        return view('pages.agent.dashboard', compact('listings', 'recentEnquiries', 'stats'));
    }
}
