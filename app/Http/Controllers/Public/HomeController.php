<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Product;
use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Slider;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(Request $request): Response
    {
        return Inertia::render('Public/Home', [
            'sliders' => Slider::active()->get(),
            'services' => Service::active()->take(6)->get(['id', 'title', 'slug', 'icon', 'short_desc']),
            'featuredProducts' => Product::query()
                ->active()
                ->with(['brand:id,name,slug', 'category:id,name,slug', 'images'])
                ->featured()
                ->orderBy('sort_order')
                ->take(8)
                ->get(),
            'featuredProjects' => Project::query()
                ->active()
                ->featured()
                ->orderBy('sort_order')
                ->take(6)
                ->get(),
            'clients' => Client::active()->get(['id', 'name', 'logo_path', 'website']),
            'stats' => Setting::getMany(
                ['stat_years_experience', 'stat_projects_completed', 'stat_experts', 'stat_happy_clients'],
                ['15+', '500+', '19', '50+'],
            ),
        ]);
    }
}
