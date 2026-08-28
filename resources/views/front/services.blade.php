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
    /* Uses the site's existing design tokens (see :root / .is_dark in
       your global stylesheet) so this page automatically follows the
       same light/dark palette as the rest of the site — no separate
       dark-mode block needed for colours that already invert via
       tokens (whiteColor, blackColor, headingColor, contentColor, etc).
    ------------------------------------------------------------------ */

    .svc-page {
        background-color: var(--pinkcolor);
        background-image: repeating-linear-gradient(
            135deg,
            rgba(0,0,0,0.015) 0px,
            rgba(0,0,0,0.015) 2px,
            transparent 2px,
            transparent 14px
        );
        transition: background-color var(--transition);
    }

    html.is_dark .svc-page {
        background-image: repeating-linear-gradient(
            135deg,
            rgba(255,255,255,0.03) 0px,
            rgba(255,255,255,0.03) 2px,
            transparent 2px,
            transparent 14px
        );
    }

    .svc-card {
        display: block;
        background: var(--whiteColor);
        border-radius: 20px;
        padding: 40px 32px 36px;
        height: 100%;
        text-decoration: none;
        box-shadow: 0 4px 24px rgba(10, 6, 36, 0.06);
        transition: transform .3s cubic-bezier(.2,.8,.2,1),
                    box-shadow var(--transition),
                    background-color var(--transition);
        will-change: transform;
    }

    .svc-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 18px 38px rgba(10, 6, 36, 0.12);
    }

    html.is_dark .svc-card {
        box-shadow: var(--darkShadow);
    }

    html.is_dark .svc-card:hover {
        box-shadow: 0 0 28px 8px rgba(96, 117, 112, 0.28);
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
        background: var(--gradientColor);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: transform .35s cubic-bezier(.2,.8,.2,1);
    }

    .svc-card:hover .svc-card__icon {
        transform: rotate(-8deg) scale(1.06);
    }

    .svc-card__icon img {
        width: 46px;
        height: 46px;
        object-fit: contain;
        transition: transform .35s ease;
    }

    .svc-card:hover .svc-card__icon img {
        transform: rotate(8deg) scale(1.05);
    }

    .svc-card__icon i {
        font-size: 40px;
        color: var(--whiteColor);
        transition: transform .35s ease;
    }

    html.is_dark .svc-card__icon i {
        color: var(--blackColor); /* blackColor flips to white in dark mode */
    }

    .svc-card:hover .svc-card__icon i {
        transform: rotate(8deg) scale(1.05);
    }

    .svc-card__arrow {
        width: 46px;
        height: 46px;
        border-radius: 50%;
        background: var(--borderColor);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        transition: background var(--transition), transform .3s cubic-bezier(.2,.8,.2,1);
    }

    .svc-card__arrow svg path {
        transition: stroke var(--transition);
        stroke: var(--blackColor);
    }

    .svc-card:hover .svc-card__arrow {
        background: var(--blackColor);
        transform: translate(4px, -4px) rotate(45deg);
    }

    .svc-card:hover .svc-card__arrow svg path {
        stroke: var(--whiteColor);
    }

    .svc-card__title {
        font-weight: 700;
        text-transform: uppercase;
        color: var(--headingColor);
        margin-bottom: 16px;
        line-height: 1.3;
        transition: color var(--transition);
    }

    .svc-card__text {
        color: var(--contentColor);
        margin-bottom: 0;
        line-height: 1.7;
        transition: color var(--transition);
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

    @media (prefers-reduced-motion: reduce) {
        .svc-card,
        .svc-card__icon,
        .svc-card__icon img,
        .svc-card__icon i,
        .svc-card__arrow,
        .svc-card__arrow svg path,
        .svc-card__title,
        .svc-card__text {
            transition: none !important;
        }
        .svc-card:hover { transform: none; }
        .svc-card:hover .svc-card__icon,
        .svc-card:hover .svc-card__icon img,
        .svc-card:hover .svc-card__icon i,
        .svc-card:hover .svc-card__arrow {
            transform: none;
        }
    }
</style>
@endpush