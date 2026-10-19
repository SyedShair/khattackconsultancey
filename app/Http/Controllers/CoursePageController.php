<?php

namespace App\Http\Controllers;

class CoursePageController extends Controller
{
    public function show(string $slug)
    {
        $course = config('courses.' . $slug);
        abort_if(! $course, 404);

        return view('website.courses.show', compact('course'));
    }
}