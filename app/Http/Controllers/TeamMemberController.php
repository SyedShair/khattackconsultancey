<?php

namespace App\Http\Controllers;

use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TeamMemberController extends Controller
{
    public function index()
    {
        $members = TeamMember::orderBy('sort_order')->get();

        return view('team-members.index', compact('members'));
    }

    public function create()
    {
        return view('team-members.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);
        $validated['is_active'] = $request->boolean('is_active');

        $validated['photo'] = $request->hasFile('photo')
            ? $request->file('photo')->store('team-members', 'public')
            : null;

        $validated['sort_order'] = (TeamMember::max('sort_order') ?? 0) + 1;

        TeamMember::create($validated);

        return redirect()->route('team-members.index')->with('status', 'Team member created.');
    }

    public function edit(TeamMember $teamMember)
    {
        return view('team-members.edit', compact('teamMember'));
    }

    public function update(Request $request, TeamMember $teamMember)
    {
        $validated = $this->validated($request);
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('photo')) {
            if ($teamMember->photo) {
                Storage::disk('public')->delete($teamMember->photo);
            }
            $validated['photo'] = $request->file('photo')->store('team-members', 'public');
        }

        $teamMember->update($validated);

        return redirect()->route('team-members.index')->with('status', 'Team member updated.');
    }

    public function destroy(TeamMember $teamMember)
    {
        if ($teamMember->photo) {
            Storage::disk('public')->delete($teamMember->photo);
        }

        $teamMember->delete();

        return response()->json(['message' => 'Team member deleted.']);
    }

    public function toggleActive(TeamMember $teamMember)
    {
        $teamMember->update(['is_active' => ! $teamMember->is_active]);

        return response()->json([
            'message'   => $teamMember->is_active ? 'Team member activated.' : 'Team member deactivated.',
            'is_active' => $teamMember->is_active,
        ]);
    }

    /**
     * AJAX: persist new drag-and-drop order.
     * Expects: { order: [id1, id2, id3, ...] } in that display order.
     */
    public function reorder(Request $request)
    {
        $validated = $request->validate([
            'order'   => ['required', 'array'],
            'order.*' => ['integer', 'exists:team_members,id'],
        ]);

        foreach ($validated['order'] as $index => $id) {
            TeamMember::where('id', $id)->update(['sort_order' => $index]);
        }

        return response()->json(['message' => 'Order updated.']);
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'name'         => ['required', 'string', 'max:150'],
            'designation'  => ['nullable', 'string', 'max:150'],
            'facebook_url' => ['nullable', 'string', 'max:255'],
            'twitter_url'  => ['nullable', 'string', 'max:255'],
            'skype_url'    => ['nullable', 'string', 'max:255'],
            'link'         => ['nullable', 'string', 'max:255'],
            'photo'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ]);
    }
}