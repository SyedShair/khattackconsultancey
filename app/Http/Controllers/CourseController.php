<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::withCount('items')->ordered()->get();

        return view('courses.index', compact('courses'));
    }

    public function create()
    {
        return view('courses.create');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);

        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('courses', 'public');
        }

        $data['slug']       = $this->uniqueSlug($data['title']);
        $data['is_active']  = $request->boolean('is_active');
        $data['sort_order'] = (Course::max('sort_order') ?? 0) + 1;

        $course = Course::create($data);
        $this->syncItems($course, $request);

        return redirect()->route('courses.index')->with('status', 'Course created.');
    }

    public function edit(Course $course)
    {
        $course->load('items');

        return view('courses.edit', compact('course'));
    }

    public function update(Request $request, Course $course)
    {
        $data = $this->validated($request);

        if ($request->hasFile('image')) {
            if ($course->image) {
                Storage::disk('public')->delete($course->image);
            }
            $data['image'] = $request->file('image')->store('courses', 'public');
        }

        if ($data['title'] !== $course->title) {
            $data['slug'] = $this->uniqueSlug($data['title'], $course->id);
        }

        $data['is_active'] = $request->boolean('is_active');

        $course->update($data);
        $this->syncItems($course, $request);

        return redirect()->route('courses.index')->with('status', 'Course updated.');
    }

    public function destroy(Course $course)
    {
        if ($course->image) {
            Storage::disk('public')->delete($course->image);
        }
        foreach ($course->items as $item) {
            if ($item->image) {
                Storage::disk('public')->delete($item->image);
            }
        }
        $course->delete(); // sub-courses are removed by the cascade

        return response()->json(['message' => 'Course deleted.']);
    }

    public function toggleActive(Course $course)
    {
        $course->update(['is_active' => ! $course->is_active]);

        return response()->json([
            'message'   => 'Status updated.',
            'is_active' => $course->is_active,
        ]);
    }

    public function reorder(Request $request)
    {
        foreach ((array) $request->input('order', []) as $position => $id) {
            Course::where('id', $id)->update(['sort_order' => $position + 1]);
        }

        return response()->json(['message' => 'Order saved.']);
    }

    /* ------------------------------------------------------------ */

    private function validated(Request $request): array
    {
        $request->validate([
            'title'               => 'required|string|max:255',
            'description'         => 'nullable|string',
            'image'               => 'nullable|image|max:4096',
            'items'               => 'nullable|array',
            'items.*.title'       => 'nullable|string|max:255',
            'items.*.description' => 'nullable|string',
            'items.*.image'       => 'nullable|image|max:4096',
        ]);

        return $request->only(['title', 'description']);
    }

    private function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title) ?: 'course';
        $slug = $base;
        $i = 2;

        while (Course::where('slug', $slug)
            ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
            ->exists()) {
            $slug = $base . '-' . $i++;
        }

        return $slug;
    }

    /** Create / update / delete sub-courses to match the submitted rows (in form order). */
    private function syncItems(Course $course, Request $request): void
    {
        $rows     = (array) $request->input('items', []);
        $keep     = [];
        $position = 0;

        foreach ($rows as $key => $row) {
            $title = trim($row['title'] ?? '');
            if ($title === '') {
                continue; // ignore blank rows
            }

            $payload = [
                'title'       => $title,
                'description' => $row['description'] ?? null,
                'sort_order'  => $position++,
            ];

            $item = ! empty($row['id']) ? $course->items()->find($row['id']) : null;

            // Remove the current image if ticked, or when a new one replaces it
            $newImage = $request->file("items.$key.image");
            if ($item && $item->image && ($newImage || ! empty($row['remove_image']))) {
                Storage::disk('public')->delete($item->image);
                $payload['image'] = null;
            }
            if ($newImage) {
                $payload['image'] = $newImage->store('courses/items', 'public');
            }

            if ($item) {
                $item->update($payload);
            } else {
                $item = $course->items()->create($payload);
            }

            $keep[] = $item->id;
        }

        // Delete rows that were removed from the form (and their images)
        foreach ($course->items()->whereNotIn('id', $keep)->get() as $old) {
            if ($old->image) {
                Storage::disk('public')->delete($old->image);
            }
            $old->delete();
        }
    }
}
