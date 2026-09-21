<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class SettingController extends Controller
{
    public const KEYS = [
        'site_name', 'tagline', 'logo_path', 'address', 'phone_primary', 'phone_secondary',
        'email_primary', 'email_secondary', 'office_hours', 'map_embed_url',
        'facebook_url', 'linkedin_url', 'youtube_url', 'whatsapp_number',
        'footer_text', 'about_intro', 'about_vision', 'about_mission', 'core_values',
        'company_info', 'stat_years_experience', 'stat_projects_completed',
        'stat_experts', 'stat_happy_clients',
    ];

    public function edit(): Response
    {
        return Inertia::render('Admin/Settings/Edit', [
            'settings' => Setting::getManyDecoded(self::KEYS),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'site_name' => ['required', 'string', 'max:255'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:500'],
            'phone_primary' => ['nullable', 'string', 'max:30'],
            'phone_secondary' => ['nullable', 'string', 'max:30'],
            'email_primary' => ['nullable', 'email', 'max:255'],
            'email_secondary' => ['nullable', 'email', 'max:255'],
            'office_hours' => ['nullable', 'string', 'max:255'],
            'map_embed_url' => ['nullable', 'url', 'max:1000'],
            'facebook_url' => ['nullable', 'url', 'max:255'],
            'linkedin_url' => ['nullable', 'url', 'max:255'],
            'youtube_url' => ['nullable', 'url', 'max:255'],
            'whatsapp_number' => ['nullable', 'string', 'max:30'],
            'footer_text' => ['nullable', 'string', 'max:500'],
            'about_intro' => ['nullable', 'string'],
            'about_vision' => ['nullable', 'string'],
            'about_mission' => ['nullable', 'string'],
            'core_values' => ['nullable', 'array'],
            'core_values.*' => ['nullable', 'string', 'max:255'],
            'company_info' => ['nullable', 'array'],
            'stat_years_experience' => ['nullable', 'string', 'max:20'],
            'stat_projects_completed' => ['nullable', 'string', 'max:20'],
            'stat_experts' => ['nullable', 'string', 'max:20'],
            'stat_happy_clients' => ['nullable', 'string', 'max:20'],
        ]);

        if ($request->hasFile('logo')) {
            $request->validate(['logo' => ['image', 'mimes:png,jpg,jpeg,svg,webp', 'max:2048']]);
            $old = Setting::get('logo_path');
            if ($old) {
                Storage::disk('public')->delete($old);
            }
            $data['logo_path'] = $request->file('logo')->store('site', 'public');
        }

        foreach (self::KEYS as $key) {
            if (! array_key_exists($key, $data)) {
                continue;
            }

            $value = $data[$key];

            if (in_array($key, ['core_values', 'company_info'], true)) {
                $value = match ($key) {
                    'core_values' => array_values(array_filter((array) $value, fn ($v) => filled($v))),
                    'company_info' => array_values(array_filter(
                        array_map(
                            fn ($row) => ['label' => trim((string) ($row['label'] ?? '')), 'value' => trim((string) ($row['value'] ?? ''))],
                            (array) $value
                        ),
                        fn ($row) => filled($row['label'])
                    )),
                };
            } elseif (is_string($value)) {
                $value = trim($value);
            }

            Setting::set($key, $value);
        }

        Cache::forget('site_shared_settings');

        return redirect()->back()->with('success', 'Settings saved.');
    }
}
