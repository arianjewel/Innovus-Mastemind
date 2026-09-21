<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Setting;
use App\Models\TeamMember;
use Inertia\Inertia;
use Inertia\Response;

class AboutController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Public/About', [
            'about' => Setting::getManyDecoded([
                'about_intro',
                'about_vision',
                'about_mission',
                'core_values',
                'company_info',
            ], [
                'about_intro' => '',
                'about_vision' => '',
                'about_mission' => '',
                'core_values' => [],
                'company_info' => [],
            ]),
            'leadership' => TeamMember::query()->active()->ofType('leadership')->get(),
            'staff' => TeamMember::query()->active()->ofType('staff')->get(),
            'consultants' => TeamMember::query()->active()->ofType('consultant')->get(),
            'services' => Service::active()->get(['id', 'title', 'slug', 'icon', 'short_desc']),
        ]);
    }
}
