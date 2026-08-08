<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::orderBy('sort_order')->get();

        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);
        $validated['is_active'] = $request->boolean('is_active');

        $validated['image'] = $request->hasFile('image')
            ? $request->file('image')->store('projects', 'public')
            : null;

        $validated['sort_order'] = (Project::max('sort_order') ?? 0) + 1;

        Project::create($validated);

        return redirect()->route('projects.index')->with('status', 'Project created.');
    }

    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $this->validated($request);
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('image')) {
            if ($project->image) {
                Storage::disk('public')->delete($project->image);
            }
            $validated['image'] = $request->file('image')->store('projects', 'public');
        }

        $project->update($validated);

        return redirect()->route('projects.index')->with('status', 'Project updated.');
    }

    public function destroy(Project $project)
    {
        if ($project->image) {
            Storage::disk('public')->delete($project->image);
        }

        $project->delete();

        return response()->json(['message' => 'Project deleted.']);
    }

    public function toggleActive(Project $project)
    {
        $project->update(['is_active' => ! $project->is_active]);

        return response()->json([
            'message'   => $project->is_active ? 'Project activated.' : 'Project deactivated.',
            'is_active' => $project->is_active,
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
            'order.*' => ['integer', 'exists:projects,id'],
        ]);

        foreach ($validated['order'] as $index => $id) {
            Project::where('id', $id)->update(['sort_order' => $index]);
        }

        return response()->json(['message' => 'Order updated.']);
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:150'],
            'link'  => ['nullable', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
        ]);
    }
}
