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

    public function show(string $id): View
    {
        $user = auth()->user();

        $enquiry = Enquiry::whereHas('listing', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->with(['listing', 'user'])->findOrFail($id);

        if ($enquiry->status === 'new') {
            $enquiry->update(['status' => 'read']);
        }

        return view('pages.agent.enquiries.show', compact('enquiry'));
    }

    public function reply(Request $request, string $id)
    {
        $user = auth()->user();

        $enquiry = Enquiry::whereHas('listing', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->findOrFail($id);

        $validated = $request->validate([
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $enquiry->reply($validated['message']);

        return back()->with('success', 'Reply sent.');
    }

    public function archive(string $id)
    {
        $user = auth()->user();

        $enquiry = Enquiry::whereHas('listing', function ($q) use ($user) {
            $q->where('user_id', $user->id);
        })->findOrFail($id);

        $enquiry->archive();

        return back()->with('success', 'Enquiry archived.');
    }
}
