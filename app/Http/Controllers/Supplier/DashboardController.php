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

        return view('pages.supplier.dashboard', compact('supplier', 'stats', 'viewsTrend'));
    }
}
