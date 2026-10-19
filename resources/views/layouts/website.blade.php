<!DOCTYPE html>
<html lang="en-GB">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>@yield('title', 'Skill Up Notts')</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
:root{--navy:#2f3b52;--header-h:110px}
html{scroll-behavior:smooth;scroll-padding-top:80px}
body{font-family:"Poppins",system-ui,sans-serif;color:#222a38}

/* ---------- HEADER ---------- */
#headerSpacer{min-height:var(--header-h)}
.site-header{background:#fff;width:100%;z-index:1030;position:relative;border-bottom:1px solid #eef0f4}
.site-header.is-stuck{position:fixed;top:0;left:0;border-bottom-color:transparent;box-shadow:0 4px 18px rgba(20,30,50,.12);animation:slideDown .35s ease}
@keyframes slideDown{from{transform:translateY(-100%)}to{transform:translateY(0)}}
.site-header .navbar{min-height:110px;padding-block:.25rem;transition:min-height .3s ease}
.site-header.is-stuck .navbar{min-height:72px}
.navbar-brand{padding:0;margin-right:1rem;display:flex;align-items:center}
.brand-logo{display:block;width:auto;height:100px;transition:height .3s ease}
.site-header.is-stuck .brand-logo{height:44px}
.brand-logo-sm{display:block;width:auto;height:44px}
.nav-link{font-size:.95rem;font-weight:400;text-transform:uppercase;color:#222!important}
.dropdown-item{font-size:.85rem;padding:.55rem 1.1rem}
@media (min-width:992px){
  .nav-link{padding:.35rem 0!important;border-bottom:2px solid transparent}
  .nav-link.active{font-weight:600;color:var(--navy)!important;border-bottom-color:var(--navy)}
  .navbar-nav{gap:2.2rem}
  .dropdown-toggle::after{border:0;width:.55em;height:.55em;border-right:1.5px solid currentColor;border-bottom:1.5px solid currentColor;transform:rotate(45deg) translateY(-3px);margin-left:.5em;vertical-align:middle}
  .dropdown-menu{border-radius:0;border:1px solid #eef0f4;box-shadow:0 8px 24px rgba(20,30,50,.1)}
}
@media (max-width:991.98px){
  :root{--header-h:80px}
  .brand-logo{height:56px}
  .site-header.is-stuck .brand-logo{height:40px}
  .site-header .navbar{min-height:80px}
  .site-header.is-stuck .navbar{min-height:64px}
  .offcanvas{max-width:85vw}
  .offcanvas .nav-link{padding:.9rem 0;border-bottom:1px solid #e5e8ee;font-size:.85rem}
  .offcanvas .nav-link.active{font-weight:600;color:var(--navy)!important}
  .offcanvas .dropdown-menu{border:0;padding-left:1rem;box-shadow:none}
}
@media (prefers-reduced-motion:reduce){html{scroll-behavior:auto}.site-header.is-stuck{animation:none}}
</style>
@stack('styles')
</head>
<body>

<div id="headerSpacer">
<header id="siteHeader" class="site-header">
 <nav class="navbar navbar-expand-lg">
  <div class="container-xl">
   <a class="navbar-brand" href="{{ url('/') }}" aria-label="Skill Up Notts home">
    <img class="brand-logo" src="{{ asset('website/img/logo.png') }}" alt="Skill Up Notts Ltd" width="300" height="120">
   </a>

   <button class="navbar-toggler border-0" type="button" data-bs-toggle="offcanvas" data-bs-target="#sideMenu" aria-controls="sideMenu" aria-label="Open menu">
    <span class="navbar-toggler-icon"></span>
   </button>

   <div class="offcanvas offcanvas-end" tabindex="-1" id="sideMenu" aria-labelledby="sideMenuLabel">
    <div class="offcanvas-header border-bottom">
     <h5 class="offcanvas-title mb-0" id="sideMenuLabel">
      <img class="brand-logo-sm" src="{{ asset('website/img/logo.png') }}" alt="Skill Up Notts Ltd">
     </h5>
     <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close menu"></button>
    </div>

    <div class="offcanvas-body ms-lg-auto flex-lg-grow-0 align-items-lg-center">
     <ul class="navbar-nav">
      <li class="nav-item"><a class="nav-link {{ request()->is('/') ? 'active' : '' }}" href="{{ url('/') }}">Home</a></li>
      <li class="nav-item"><a class="nav-link" href="{{ route('about-us') }}">About us</a></li>
      <li class="nav-item dropdown">
       <a class="nav-link dropdown-toggle {{ request()->is('courses/*') ? 'active' : '' }}" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Courses</a>
       <ul class="dropdown-menu">
        <li><a class="dropdown-item" href="{{ route('courses.show','esol') }}">ESOL</a></li>
        <li><a class="dropdown-item" href="{{ route('courses.show','functional-skills') }}">Functional Skills</a></li>
        <li><a class="dropdown-item" href="{{ route('courses.show','it-digital-skills') }}">IT &amp; Digital Skills</a></li>
        <li><a class="dropdown-item" href="{{ route('courses.show','test-preparation') }}">Test Preparation</a></li>
        <li><a class="dropdown-item" href="{{ route('courses.show','enterprise-crafts') }}">Enterprise &amp; Crafts</a></li>
        <li><a class="dropdown-item" href="{{ route('courses.show','vocational-training') }}">Vocational Training</a></li>
       </ul>
      </li>
      <li class="nav-item"><a class="nav-link" href="{{ route('selt') }}">Trinity SELT Preparation</a></li>
      <li class="nav-item dropdown">
       <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">More</a>
       <ul class="dropdown-menu dropdown-menu-lg-end">
        <li><a class="dropdown-item" href="{{ route('vacancies.public.index') }}">Vacancies</a></li>
       </ul>
      </li>
     </ul>
    </div>
   </div>
  </div>
 </nav>
</header>
</div>

@yield('content')

<footer class="text-center small text-secondary py-4">
 <div class="container">Copyright © {{ date('Y') }} Skill Up Notts LTD – All Rights Reserved.<br><a href="#" class="link-secondary">Privacy Policy</a></div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Header: visible by default, sticky once you scroll past it
(function () {
  const header = document.getElementById('siteHeader');
  const spacer = document.getElementById('headerSpacer');
  let headerH = header.offsetHeight, ticking = false;
  function measure(){ if(!header.classList.contains('is-stuck')){ headerH = header.offsetHeight; spacer.style.height = headerH + 'px'; } }
  function onScroll(){ const s = window.scrollY > headerH; if (s !== header.classList.contains('is-stuck')) header.classList.toggle('is-stuck', s); ticking = false; }
  window.addEventListener('scroll', () => { if(!ticking){ requestAnimationFrame(onScroll); ticking = true; } }, { passive:true });
  window.addEventListener('resize', measure);
  window.addEventListener('load', () => { measure(); onScroll(); });
  measure(); onScroll();
})();
</script>
@stack('scripts')
</body>
</html>