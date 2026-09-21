<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brochure;
use App\Models\Client;
use App\Models\Inquiry;
use App\Models\Message;
use App\Models\Product;
use App\Models\Project;
use App\Models\Service;
use App\Models\TeamMember;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/Dashboard', [
            'counts' => [
                'products' => Product::count(),
                'projects' => Project::count(),
                'services' => Service::count(),
                'teamMembers' => TeamMember::count(),
                'clients' => Client::count(),
                'brochures' => Brochure::where('is_active', true)->count(),
            ],
            'unreadMessages' => Message::unread()->count(),
            'unreadInquiries' => Inquiry::unread()->count(),
            'latestMessages' => Message::latest()->take(5)->get(['id', 'name', 'subject', 'is_read', 'created_at']),
            'latestInquiries' => Inquiry::query()->with('product:id,title,slug')
                ->latest()->take(5)
                ->get(['id', 'product_id', 'name', 'phone', 'quantity', 'is_read', 'created_at']),
        ]);
    }
}
