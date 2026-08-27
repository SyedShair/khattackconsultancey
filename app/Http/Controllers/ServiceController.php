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
        $validated['sort_order'] = (Service::max('sort_order') ?? 0) + 1;

        $validated = $this->handleUploads($request, $validated);

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

        $validated = $this->handleUploads($request, $validated, $service);

        $service->update($validated);

        return redirect()->route('services.index')->with('status', 'Service updated.');
    }

    public function destroy(Service $service)
    {
        foreach (['icon', 'detail_image', 'planning_image', 'brochure_pdf', 'brochure_doc'] as $field) {
            if ($service->$field) {
                Storage::disk('public')->delete($service->$field);
            }
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

    /**
     * Public-facing service details page, e.g. /services/{slug}
     */
    public function show(Service $service,Request $request)

  
    {

    
        $allServices = Service::active()->orderBy('sort_order')->get();

        return view('front.service-details', compact('service', 'allServices'));
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'title'       => ['required', 'string', 'max:150'],
            'description' => ['nullable', 'string', 'max:500'],
            'link'        => ['nullable', 'string', 'max:255'],
            'icon'        => ['nullable', 'image', 'mimes:jpg,jpeg,png,svg,webp', 'max:2048'],

            // Detail page fields
            'content'           => ['nullable', 'string'],
            'detail_image'      => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'planning_image'    => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'planning_heading'  => ['nullable', 'string', 'max:255'],
            'planning_text'     => ['nullable', 'string'],
            'execution_heading' => ['nullable', 'string', 'max:255'],
            'execution_text'    => ['nullable', 'string'],
            'brochure_pdf'      => ['nullable', 'file', 'mimes:pdf', 'max:10240'],
            'brochure_doc'      => ['nullable', 'file', 'mimes:doc,docx', 'max:10240'],
        ]);
    }

    /**
     * Store any uploaded files (icon + all detail-page files), deleting the
     * old file on replacement, and merge the resulting paths into $data.
     * Fields with no new upload are left untouched (so editing text fields
     * doesn't wipe out an existing file).
     */
    protected function handleUploads(Request $request, array $data, ?Service $service = null): array
    {
        $fileFields = ['icon', 'detail_image', 'planning_image', 'brochure_pdf', 'brochure_doc'];

        foreach ($fileFields as $field) {
            if ($request->hasFile($field)) {
                if ($service && $service->$field) {
                    Storage::disk('public')->delete($service->$field);
                }
                $data[$field] = $request->file($field)->store('services', 'public');
            } else {
                unset($data[$field]);
            }
        }

        return $data;
    }
}