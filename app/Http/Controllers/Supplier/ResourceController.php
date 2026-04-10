<?php

namespace App\Http\Controllers\Supplier;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use App\Models\SupplierResource;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ResourceController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $supplier = Supplier::where('user_id', $user->id)->first();

        if (! $supplier) {
            return redirect()->route('supplier.dashboard');
        }

        // Check if supplier tier allows resources
        if (!$supplier->tier->canUploadResources()) {
            return view('pages.supplier.resources.upgrade-required', compact('supplier'));
        }

        $resources = $supplier->resources()->latest()->paginate(10);

        return view('pages.supplier.resources.index', compact('supplier', 'resources'));
    }

    public function store(Request $request)
    {
        $user = auth()->user();
        $supplier = Supplier::where('user_id', $user->id)->first();

        if (! $supplier) {
            return redirect()->route('supplier.dashboard');
        }

        if (!$supplier->tier->canUploadResources()) {
            abort(403, 'Your tier does not allow resource uploads.');
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:200'],
            'description' => ['nullable', 'string', 'max:500'],
            'type' => ['required', 'in:guide,brochure,case_study,video,training,other'],
            'file' => ['required', 'file', 'max:20480'], // 20MB max
        ]);

        // TODO: Handle file upload to S3
        $fileUrl = ''; // Placeholder

        SupplierResource::create([
            'supplier_id' => $supplier->id,
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'type' => $validated['type'],
            'file_url' => $fileUrl,
            'file_type' => $request->file('file')->getClientOriginalExtension(),
        ]);

        return back()->with('success', 'Resource uploaded successfully.');
    }

    public function destroy(string $id)
    {
        $user = auth()->user();
        $supplier = Supplier::where('user_id', $user->id)->first();

        if (! $supplier) {
            return redirect()->route('supplier.dashboard');
        }

        $resource = SupplierResource::where('supplier_id', $supplier->id)
            ->findOrFail($id);

        // TODO: Delete file from S3

        $resource->delete();

        return back()->with('success', 'Resource deleted.');
    }
}
