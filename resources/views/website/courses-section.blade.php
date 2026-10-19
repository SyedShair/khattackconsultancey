{{-- Homepage section: @include('website.courses-section') --}}
@php
    $courses = \App\Models\Course::active()->ordered()->with('items')->get();
@endphp

<section id="tb__courses" class="py-5">
    <div class="container">
        <div class="text-center mb-5">
            <h2>Our Courses</h2>
        </div>

        @foreach($courses as $course)
            <div class="mb-5" id="course-{{ $course->slug }}">

                {{-- Course heading: image + detail --}}
                <div class="row align-items-center g-4 mb-4">
                    <div class="col-lg-5 {{ $loop->even ? 'order-lg-2' : '' }}">
                        @if($course->image_url)
                            <img src="{{ $course->image_url }}" alt="{{ $course->title }}"
                                 class="img-fluid rounded w-100" style="max-height:380px;object-fit:cover;">
                        @endif
                    </div>
                    <div class="col-lg-7">
                        <h3 class="mb-3">{{ $course->title }}</h3>
                        @if($course->description)
                            <p>{{ $course->description }}</p>
                        @endif
                    </div>
                </div>

                {{-- Sub-courses: cards with their own image --}}
                @if($course->items->isNotEmpty())
                    <div class="row g-4">
                        @foreach($course->items as $item)
                            <div class="col-md-6 col-lg-4">
                                <div class="h-100 border rounded overflow-hidden" style="background: var(--whiteColor);">
                                    @if($item->image_url)
                                        <img src="{{ $item->image_url }}" alt="{{ $item->title }}"
                                             class="w-100" style="height:190px;object-fit:cover;">
                                    @endif
                                    <div class="p-3">
                                        <h6 class="mb-2" style="color: var(--primaryColor);">{{ $item->title }}</h6>
                                        @if($item->description)
                                            <p class="mb-0 small">{{ $item->description }}</p>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        @endforeach
    </div>
</section>
