@extends('layouts.front')

@section('title', 'Our Services')
@section('meta_description', 'Explore all consulting services offered by ' . ($appSetting->app_name ?? config('app.name')) . '.')

@section('content')

<!-- breadcrumbarea__start -->
<div class="breadcrumbarea" style="background: url({{ asset('website/img/about/about__bg__1.jpg') }});">
    <div class="container">
        <div class="row">
            <div class="col-xl-12" data-aos="fade-up" data-aos-duration="1500">
                <div class="breadcrumbarea__content__wraper">
                    <div class="breadcrumbarea__title">
                        <h2 class="heading">Service Page</h2>
                    </div>
                    <div class="breadcrumbarea__inner">
                        <ul>
                            <li><a href="{{ url('/') }}">Home</a></li>
                            <li>// </li>
                            <li>Services</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- breadcrumbarea__end -->

<!-- service__section__start -->
<div class="svc-page sp_top_140 sp_bottom_140">
    <div class="container">
        <div class="row g-4">

            @php
                $fallbackServices = [
                    ['title' => 'Regulatory Compliance', 'description' => 'Helping organisations establish and maintain robust compliance systems while reducing operational and regulatory risk.', 'icon_class' => 'icofont-file-alt'],
                    ['title' => 'HR Compliance & Record Keeping', 'description' => 'Supporting businesses with effective HR processes, workforce management, and record-keeping systems to help maintain compliance and operational efficiency.', 'icon_class' => 'icofont-key'],
                    ['title' => 'Marketing & Media Management', 'description' => 'Helping businesses increase visibility, strengthen their brand presence, and engage effectively with their target audience through strategic marketing and media support.', 'icon_class' => 'icofont-chart-bar-graph'],
                ];
                $iconCycle = ['icofont-file-alt', 'icofont-key', 'icofont-chart-bar-graph', 'icofont-briefcase', 'icofont-globe', 'icofont-users-alt-4'];
            @endphp

            @forelse($services as $index => $service)
                <div class="col-xl-4 col-lg-4 col-md-6 col-12" data-aos="fade-up" data-aos-duration="{{ 1500 + $index * 200 }}">
                    <a href="{{ route('services.show', $service) }}" class="svc-card">
                        <div class="svc-card__top">
                            <div class="svc-card__icon">
                                @if($service->icon_url)
                                    <img src="{{ $service->icon_url }}" alt="{{ $service->title }}">
                                @else
                                    <i class="{{ $iconCycle[$index % count($iconCycle)] }}"></i>
                                @endif
                            </div>
                            <span class="svc-card__arrow">
                                <svg width="16" height="16" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M14.4258 10.9897L23.0101 10.9897L23.0101 19.574" stroke="#0A0624" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    <path d="M10.9902 23.0107L22.8908 11.1101" stroke="#0A0624" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                        </div>
                        <h5 class="svc-card__title">{{ strtoupper($service->title) }}</h5>
                        @if($service->description)
                            <p class="svc-card__text">{{ $service->description }}</p>
                        @endif
                    </a>
                </div>
            @empty
                @foreach($fallbackServices as $index => $fallback)
                    <div class="col-xl-4 col-lg-4 col-md-6 col-12" data-aos="fade-up" data-aos-duration="{{ 1500 + $index * 200 }}">
                        <a href="{{ route('services.public.index') }}" class="svc-card">
                            <div class="svc-card__top">
                                <div class="svc-card__icon">
                                    <i class="{{ $fallback['icon_class'] }}"></i>
                                </div>
                                <span class="svc-card__arrow">
                                    <svg width="16" height="16" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M14.4258 10.9897L23.0101 10.9897L23.0101 19.574" stroke="#0A0624" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M10.9902 23.0107L22.8908 11.1101" stroke="#0A0624" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg>
                                </span>
                            </div>
                            <h5 class="svc-card__title">{{ strtoupper($fallback['title']) }}</h5>
                            <p class="svc-card__text">{{ $fallback['description'] }}</p>
                        </a>
                    </div>
                @endforeach
            @endforelse

        </div>
    </div>
</div>
<!-- service__section__end -->

@endsection

@push('styles')
<style>
    .svc-page {
        background-color: #eef0ef;
        background-image: repeating-linear-gradient(
            135deg,
            rgba(0,0,0,0.015) 0px,
            rgba(0,0,0,0.015) 2px,
            transparent 2px,
            transparent 14px
        );
    }

    .svc-card {
        display: block;
        background: #ffffff;
        border-radius: 20px;
        padding: 40px 32px 36px;
        height: 100%;
        text-decoration: none;
        box-shadow: 0 4px 24px rgba(10, 6, 36, 0.06);
        transition: transform .25s ease, box-shadow .25s ease;
    }

    .svc-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 14px 34px rgba(10, 6, 36, 0.12);
    }

    .svc-card__top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 28px;
    }

    .svc-card__icon {
        width: 96px;
        height: 96px;
        border-radius: 50%;
        background: linear-gradient(90deg, #00229E 50%, #FE0094 50%);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .svc-card__icon img {
        width: 46px;
        height: 46px;
        object-fit: contain;
    }

    .svc-card__icon i {
        font-size: 40px;
        color: #ffffff;
    }

    .svc-card__arrow {
        width: 46px;
        height: 46px;
        border-radius: 50%;
        background: #eef0f2;
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: background .2s ease;
    }

    .svc-card:hover .svc-card__arrow {
        background: #0A0624;
    }

    .svc-card:hover .svc-card__arrow svg path {
        stroke: #ffffff;
    }

    .svc-card__title {
        font-weight: 700;
        text-transform: uppercase;
        color: #0A0624;
        margin-bottom: 16px;
        line-height: 1.3;
    }

    .svc-card__text {
        color: #6b7280;
        margin-bottom: 0;
        line-height: 1.7;
    }

    @media (max-width: 575.98px) {
        .svc-card {
            padding: 32px 24px 28px;
        }
        .svc-card__icon {
            width: 80px;
            height: 80px;
        }
    }

    /* Large screens: the theme's own container only widens to 1355px
       above 1500px (see the site's global stylesheet) — without a
       matching rule here, these cards stay a fixed small size while
       everything else on the page visually scales up, making the
       services section look undersized on big monitors. */
    @media (min-width: 1200px) {
        .svc-card__title {
            font-size: 22px;
        }
        .svc-card__text {
            font-size: 17px;
        }
    }

    @media (min-width: 1500px) and (max-width: 1920px) {
        .svc-page .container {
            max-width: 1355px;
        }
        .svc-card {
            padding: 48px 40px 44px;
        }
        .svc-card__icon {
            width: 110px;
            height: 110px;
        }
        .svc-card__icon i {
            font-size: 46px;
        }
        .svc-card__icon img {
            width: 52px;
            height: 52px;
        }
        .svc-card__arrow {
            width: 52px;
            height: 52px;
        }
        .svc-card__title {
            font-size: 24px;
        }
        .svc-card__text {
            font-size: 18px;
        }
    }
</style>
@endpush