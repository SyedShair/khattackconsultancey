<!DOCTYPE html>
<html lang="en-GB">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Trinity SELT Preparation | Skill Up Notts</title>
<meta name="description" content="Trinity College London SELT preparation courses in Nottingham for UK visa, settlement and British citizenship English tests.">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
:root{--navy:#2f3b52;--slate:#2f3d52;--gold:#f5b21b;--header-h:110px}
html{scroll-behavior:smooth;scroll-padding-top:80px}
body{font-family:"Poppins",system-ui,sans-serif;color:#222a38}
.serif{font-family:Georgia,"Times New Roman",serif;font-weight:400}

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

/* ---------- Banner ---------- */
.selt-banner{display:block;width:100%;height:auto;background:#fdb515}

/* ---------- Intro (dark) ---------- */
.intro{background:var(--slate);color:#fff;padding-block:clamp(2.5rem,6vw,4.5rem)}
.intro-img{display:block;width:100%;height:auto;aspect-ratio:3/2;object-fit:cover}
.intro h1{font-size:clamp(1.8rem,4vw,2.75rem);line-height:1.15;text-transform:uppercase;margin-bottom:1.25rem}
.intro .lead-strong{font-weight:600;font-size:1rem;line-height:1.6;margin-bottom:1.25rem}
.intro p{font-size:.95rem;line-height:1.75;color:#dde3ec;max-width:62ch}
.trust{display:flex;align-items:center;gap:.6rem;font-size:.9rem;color:#fff;margin-top:1.5rem}
.trust .stars{color:var(--gold);letter-spacing:.15em}

.features{margin-top:clamp(2.5rem,6vw,4rem)}
.feature{border-top:3px solid var(--gold);padding-top:1.1rem;height:100%}
.feature h2{font-family:"Poppins",system-ui,sans-serif;font-weight:500;font-size:1.15rem;line-height:1.35;margin-bottom:.7rem}
.feature p{font-size:.9rem;line-height:1.7;color:#dde3ec;margin:0}

/* ---------- Exam chooser ---------- */
.exams{padding-block:clamp(2.5rem,6vw,4.5rem)}
.exams-img{display:block;width:100%;height:auto}
.exams-note{text-align:center;font-size:clamp(1rem,1.6vw,1.3rem);color:#222a38;max-width:44ch;margin:1.75rem auto 0}

/* ---------- Book CTA ---------- */
.book{background:var(--slate);color:#fff;text-align:center;padding-block:clamp(2.5rem,6vw,4rem)}
.book h2{font-size:clamp(1.6rem,3.6vw,2.6rem);line-height:1.2;text-transform:uppercase;margin-bottom:1.75rem}
.btn-book{display:block;width:min(100%,640px);margin-inline:auto;background:#fff;color:#222;border-radius:0;font-weight:600;font-size:.85rem;letter-spacing:.08em;text-transform:uppercase;padding:1.1rem 1.5rem}
.btn-book:hover,.btn-book:focus-visible{background:#e9edf2;color:#222}

/* ---------- Process ---------- */
.process{padding-block:clamp(2.5rem,6vw,4.5rem)}
.process-img{display:block;width:100%;height:auto}

@media (prefers-reduced-motion:reduce){html{scroll-behavior:auto}.site-header.is-stuck{animation:none}}
</style>
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
      <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
      <li class="nav-item"><a class="nav-link" href="{{ url('/') }}#about">About us</a></li>
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
      <li class="nav-item"><a class="nav-link active" aria-current="page" href="{{ url('/trinity-selt-preparation') }}">Trinity SELT Preparation</a></li>
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

<main>

 {{-- Banner --}}
 <img class="selt-banner" src="{{ asset('website/img/selt/selt-banner.png') }}"
      alt="Trinity College London Secure English Language Tests. Need a Secure English Language Test for your UK visa application?"
      width="2560" height="616">

 {{-- Intro --}}
 <section class="intro">
  <div class="container-xl">
   <div class="row align-items-center g-4 g-lg-5">
    <div class="col-lg-6">
     <img class="intro-img" src="{{ asset('website/img/selt/selt-hero.png') }}"
          alt="Learners studying together at Skill Up Notts" width="1536" height="1024">
    </div>
    <div class="col-lg-6">
     <h1 class="serif">Trinity SELT Preparation</h1>
     <p class="lead-strong">Prepare for your UK Visa, Settlement or British Citizenship English Test with Confidence</p>
     <p>At Skill Up Notts Ltd, we provide professional preparation courses for Trinity College London Secure English Language Tests (SELT), helping learners build the confidence and English language skills needed to succeed.</p>
     <p>As a Trinity Approved Service Provider, we offer expert guidance, personalised tuition and realistic mock exam practice for learners preparing for UK Visa and Immigration (UKVI) approved English language tests. Whether you’re applying for a Family Visa, Indefinite Leave to Remain (ILR), British Citizenship or a Student Visa, our experienced tutors are here to support you every step of the way.</p>
     <div class="trust"><span class="stars" aria-hidden="true">★★★★★</span> Trusted by learners across Nottinghamshire</div>
    </div>
   </div>

   <div class="row g-4 g-lg-5 features">
    <div class="col-md-4">
     <div class="feature">
      <h2>Expert Trinity SELT Preparation</h2>
      <p>As a Trinity College London Approved Service Provider, we deliver professional preparation courses designed to help you build the skills and confidence needed to succeed.</p>
     </div>
    </div>
    <div class="col-md-4">
     <div class="feature">
      <h2>Experienced Tutors &amp; Personalised Support</h2>
      <p>Our qualified SELT tutors provide one-to-one guidance, small group learning, and realistic mock exam practice, tailoring every session to your individual learning needs and visa requirements.</p>
     </div>
    </div>
    <div class="col-md-4">
     <div class="feature">
      <h2>Flexible Learning, Real Results</h2>
      <p>With flexible class times, a welcoming learning environment, and dedicated support throughout your journey, we’re committed to helping you feel fully prepared and confident on exam day.</p>
     </div>
    </div>
   </div>
  </div>
 </section>

 {{-- Which exam --}}
 <section class="exams">
  <div class="container-xl">
   <img class="exams-img" src="{{ asset('website/img/selt/selt-exams.png') }}"
        alt="Which SELT exam do I need? GESE Grade 2 (A1), GESE Grade 3 (A2), GESE Grade 5 (B1), ISE I (B1) and ISE II (B2), with the visas each one is used for and when results arrive."
        width="1536" height="954" loading="lazy">
   <p class="exams-note">Not sure which SELT exam you need? Contact us for a free assessment and we’ll help you choose.</p>
  </div>
 </section>

 {{-- Book --}}
 <section class="book">
  <div class="container-xl">
   <h2 class="serif">Ready to take your Trinity SELT exam?</h2>
   <a href="https://www.trinitycollege.com/qualifications/SELT/UKVI?utm_source=google&utm_medium=ppc&utm_campaign=google%20display%20ads&gad_source=0&gad_campaignid=12897439335&gclid=CjwKCAjw1IHTBhAaEiwA4AYNFgvbCNeT0W8vFbE7j-mcSq4vZtYkDmmonTQBuEV-4-F2_cXusqFv-BoCYLwQAvD_BwE" class="btn btn-book">Book your exam with Trinity</a>
  </div>
 </section>

 {{-- Process --}}
 <section class="process">
  <div class="container-xl">
   <img class="process-img" src="{{ asset('website/img/selt/selt-process.png') }}"
        alt="Our preparation process. Step 1, Assess and Plan: we assess your current English level and understand your goals to create a personalised preparation plan. Step 2, Learn and Practise: attend engaging lessons with our expert tutors. Step 3, Practice and Improve: take part in mock tests and speaking practice sessions. Step 4, Book Your Exam: we guide you through the booking process and help you choose the right Trinity SELT exam. Step 5, Take Your Exam: take your Trinity SELT exam with confidence. We're with you every step of the way, from your first lesson to exam day and beyond."
        width="1774" height="887" loading="lazy">
  </div>
 </section>

</main>

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
</body>
</html>