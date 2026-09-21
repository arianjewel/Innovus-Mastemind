<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class SliderController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Sliders/Index', [
            'sliders' => Slider::orderBy('sort_order')->get(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Sliders/Form');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $request->validate(['image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096']]);
        $data['image_path'] = $this->storeImage($request);

        Slider::create($data);

        return redirect()->route('admin.sliders.index')->with('success', 'Slide created.');
    }

    public function edit(Slider $slider): Response
    {
        return Inertia::render('Admin/Sliders/Form', ['slider' => $slider]);
    }

    public function update(Request $request, Slider $slider): RedirectResponse
    {
        $data = $this->validated($request, $slider->id);

        if ($request->hasFile('image')) {
            $request->validate(['image' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:4096']]);
            Storage::disk('public')->delete($slider->image_path);
            $data['image_path'] = $this->storeImage($request);
        }

        $slider->update($data);

        return redirect()->route('admin.sliders.index')->with('success', 'Slide updated.');
    }

    public function destroy(Slider $slider): RedirectResponse
    {
        Storage::disk('public')->delete($slider->image_path);
        $slider->delete();

        return back()->with('success', 'Slide deleted.');
    }

    private function validated(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'subtitle' => ['nullable', 'string', 'max:500'],
            'cta_text' => ['nullable', 'string', 'max:100'],
            'cta_link' => ['nullable', 'string', 'max:255'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ]) + ['is_active' => $request->boolean('is_active')];
    }

    private function storeImage(Request $request): string
    {
        return $request->file('image')->store('sliders', 'public');
    }
}
