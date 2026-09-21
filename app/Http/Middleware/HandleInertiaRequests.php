<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function version(Request $request): ?string
    {
        if (app()->isProduction()) {
            return parent::version($request);
        }

        return null;
    }

    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'auth' => [
                'user' => fn () => $request->user()
                    ? $request->user()->only('id', 'name', 'email', 'is_admin')
                    : null,
            ],
            'flash' => fn () => [
                'success' => $request->session()->get('success'),
                'error' => $request->session()->get('error'),
            ],
            'site' => fn () => \Illuminate\Support\Facades\Cache::rememberForever('site_shared_settings', function () {
                return \App\Models\Setting::getMany([
                    'site_name', 'tagline', 'logo_path', 'address', 'phone_primary',
                    'phone_secondary', 'email_primary', 'email_secondary',
                    'facebook_url', 'linkedin_url', 'youtube_url', 'whatsapp_number',
                    'footer_text',
                ]);
            }),
            'unreadMessages' => fn () => $request->user()?->is_admin
                ? \App\Models\Message::unread()->count()
                : 0,
            'unreadInquiries' => fn () => $request->user()?->is_admin
                ? \App\Models\Inquiry::unread()->count()
                : 0,
        ];
    }
}
