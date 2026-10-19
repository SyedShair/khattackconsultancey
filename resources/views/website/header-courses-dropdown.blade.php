{{-- Replace the hardcoded <ul class="menu__dropdown"> under COURSES in the header with this --}}
@php
    $navCourses = \App\Models\Course::active()->ordered()->get(['id', 'title', 'slug']);
@endphp

<ul class="menu__dropdown">
    @foreach($navCourses as $navCourse)
        <li><a href="{{ url('/#course-' . $navCourse->slug) }}">{{ $navCourse->title }}</a></li>
    @endforeach
</ul>

{{-- Mobile offcanvas version: same loop inside the <details> <ul> --}}
