<?php

namespace App\Http\Controllers;

class VocationalController extends Controller
{
    public function index()
    {
        $categories = config('vocational.categories');

        return view('website.vocational.index', compact('categories'));
    }

    public function show(string $category)
    {
        $categories = config('vocational.categories');
        abort_unless(isset($categories[$category]), 404);

        $data = $categories[$category];

        // Alphabetical list of ['name' => ..., 'level' => ...]
        $courses = collect($data['courses'])
            ->map(fn ($c) => ['name' => $c[0], 'level' => $c[1]])
            ->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE)
            ->values();

        return view('website.vocational.show', [
            'slug'       => $category,
            'title'      => $data['title'],
            'courses'    => $courses,
            'categories' => $categories,
        ]);
    }
}