<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class TeamMemberController extends Controller
{
    public function index(): Response
    {
        return Inertia::render('Admin/TeamMembers/Index', [
            'members' => TeamMember::orderBy('type')->orderBy('sort_order')->get(),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('Admin/TeamMembers/Form');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);

        if ($request->hasFile('photo')) {
            $data['photo_path'] = $request->file('photo')->store('team', 'public');
        }

        TeamMember::create($this->normalize($data));

        return redirect()->route('admin.team-members.index')->with('success', 'Team member added.');
    }

    public function edit(TeamMember $teamMember): Response
    {
        return Inertia::render('Admin/TeamMembers/Form', ['member' => $teamMember]);
    }

    public function update(Request $request, TeamMember $teamMember): RedirectResponse
    {
        $data = $this->validated($request, $teamMember->id);

        if ($request->hasFile('photo')) {
            if ($teamMember->photo_path) {
                Storage::disk('public')->delete($teamMember->photo_path);
            }
            $data['photo_path'] = $request->file('photo')->store('team', 'public');
        }

        $teamMember->update($this->normalize($data));

        return redirect()->route('admin.team-members.index')->with('success', 'Team member updated.');
    }

    public function destroy(TeamMember $teamMember): RedirectResponse
    {
        if ($teamMember->photo_path) {
            Storage::disk('public')->delete($teamMember->photo_path);
        }
        $teamMember->delete();

        return back()->with('success', 'Team member removed.');
    }

    private function validated(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'designation' => ['nullable', 'string', 'max:255'],
            'type' => ['required', 'in:leadership,staff,consultant'],
            'qualification' => ['nullable', 'string', 'max:1000'],
            'expertise' => ['nullable', 'string', 'max:1000'],
            'experience' => ['nullable', 'string', 'max:100'],
            'bio' => ['nullable', 'string'],
            'highlights' => ['nullable', 'array'],
            'highlights.*' => ['nullable', 'string', 'max:1000'],
            'sort_order' => ['nullable', 'integer', 'min:0'],
            'is_active' => ['boolean'],
        ]) + ['is_active' => $request->boolean('is_active')];
    }

    private function normalize(array $data): array
    {
        $data['highlights'] = array_values(array_filter($data['highlights'] ?? [], fn ($v) => filled($v)));

        return $data;
    }
}
