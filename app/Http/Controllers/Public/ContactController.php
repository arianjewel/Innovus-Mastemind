<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ContactController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Public/Contact', [
            'contact' => Setting::getMany([
                'site_name', 'tagline', 'address', 'phone_primary',
                'phone_secondary', 'email_primary', 'email_secondary',
                'office_hours', 'map_embed_url', 'facebook_url', 'linkedin_url',
            ]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        Message::create($validated);

        return back()->with('success', 'Thank you! Your message has been sent. We will get back to you soon.');
    }
}
