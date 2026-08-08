@extends('layouts.front')

@section('title', ($appSetting->app_name ?? config('app.name')) . ' | Home')

@section('content')

@php
    $heroSlides = \App\Models\HeroSlide::active()->get();
@endphp

<!-- herobanner__section__start -->
<div class="herobanner herobanner__with__transparent__header" id="tb__home"
     style="background: url({{ $heroSlides->first()->background_image_url ?? asset('website/img/herobaner/herobanner__1.jpg') }});">
    <div class="container">
        <div class="herobanner__wrapper">
            <div class="herobanner__slider__active swiper">
                <div class="swiper-wrapper">

                    @forelse($heroSlides as $slide)
                        <div class="herobanner__single swiper-slide position-relative">
                            <div class="row align-items-center height__950">
                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12" data-aos="fade-up" data-aos-duration="1500">
                                    <div class="herobanner__content__wrapper">
                                        <div class="herobanner__title">
                                            <h1>{{ $slide->title }}</h1>
                                        </div>
                                        @if($slide->description)
                                            <div class="herobanner__text">
                                                <p>{{ $slide->description }}</p>
                                            </div>
                                        @endif
                                        @if($slide->button_text)
                                            <div class="herobanner__button">
                                                <a class="default__button" href="{{ $slide->button_link ?: '#tb__service' }}">{{ $slide->button_text }}</a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 ">
                                    <div class="herobanner__img herobanner__img--position">
                                        <img src="{{ $slide->image_url ?? asset('website/img/herobaner/herobanner__front__1.png') }}" alt="{{ $slide->title }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        {{-- No slides configured yet in admin — sensible default so the homepage never looks empty --}}
                        <div class="herobanner__single swiper-slide position-relative">
                            <div class="row align-items-center height__950">
                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12" data-aos="fade-up" data-aos-duration="1500">
                                    <div class="herobanner__content__wrapper">
                                        <div class="herobanner__title">
                                            <h1>WE ARE CONSULTING AGENCY</h1>
                                        </div>
                                        <div class="herobanner__text">
                                            <p>Sagittis purus amet volutpat consequat mauris nunc congue nisi and tortor.</p>
                                        </div>
                                        <div class="herobanner__button">
                                            <a class="default__button" href="#tb__service">OUR ALL SERVICES</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 ">
                                    <div class="herobanner__img herobanner__img--position">
                                        <img src="{{ asset('website/img/herobaner/herobanner__front__1.png') }}" alt="Hero Banner">
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforelse

                </div>
                <div class="slider__controls__wrap slider__controls__pagination slider__controls__arrows herobanner__arrow__1">
                    <div class="swiper-button-next arrow-btn">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M14.4297 5.92999L20.4997 12L14.4297 18.07" stroke="#fff" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M3.5 12H20.33" stroke="#fff" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                    <div class="swiper-button-prev arrow-btn">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M9.57031 5.92999L3.50031 12L9.57031 18.07" stroke="#fff" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                            <path d="M20.5 12H3.67" stroke="#fff" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        
    </div>
    <div class="herobanner__icon">
        <img class="herobanner__vector hero__icon__1" src="{{ asset('website/img/herobaner/vector__1.png') }}" alt="Vector photo">
        <img class="herobanner__vector hero__icon__2" src="{{ asset('website/img/herobaner/vector__2.png') }}" alt="Vector photo">
        <img class="herobanner__vector hero__icon__3" src="{{ asset('website/img/herobaner/vector__3.png') }}" alt="Vector photo">
        <img class="herobanner__vector hero__icon__4" src="{{ asset('website/img/herobaner/vector__4.png') }}" alt="Vector photo">
    </div>

</div>

  <div class="header__animate">
        <div class="container-fluid">
            <div class="header__animate__wraper">

            <div class="header__animate__item">
    <img src="{{ asset('website/img/brand/brand__4.png') }}" alt="Regulatory Compliance">
    <h3>REGULATORY COMPLIANCE</h3>
</div>

<div class="header__animate__item">
    <img src="{{ asset('website/img/brand/brand__4.png') }}" alt="Human Resources Compliance">
    <h3>HUMAN RESOURCES COMPLIANCE</h3>
</div>

<div class="header__animate__item">
    <img src="{{ asset('website/img/brand/brand__4.png') }}" alt="Marketing & Media Management">
    <h3>MARKETING & MEDIA MANAGEMENT</h3>
</div>

<div class="header__animate__item">
    <img src="{{ asset('website/img/brand/brand__4.png') }}" alt="Website Development & Hosting">
    <h3>WEBSITE DEVELOPMENT & HOSTING</h3>
</div>

<div class="header__animate__item">
    <img src="{{ asset('website/img/brand/brand__4.png') }}" alt="Regulatory Compliance">
    <h3>REGULATORY COMPLIANCE</h3>
</div>

<div class="header__animate__item">
    <img src="{{ asset('website/img/brand/brand__4.png') }}" alt="Human Resources Compliance">
    <h3>HUMAN RESOURCES COMPLIANCE</h3>
</div>

<div class="header__animate__item">
    <img src="{{ asset('website/img/brand/brand__4.png') }}" alt="Marketing & Media Management">
    <h3>MARKETING & MEDIA MANAGEMENT</h3>
</div>

<div class="header__animate__item">
    <img src="{{ asset('website/img/brand/brand__4.png') }}" alt="Website Development & Hosting">
    <h3>WEBSITE DEVELOPMENT & HOSTING</h3>
</div>
            
        </div> 
        </div>
    </div>

            <!-- about__section__start -->
        <div class="about about__grident__bg about__white__bg position-relative sp_bottom_120 sp_top_160" id="tb__about"
             style="background: var(--pinkcolor) url({{ asset('website/img/about/about__bg__img.png') }});">
            <div class="container">
                <div class="row">
              
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12" data-aos="fade-up" data-aos-duration="1500">
                        <div class="about__inner about__inner--2">

                            <div class="section__title  section__title--2 section__title--3">
                                <div class="section__title__button">
                                    <span>About</span>
                                </div>
                                <div class="section__title__heading">
                                    <h3>Empowering Businesses with Compliance, Digital Solutions & Strategic Growth</h3>
                                </div>
    
                            </div>

                            <div class="about__vision__wrapper about__vision__wrapper--3">
                            <div class="about__number">
                                <div class="about__number__inner">
                                    <span style="font-size: 38px;">Khattak</span>
                                    <p> Consultancy</p>
                                    <div class="about__number__icon">
                                        <a href="#">  <svg width="34" height="34" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                                          <path d="M14.4258 10.9897L23.0101 10.9897L23.0101 19.574" stroke="#0A0624" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                          <path d="M10.9902 23.0107L22.8908 11.1101" stroke="#0A0624" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"></path>
                                          </svg></a>
                                      </div>
                                </div>
                            
                            </div>
                            <div class="about__text__wrapper">
                            <div class="about__misson">
                                <h6> Mission & Vision</h6>
                            </div>
                            <div class="about__text__2">
                                <p>At Khattak consultancy, our mission is to provide expert advice and guidance to businesses in need of strategic planning, marketing, and financial management. 



Our team of experienced consultants has a proven track record of success in helping businesses achieve their goals and reach their full potential. 



We are dedicated to providing personalized services tailored to meet the unique needs of each of our clients. Contact us today to learn how we can help your business thrive.</p>
                            </div>
                            <div class="about__button">
                                <a class="default__button btn__white" href="#">LEARN MORE ABOUT</a>
                            </div>
                        </div>
                        </div>
                       

                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12" data-aos="fade-up" data-aos-duration="1800">
                        <div class="about__img__3" data-tilt>
                            <img src="{{ asset('website/img/about/about__4.png') }}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
         <!-- about__section__end-->
<!-- herobanner__section__end -->

<!-- service__section__start -->
<div class="service sp_top_140 sp_bottom_330 special__spacing" id="tb__service" style="background: var(--pinkcolor) url({{ asset('website/img/service/service__bg__img.png') }});" data-aos="fade-up">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="section__title text-center sp_bottom_90">
                    <div class="section__title__heading">
                        <h3>Strategic Advisory Services</h3>
                    </div>
                    <div class="section__title__text">
                        <p>Practical advisory solutions designed to help businesses strengthen compliance, improve operations, support workforce management, and achieve sustainable growth.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @php
                $services = \App\Models\Service::active()->get();
                $fallbackServices = [
                    ['title' => 'Agency Consulting', 'description' => 'Sagittis purus sit amet volutpat consequat mauris nunc congue nisi', 'icon' => asset('website/img/service/service__1.png')],
                    ['title' => 'HR Consulting', 'description' => 'Sagittis purus sit amet volutpat consequat mauris nunc congue nisi', 'icon' => asset('website/img/service/service__2.png')],
                    ['title' => 'IT Consulting', 'description' => 'Sagittis purus sit amet volutpat consequat mauris nunc congue nisi', 'icon' => asset('website/img/service/service__3.png')],
                    ['title' => 'Legal Consulting', 'description' => 'Sagittis purus sit amet volutpat consequat mauris nunc congue nisi', 'icon' => asset('website/img/service/service__4.png')],
                ];
            @endphp
 
            @forelse($services as $index => $service)
                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12" data-aos="fade-up" data-aos-duration="{{ 1500 + $index * 200 }}">
                    <div class="service__single__wraper common__gradient__bg single__transform">
                        <div class="service__single__inner">
                            <div class="service__img">
                                <img src="{{ $service->icon_url ?? asset('website/img/service/service__1.png') }}" alt="{{ $service->title }}">
                            </div>
                            <div class="service__content">
                                <div class="service__heading"><h5><a href="{{ $service->link_or_default }}">{{ $service->title }}</a></h5></div>
                                @if($service->description)
                                    <div class="service__text"><p>{{ $service->description }}</p></div>
                                @endif
                                <div class="service__icon">
                                    <a href="{{ $service->link_or_default }}"><svg width="34" height="34" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M14.4258 10.9897L23.0101 10.9897L23.0101 19.574" stroke="#0A0624" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        <path d="M10.9902 23.0107L22.8908 11.1101" stroke="#0A0624" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg></a>
                                </div>
                            </div>
                        </div>
                        <div class="service__img__bg"><img src="{{ asset('website/img/service/service__1__img__bg.svg') }}" alt=""></div>
                    </div>
                </div>
            @empty
                {{-- No services configured yet in admin — sensible defaults so this section never looks empty --}}
                @foreach($fallbackServices as $index => $fallback)
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-6 col-12" data-aos="fade-up" data-aos-duration="{{ 1500 + $index * 200 }}">
                        <div class="service__single__wraper common__gradient__bg single__transform">
                            <div class="service__single__inner">
                                <div class="service__img"><img src="{{ $fallback['icon'] }}" alt="{{ $fallback['title'] }}"></div>
                                <div class="service__content">
                                    <div class="service__heading"><h5><a href="#tb__service">{{ $fallback['title'] }}</a></h5></div>
                                    <div class="service__text"><p>{{ $fallback['description'] }}</p></div>
                                    <div class="service__icon">
                                        <a href="#tb__service"><svg width="34" height="34" viewBox="0 0 34 34" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M14.4258 10.9897L23.0101 10.9897L23.0101 19.574" stroke="#0A0624" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                            <path d="M10.9902 23.0107L22.8908 11.1101" stroke="#0A0624" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg></a>
                                    </div>
                                </div>
                            </div>
                            <div class="service__img__bg"><img src="{{ asset('website/img/service/service__1__img__bg.svg') }}" alt=""></div>
                        </div>
                    </div>
                @endforeach
            @endforelse
        </div>
    </div>
    <div class="section__strock__line__animation">
        <img class="ssla__animation service__line__animation" src="{{ asset('website/img/service/service__small__img.png') }}" alt="">
    </div>
</div>
<!-- service__section__end -->

<!-- about__section__start -->
<div class="about position-relative sp_bottom_140" >
    <div class="container">
        <div class="row">
            <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12" data-aos="fade-up" data-aos-duration="1500">
                <div class="about__img__wrapper position-relative" data-tilt>
                    <img class="about__img__1" src="{{ asset('website/img/about/about__1.png') }}" alt="">
                    <div class="about__number">
                        <div class="about__number__inner about__number__position">
                            <span>10</span>
                            <p>Years Experience</p>
                        </div>
                    </div>
                    <div class="section__strock__line__animation">
                        <img class="ssla__animation ssl__img__1" src="{{ asset('website/img/about/about__small__img__1.png') }}" alt="">
                        <img class="ssla__animation ssl__img__2" src="{{ asset('website/img/about/about__small__img__2.png') }}" alt="">
                    </div>
                </div>
            </div>
            <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12" data-aos="fade-up" data-aos-duration="2000">
                <div class="about__inner">
                    <div class="section__title section__title--2 sp_bottom_30">
                        <div class="section__title__heading">
                            <h3>WE HELP BUSINESSES SCALE WITH CLARITY, STRUCTURE AND CONFIDENCE</h3>
                        </div>
                        <div class="section__title__text">
                            <p><span class="text__gradient">Growth</span> creates complexity and many businesses struggle with:</p>
                        </div>
                    </div>
                   <div class="about__list">
                            <ul>
                                <li><i class="icofont-check"></i>Operational inefficiencies</li>
                                <li><i class="icofont-check"></i>Weak internal structure</li>
                                <li><i class="icofont-check"></i>Compliance and regulatory challenges</li>
                                <li><i class="icofont-check"></i>Inconsistent marketing</li>
                                <li><i class="icofont-check"></i>Competitive compensation</li>
                                <li><i class="icofont-check"></i>A positive workplace culture</li>
                            </ul>
                        </div>

                        
                
                    <div class="about__text__3"><p>We help organisations solve these challanges through practical advisory, frameworks, complaince support, HR guidance and record keeping, Marketing strategies designed for sustainable, long term growth</p></div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- about__section__end-->

@php
    $projects = \App\Models\Project::active()->get();
    $fallbackProjects = [
        ['title' => 'Business Process Optimization', 'image' => asset('website/img/project/project__5.png')],
        ['title' => 'Market Research and Analysis', 'image' => asset('website/img/project/project__6.png')],
        ['title' => 'Risk Assessment and Management', 'image' => asset('website/img/project/project__7.png')],
    ];
@endphp

<!-- project__section__start -->
<div class="project sp_bottom_80 special__spacing" id="tb__projects">
    <div class="project__margin">
        <div class="container sp_top_100">
            <div class="row align-items-center" data-aos="fade-up" data-aos-duration="1500">
                <div class="col-xl-4 col-lg-3 col-md-6 col-sm-12">
                    <div class="section__title section__title--2  sp_bottom_30">
                        <div class="section__title__button">
                            <span class="text__gradient">Our Project</span>
                        </div>
                        <div class="section__title__heading">
                            <h3>COMPLETE PROJECTS</h3>
                        </div>

                    </div>
                </div>
                <div class="col-xl-2 col-lg-3 col-md-6 col-sm-12">
                    <div class="project__bottom__img text-center">
                        <img src="{{ asset('website/img/project/project__small__img__2.png') }}" alt="">
                    </div>
                </div>
                <div class="col-xl-6 col-lg-6 col-md-6  col-sm-12">
                    <div class="project__bottom__text">
                        From HR compliance to sales tracking and AI-driven marketing, we build the systems that keep businesses running smoothly — <a href="#">explore a few of the platforms we've delivered</a> for clients across finance, HR, and marketing
                    </div>
                </div>
            </div>
        </div>
        <div class="container  sp_bottom_60 sp_top_30 ">

            <div class="row">

                @forelse($projects as $index => $project)
                    <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12" data-aos="fade-up" data-aos-duration="{{ 1800 + $index * 300 }}">
                        <div class="project__single single__transform">
                            <div class="project__img project__img--2">
                                <img src="{{ $project->image_url ?? asset('website/img/project/project__5.png') }}" alt="{{ $project->title }}">
                                <div class="project__heading project__heading--2">
                                    <h3><a href="{{ $project->link_or_default }}" style="color: #fff;">{{ $project->title }}</a></h3>
                                </div>
                                <div class="project__icon project__icon--2">
                                    <a class="direction__btn" href="{{ $project->link_or_default }}"><svg width="34"
                                            height="34" viewBox="0 0 34 34" fill="none"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path d="M14.4258 10.9897L23.0101 10.9897L23.0101 19.574"
                                                stroke="#0A0624" stroke-width="1.5"
                                                stroke-miterlimit="10" stroke-linecap="round"
                                                stroke-linejoin="round" />
                                            <path d="M10.9902 23.0107L22.8908 11.1101" stroke="#0A0624"
                                                stroke-width="1.5" stroke-miterlimit="10"
                                                stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </a>
                                </div>

                            </div>

                        </div>
                    </div>
                @empty
                    {{-- No projects configured yet in admin — sensible defaults so this section never looks empty --}}
                    @foreach($fallbackProjects as $index => $fallback)
                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-6 col-12" data-aos="fade-up" data-aos-duration="{{ 1800 + $index * 300 }}">
                            <div class="project__single single__transform">
                                <div class="project__img project__img--2">
                                    <img src="{{ $fallback['image'] }}" alt="{{ $fallback['title'] }}">
                                    <div class="project__heading project__heading--2">
                                        <h3><a href="#">{{ $fallback['title'] }}</a></h3>
                                    </div>
                                    <div class="project__icon project__icon--2">
                                        <a class="direction__btn" href="#"><svg width="34"
                                                height="34" viewBox="0 0 34 34" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path d="M14.4258 10.9897L23.0101 10.9897L23.0101 19.574"
                                                    stroke="#0A0624" stroke-width="1.5"
                                                    stroke-miterlimit="10" stroke-linecap="round"
                                                    stroke-linejoin="round" />
                                                <path d="M10.9902 23.0107L22.8908 11.1101" stroke="#0A0624"
                                                    stroke-width="1.5" stroke-miterlimit="10"
                                                    stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @endforelse

            </div>
            <div class="col-xl-12" data-aos="fade-up" data-aos-duration="1500">
                <div class="project__bottom__button sp_top_30 text-center">
                    <a class="default__button btn__black " href="#">VIEW OTHER PROJECT</a>
                </div>
            </div>
            <div class="project__small__img">
                <img class="project__img__1" src="{{ asset('website/img/project/project__small__img.png') }}" alt="">
                <img class="project__img__2" src="{{ asset('website/img/project/project__small__img__1.png') }}" alt="">
            </div>
        </div>

    </div>
</div>
<!-- project__section__end -->

@php
    $teamMembers = \App\Models\TeamMember::active()->get();
    $fallbackTeam = [
        ['name' => 'GINGER GRIFFITH', 'designation' => 'Founder & CEO', 'photo' => asset('website/img/team/team_5.png')],
        ['name' => 'SABRINA TUCKER', 'designation' => 'Project Manager', 'photo' => asset('website/img/team/team_6.png')],
        ['name' => 'WILLIAM GURRERO', 'designation' => 'Web Developer', 'photo' => asset('website/img/team/team_7.png')],
        ['name' => 'MARION GRAHAM', 'designation' => 'UI/UX Designer', 'photo' => asset('website/img/team/team_8.png')],
    ];
@endphp

<!-- team__member__start -->
<div class="team__member sp_top_140 sp_bottom_140" data-aos="fade-up" data-aos-duration="1500">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="section__title text-center sp_bottom_90">
                    <div class="section__title__button">
                        <span class="text__gradient">Our Team</span>
                    </div>
                    <div class="section__title__heading">
                        <h3>MEET THE PEOPLE BEHIND OUR WORK.</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row position-relative">

            <div class="team__slider__active swiper team__padding">
                <div class="swiper-wrapper">

                    @forelse($teamMembers as $index => $member)
                        <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 swiper-slide" data-aos="fade-up" data-aos-duration="{{ 1500 + $index * 300 }}">
                            <div class="team__member__single common__gradient__bg single__transform">
                                <div class="team__member__single__inner">
                                    <div class="team__member__img">
                                        <img src="{{ $member->photo_url ?? asset('website/img/team/team_5.png') }}" alt="{{ $member->name }}">
                                    </div>

                                    <div class="team__member__name">
                                        <h6><a href="{{ $member->link_or_default }}">{{ strtoupper($member->name) }}</a></h6>
                                        @if($member->designation)
                                            <p>{{ $member->designation }}</p>
                                        @endif
                                    </div>
                                    <div class="team__member__icon team__member__icon--2">
                                        <ul>
                                            @if($member->facebook_url)
                                                <li><a href="{{ $member->facebook_url }}" target="_blank"><i class="icofont-facebook"></i></a></li>
                                            @endif
                                            @if($member->twitter_url)
                                                <li><a href="{{ $member->twitter_url }}" target="_blank"><i class="icofont-twitter"></i></a></li>
                                            @endif
                                            @if($member->skype_url)
                                                <li><a href="{{ $member->skype_url }}" target="_blank"><i class="icofont-skype"></i></a></li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        {{-- No team members configured yet in admin — sensible defaults so this section never looks empty --}}
                        @foreach($fallbackTeam as $index => $fallback)
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 swiper-slide" data-aos="fade-up" data-aos-duration="{{ 1500 + $index * 300 }}">
                                <div class="team__member__single common__gradient__bg single__transform">
                                    <div class="team__member__single__inner">
                                        <div class="team__member__img">
                                            <img src="{{ $fallback['photo'] }}" alt="{{ $fallback['name'] }}">
                                        </div>
                                        <div class="team__member__name">
                                            <h6><a href="#">{{ $fallback['name'] }}</a></h6>
                                            <p>{{ $fallback['designation'] }}</p>
                                        </div>
                                        <div class="team__member__icon team__member__icon--2">
                                            <ul>
                                                <li><a href="#"><i class="icofont-facebook"></i></a></li>
                                                <li><a href="#"><i class="icofont-twitter"></i></a></li>
                                                <li><a href="#"><i class="icofont-skype"></i></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endforelse

                </div>
            </div>

            <div class="slider__controls__wrap slider__controls__pagination slider__controls__arrows">
                <div class="swiper-button-next arrow-btn arrow-btn-2">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M14.4297 5.92999L20.4997 12L14.4297 18.07" stroke="#fff" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M3.5 12H20.33" stroke="#fff" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <div class="swiper-button-prev arrow-btn arrow-btn-2">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.57031 5.92999L3.50031 12L9.57031 18.07" stroke="#fff" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M20.5 12H3.67" stroke="#fff" stroke-width="1.5" stroke-miterlimit="10" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
            </div>

        </div>
    </div>
</div>
<!-- team__member__end -->


        <!-- pink__color__start -->
           <!-- <div class="pink__color"> </div>         -->
         



<!-- contact__section__start -->
<div class="contact sp_bottom_140" id="tb__contact">
    <div class="container">
        <div class="row">
            <div class="col-xl-12" data-aos="fade-up" data-aos-duration="1500">
                <div class="section__title text-center sp_bottom_70">
                    <div class="section__title__button">
                        <span class="text__gradient">Contact Us</span>
                    </div>
                    <div class="section__title__heading">
                        <h3>CONSULTING SUPPORT IS JUST A CALL OR EMAIL AWAY.</h3>
                    </div>

                </div>
            </div>

            <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12" data-aos="fade-up" data-aos-duration="1500">

                @if(session('status'))
                    <div class="alert alert-success">{{ session('status') }}</div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('contact.store') }}" method="POST">
                    @csrf
                    <div class="contact__input__wrapper">
                        <div class="row">
                            <div class="col-xl-6">
                                <div class="contact__input">
                                    <input class="contact__common__input" type="text" name="first_name"
                                           value="{{ old('first_name') }}" placeholder="First Name" required>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="contact__input">
                                    <input class="contact__common__input" type="text" name="last_name"
                                           value="{{ old('last_name') }}" placeholder="Last Name">
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="contact__input">
                                    <input class="contact__common__input" type="email" name="email"
                                           value="{{ old('email') }}" placeholder="Email" required>
                                </div>
                            </div>
                            <div class="col-xl-6">
                                <div class="contact__input">
                                    <input class="contact__common__input" type="text" name="phone"
                                           value="{{ old('phone') }}" placeholder="Phone">
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <select class="contact__common__input" name="subject" id="subject">
                                    <option value="" {{ old('subject') === null ? 'selected' : '' }}>Subject:</option>
                                    <option value="General Enquiry" {{ old('subject') === 'General Enquiry' ? 'selected' : '' }}>General Enquiry</option>
                                    <option value="Consulting Services" {{ old('subject') === 'Consulting Services' ? 'selected' : '' }}>Consulting Services</option>
                                    <option value="Careers" {{ old('subject') === 'Careers' ? 'selected' : '' }}>Careers</option>
                                </select>
                            </div>
                            <div class="col-xl-12">
                                <textarea class="contact__common__input" name="message" id="message" cols="30" rows="10"
                                          placeholder="Write a message...." required>{{ old('message') }}</textarea>
                            </div>
                            <div class="col-xl-12">
                                <div class="contact__button">
                                    <button type="submit" class="default__button" style="border:0;">SEND MESSAGE</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

            </div>

           <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 contact__info__right" data-aos="fade-up" data-aos-duration="1500">
                <div class="contact__info">

                    {{-- ============== Opening hours: dynamic from Settings ============== --}}
                    <div class="contact__single__item" data-aos="fade-up" data-aos-duration="1500">
                        <div class="contact__icon">
                            <span>
                                <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1501_3784)">
                                    <path d="M21.3388 3.66116C18.9779 1.30024 15.8388 0 12.5 0C9.16119 0 6.02207 1.30024 3.66116 3.66116C1.30024 6.02207 0 9.16119 0 12.5C0 15.8388 1.30024 18.9779 3.66116 21.3388C6.02207 23.6998 9.16119 25 12.5 25C15.8388 25 18.9779 23.6998 21.3388 21.3388C23.6998 18.9779 25 15.8388 25 12.5C25 9.16119 23.6998 6.02207 21.3388 3.66116ZM13.2257 23.5107V22.0125C13.2257 21.608 12.8979 21.2801 12.4933 21.2801C12.089 21.2801 11.7609 21.608 11.7609 22.0125V23.5098C6.26163 23.1443 1.85204 18.7326 1.48983 13.2324H3.11508C3.51944 13.2324 3.8475 12.9045 3.8475 12.5C3.8475 12.0955 3.51944 11.7676 3.11508 11.7676H1.48983C1.85223 6.26297 6.26869 1.8486 11.7743 1.48926V3.0365C11.7743 3.44105 12.1021 3.76892 12.5067 3.76892C12.911 3.76892 13.2391 3.44105 13.2391 3.0365V1.49021C18.7384 1.85566 23.148 6.26736 23.5102 11.7676H22.0022C21.5979 11.7676 21.2698 12.0955 21.2698 12.5C21.2698 12.9045 21.5979 13.2324 22.0022 13.2324H23.5102C23.1478 18.737 18.7313 23.1514 13.2257 23.5107Z" fill="url(#paint0_linear_1501_3784)"/>
                                    <path d="M14.4014 13.5136C14.5632 13.2111 14.6553 12.8663 14.6553 12.5001C14.6553 12.2529 14.613 12.0152 14.5359 11.794L17.1404 9.18948C17.4263 8.90356 17.4263 8.4397 17.1404 8.15379C16.8543 7.86768 16.3906 7.86768 16.1045 8.15379L13.607 10.6513C13.283 10.4565 12.9042 10.3442 12.4994 10.3442C11.3108 10.3442 10.3438 11.3114 10.3438 12.5001C10.3438 13.6887 11.3108 14.6557 12.4994 14.6557C12.7871 14.6557 13.0615 14.5987 13.3125 14.4961L18.4605 19.644C18.6035 19.7871 18.791 19.8586 18.9783 19.8586C19.1658 19.8586 19.3533 19.7871 19.4964 19.644C19.7823 19.3581 19.7823 18.8943 19.4964 18.6083L14.4014 13.5136ZM11.8084 12.5001C11.8084 12.119 12.1185 11.809 12.4994 11.809C12.8803 11.809 13.1905 12.1192 13.1905 12.5001C13.1905 12.881 12.8803 13.1911 12.4994 13.1911C12.1185 13.1911 11.8084 12.8811 11.8084 12.5001Z" fill="url(#paint1_linear_1501_3784)"/>
                                    </g>
                                    <defs>
                                    <linearGradient id="paint0_linear_1501_3784" x1="5.10511e-08" y1="14.6552" x2="25" y2="14.6552" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#3E5B54"/>
                                    <stop offset="0.479167" stop-color="#4F6B63"/>
                                    <stop offset="1" stop-color="#607570"/>
                                    </linearGradient>
                                    <linearGradient id="paint1_linear_1501_3784" x1="10.3438" y1="14.9264" x2="19.7108" y2="14.9264" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#3E5B54"/>
                                    <stop offset="0.479167" stop-color="#4F6B63"/>
                                    <stop offset="1" stop-color="#607570"/>
                                    </linearGradient>
                                    <clipPath id="clip0_1501_3784">
                                    <rect width="25" height="25" fill="white"/>
                                    </clipPath>
                                    </defs>
                                </svg>
                            </span>
                        </div>
                        <div class="contact__text">
                            <h6>Hours:</h6>
                            @forelse($appSetting->formattedOpeningHours() ?? [] as $day => $hours)
                                <p>{{ $day }}: {{ $hours }}</p>
                            @empty
                                <p class="text-muted">Hours not set yet.</p>
                            @endforelse
                        </div>
                    </div>

                    {{-- ============== Phone/Email: dynamic from Settings ============== --}}
                    <div class="contact__single__item" data-aos="fade-up" data-aos-duration="1500">
                        <div class="contact__icon">
                            <span>
                                <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <g clip-path="url(#clip0_1501_3772)">
                                    <path d="M19.7592 15.4866C19.2474 14.9537 18.6301 14.6688 17.9758 14.6688C17.3268 14.6688 16.7042 14.9484 16.1713 15.4813L14.5039 17.1434C14.3667 17.0695 14.2295 17.0009 14.0976 16.9323C13.9077 16.8374 13.7283 16.7477 13.5753 16.6527C12.0134 15.6607 10.5941 14.368 9.23277 12.6954C8.57321 11.8617 8.13 11.1599 7.80813 10.4476C8.2408 10.0519 8.64181 9.64033 9.03226 9.24459C9.18 9.09685 9.32774 8.94384 9.47548 8.7961C10.5835 7.68805 10.5835 6.25286 9.47548 5.14482L8.03502 3.70435C7.87145 3.54078 7.70261 3.37194 7.54431 3.20309C7.22773 2.87596 6.89531 2.53826 6.55235 2.22168C6.04053 1.71514 5.42847 1.44604 4.78474 1.44604C4.14102 1.44604 3.5184 1.71514 2.99076 2.22168C2.98549 2.22696 2.98549 2.22696 2.98021 2.23223L1.18623 4.04204C0.510844 4.71743 0.125666 5.54055 0.0412429 6.49558C-0.0853912 8.03629 0.368381 9.47148 0.716625 10.4107C1.5714 12.7165 2.8483 14.8534 4.75309 17.1434C7.06416 19.903 9.84483 22.0821 13.0212 23.6176C14.2348 24.1927 15.8547 24.8734 17.6645 24.9894C17.7753 24.9947 17.8914 25 17.9969 25C19.2158 25 20.2394 24.562 21.0414 23.6914C21.0467 23.6809 21.0572 23.6756 21.0625 23.6651C21.3369 23.3326 21.6535 23.0319 21.9859 22.71C22.2128 22.4937 22.4449 22.2668 22.6718 22.0294C23.1942 21.4859 23.4685 20.8527 23.4685 20.2037C23.4685 19.5494 23.1889 18.9216 22.656 18.3939L19.7592 15.4866ZM21.6482 21.0427C21.6429 21.0427 21.6429 21.0479 21.6482 21.0427C21.4424 21.2643 21.2313 21.4648 21.0045 21.6864C20.6615 22.0135 20.3133 22.3565 19.9861 22.7417C19.4532 23.3115 18.8253 23.5806 18.0022 23.5806C17.923 23.5806 17.8386 23.5806 17.7595 23.5754C16.1924 23.4751 14.7361 22.863 13.6439 22.3407C10.6574 20.8949 8.03502 18.8424 5.85586 16.2411C4.0566 14.0725 2.85358 12.0675 2.05684 9.9147C1.56613 8.60087 1.38673 7.57725 1.46588 6.61166C1.51864 5.99432 1.75608 5.48251 2.19402 5.04456L3.99328 3.2453C4.25183 3.00259 4.5262 2.87068 4.7953 2.87068C5.12771 2.87068 5.39681 3.07118 5.56566 3.24003C5.57093 3.2453 5.57621 3.25058 5.58148 3.25586C5.90335 3.55661 6.20938 3.86792 6.53124 4.20034C6.69481 4.36918 6.86365 4.53803 7.0325 4.71215L8.47296 6.15261C9.03226 6.71191 9.03226 7.229 8.47296 7.7883C8.31995 7.94132 8.17221 8.09434 8.01919 8.24207C7.57597 8.69585 7.15386 9.11796 6.69481 9.52952C6.68426 9.54007 6.6737 9.54535 6.66843 9.5559C6.21465 10.0097 6.29908 10.4529 6.39405 10.7537C6.39933 10.7695 6.40461 10.7853 6.40988 10.8011C6.78451 11.7087 7.31215 12.5635 8.11417 13.5818L8.11944 13.5871C9.57574 15.3811 11.1112 16.7793 12.8049 17.8504C13.0212 17.9876 13.2428 18.0984 13.4539 18.204C13.6439 18.2989 13.8233 18.3886 13.9763 18.4836C13.9974 18.4942 14.0185 18.51 14.0396 18.5205C14.219 18.6102 14.3878 18.6525 14.562 18.6525C14.9999 18.6525 15.2743 18.3781 15.364 18.2884L17.1685 16.4838C17.3479 16.3044 17.6328 16.0881 17.9652 16.0881C18.2924 16.0881 18.5615 16.2939 18.725 16.4733C18.7303 16.4786 18.7303 16.4786 18.7356 16.4838L21.6429 19.3912C22.1864 19.9293 22.1864 20.4834 21.6482 21.0427Z" fill="url(#paint0_linear_1501_3772)"/>
                                    <path d="M13.5121 5.94676C14.8945 6.17892 16.1503 6.83319 17.1528 7.83571C18.1554 8.83823 18.8044 10.094 19.0418 11.4764C19.0998 11.8247 19.4006 12.0674 19.7436 12.0674C19.7858 12.0674 19.8227 12.0621 19.8649 12.0569C20.2554 11.9935 20.5139 11.6242 20.4506 11.2337C20.1657 9.5611 19.3742 8.03622 18.1659 6.82792C16.9576 5.61962 15.4327 4.82815 13.7601 4.54323C13.3696 4.47991 13.0056 4.73846 12.937 5.12363C12.8684 5.50881 13.1217 5.88344 13.5121 5.94676Z" fill="url(#paint1_linear_1501_3772)"/>
                                    <path d="M24.9734 11.028C24.5038 8.27374 23.2058 5.76744 21.2114 3.77295C19.2169 1.77846 16.7106 0.480461 13.9563 0.0108597C13.5711 -0.0577338 13.207 0.206087 13.1384 0.591266C13.0751 0.981721 13.3337 1.34579 13.7241 1.41439C16.1829 1.83123 18.4254 2.99731 20.2088 4.77547C21.9923 6.5589 23.1531 8.80138 23.5699 11.2602C23.628 11.6084 23.9287 11.8511 24.2717 11.8511C24.3139 11.8511 24.3508 11.8459 24.393 11.8406C24.7782 11.7826 25.042 11.4132 24.9734 11.028Z" fill="url(#paint2_linear_1501_3772)"/>
                                    </g>
                                    <defs>
                                    <linearGradient id="paint0_linear_1501_3772" x1="0.0195313" y1="15.2535" x2="23.4685" y2="15.2535" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#3E5B54"/>
                                    <stop offset="0.479167" stop-color="#4F6B63"/>
                                    <stop offset="1" stop-color="#607570"/>
                                    </linearGradient>
                                    <linearGradient id="paint1_linear_1501_3772" x1="12.9258" y1="8.95" x2="20.4601" y2="8.95" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#3E5B54"/>
                                    <stop offset="0.479167" stop-color="#4F6B63"/>
                                    <stop offset="1" stop-color="#607570"/>
                                    </linearGradient>
                                    <linearGradient id="paint2_linear_1501_3772" x1="13.1289" y1="6.94722" x2="24.9843" y2="6.94722" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#3E5B54"/>
                                    <stop offset="0.479167" stop-color="#4F6B63"/>
                                    <stop offset="1" stop-color="#607570"/>
                                    </linearGradient>
                                    <clipPath id="clip0_1501_3772">
                                    <rect width="25" height="25" fill="white"/>
                                    </clipPath>
                                    </defs>
                                </svg>
                            </span>
                        </div>
                        <div class="contact__text">
                            <h6>Call Us:</h6>
                            @if($appSetting->phone ?? false)
                                <p>{{ $appSetting->phone }}</p>
                            @endif
                            @if($appSetting->email ?? false)
                                <p>{{ $appSetting->email }}</p>
                            @endif
                            @if(! ($appSetting->phone ?? false) && ! ($appSetting->email ?? false))
                                <p class="text-muted">Not set yet.</p>
                            @endif
                        </div>
                    </div>

                    {{-- ============== Address: dynamic from Settings ============== --}}
                    <div class="contact__single__item" data-aos="fade-up" data-aos-duration="1500">
                        <div class="contact__icon">
                            <span>
                                <svg width="25" height="25" viewBox="0 0 25 25" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M19.9763 3.09698C17.9792 1.09986 15.3239 0 12.4995 0C9.67521 0 7.01983 1.09986 5.02276 3.09698C3.02564 5.09415 1.92578 7.74943 1.92578 10.5737C1.92578 16.2872 7.32804 21.0394 10.2303 23.5924C10.6337 23.9472 10.982 24.2536 11.2594 24.5128C11.6071 24.8375 12.0533 25 12.4995 25C12.9457 25 13.3919 24.8375 13.7396 24.5128C14.0171 24.2536 14.3654 23.9472 14.7687 23.5924C17.671 21.0393 23.0732 16.2872 23.0732 10.5737C23.0732 7.74943 21.9734 5.09415 19.9763 3.09698ZM13.8014 22.4929C13.3892 22.8555 13.0333 23.1686 12.7399 23.4427C12.6051 23.5685 12.3939 23.5686 12.2591 23.4427C11.9656 23.1685 11.6097 22.8554 11.1975 22.4929C8.46901 20.0927 3.39014 15.625 3.39014 10.5738C3.39014 5.55089 7.47652 1.4645 12.4994 1.4645C17.5223 1.4645 21.6087 5.55089 21.6087 10.5738C21.6087 15.625 16.5299 20.0927 13.8014 22.4929Z" fill="url(#paint0_linear_1501_3759)"/>
                                    <path d="M12.4996 5.51465C9.93018 5.51465 7.83984 7.60494 7.83984 10.1743C7.83984 12.7437 9.93018 14.834 12.4996 14.834C15.069 14.834 17.1592 12.7437 17.1592 10.1743C17.1592 7.60494 15.069 5.51465 12.4996 5.51465ZM12.4996 13.3695C10.7377 13.3695 9.3043 11.9361 9.3043 10.1743C9.3043 8.41246 10.7377 6.97906 12.4996 6.97906C14.2614 6.97906 15.6948 8.41246 15.6948 10.1743C15.6948 11.9361 14.2614 13.3695 12.4996 13.3695Z" fill="url(#paint1_linear_1501_3759)"/>
                                    <defs>
                                    <linearGradient id="paint0_linear_1501_3759" x1="1.92578" y1="14.6551" x2="23.0732" y2="14.6551" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#3E5B54"/>
                                    <stop offset="0.479167" stop-color="#4F6B63"/>
                                    <stop offset="1" stop-color="#607570"/>
                                    </linearGradient>
                                    <linearGradient id="paint1_linear_1501_3759" x1="7.83984" y1="10.9777" x2="17.1592" y2="10.9777" gradientUnits="userSpaceOnUse">
                                    <stop stop-color="#3E5B54"/>
                                    <stop offset="0.479167" stop-color="#4F6B63"/>
                                    <stop offset="1" stop-color="#607570"/>
                                    </linearGradient>
                                    </defs>
                                </svg>
                            </span>
                        </div>
                        <div class="contact__text">
                            <h6>Location:</h6>
                            @if($appSetting->address ?? false)
                                <p>{{ $appSetting->address }}</p>
                            @else
                                <p class="text-muted">Address not set yet.</p>
                            @endif
                        </div>
                    </div>

                </div>
                <div class="contact__img" data-aos="fade-up" data-aos-duration="1500">
                    <img src="{{ asset('website/img/contact/contact.png') }}" alt="">
                </div>
            </div>

            @if($appSetting->map_url ?? false)
                <div class="col-12 mt-4" data-aos="fade-up" data-aos-duration="1500">
                    <div class="ratio ratio-21x9">
                        <iframe src="{{ $appSetting->map_url }}" style="border:0;" loading="lazy" allowfullscreen></iframe>
                    </div>
                </div>
            @endif

        </div>
    </div>
</div>
<!-- contact__section__end -->



@endsection


@push('scripts')
<script>
    (function () {
        function initHeroAutoplay() {
            const heroEl = document.querySelector('.herobanner__slider__active');
            if (!heroEl || typeof Swiper === 'undefined') return;
 
            // The theme's own main.js likely already initialized this
            // slider without autoplay. Re-initialize it here with
            // autoplay + smoother transitions, rather than fighting
            // over the same instance.
            if (heroEl.swiper) {
                heroEl.swiper.destroy(true, true);
            }
 
            const heroSwiper = new Swiper(heroEl, {
                loop: true,
                speed: 650,
                autoplay: {
                    delay: 2000,
                    disableOnInteraction: false,
                    pauseOnMouseEnter: true,
                },
                navigation: {
                    nextEl: heroEl.querySelector('.swiper-button-next'),
                    prevEl: heroEl.querySelector('.swiper-button-prev'),
                },
                on: {
                    slideChangeTransitionStart: replayActiveSlideAnimation,
                    init: replayActiveSlideAnimation,
                },
            });
 
            function replayActiveSlideAnimation(swiper) {
                const activeSlide = heroEl.querySelector('.swiper-slide-active');
                if (!activeSlide) return;
 
                [activeSlide.querySelector('.herobanner__content__wrapper'), activeSlide.querySelector('.herobanner__img')]
                    .forEach(el => {
                        if (!el) return;
                        el.style.animation = 'none';
                        void el.offsetWidth; // force reflow so the animation restarts
                        el.style.animation = '';
                    });
            }
        }
 
        // Give the theme's own main.js a moment to run first, then take over.
        window.addEventListener('load', () => setTimeout(initHeroAutoplay, 100));
    })();
</script>
@endpush