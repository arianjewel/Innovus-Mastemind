<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Inertia\Inertia;
use Inertia\Response;

class ServiceController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Public/Services/Index', [
            'services' => Service::active()->get(),
        ]);
    }

    public function show(Service $service): Response
    {
        abort_unless($service->is_active, 404);

        return Inertia::render('Public/Services/Show', [
            'service' => $service,
            'otherServices' => Service::active()
                ->whereKeyNot($service->getKey())
                ->get(['id', 'title', 'slug', 'icon', 'short_desc']),
        ]);
    }
}
