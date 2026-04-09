<?php

namespace App\Http\Controllers\Supplier;

use App\Enums\SupplierCategory;
use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProfileController extends Controller
{
    public function edit(): View
    {
        $user = auth()->user();
        $supplier = Supplier::where('user_id', $user->id)->firstOrFail();

        return view('pages.supplier.profile.edit', [
            'supplier' => $supplier,
            'categories' => SupplierCategory::options(),
        ]);
    }

    public function update(Request $request)
    {
        $user = auth()->user();
        $supplier = Supplier::where('user_id', $user->id)->firstOrFail();

        $rules = [
            'name' => ['required', 'string', 'max:200'],
            'category' => ['required', 'string'],
            'short_description' => ['required', 'string', 'max:' . $supplier->tier->maxDescriptionLength()],
            'contact_email' => ['required', 'email'],
            'website' => ['nullable', 'url'],
        ];

        // Premium+ fields
        if ($supplier->is_premium) {
            $rules['long_description'] = ['nullable', 'string', 'max:' . $supplier->tier->maxDescriptionLength()];
            $rules['contact_name'] = ['nullable', 'string', 'max:100'];
            $rules['contact_phone'] = ['nullable', 'string', 'max:20'];
            $rules['address'] = ['nullable', 'string', 'max:500'];
            $rules['social_links'] = ['nullable', 'array'];
            $rules['logo'] = ['nullable', 'image', 'max:2048'];
            $rules['photos'] = ['nullable', 'array', 'max:' . $supplier->tier->maxPhotos()];
            $rules['photos.*'] = ['image', 'max:2048'];
        }

        // Featured tier fields
        if ($supplier->is_featured) {
            $rules['custom_branding'] = ['nullable', 'array'];
        }

        $validated = $request->validate($rules);

        // TODO: Handle file uploads for logo and photos

        $supplier->update($validated);

        return back()->with('success', 'Profile updated successfully.');
    }
}
