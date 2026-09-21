<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class ProductController extends Controller
{
    public function index(Request $request): Response
    {
        $search = $request->query('search');

        return Inertia::render('Admin/Products/Index', [
            'products' => Product::query()
                ->with(['category:id,name', 'brand:id,name', 'images'])
                ->when($search, fn ($q) => $q->where('title', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%"))
                ->latest()
                ->paginate(15)
                ->withQueryString(),
            'filters' => ['search' => $search],
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Products/Form', [
            'product' => null,
            'categories' => Category::active()->get(['id', 'name']),
            'brands' => Brand::active()->get(['id', 'name']),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $product = Product::create($this->normalize($data));

        $this->syncImages($request, $product);

        return redirect()->route('admin.products.index')->with('success', 'Product created.');
    }

    public function edit(Product $product): Response
    {
        $product->load('images');

        return Inertia::render('Admin/Products/Form', [
            'product' => $product,
            'categories' => Category::active()->get(['id', 'name']),
            'brands' => Brand::active()->get(['id', 'name']),
        ]);
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $data = $this->validated($request, $product->id);
        $product->update($this->normalize($data));

        if ($request->boolean('replace_images') && $request->hasFile('images')) {
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image->path);
                $image->delete();
            }
        }

        $this->syncImages($request, $product);

        return redirect()->route('admin.products.index')->with('success', 'Product updated.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        foreach ($product->images as $image) {
            Storage::disk('public')->delete($image->path);
        }
        $product->delete();

        return back()->with('success', 'Product deleted.');
    }

    public function updateImages(Request $request, Product $product): RedirectResponse
    {
        $request->validate([
            'images' => ['required', 'array'],
            'images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);

        $this->syncImages($request, $product);

        return back()->with('success', 'Images uploaded.');
    }

    public function destroyImage(ProductImage $image): RedirectResponse
    {
        Storage::disk('public')->delete($image->path);
        $image->delete();

        return back()->with('success', 'Image removed.');
    }

    public function makeCover(ProductImage $image): RedirectResponse
    {
        $rank = 1;

        foreach ($image->product->images()->whereKeyNot($image->id)->orderBy('sort_order')->get() as $img) {
            $img->update(['sort_order' => $rank++]);
        }

        $image->update(['sort_order' => 0]);

        return back()->with('success', 'Cover image updated.');
    }

    private function validated(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:products,slug'.($id ? ",{$id}" : '')],
            'category_id' => ['nullable', 'exists:categories,id'],
            'brand_id' => ['nullable', 'exists:brands,id'],
            'sku' => ['nullable', 'string', 'max:100'],
            'price' => ['required', 'numeric', 'min:0'],
            'old_price' => ['nullable', 'numeric', 'min:0', 'gt:price'],
            'unit' => ['nullable', 'string', 'max:30'],
            'currency' => ['nullable', 'string', 'max:10'],
            'short_desc' => ['nullable', 'string', 'max:500'],
            'details' => ['nullable', 'string'],
            'specifications' => ['nullable', 'array'],
            'specifications.*.label' => ['required_with:specifications', 'string', 'max:255'],
            'specifications.*.value' => ['nullable', 'string', 'max:500'],
            'is_featured' => ['boolean'],
            'is_active' => ['boolean'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
        ]) + [
            'is_featured' => $request->boolean('is_featured'),
            'is_active' => $request->boolean('is_active'),
        ];
    }

    private function normalize(array $data): array
    {
        $data['specifications'] = array_values(array_filter(
            $data['specifications'] ?? [],
            fn ($row) => filled($row['label'] ?? null)
        ));

        foreach ($data['specifications'] as &$row) {
            $row['value'] = $row['value'] ?? '';
        }

        $data['old_price'] = $data['old_price'] ?? null;

        return $data;
    }

    private function syncImages(Request $request, Product $product): void
    {
        if (! $request->hasFile('images')) {
            return;
        }

        $startAt = (int) $product->images()->max('sort_order');

        foreach ($request->file('images') as $i => $file) {
            $path = $file->store("products/{$product->id}", 'public');
            $product->images()->create([
                'path' => $path,
                'sort_order' => $startAt + $i,
            ]);
        }
    }
}
