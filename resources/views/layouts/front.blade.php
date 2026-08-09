<!doctype html>
<html class="no-js" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>@yield('title', $appSetting->app_name ?? config('app.name'))</title>
    <meta name="description" content="@yield('meta_description', '')">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" type="image/x-icon" href="{{ $appSetting->logo_url ?? asset('website/img/favicon.ico') }}">

    <!-- CSS here -->
    <link rel="stylesheet" href="{{ asset('website/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('website/css/aos.min.css') }}">
    <link rel="stylesheet" href="{{ asset('website/css/icofont.min.css') }}">
    <link rel="stylesheet" href="{{ asset('website/css/glightbox.min.css') }}">
    <link rel="stylesheet" href="{{ asset('website/css/swiper-bundle.min.css') }}">
    <link rel="stylesheet" href="{{ asset('website/css/style.css') }}">

    @stack('styles')

    <style>
        /* Inner pages (no hero image behind the header) need a solid,
           high-contrast header — the theme's default transparent header
           only reads correctly over the dark hero banner on the homepage. */
        .headerarea__solid {
            background: #ffffff;
            box-shadow: 0 2px 16px rgba(10, 6, 36, 0.08);
        }

        /* Nav text is white ONLY while the header is in its transparent
           state (sitting over the dark hero/banner). Solid and scrolled
           states override this to dark further down — this fixes the
           "menu disappears" bug that comes from forcing white globally. */
        .headerarea__transparent .headerarea__main__menu nav ul li a,
        .headerarea__transparent .mobile__log--title {
            color: #ffffff !important;
        }
        .headerarea__solid .headerarea__main__menu nav ul li a,
        .headerarea__solid .mobile__log--title {
            color: #0A0624 !important;
        }
        .headerarea__solid .headerarea__logo img {
            max-height: 42px;
            width: auto;
        }
        .inner__page__spacing {
            padding-top: 140px;
        }
        @media (max-width: 767px) {
            .inner__page__spacing { padding-top: 100px; }
        }
        .footer__menu ul li a {
            color: #fff !important;
        }

        /* Header stays transparent throughout — including while scrolled —
           per request. Text color still follows headerarea__transparent
           vs headerarea__solid per route, defined above. */

        html.is_dark {
            --content-text-color: #ffffff;
        }
        /* About / Mission section with a pinned white card background
           (.about__white__bg forces white regardless of theme by default) */
        .about.about__white__bg {
            background-color: #ffffff;
        }
        html.is_dark .about.about__white__bg {
            background-color: #14101f; /* swap for your actual dark "card" surface colour */
        }

        .about.about__white__bg .section__title__button span,
        .about.about__white__bg .section__title__heading h3,
        .about.about__white__bg .about__number__inner span,
        .about.about__white__bg .about__number__inner p,
        .about.about__white__bg .about__misson h6,
        .about.about__white__bg .about__text__2 p {
            color: var(--content-text-color) !important;
        }
        body,
        p,
        li,
        h1, h2, h3, h4, h5, h6,
        span:not(.text__gradient),
        a:not(.default__button):not(.text__gradient) {
            color: var(--content-text-color);
        }
        /* Replace the blue→purple→pink gradient overlay with brand colour */
        .about__white__bg.about__grident__bg::after {
            background: var(--accent, #607570) !important;
            opacity: 0.15; /* lower opacity so content behind stays readable */
        }

        /* Dark mode: slightly more visible */
        html.is_dark .about__white__bg.about__grident__bg::after {
            opacity: 0.25;
        }
        .project__margin {
            background: var(--whiteColor);
            margin-top: 7px !important;
            border-radius: var(--borderRadius);
            position: relative;
            margin-left: 185px;
            margin-right: 185px;
        }

        /* ============== WhatsApp icon in the navbar (blinking) ============== */
        .headerarea__whatsapp {
            position: relative;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 38px;
            height: 38px;
            border-radius: 50%;
            transition: background-color .15s ease, transform .15s ease;
        }
        .headerarea__whatsapp:hover {
            background-color: rgba(37, 211, 102, 0.12);
            transform: scale(1.06);
        }
        .headerarea__whatsapp__pulse {
            position: absolute;
            inset: 4px;
            border-radius: 50%;
            background: #25D366;
            animation: whatsappBlink 1.8s ease-out infinite;
        }
        @keyframes whatsappBlink {
            0%   { transform: scale(1);   opacity: 0.6; }
            70%  { transform: scale(1.8); opacity: 0; }
            100% { transform: scale(1.8); opacity: 0; }
        }
    </style>

    <script>
        // Default theme comes from Settings (admin-controlled). A visitor's
        // own toggle choice (stored in localStorage) always wins over that
        // default for their session.
        if (localStorage.getItem("theme-color") === "dark" || (!("theme-color" in localStorage) && "{{ $appSetting->theme ?? 'light' }}" === "dark")) {
            document.documentElement.classList.add("is_dark");
        }
        if (localStorage.getItem("theme-color") === "light" || (!("theme-color" in localStorage) && "{{ $appSetting->theme ?? 'light' }}" === "light")) {
            document.documentElement.classList.remove("is_dark");
        }
    </script>
</head>

<body class="body__wrapper">

    <!-- pre loader area start -->
    <div id="back__preloader">
        <div id="back__circle_loader"></div>
        <div class="back__loader_logo">
            <img loading="lazy" src="{{ asset('website/img/pre.png') }}" alt="Preload">
        </div>
    </div>
    <!-- pre loader area end -->

    <!-- Dark/Light area start -->
    <div class="mode_switcher my_switcher">
        <button id="light--to-dark-button" class="light align-items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="ionicon dark__mode" viewBox="0 0 512 512"><path d="M160 136c0-30.62 4.51-61.61 16-88C99.57 81.27 48 159.32 48 248c0 119.29 96.71 216 216 216 88.68 0 166.73-51.57 200-128-26.39 11.49-57.38 16-88 16-119.29 0-216-96.71-216-216z" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="32"/></svg>
            <svg xmlns="http://www.w3.org/2000/svg" class="ionicon light__mode" viewBox="0 0 512 512"><path fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M256 48v48M256 416v48M403.08 108.92l-33.94 33.94M142.86 369.14l-33.94 33.94M464 256h-48M96 256H48M403.08 403.08l-33.94-33.94M142.86 142.86l-33.94-33.94"/><circle cx="256" cy="256" r="80" fill="none" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32"/></svg>
            <span class="light__mode">Light</span>
            <span class="dark__mode">Dark</span>
        </button>
    </div>
    <!-- Dark/Light area end -->

    <main class="main_wrapper overflow-hidden">

        <!-- header__start -->
        <header>
            <div class="headerarea headerarea--1 header__sticky main__header headerarea__transparent">
                <div class="container desktop__menu__wrapper">
                    <div class="headerarea__main__wrapper position-relative">

                        <div class="headerarea__component__wrap">
                            <div class="headerarea__component">
                                <div class="headerarea__logo">
                                    <a href="{{ url('/') }}">
                                        <img src="{{ $appSetting->logo_url ?? asset('website/img/logo/Logo_1.png') }}"
                                             alt="{{ $appSetting->app_name ?? config('app.name') }} Logo">
                                    </a>
                                </div>
                            </div>
                            <div class="headerarea__component">
                                <div class="headerarea__main__menu">
                                    <nav>
                                        <ul>
                                            <li><a href="{{ url('/#tb__home') }}">HOME</a></li>
                                            <li><a href="{{ url('/#tb__about') }}">ABOUT</a></li>
                                            <li><a href="{{ url('/#tb__service') }}">SERVICE</a></li>
                                            <li><a href="{{ url('/#tb__projects') }}">PROJECTS</a></li>
                                            <li><a href="{{ url('/#tb__blogs') }}">BLOGS</a></li>
                                            <li><a href="{{ url('/#tb__contact') }}">CONTACT</a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                            <div class="headerarea__component">

                                <div class="headerarea__right d-flex align-items-center gap-3">

                                    @if($appSetting->whatsapp_link ?? false)
                                        <a href="{{ $appSetting->whatsapp_link }}" target="_blank" rel="noopener"
                                           class="headerarea__whatsapp" aria-label="Chat with us on WhatsApp">
                                            <span class="headerarea__whatsapp__pulse"></span>
                                            <svg width="24" height="24" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M16.001 3C9.11 3 3.5 8.61 3.5 15.5c0 2.29.62 4.44 1.7 6.29L3 29l7.4-2.16A12.44 12.44 0 0 0 16 28.5C22.89 28.5 28.5 22.89 28.5 16S22.89 3 16.001 3Z" fill="#25D366"/>
                                                <path d="M22.14 18.66c-.33-.16-1.95-.96-2.26-1.07-.3-.11-.53-.16-.75.17-.22.33-.86 1.07-1.06 1.29-.2.22-.39.25-.72.08-.33-.16-1.4-.52-2.66-1.65-.98-.88-1.65-1.96-1.84-2.29-.19-.33-.02-.5.14-.66.15-.15.33-.39.5-.58.16-.2.22-.33.33-.55.11-.22.06-.42-.03-.58-.08-.16-.75-1.82-1.03-2.49-.27-.65-.55-.56-.75-.57-.19-.01-.42-.01-.64-.01-.22 0-.58.08-.89.42-.3.33-1.16 1.14-1.16 2.77s1.19 3.22 1.36 3.44c.16.22 2.34 3.57 5.67 5.01.79.34 1.41.55 1.89.7.79.25 1.51.22 2.08.13.63-.09 1.95-.8 2.23-1.57.27-.77.27-1.43.19-1.57-.08-.14-.3-.22-.63-.38Z" fill="#fff"/>
                                            </svg>
                                        </a>
                                    @endif

                                    <div class="headerarea__button">
                                        <a class="default__button" href="{{ route('vacancies.public.index') }}">CAREERS</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mob_menu_wrapper container-fluid">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="offcanvas__header--menu__open ">
                            <a class="offcanvas__header--menu__open--btn" href="javascript:void(0)" data-offcanvas>
                                <svg xmlns="http://www.w3.org/2000/svg" class="ionicon offcanvas__header--menu__open--svg" viewBox="0 0 512 512"><path fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-miterlimit="10" stroke-width="32" d="M80 160h352M80 256h352M80 352h352"/></svg>
                                <span class="visually-hidden">Offcanvas Menu Open</span>
                            </a>
                        </div>
                        <div class="mobile__log">
                            <div class="mobile__log--title">
                                <a class="mobile__log--link" href="{{ url('/') }}">
                                    <img class="mobile__log--img" src="{{ $appSetting->logo_url ?? asset('website/img/logo/Logo_1.png') }}" alt="logo-img">
                                </a>
                            </div>
                        </div>
                        <div class="headerarea__component mobile__component__right">
                            <div class="headerarea__right d-flex align-items-center gap-2">
                                @if($appSetting->whatsapp_link ?? false)
                                    <a href="{{ $appSetting->whatsapp_link }}" target="_blank" rel="noopener"
                                       class="headerarea__whatsapp" aria-label="Chat with us on WhatsApp">
                                        <span class="headerarea__whatsapp__pulse"></span>
                                        <svg width="22" height="22" viewBox="0 0 32 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M16.001 3C9.11 3 3.5 8.61 3.5 15.5c0 2.29.62 4.44 1.7 6.29L3 29l7.4-2.16A12.44 12.44 0 0 0 16 28.5C22.89 28.5 28.5 22.89 28.5 16S22.89 3 16.001 3Z" fill="#25D366"/>
                                            <path d="M22.14 18.66c-.33-.16-1.95-.96-2.26-1.07-.3-.11-.53-.16-.75.17-.22.33-.86 1.07-1.06 1.29-.2.22-.39.25-.72.08-.33-.16-1.4-.52-2.66-1.65-.98-.88-1.65-1.96-1.84-2.29-.19-.33-.02-.5.14-.66.15-.15.33-.39.5-.58.16-.2.22-.33.33-.55.11-.22.06-.42-.03-.58-.08-.16-.75-1.82-1.03-2.49-.27-.65-.55-.56-.75-.57-.19-.01-.42-.01-.64-.01-.22 0-.58.08-.89.42-.3.33-1.16 1.14-1.16 2.77s1.19 3.22 1.36 3.44c.16.22 2.34 3.57 5.67 5.01.79.34 1.41.55 1.89.7.79.25 1.51.22 2.08.13.63-.09 1.95-.8 2.23-1.57.27-.77.27-1.43.19-1.57-.08-.14-.3-.22-.63-.38Z" fill="#fff"/>
                                        </svg>
                                    </a>
                                @endif
                                <div class="headerarea__button">
                                        <a class="default__button" href="{{ route('vacancies.public.index') }}">CAREERS</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </header>

        <!-- Start Offcanvas header menu -->
        <div class="offcanvas__header">
            <div class="offcanvas__inner">
                <div class="offcanvas__logo">
                    <a class="offcanvas__logo_link" href="{{ url('/') }}">
                        <img src="{{ $appSetting->logo_url ?? asset('website/img/logo/Logo_2.png') }}" alt="Logo-img">
                    </a>
                    <button class="offcanvas__close--btn" data-offcanvas>close</button>
                </div>
                <nav class="offcanvas__menu">
                    <ul class="offcanvas__menu_ul">
                        <li class="offcanvas__menu_li"><a class="offcanvas__menu_item" href="{{ url('/#tb__home') }}">HOME</a></li>
                         <li class="offcanvas__menu_li"><a class="offcanvas__menu_item" href="{{ url('/#tb__about') }}">ABOUT</a></li>
                        <li class="offcanvas__menu_li"><a class="offcanvas__menu_item" href="{{ url('/#tb__service') }}">SERVICE</a></li>
                        <li class="offcanvas__menu_li"><a class="offcanvas__menu_item" href="{{ url('/#tb__projects') }}">PROJECTS</a></li>
                        <li class="offcanvas__menu_li"><a class="offcanvas__menu_item" href="{{ url('/#tb__contact') }}">CONTACT</a></li>
                         <li class="offcanvas__menu_li"><a class="offcanvas__menu_item" href="{{ route('vacancies.public.index') }}">CAREERS</a></li>

                    </ul>
                </nav>
            </div>
        </div>
        <!-- End Offcanvas header menu -->

        @yield('content')

        <!-- footer__section__start -->
        <div class="footer position-relative sp_top_250 pink__bg__color" id="footer__area" style="background-image: url({{ asset('website/img/footer/footer_1.png') }});">

            <div class="bastun__brand__badge bastun__brand__badge__footer">
                <div class="bastun__brand__badge__inner position-relative">
                    <a href="{{ url('/') }}">
                        <img class="bbb__animate" src="{{ asset('website/img/footer/brand__badge.png') }}" alt="Footer badge">
                        <img class="bbb__icon" src="{{ asset('website/img/footer/brand__badge__inner.png') }}" alt="Footer icon badge">
                    </a>
                </div>
            </div>

            <div class="container">
                <div class="footer__wrapper sp_bottom_110">
                    <div class="row">
                        <div class="col-xl-4 col-lg-6 col-md-6" data-aos="fade-up" data-aos-duration="1500">
                            <div class="footer__widget footer__left">
                                <div class="footer__logo">
                                    <img src="{{ $appSetting->logo_url ?? asset('website/img/logo/Logo_1.png') }}" alt="{{ $appSetting->app_name ?? config('app.name') }}">
                                </div>
                                <div class="footer__text">
                                    <p>{{ $appSetting->address ?? '' }}</p>
                                </div>
                                <div class="footer__icon">
                                    <ul>
                                        <li><a href="#"><i class="icofont-facebook"></i></a></li>
                                        <li><a href="#"><i class="icofont-twitter"></i></a></li>
                                        <li><a href="#"><i class="icofont-skype"></i></a></li>
                                        <li><a href="#"><i class="icofont-linkedin"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-2 col-lg-6 col-md-6 col-sm-6" data-aos="fade-up" data-aos-duration="2000">
                            <div class="footer__widget footer__support">
                                <div class="footer__menu__title"><h6>SUPPORT :</h6></div>
                                <div class="footer__menu">
                                    <ul>
                                        <li><a href="{{ url('/#tb__home') }}">Home</a></li>
                                        <li><a href="{{ url('/#tb__about') }}">About us</a></li>
                                        <li><a href="{{ url('/#tb__projects') }}">Blog update</a></li>
                                        <li><a href="{{ url('/#tb__service') }}">Our services</a></li>
                                        <li><a href="{{ route('vacancies.public.index') }}">Careers</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-2 col-lg-6 col-md-6 col-sm-6" data-aos="fade-up" data-aos-duration="2500">
                            <div class="footer__widget footer__quick">
                                <div class="footer__menu__title"><h6>QUICK LINKS :</h6></div>
                                <div class="footer__menu">
                                    <ul>
                                        <li><a href="#">Privacy & policy</a></li>
                                        <li><a href="#">Terms & conditions</a></li>
                                        <li><a href="#">FAQ</a></li>
                                        <li><a href="#contact">Customer support</a></li>
                                        <li><a href="{{ url('/#tb__contact') }}">Contact us</a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12" data-aos="fade-up" data-aos-duration="3000">
                            <div class="footer__widget footer__right">
                                <div class="footer__menu__title"><h6>CONTACT :</h6></div>
                                <div class="footer__text">
                                    @if($appSetting->phone ?? false)
                                        <p><i class="icofont-phone"></i> {{ $appSetting->phone }}</p>
                                    @endif
                                    @if($appSetting->email ?? false)
                                        <p><i class="icofont-envelope"></i> {{ $appSetting->email }}</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="copyright">
                    <div class="row align-items-center">
                        <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                            <div class="copyright__left">
                                <p>Copyright &copy; {{ date('Y') }} <a href="{{ url('/') }}">{{ $appSetting->app_name ?? config('app.name') }}.</a> All Right Reserved</p>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-6 col-12">
                            <div class="copyright__right">
                                <ul>
                                    <li><a href="#">Privacy & Policy ||</a></li>
                                    <li><a href="#">Terms & Conditions</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- footer__section__end -->

    </main>

    <!-- JS here -->
    <script src="{{ asset('website/js/popper.min.js') }}"></script>
    <script src="{{ asset('website/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('website/js/glightbox.min.js') }}"></script>
    <script src="{{ asset('website/js/plugins.js') }}"></script>
    <script src="{{ asset('website/js/swiper-bundle.min.js') }}"></script>
    <script src="{{ asset('website/js/main.js') }}"></script>

    <script>
        // Same default-from-Settings logic, applied to the switcher button's
        // own icon/label state so it matches whatever theme is actually active.
        if (localStorage.getItem("theme-color") === "dark" || (!("theme-color" in localStorage) && "{{ $appSetting->theme ?? 'light' }}" === "dark")) {
            document.getElementById("light--to-dark-button")?.classList.add("dark--mode");
        }
        if (localStorage.getItem("theme-color") === "light" || (!("theme-color" in localStorage) && "{{ $appSetting->theme ?? 'light' }}" === "light")) {
            document.getElementById("light--to-dark-button")?.classList.remove("dark--mode");
        }
    </script>

    @include('partials.assistant-widget')

    @stack('scripts')
</body>
</html>