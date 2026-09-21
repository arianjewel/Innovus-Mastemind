<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProductImage;
use Illuminate\Support\Facades\Storage;

class ProductImageController extends Controller
{
    public function destroy(ProductImage $image)
    {
        Storage::disk('public')->delete($image->path);
        $image->delete();

        return back()->with('success', 'Image removed.');
    }

    public function makeCover(ProductImage $image)
    {
        $rank = 1;

        foreach ($image->product->images()->whereKeyNot($image->id)->orderBy('sort_order')->get() as $img) {
            $img->update(['sort_order' => $rank++]);
        }

        $image->update(['sort_order' => 0]);

        return back()->with('success', 'Cover image updated.');
    }
}
