<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    public function index(Request $request): Response
    {
        $filters = $request->only(['search', 'category', 'brand', 'sort', 'min_price', 'max_price']);

        $products = Product::query()
            ->active()
            ->with(['category:id,name,slug', 'brand:id,name,slug', 'images'])
            ->when($filters['search'] ?? null, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('short_desc', 'like', "%{$search}%")
                        ->orWhere('sku', 'like', "%{$search}%");
                });
            })
            ->when($filters['category'] ?? null, fn ($query, $slug) => $query
                ->whereHas('category', fn ($q) => $q->where('slug', $slug)))
            ->when($filters['brand'] ?? null, fn ($query, $slug) => $query
                ->whereHas('brand', fn ($q) => $q->where('slug', $slug)))
            ->when($filters['min_price'] ?? null, fn ($query, $min) => $query
                ->where('price', '>=', $min))
            ->when($filters['max_price'] ?? null, fn ($query, $max) => $query
                ->where('price', '<=', $max))
            ->when($filters['sort'] ?? 'latest', fn ($query, $sort) => match ($sort) {
                'price_low' => $query->orderBy('price'),
                'price_high' => $query->orderByDesc('price'),
                'title' => $query->orderBy('title'),
                default => $query->orderByDesc('id'),
            })
            ->paginate(12)
            ->withQueryString();

        return Inertia::render('Public/Products/Index', [
            'products' => $products,
            'filters' => $filters,
            'categories' => Category::active()
                ->withCount(['products' => fn ($q) => $q->where('is_active', true)])
                ->get(['id', 'name', 'slug']),
            'brands' => Brand::active()
                ->withCount(['products' => fn ($q) => $q->where('is_active', true)])
                ->get(['id', 'name', 'slug']),
        ]);
    }

    public function show(Product $product): Response
    {
        abort_unless($product->is_active, 404);

        $product->load([
            'category:id,name,slug',
            'brand:id,name,slug',
            'images',
        ]);

        $product->increment('views');

        $related = Product::query()
            ->active()
            ->with(['brand:id,name,slug', 'images'])
            ->where('category_id', $product->category_id)
            ->whereKeyNot($product->getKey())
            ->take(4)
            ->get();

        return Inertia::render('Public/Products/Show', [
            'product' => $product,
            'relatedProducts' => $related,
        ]);
    }
}
