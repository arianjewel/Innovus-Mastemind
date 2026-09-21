<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brochure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class BrochureController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Brochures/Index', [
            'brochures' => Brochure::latest()->get(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Brochures/Form', ['brochure' => null]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'pdf' => ['required', 'file', 'mimes:pdf', 'max:20480'],
            'is_active' => ['boolean'],
        ]);
        $data['is_active'] = $request->boolean('is_active');

        $file = $request->file('pdf');
        $data['pdf_path'] = $file->store('brochures', 'public');
        $data['size_bytes'] = $file->getSize();

        Brochure::create($data);

        return redirect()->route('admin.brochures.index')->with('success', 'Brochure uploaded.');
    }

    public function edit(Brochure $brochure): Response
    {
        return Inertia::render('Admin/Brochures/Form', ['brochure' => $brochure]);
    }

    public function update(Request $request, Brochure $brochure): RedirectResponse
    {
        $data = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'pdf' => ['nullable', 'file', 'mimes:pdf', 'max:20480'],
            'is_active' => ['boolean'],
        ]);
        $data['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('pdf')) {
            Storage::disk('public')->delete($brochure->pdf_path);
            $file = $request->file('pdf');
            $data['pdf_path'] = $file->store('brochures', 'public');
            $data['size_bytes'] = $file->getSize();
        }

        $brochure->update($data);

        return redirect()->route('admin.brochures.index')->with('success', 'Brochure updated.');
    }

    public function destroy(Brochure $brochure): RedirectResponse
    {
        Storage::disk('public')->delete($brochure->pdf_path);
        $brochure->delete();

        return back()->with('success', 'Brochure deleted.');
    }
}
