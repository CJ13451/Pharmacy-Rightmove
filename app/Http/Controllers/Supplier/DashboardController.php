<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();
        
        $supplier = Supplier::where('user_id', $user->id)->first();

        if (!$supplier) {
            return view('pages.supplier.no-profile');
        }

        $stats = [
            'views' => $supplier->views_count,
            'clicks' => $supplier->clicks_count,
            'resources_count' => $supplier->resources()->count(),
        ];

        // Views over last 30 days (placeholder - would need view tracking table)
        $viewsTrend = [];

        // Month-on-month change placeholders. Would be computed from a
        // view-tracking table once one exists; for now send null so the
        // dashboard view hides the trend lines rather than crashing.
        $viewsChange = null;
        $clicksChange = null;

        // Profile completeness. Count the fields the user has filled in
        // that are relevant for their tier so the "Profile Completeness"
        // card can nudge them to add anything missing.
        $checks = [
            'short description' => !empty($supplier->short_description),
            'contact email' => !empty($supplier->contact_email),
            'website' => !empty($supplier->website),
        ];
        if ($supplier->is_premium) {
            $checks['logo'] = !empty($supplier->logo);
            $checks['long description'] = !empty($supplier->long_description);
            $checks['contact name'] = !empty($supplier->contact_name);
            $checks['contact phone'] = !empty($supplier->contact_phone);
            $checks['address'] = !empty($supplier->address);
        }

        $filledCount = count(array_filter($checks));
        $totalCount = count($checks);
        $profileCompleteness = $totalCount > 0 ? (int) round(($filledCount / $totalCount) * 100) : 100;
        $missingFields = array_keys(array_filter($checks, fn ($v) => ! $v));

        return view('pages.supplier.dashboard', compact(
            'supplier',
            'stats',
            'viewsTrend',
            'viewsChange',
            'clicksChange',
            'profileCompleteness',
            'missingFields'
        ));
    }
}
