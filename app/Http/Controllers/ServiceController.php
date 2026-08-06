<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::orderBy('sort_order')->get();

        return view('services.index', compact('services'));
    }

    public function create()
    {
        return view('services.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);
        $validated['is_active'] = $request->boolean('is_active');

        $validated['icon'] = $request->hasFile('icon')
            ? $request->file('icon')->store('services', 'public')
            : null;

        $validated['sort_order'] = (Service::max('sort_order') ?? 0) + 1;

        Service::create($validated);

        return redirect()->route('services.index')->with('status', 'Service created.');
    }

    public function edit(Service $service)
    {
        return view('services.edit', compact('service'));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $this->validated($request);
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('icon')) {
            if ($service->icon) {
                Storage::disk('public')->delete($service->icon);
            }
            $validated['icon'] = $request->file('icon')->store('services', 'public');
        }

        $service->update($validated);

        return redirect()->route('services.index')->with('status', 'Service updated.');
    }

    public function destroy(Service $service)
    {
        if ($service->icon) {
            Storage::disk('public')->delete($service->icon);
        }

        $service->delete();

        return response()->json(['message' => 'Service deleted.']);
    }

    public function toggleActive(Service $service)
    {
        $service->update(['is_active' => ! $service->is_active]);

        return response()->json([
            'message'   => $service->is_active ? 'Service activated.' : 'Service deactivated.',
            'is_active' => $service->is_active,
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
            'order.*' => ['integer', 'exists:services,id'],
        ]);

        foreach ($validated['order'] as $index => $id) {
            Service::where('id', $id)->update(['sort_order' => $index]);
        }

        return response()->json(['message' => 'Order updated.']);
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'title'       => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:500'],
            'link'        => ['nullable', 'string', 'max:255'],
            'icon'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,svg,webp', 'max:2048'],
        ]);
    }
}