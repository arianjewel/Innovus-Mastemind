<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class InquiryController extends Controller
{
    public function store(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'email' => ['nullable', 'email', 'max:255'],
            'quantity' => ['nullable', 'string', 'max:100'],
            'message' => ['nullable', 'string', 'max:3000'],
        ]);

        Inquiry::create($validated + ['product_id' => $product->id]);

        return back()->with('success', 'Your quote request has been submitted. Our team will contact you shortly.');
    }
}
