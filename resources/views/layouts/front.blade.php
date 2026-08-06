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
        /* .headerarea__solid {
            background: #ffffff;
            box-shadow: 0 2px 16px rgba(10, 6, 36, 0.08);
        } */
        .headerarea__main__menu nav ul li a,
        .mobile__log--title {
            color: #ffffff !important;
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
color:#fff !important;

}
        /* Scrolled state: our own class (added via JS below), independent
           of whatever class name the theme's own scroll script uses.
           Forces a solid white bar with dark text so the menu never goes
           invisible while scrolling, on the homepage or inner pages. */
      
        /* .headerarea.navbar-scrolled .headerarea__main__menu nav ul li a,
        .headerarea.navbar-scrolled .mobile__log--title {
            color: #0A0624 !important;
        }:root { */
    /* --content-text-color: #0A0624;
} */
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
            <div class="headerarea headerarea--1 header__sticky main__header {{ request()->routeIs('home') ? 'headerarea__transparent' : 'headerarea__solid' }}">
                <div class="container desktop__menu__wrapper">
                    <div class="headerarea__main__wrapper position-relative">

                        <div class="headerarea__component__wrap">
                            <div class="headerarea__component">
                                <div class="headerarea__logo">
                                    <a href="{{ url('/') }}">
                                        <img src="{{ Storage::url($appSetting->logo ?? 'website/img/logo/Logo_1.png') }}"
                                             alt="{{ $appSetting->app_name ?? config('app.name') }} Logo">
                                    </a>
                                </div>
                            </div>
                            <div class="headerarea__component">
                                <div class="headerarea__main__menu">
                                    <nav>
                                        <ul>
                                            <li><a href="{{ url('/#tb__home') }}">HOME</a></li>
                                            <li><a href="{{ url('/#tb__service') }}">SERVICE</a></li>
                                            <li><a href="{{ url('/#tb__about') }}">ABOUT</a></li>
                                            <li><a href="{{ url('/#tb__projects') }}">PROJECTS</a></li>
                                            <li><a href="{{ url('/#tb__blogs') }}">BLOGS</a></li>
                                            <li><a href="{{ url('/#tb__contact') }}">CONTACT</a></li>
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                            <div class="headerarea__component">
                                <div class="headerarea__right">
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
                                    <img class="mobile__log--img" src="{{ Storage::url($appSetting->logo ??     'website/img/logo/Logo_1.png') }}" alt="logo-img">
                                </a>
                            </div>
                        </div>
                        <div class="headerarea__component mobile__component__right">
                            <div class="headerarea__right">
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
                        <img src="{{ Storage::url($appSetting->logo ?? 'website/img/logo/Logo_2.png') }}" alt="Logo-img">
                    </a>
                    <button class="offcanvas__close--btn" data-offcanvas>close</button>
                </div>
                <nav class="offcanvas__menu">
                    <ul class="offcanvas__menu_ul">
                        <li class="offcanvas__menu_li"><a class="offcanvas__menu_item" href="{{ url('/#tb__home') }}">HOME</a></li>
                        <li class="offcanvas__menu_li"><a class="offcanvas__menu_item" href="{{ url('/#tb__service') }}">SERVICE</a></li>
                        <li class="offcanvas__menu_li"><a class="offcanvas__menu_item" href="{{ url('/#tb__about') }}">ABOUT</a></li>
                        <li class="offcanvas__menu_li"><a class="offcanvas__menu_item" href="{{ url('/#tb__projects') }}">PROJECTS</a></li>
                        <li class="offcanvas__menu_li"><a class="offcanvas__menu_item" href="{{ route('vacancies.public.index') }}">CAREERS</a></li>
                        <li class="offcanvas__menu_li"><a class="offcanvas__menu_item" href="{{ url('/#tb__blogs') }}">BLOGS</a></li>
                        <li class="offcanvas__menu_li"><a class="offcanvas__menu_item" href="{{ url('/#tb__contact') }}">CONTACT</a></li>
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
                                    <img src="{{ Storage::url($appSetting->logo ?? 'website/img/logo/Logo_1.png') }}" alt="{{ $appSetting->app_name ?? config('app.name') }}">
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
                                        <li><a href="{{ url('/#tb__blogs') }}">Blog update</a></li>
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
                                        <li><a href="#">Customer support</a></li>
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

    <script>
        // Force a readable (dark-text-on-white) header once the page is
        // scrolled, regardless of homepage (transparent) vs inner page
        // (solid) starting state — fixes the menu disappearing on scroll.
        (function () {
            const header = document.querySelector('.headerarea');
            if (!header) return;

            function updateHeaderOnScroll() {
                if (window.scrollY > 60) {
                    header.classList.add('navbar-scrolled');
                } else {
                    header.classList.remove('navbar-scrolled');
                }
            }

            updateHeaderOnScroll();
            window.addEventListener('scroll', updateHeaderOnScroll, { passive: true });
        })();
    </script>

    @stack('scripts')
</body>
</html>