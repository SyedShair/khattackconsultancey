@extends('layouts.front')

@section('title', $service->title)
@section('meta_description', Str::limit(strip_tags($service->description ?? $service->content ?? ''), 155))

@section('content')

<!-- breadcrumbarea__start -->
<div class="breadcrumbarea" style="background: url({{ asset('website/img/about/about__bg__1.jpg') }});">
    <div class="container">
        <div class="row">
            <div class="col-xl-12" data-aos="fade-up" data-aos-duration="1500">
                <div class="breadcrumbarea__content__wraper">
                    <div class="breadcrumbarea__title">
                        <h2 class="heading">{{ $service->title }}</h2>
                    </div>
                    <div class="breadcrumbarea__inner">
                        <ul>
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li>// </li>
                            <li>{{ $service->title }}</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- breadcrumbarea__end -->

<!-- service__details__start -->
<div class="service__details sp_top_140 sp_bottom_160">
    <div class="container">
        <div class="row">
            <div class="col-xl-4 col-lg-4 col-md-12 col-12">
                <div class="service__details__sidebar sidebar">

                    <div class="sidebar__widget" data-aos="fade-up" data-aos-duration="1500">
                        <div class="sidebar__search">
                            <form action="{{ url('/') }}" method="GET" style="position: relative;">
                                <input class="sidebar__common__input" type="text" name="q" placeholder="Search Here...">
                                <button type="submit" class="sidebar__search__button" style="border:0;background:none;padding:0;">
                                    <svg width="18" height="19" viewBox="0 0 18 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M14.4 13.372L17.91 16.864C17.97 16.924 18 17.002 18 17.098C18 17.194 17.97 17.272 17.91 17.332L16.758 18.484C16.698 18.544 16.62 18.574 16.524 18.574C16.428 18.574 16.35 18.544 16.29 18.484L15.966 18.142L15.804 17.998C15.72 17.926 15.672 17.884 15.66 17.872L12.816 15.028C12.756 14.956 12.672 14.92 12.564 14.92C12.468 14.908 12.384 14.932 12.312 14.992C11.664 15.448 10.962 15.802 10.206 16.054C9.426 16.306 8.628 16.432 7.812 16.432C6.396 16.432 5.082 16.078 3.87 15.37C2.694 14.674 1.758 13.738 1.062 12.562C0.354 11.35 0 10.036 0 8.62C0 7.204 0.354 5.89 1.062 4.678C1.758 3.502 2.694 2.566 3.87 1.87C5.082 1.162 6.396 0.807999 7.812 0.807999C9.228 0.807999 10.536 1.162 11.736 1.87C12.912 2.566 13.848 3.502 14.544 4.678C15.252 5.89 15.606 7.204 15.606 8.62C15.606 10.156 15.192 11.566 14.364 12.85C14.316 12.934 14.292 13.024 14.292 13.12C14.304 13.216 14.34 13.3 14.4 13.372ZM12.528 12.256C12.924 11.74 13.23 11.176 13.446 10.564C13.662 9.94 13.77 9.292 13.77 8.62C13.77 7.54 13.5 6.538 12.96 5.614C12.432 4.702 11.718 3.982 10.818 3.454C9.894 2.914 8.892 2.644 7.812 2.644C6.732 2.644 5.73 2.914 4.806 3.454C3.894 3.982 3.174 4.702 2.646 5.614C2.106 6.538 1.836 7.54 1.836 8.62C1.836 9.7 2.106 10.702 2.646 11.626C3.174 12.538 3.894 13.258 4.806 13.786C5.73 14.326 6.732 14.596 7.812 14.596C8.532 14.596 9.222 14.476 9.882 14.236C10.542 13.984 11.136 13.63 11.664 13.174C11.988 12.898 12.276 12.592 12.528 12.256Z" fill="#1C5C05"/>
                                    </svg>
                                </button>
                            </form>
                        </div>
                    </div>

                    <div class="sidebar__widget" data-aos="fade-up" data-aos-duration="1800">
                        <div class="sidebar__title">
                            <h5>All Services:</h5>
                        </div>
                        <div class="sidebar__list">
                            <ul>
                                @forelse($allServices as $item)
                                <li>
                                    <a class="sidebar__common__input {{ $item->id === $service->id ? 'active' : '' }}"
                                       href="{{ route('services.show', $item) }}">
                                        {{ $item->title }}
                                        <i class="icofont-rounded-right"></i>
                                    </a>
                                </li>
                                @empty
                                <li><span class="sidebar__common__input">No other services yet.</span></li>
                                @endforelse
                            </ul>
                        </div>
                    </div>

                    @if($service->brochure_pdf_url || $service->brochure_doc_url)
                    <div class="sidebar__widget" data-aos="fade-up" data-aos-duration="2100">
                        <div class="sidebar__title">
                            <h5>Download Brochure:</h5>
                        </div>
                        <div class="sidebar__button">
                            @if($service->brochure_pdf_url)
                                <a class="default__button sidebar__button__1" target="_blank" href="{{ $service->brochure_pdf_url }}">
                                    Download PDF<i class="icofont-file-pdf"></i>
                                </a>
                            @endif
                            @if($service->brochure_doc_url)
                                <a class="default__button btn__black" target="_blank" href="{{ $service->brochure_doc_url }}">
                                    Download DOC<i class="icofont-file-document"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                    @endif

                </div>
            </div>

            <div class="col-xl-8 col-lg-8 col-md-12 col-12">
                <div class="service__details__wraper">

                    @if($service->detail_image_url)
                    <div class="service__details__img" data-aos="fade-up" data-aos-duration="1500">
                        <img src="{{ $service->detail_image_url }}" alt="{{ $service->title }}">
                    </div>
                    @endif

                    <div class="service__details__heading" data-aos="fade-up" data-aos-duration="1500">
                        <h4>{{ $service->title }}</h4>
                    </div>

                    @if($service->content)
                    <div class="service__details__text" data-aos="fade-up" data-aos-duration="1500">
                        @foreach(preg_split('/\r\n|\r|\n/', $service->content) as $paragraph)
                            @continue(trim($paragraph) === '')
                            <p>{{ $paragraph }}</p>
                        @endforeach
                    </div>
                    @endif

                    @if($service->planning_image_url || $service->planning_heading || $service->planning_text)
                    <div class="service__details__planning" data-aos="fade-up" data-aos-duration="1500">
                        <div class="row">
                            @if($service->planning_image_url)
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="service__details__planning__img">
                                    <img src="{{ $service->planning_image_url }}" alt="{{ $service->planning_heading }}">
                                </div>
                            </div>
                            @endif
                            <div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
                                <div class="service__details__planning__inner">
                                    @if($service->planning_heading)
                                    <div class="service__details__planning__heading">
                                        <h6>{{ $service->planning_heading }}</h6>
                                    </div>
                                    @endif
                                    @if($service->planning_text)
                                    <div class="service__details__planning__text">
                                        @foreach(preg_split('/\r\n|\r|\n/', $service->planning_text) as $paragraph)
                                            @continue(trim($paragraph) === '')
                                            <p>{{ $paragraph }}</p>
                                        @endforeach
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endif

                    @if($service->execution_heading)
                    <div class="service__details__heading" data-aos="fade-up" data-aos-duration="1500">
                        <h4>{{ $service->execution_heading }}</h4>
                    </div>
                    @endif

                    @if($service->execution_text)
                    <div class="service__details__text" data-aos="fade-up" data-aos-duration="1500">
                        @foreach(preg_split('/\r\n|\r|\n/', $service->execution_text) as $paragraph)
                            @continue(trim($paragraph) === '')
                            <p>{{ $paragraph }}</p>
                        @endforeach
                    </div>
                    @endif

                    <div class="service__details__button" data-aos="fade-up" data-aos-duration="1500">
                        <a class="default__button" href="{{ url('/#tb__contact') }}">Contact Us</a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
<!-- service__details__end -->

@endsection