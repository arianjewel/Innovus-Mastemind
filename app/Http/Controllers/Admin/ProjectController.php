<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\ProjectDocument;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class ProjectController extends Controller
{
    public function index(Request $request): Response
    {
        $search = $request->query('search');

        return Inertia::render('Admin/Projects/Index', [
            'projects' => Project::query()
                ->withCount('documents')
                ->when($search, fn ($q) => $q->where('title', 'like', "%{$search}%")
                    ->orWhere('client', 'like', "%{$search}%"))
                ->orderBy('sort_order')
                ->paginate(15)
                ->withQueryString(),
            'filters' => ['search' => $search],
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/Projects/Form', ['project' => null]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('projects', 'public');
        }

        $project = Project::create($this->normalize($data));

        $gallery = $this->syncGallery($request, $project);
        $data['gallery'] = $gallery;
        $project->update($this->normalize($data));

        $this->syncFiles($request, $project);

        return redirect()->route('admin.projects.index')->with('success', 'Project created.');
    }

    public function edit(Project $project): Response
    {
        $project->load('documents');

        return Inertia::render('Admin/Projects/Form', [
            'project' => $project,
        ]);
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $data = $this->validated($request, $project->id);

        if ($request->hasFile('image')) {
            if ($project->image_path) {
                Storage::disk('public')->delete($project->image_path);
            }
            $data['image_path'] = $request->file('image')->store('projects', 'public');
        }

        $gallery = $this->syncGallery($request, $project);
        $data['gallery'] = $gallery;

        $project->update($this->normalize($data));
        $this->syncFiles($request, $project);

        return redirect()->route('admin.projects.index')->with('success', 'Project updated.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        if ($project->image_path) {
            Storage::disk('public')->delete($project->image_path);
        }
        foreach ($project->gallery ?? [] as $path) {
            Storage::disk('public')->delete($path);
        }
        foreach ($project->documents as $doc) {
            Storage::disk('public')->delete($doc->file_path);
        }
        $project->delete();

        return back()->with('success', 'Project deleted.');
    }

    public function destroyDocument(ProjectDocument $document): RedirectResponse
    {
        Storage::disk('public')->delete($document->file_path);
        $document->delete();

        return back()->with('success', 'Document removed.');
    }

    private function validated(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:projects,slug'.($id ? ",{$id}" : '')],
            'type' => ['required', 'in:consultancy,construction,supply'],
            'client' => ['nullable', 'string', 'max:255'],
            'location' => ['nullable', 'string', 'max:255'],
            'period' => ['nullable', 'string', 'max:100'],
            'contract_amount' => ['nullable', 'numeric', 'min:0'],
            'overview' => ['nullable', 'string'],
            'scope' => ['nullable', 'array'],
            'scope.*' => ['nullable', 'string', 'max:500'],
            'status' => ['required', 'in:ongoing,completed'],
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
        $data['scope'] = array_values(array_filter($data['scope'] ?? [], fn ($v) => filled($v)));
        $data['contract_amount'] = $data['contract_amount'] ?? null;

        return $data;
    }

    private function syncGallery(Request $request, Project $project): array
    {
        $existing = array_values(array_filter((array) $request->input('existing_gallery', [])));

        // remove deleted gallery images from disk
        foreach (array_diff($project->gallery ?? [], $existing) as $removed) {
            Storage::disk('public')->delete($removed);
        }

        if ($request->hasFile('gallery_files')) {
            foreach ($request->file('gallery_files') as $file) {
                $existing[] = $file->store('projects/gallery', 'public');
            }
        }

        return $existing;
    }

    private function syncFiles(Request $request, Project $project): void
    {
        if (! $request->hasFile('documents')) {
            return;
        }

        $startAt = (int) $project->documents()->max('sort_order');

        foreach ($request->file('documents') as $i => $file) {
            $path = $file->store("projects/{$project->id}/documents", 'public');
            $project->documents()->create([
                'title' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                'file_path' => $path,
                'size_bytes' => $file->getSize(),
                'sort_order' => $startAt + $i,
            ]);
        }
    }
}
