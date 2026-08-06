<?php

namespace App\Http\Controllers;

use App\Models\HeroSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroSlideController extends Controller
{
    public function index()
    {
        $slides = HeroSlide::orderBy('sort_order')->get();

        return view('hero-slides.index', compact('slides'));
    }

    public function create()
    {
        return view('hero-slides.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validated($request);
        $validated['is_active'] = $request->boolean('is_active');

        $validated['background_image'] = $request->hasFile('background_image')
            ? $request->file('background_image')->store('hero-slides', 'public')
            : null;

        $validated['image'] = $request->hasFile('image')
            ? $request->file('image')->store('hero-slides', 'public')
            : null;

        $validated['sort_order'] = (HeroSlide::max('sort_order') ?? 0) + 1;

        HeroSlide::create($validated);

        return redirect()->route('hero-slides.index')->with('status', 'Slide created.');
    }

    public function edit(HeroSlide $heroSlide)
    {
        return view('hero-slides.edit', ['slide' => $heroSlide]);
    }

    public function update(Request $request, HeroSlide $heroSlide)
    {
        $validated = $this->validated($request);
        $validated['is_active'] = $request->boolean('is_active');
        if ($request->hasFile('background_image')) {
            if ($heroSlide->background_image) {
                Storage::disk('public')->delete($heroSlide->background_image);
            }
            $validated['background_image'] = $request->file('background_image')->store('hero-slides', 'public');
        }

        if ($request->hasFile('image')) {
            if ($heroSlide->image) {
                Storage::disk('public')->delete($heroSlide->image);
            }
            $validated['image'] = $request->file('image')->store('hero-slides', 'public');
        }

        $heroSlide->update($validated);

        return redirect()->route('hero-slides.index')->with('status', 'Slide updated.');
    }

    public function destroy(HeroSlide $heroSlide)
    {
        if ($heroSlide->background_image) {
            Storage::disk('public')->delete($heroSlide->background_image);
        }
        if ($heroSlide->image) {
            Storage::disk('public')->delete($heroSlide->image);
        }

        $heroSlide->delete();

        return response()->json(['message' => 'Slide deleted.']);
    }

    public function toggleActive(HeroSlide $heroSlide)
    {
        $heroSlide->update(['is_active' => ! $heroSlide->is_active]);

        return response()->json([
            'message'   => $heroSlide->is_active ? 'Slide activated.' : 'Slide deactivated.',
            'is_active' => $heroSlide->is_active,
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
            'order.*' => ['integer', 'exists:hero_slides,id'],
        ]);

        foreach ($validated['order'] as $index => $id) {
            HeroSlide::where('id', $id)->update(['sort_order' => $index]);
        }

        return response()->json(['message' => 'Order updated.']);
    }

    protected function validated(Request $request): array
    {
        return $request->validate([
            'title'             => ['required', 'string', 'max:150'],
            'description'       => ['nullable', 'string', 'max:500'],
            'button_text'       => ['nullable', 'string', 'max:50'],
            'button_link'       => ['nullable', 'string', 'max:255'],
            'background_image'  => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'image'             => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'is_active'         => ['nullable', 'boolean'],
        ]);
    }
}