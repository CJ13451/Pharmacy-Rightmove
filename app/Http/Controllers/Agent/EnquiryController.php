<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use Illuminate\Http\Request;
use Illuminate\View\View;

class EnquiryController extends Controller
{
    public function index(Request $request): View
    {
        $user = auth()->user();

        $query = Enquiry::whereHas('listing', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->with(['listing', 'user']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by listing
        if ($request->filled('listing_id')) {
            $query->where('listing_id', $request->listing_id);
        }

        $enquiries = $query->latest()->paginate(20);

        // Mark new ones as read when viewed
        Enquiry::whereIn('id', $enquiries->pluck('id'))
            ->where('status', 'new')
            ->update(['status' => 'read']);

        return view('pages.agent.enquiries.index', compact('enquiries'));
    }
}
