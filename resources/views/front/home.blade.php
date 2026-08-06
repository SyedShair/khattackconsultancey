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
                                <h3>WE OFFER CONSULTANCY SERVICES.</h3>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row position-relative">

                    <div class="team__slider__active swiper team__padding">
                        <div class="swiper-wrapper">
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 swiper-slide" data-aos="fade-up" data-aos-duration="1500">
                                <div class="team__member__single common__gradient__bg single__transform">
                                    <div class="team__member__single__inner">
                                        <div class="team__member__img">
                                            <img src="img/team/team_5.png" alt="">
                                        </div>

                                        <div class="team__member__name">
                                            <h6><a href="team-details.html">GINGER GRIFFITH</a></h6>
                                            <p>Founder & CEO</p>
                                        </div>
                                        <div class="team__member__icon team__member__icon--2">
                                            <ul>
                                                <li>
                                                    <a href="#"><i class="icofont-facebook"></i></a>
                                                </li>
                                                <li>
                                                    <a href="#"><i class="icofont-twitter"></i></a>
                                                </li>
                                                <li>
                                                    <a href="#"><i class="icofont-skype"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 swiper-slide" data-aos="fade-up" data-aos-duration="1800">
                                <div class="team__member__single common__gradient__bg single__transform">
                                    <div class="team__member__single__inner">
                                        <div class="team__member__img">
                                            <img src="img/team/team_6.png" alt="">
                                        </div>
                                        <div class="team__member__name">
                                            <h6><a href="team-details.html">SABRINA TUCKER</a></h6>
                                            <p>Project Manager</p>
                                        </div>
                                        <div class="team__member__icon team__member__icon--2">
                                            <ul>
                                                <li>
                                                    <a href="#"><i class="icofont-facebook"></i></a>
                                                </li>
                                                <li>
                                                    <a href="#"><i class="icofont-twitter"></i></a>
                                                </li>
                                                <li>
                                                    <a href="#"><i class="icofont-skype"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 swiper-slide" data-aos="fade-up" data-aos-duration="2100">
                                <div class="team__member__single common__gradient__bg single__transform">
                                    <div class="team__member__single__inner">
                                        <div class="team__member__img">
                                            <img src="img/team/team_7.png" alt="">
                                        </div>
                                        <div class="team__member__name">
                                            <h6><a href="team-details.html">WILLIAM GURRERO</a></h6>
                                            <p>Web Developer</p>
                                        </div>
                                        <div class="team__member__icon team__member__icon--2">
                                            <ul>
                                                <li>
                                                    <a href="#"><i class="icofont-facebook"></i></a>
                                                </li>
                                                <li>
                                                    <a href="#"><i class="icofont-twitter"></i></a>
                                                </li>
                                                <li>
                                                    <a href="#"><i class="icofont-skype"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 swiper-slide" data-aos="fade-up" data-aos-duration="2400">
                                <div class="team__member__single common__gradient__bg single__transform">
                                    <div class="team__member__single__inner">
                                        <div class="team__member__img">
                                            <img src="img/team/team_8.png" alt="">
                                        </div>
                                        <div class="team__member__name">
                                            <h6><a href="team-details.html">MARION GRAHAM</a></h6>
                                            <p>UI/UX Designer</p>
                                        </div>
                                        <div class="team__member__icon team__member__icon--2">
                                            <ul>
                                                <li>
                                                    <a href="#"><i class="icofont-facebook"></i></a>
                                                </li>
                                                <li>
                                                    <a href="#"><i class="icofont-twitter"></i></a>
                                                </li>
                                                <li>
                                                    <a href="#"><i class="icofont-skype"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 swiper-slide" data-aos="fade-up" data-aos-duration="2800">
                                <div class="team__member__single common__gradient__bg single__transform">
                                    <div class="team__member__single__inner">
                                        <div class="team__member__img">
                                            <img src="img/team/team_7.png" alt="">
                                        </div>
                                        <div class="team__member__name">
                                            <h6><a href="team-details.html">WILLIAM GURRERO</a></h6>
                                            <p>Web Developer</p>
                                        </div>
                                        <div class="team__member__icon team__member__icon--2">
                                            <ul>
                                                <li>
                                                    <a href="#"><i class="icofont-facebook"></i></a>
                                                </li>
                                                <li>
                                                    <a href="#"><i class="icofont-twitter"></i></a>
                                                </li>
                                                <li>
                                                    <a href="#"><i class="icofont-skype"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-12 col-12 swiper-slide" data-aos="fade-up" data-aos-duration="3100">
                                <div class="team__member__single common__gradient__bg single__transform">
                                    <div class="team__member__single__inner">
                                        <div class="team__member__img">
                                            <img src="img/team/team_8.png" alt="">
                                        </div>
                                        <div class="team__member__name">
                                            <h6><a href="team-details.html">MARION GRAHAM</a></h6>
                                            <p>UI/UX Designer</p>
                                        </div>
                                        <div class="team__member__icon team__member__icon--2">
                                            <ul>
                                                <li>
                                                    <a href="#"><i class="icofont-facebook"></i></a>
                                                </li>
                                                <li>
                                                    <a href="#"><i class="icofont-twitter"></i></a>
                                                </li>
                                                <li>
                                                    <a href="#"><i class="icofont-skype"></i></a>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
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
                        <!-- <div class="swiper-pagination"></div> -->
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
                    <div class="section__title__button"><span class="text__gradient">Contact Us</span></div>
                    <div class="section__title__heading"><h3>CONSULTING SUPPORT IS JUST A CALL OR EMAIL AWAY.</h3></div>
                </div>
            </div>

            <div class="col-xl-7 col-lg-7 col-md-12 col-sm-12" data-aos="fade-up" data-aos-duration="1500">
                <div class="contact__input__wrapper">
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="contact__input"><input class="contact__common__input" type="text" placeholder="First Name"></div>
                        </div>
                        <div class="col-xl-6">
                            <div class="contact__input"><input class="contact__common__input" type="text" placeholder="Last Name"></div>
                        </div>
                        <div class="col-xl-6">
                            <div class="contact__input"><input class="contact__common__input" type="email" placeholder="Email"></div>
                        </div>
                        <div class="col-xl-6">
                            <div class="contact__input"><input class="contact__common__input" type="text" placeholder="Phone"></div>
                        </div>
                        <div class="col-xl-12">
                            <select class="contact__common__input" name="subject" id="subject">
                                <option value="">Subject:</option>
                                <option value="general">General Enquiry</option>
                                <option value="consulting">Consulting Services</option>
                                <option value="careers">Careers</option>
                            </select>
                        </div>
                        <div class="col-xl-12">
                            <textarea class="contact__common__input" name="message" id="message" cols="30" rows="10" placeholder="Write a message...."></textarea>
                        </div>
                        <div class="col-xl-12">
                            <div class="contact__button"><a class="default__button" href="#tb__contact">SEND MESSAGE</a></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-5 col-lg-5 col-md-12 col-sm-12 contact__info__right" data-aos="fade-up" data-aos-duration="1500">
                <div class="contact__info">

                    {{-- ============== Opening hours: dynamic from Settings ============== --}}
                    <div class="contact__single__item" data-aos="fade-up" data-aos-duration="1500">
                        <div class="contact__icon">
                            <span><i class="icofont-clock-time"></i></span>
                        </div>
                        <div class="contact__text">
                            <h6>Hours:</h6>
                            @foreach($appSetting->formattedOpeningHours() ?? [] as $day => $hours)
                                <p>{{ $day }}: {{ $hours }}</p>
                            @endforeach
                        </div>
                    </div>

                    {{-- ============== Phone: dynamic from Settings ============== --}}
                    <div class="contact__single__item" data-aos="fade-up" data-aos-duration="1500">
                        <div class="contact__icon">
                            <span><i class="icofont-phone"></i></span>
                        </div>
                        <div class="contact__text">
                            <h6>Call Us:</h6>
                            @if($appSetting->phone ?? false)
                                <p>{{ $appSetting->phone }}</p>
                            @endif
                            @if($appSetting->email ?? false)
                                <p>{{ $appSetting->email }}</p>
                            @endif
                        </div>
                    </div>

                    {{-- ============== Address + map: dynamic from Settings ============== --}}
                    <div class="contact__single__item" data-aos="fade-up" data-aos-duration="1500">
                        <div class="contact__icon">
                            <span><i class="icofont-location-pin"></i></span>
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