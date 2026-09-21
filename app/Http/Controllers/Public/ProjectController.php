<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProjectController extends Controller
{
    public function index(Request $request): Response
    {
        $type = $request->query('type');

        $projects = Project::query()
            ->active()
            ->when(in_array($type, Project::TYPES, true), fn ($q) => $q->where('type', $type))
            ->orderByDesc('is_featured')
            ->orderBy('sort_order')
            ->paginate(9)
            ->withQueryString();

        return Inertia::render('Public/Projects/Index', [
            'projects' => $projects,
            'activeType' => $type,
        ]);
    }

    public function show(Project $project): Response
    {
        abort_unless($project->is_active, 404);

        $project->load('documents');

        $related = Project::query()
            ->active()
            ->where('type', $project->type)
            ->whereKeyNot($project->getKey())
            ->take(3)
            ->get(['id', 'title', 'slug', 'client', 'location', 'status', 'image_path', 'type']);

        return Inertia::render('Public/Projects/Show', [
            'project' => $project,
            'relatedProjects' => $related,
        ]);
    }
}
