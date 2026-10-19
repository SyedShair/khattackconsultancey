<!DOCTYPE html>
<html lang="en-GB">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Skill Up Notts – Build skills. Build confidence. Build your future.</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
:root{--navy:#2f3b52;--plum:#4a1b5c;--gold:#f5b21b;--header-h:110px}
html{scroll-behavior:smooth;scroll-padding-top:80px}
body{font-family:"Poppins",system-ui,sans-serif;color:#222a38}
h1,h2,h3,.serif{font-family:Georgia,"Times New Roman",serif;font-weight:400}
.text-muted-2{color:#5d6676}

/* ---------- HEADER: normal by default, sticky after scrolling ---------- */
#headerSpacer{min-height:var(--header-h)}
.site-header{background:#fff;width:100%;z-index:1030;position:relative;border-bottom:1px solid #eef0f4}
.site-header.is-stuck{position:fixed;top:0;left:0;border-bottom-color:transparent;
  box-shadow:0 4px 18px rgba(20,30,50,.12);animation:slideDown .35s ease}
@keyframes slideDown{from{transform:translateY(-100%)}to{transform:translateY(0)}}
.site-header .navbar{min-height:110px;padding-block:.25rem;transition:min-height .3s ease}
.site-header.is-stuck .navbar{min-height:72px}

/* Logo (image) */
.navbar-brand{padding:0;margin-right:1rem;display:flex;align-items:center}
.brand-logo{display:block;width:auto;height:100px;transition:height .3s ease}
.site-header.is-stuck .brand-logo{height:44px}
.brand-logo-sm{display:block;width:auto;height:44px}

/* Nav links */
.nav-link{font-size:.95rem;font-weight:400;text-transform:uppercase;color:#222!important}
.dropdown-item{font-size:.85rem;padding:.55rem 1.1rem}
@media (min-width:992px){
  .nav-link{padding:.35rem 0!important;border-bottom:2px solid transparent}
  .nav-link.active{font-weight:600;color:var(--navy)!important;border-bottom-color:var(--navy)}
  .navbar-nav{gap:2.2rem}
  .dropdown-toggle::after{border:0;width:.55em;height:.55em;border-right:1.5px solid currentColor;border-bottom:1.5px solid currentColor;transform:rotate(45deg) translateY(-3px);margin-left:.5em;vertical-align:middle}
  .dropdown-menu{border-radius:0;border:1px solid #eef0f4;box-shadow:0 8px 24px rgba(20,30,50,.1)}
}

/* Mobile side menu */
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

/* ---------- Hero ---------- */
.btn-navy{background:var(--navy);color:#fff;font-size:.75rem;font-weight:600;letter-spacing:.08em;text-transform:uppercase;padding:.85rem 1.6rem;border-radius:0}
.btn-navy:hover{background:#1f2839;color:#fff}
.hero-img{aspect-ratio:21/9;min-height:200px;overflow:hidden;background:#e9edf2}
.hero-img img{display:block}

/* ---------- About ---------- */
.about-img{aspect-ratio:2/1;overflow:hidden;background:#e9edf2}
.about-img img{display:block;width:100%;height:100%;object-fit:cover}
.about-text{text-align:center;padding-inline:clamp(0rem,2vw,1.5rem)}
.about-text h2{font-family:"Poppins",system-ui,sans-serif;font-weight:400;font-size:clamp(1.5rem,2.4vw,1.9rem);color:#1c1f26;margin-bottom:1.25rem}
.about-text p{font-size:clamp(1rem,1.45vw,1.15rem);line-height:1.85;color:#555b66;margin:0 auto;max-width:46ch}
@media (max-width:767.98px){.about-text{padding-top:.25rem}.about-img{aspect-ratio:16/9}}

/* ---------- SELT banner (full width) ---------- */
.selt-banner{background:#fff;width:100%;padding:0 0 clamp(2rem,5vw,4rem)}
.selt-img{display:block;width:100%;height:auto}
.selt-cta{margin-top:clamp(1.5rem,3.7vw,4.4rem);padding-inline:1rem}
.btn-selt{display:block;width:54%;min-width:min(100%,320px);margin-inline:auto;background:#2f3b4f;color:#fff;font-weight:600;font-size:clamp(.8rem,1.15vw,1.1rem);letter-spacing:.08em;text-transform:uppercase;padding:clamp(.9rem,1.7vw,1.25rem) 1.5rem;border-radius:0}
.btn-selt:hover,.btn-selt:focus{background:#222c3c;color:#fff}
@media (max-width:767.98px){.btn-selt{width:100%}}

/* ---------- Courses ---------- */
.courses .sec-title{font-family:"Poppins",system-ui,sans-serif;font-weight:400;font-size:clamp(1.8rem,4vw,2.6rem);color:var(--navy);text-transform:uppercase;margin-bottom:clamp(2rem,5vw,3.5rem)}
.course-group{padding:clamp(2rem,5vw,3.5rem) 0;border-bottom:1px solid #e6e9ef}
.course-group:first-of-type{padding-top:0}
.group-title{font-family:"Poppins",system-ui,sans-serif;font-weight:400;font-size:clamp(1.5rem,3.2vw,2.2rem);color:var(--navy);text-align:center;margin:0 0 .6rem}
.group-desc{text-align:center;color:#555b66;font-size:clamp(.88rem,1.2vw,1rem);line-height:1.7;max-width:92ch;margin:0 auto clamp(1.8rem,4vw,3.5rem)}
.course-card{max-width:450px;margin-inline:auto}
.course-img{aspect-ratio:4/3;overflow:hidden;background:#e9edf2;margin-bottom:1.4rem}
.course-img img{display:block;width:100%;height:100%;object-fit:cover}
.course-card h4{font-family:"Poppins",system-ui,sans-serif;font-weight:400;font-size:clamp(1.1rem,1.6vw,1.4rem);line-height:1.35;color:#1c1f26;margin:0 0 .8rem}
.course-card p{color:#555b66;font-size:clamp(.9rem,1.2vw,1rem);line-height:1.7;margin:0}
@media (min-width:992px){.course-card-wide{margin-left:clamp(0rem,8vw,6rem);margin-right:auto}}
.group-note{text-align:center;color:#555b66;font-size:.9rem;max-width:80ch;margin:clamp(2rem,4vw,3rem) auto 0}

/* ---------- Contact ---------- */
.contact{background:#2f3d52;color:#fff;padding-block:clamp(2.5rem,6vw,4.5rem)}
.contact-title{font-family:"Poppins",system-ui,sans-serif;font-weight:400;font-size:clamp(1.8rem,4vw,2.6rem);margin-bottom:clamp(2rem,5vw,3.5rem)}
.contact-h{font-family:"Poppins",system-ui,sans-serif;font-weight:400;font-size:clamp(1.4rem,2.4vw,1.9rem);margin:0 0 1.4rem;color:#fff}
.contact-p{font-size:clamp(.95rem,1.3vw,1.1rem);line-height:1.7;color:#d3d9e3;margin:0 0 1.2rem}
.contact-strong,.contact-strong a{color:#fff;text-decoration:none}
.contact-strong a:hover{text-decoration:underline}

.cf-field{margin-bottom:1.1rem}
.cf-input{width:100%;background:#263446;border:1px solid transparent;color:#fff;font:inherit;font-size:1rem;padding:1.35rem 1.1rem;border-radius:0}
.cf-input::placeholder{color:#e6eaf0;opacity:1}
.cf-input:focus{outline:0;border-color:#8ea2c0;background:#2a3a4e}
.cf-input.is-invalid{border-color:#ff8f8f}
.cf-textarea{min-height:215px;resize:vertical;padding-top:1.1rem}
.cf-error{color:#ffb3b3;font-size:.82rem;margin-top:.35rem}

.cf-attach{display:flex;justify-content:space-between;align-items:center;gap:1rem;margin:1.6rem 0 .5rem}
.cf-attach-btn{background:none;border:0;color:#fff;font:inherit;font-size:1.05rem;padding:0;display:inline-flex;align-items:center;gap:.4rem;cursor:pointer}
.cf-attach-btn:hover{text-decoration:underline}
.cf-attach-count{font-size:.9rem;color:#d3d9e3}
.cf-files li{display:flex;justify-content:space-between;align-items:center;gap:1rem;font-size:.85rem;color:#e6eaf0;padding:.35rem 0;border-bottom:1px solid #ffffff1f}
.cf-files .nm{overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.cf-files button{background:none;border:0;color:#ffb3b3;font-size:1.2rem;line-height:1;cursor:pointer;padding:0 .25rem}

.cf-send{display:block;width:100%;margin-top:1.6rem;background:#fff;color:#222;border:0;border-radius:0;font-weight:600;letter-spacing:.12em;text-transform:uppercase;font-size:.95rem;padding:1.15rem;cursor:pointer}
.cf-send:hover{background:#e9edf2}
.cf-send:disabled{opacity:.6;cursor:wait}
.cf-status{margin-top:1rem;font-size:.95rem}
.cf-status.ok{color:#9ff0b5}
.cf-status.err{color:#ffb3b3}
.cf-legal{text-align:center;font-size:.9rem;color:#d3d9e3;margin:1.6rem auto 0;max-width:42ch}
.cf-legal a{color:#fff;font-weight:500;text-decoration:none}

/* Hours (collapsible) */
.hours-toggle{display:inline-flex;align-items:center;gap:.55rem;background:none;border:0;padding:0;color:#fff;font:inherit;font-size:clamp(1.05rem,1.6vw,1.35rem);cursor:pointer}
.hours-label{color:#aab6c8}
.hours-today{color:#fff;font-weight:500}
.hours-chev{transition:transform .25s;margin-left:.15rem}
.hours-toggle[aria-expanded="true"] .hours-chev{transform:rotate(180deg)}
.hours-toggle:focus-visible{outline:2px solid #fff;outline-offset:4px}
.hours{border-collapse:separate;border-spacing:0 .2rem;margin-top:1rem;font-size:clamp(.95rem,1.3vw,1.1rem);color:#d3d9e3}
.hours[hidden]{display:none}
.hours th{font-weight:400;padding-right:1.2rem;white-space:nowrap}
.hours tr.today th,.hours tr.today td{font-weight:700;color:#fff}

/* ---------- Map ---------- */
.map-wrap{position:relative;width:100%;height:clamp(300px,42vw,480px);background:#e8ecf1;line-height:0}
.map-wrap iframe{display:block;width:100%;height:100%;border:0}
.map-directions{position:absolute;top:1rem;left:1rem;z-index:2;display:inline-flex;align-items:center;gap:.6rem;background:#fff;color:#222;text-decoration:none;line-height:1.2;font-size:.85rem;font-weight:600;letter-spacing:.1em;text-transform:uppercase;padding:.9rem 1.4rem;box-shadow:0 2px 8px rgba(0,0,0,.2)}
.map-directions:hover{background:#f1f3f6;color:#222}
@media (max-width:575.98px){.map-directions{top:.6rem;left:.6rem;font-size:.75rem;padding:.7rem 1rem}}

/* ---------- Partners ---------- */
.partners{padding-block:clamp(2.5rem,6vw,4.5rem)}
.partners-title{font-family:"Poppins",system-ui,sans-serif;font-weight:400;font-size:clamp(1.6rem,3.2vw,2.4rem);color:var(--navy);margin:0 0 clamp(1.8rem,5vw,3.5rem)}
.partner-logo{display:flex;align-items:center;justify-content:center;height:clamp(90px,12vw,150px)}
.partner-logo img{display:block;max-width:min(100%,380px);max-height:100%;width:auto;height:auto;object-fit:contain}
@media (max-width:767.98px){.partner-logo{height:110px}.partner-logo img{max-width:min(80%,300px)}}

@media (prefers-reduced-motion:reduce){html{scroll-behavior:auto}.site-header.is-stuck{animation:none}}
</style>
</head>
<body>

<!-- HEADER: shows normally, becomes sticky on scroll -->
<div id="headerSpacer">
<header id="siteHeader" class="site-header">
 <nav class="navbar navbar-expand-lg">
  <div class="container-xl">
   <a class="navbar-brand" href="#home" aria-label="Skill Up Notts home">
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
      <li class="nav-item"><a class="nav-link active" href="#home">Home</a></li>
      <li class="nav-item"><a class="nav-link" href="{{ route('about-us') }}">About us</a></li>
      <li class="nav-item dropdown">
       <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">Courses</a>
       <ul class="dropdown-menu">

        <li><a class="dropdown-item" href="{{ route('courses.show', 'esol') }}">ESOL</a></li>
        <li><a class="dropdown-item" href="{{ route('courses.show', 'functional-skills') }}">Functional Skills</a></li>
        <li><a class="dropdown-item" href="{{ route('courses.show', 'it-digital-skills') }}">IT & Digital Skills</a></li>
        <li><a class="dropdown-item" href="{{ route('courses.show', 'test-preparation') }}">Test Preparation</a></li>
        <li><a class="dropdown-item" href="{{ route('courses.show', 'enterprise-crafts') }}">Enterprise & Crafts</a></li>
        <li><a class="dropdown-item" href="{{ route('courses.show', 'vocational-training') }}">Vocational Training</a></li>
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

<main id="home">

 <!-- HERO -->
 <section class="container text-center py-4 py-md-5">
  <h1 class="text-uppercase" style="font-size:clamp(1.5rem,4.6vw,2.6rem)">Build skills. Build confidence. Build your future.</h1>
  <p class="text-muted-2 mt-3">Learn new skills and advance your career today!</p>
  <a href="#contact" class="btn btn-navy">Start your journey</a>
  <div class="hero-img w-100 mt-4">
   <img class="w-100 h-100 object-fit-cover" src="{{ asset('website/img/banner/4.png') }}" alt="Adults learning together in a classroom">
  </div>
 </section>

 <!-- ABOUT -->
 <section id="about" class="container-xl about py-5">

  <!-- Our Mission: image left, text right -->
  <div class="row align-items-center g-4 g-lg-5 mb-5">
   <div class="col-md-6">
    <div class="about-img">
     <img src="{{ asset('website/img/banner/5.png') }}" alt="Skill Up Notts learners" loading="lazy">
    </div>
   </div>
   <div class="col-md-6 about-text">
    <h2>Our Mission</h2>
    <p>At Skill Up Notts Ltd, we believe it’s never too late to learn something new. Our mission is to provide accessible education that empowers individuals to achieve their personal and professional goals.</p>
   </div>
  </div>

  <!-- Why Skillup: text left, image right -->
  <div class="row align-items-center g-4 g-lg-5">
   <div class="col-md-6 about-text order-2 order-md-1">
    <h2>Why Skillup</h2>
    <p>
     At Skill Up Notts, we believe learning isn’t just about classrooms it’s about confidence, opportunity, and community.<br>
     We started with a simple goal: to give adults in Nottingham a place where they can <em>start again</em>, <em>move forward</em>, and <em>find new possibilities</em> through learning.
    </p>
   </div>
   <div class="col-md-6 order-1 order-md-2">
    <div class="about-img">
     <img src="{{ asset('website/img/banner/6.png') }}" alt="Learners using computers" loading="lazy">
    </div>
   </div>
  </div>

 </section>

 <!-- SELT BANNER -->
 <section id="selt" class="selt-banner">
  <a href="#contact" class="d-block">
   <img class="selt-img" src="{{ asset('website/img/banner/7.png') }}"
        alt="Trinity College London Secure English Language Tests. Need to book your Secure English Language Test? Skill Up Notts is an Approved Service Provider for SELT preparation courses."
        loading="lazy">
  </a>
  <div class="selt-cta text-center">
   <a href="{{ route('selt') }}" class="btn btn-selt">Learn more and book your SELT exam</a>
  </div>
 </section>

 <!-- COURSES -->
 <section id="courses" class="container-xl courses py-5">
  <h2 class="sec-title text-center">Explore our courses</h2>

  <!-- ENGLISH -->
  <div id="english" class="course-group">
   <h3 class="group-title">English</h3>
   <p class="group-desc">Our English programmes help adults at every level build strong communication skills for daily life, study, and work. From learning your first English words to preparing for advanced language exams, we offer a full pathway that supports your personal goals.</p>
   <div class="row g-4 g-lg-5">
    <div class="col-12 col-md-6 col-lg-4">
     <article class="course-card">
      <div class="course-img"><img src="{{ asset('website/img/banner/8.png') }}" alt="ESOL class" loading="lazy"></div>
      <h4>ESOL Skills for Life</h4>
      <p>Develop reading, writing, speaking, and listening for everyday communication.</p>
     </article>
    </div>
    <div class="col-12 col-md-6 col-lg-4">
     <article class="course-card">
      <div class="course-img"><img src="{{ asset('website/img/banner/9.png') }}" alt="Functional Skills English" loading="lazy"></div>
      <h4>Functional Skills English</h4>
      <p>Build your English skills for work, study, and life in the UK.</p>
     </article>
    </div>
    <div class="col-12 col-md-6 col-lg-4">
     <article class="course-card">
      <div class="course-img"><img src="{{ asset('website/img/banner/10.png') }}" alt="IELTS and SELT preparation" loading="lazy"></div>
      <h4>IELTS, SELT Test Preparation:</h4>
      <p>Focused training for Home Office English requirements, for visa applications, university admissions and UK residency.</p>
     </article>
    </div>
   </div>
  </div>

  <!-- DIGITAL & IT -->
  <div id="digital" class="course-group">
   <h3 class="group-title">Digital &amp; IT Skills</h3>
   <p class="group-desc">Digital confidence opens doors. Our IT and digital skills courses are designed for adults who want to learn computer basics or upgrade their tech abilities for the modern workplace.</p>
   <div class="row g-4 g-lg-5">
    <div class="col-12 col-md-6">
     <article class="course-card course-card-wide">
      <div class="course-img"><img src="{{ asset('website/img/banner/11.png') }}" alt="Functional Skills Qualification in ICT" loading="lazy"></div>
      <h4>Functional Skills Qualification in ICT</h4>
     </article>
    </div>
    <div class="col-12 col-md-6">
     <article class="course-card course-card-wide">
      <div class="course-img"><img src="{{ asset('website/img/banner/12.png') }}" alt="Microsoft Office and workplace computing" loading="lazy"></div>
      <h4>Microsoft Office &amp; Workplace Computing</h4>
     </article>
    </div>
   </div>
  </div>

  <!-- VOCATIONAL -->
  <div id="vocational" class="course-group">
   <h3 class="group-title">Vocational Training &amp; Employability</h3>
   <p class="group-desc">Our vocational training courses give you recognised qualifications and the hands-on skills needed to work in health, education, administration, construction and community support.</p>
   <div class="row g-4 g-lg-5">
    <div class="col-12 col-md-6 col-lg-4">
     <article class="course-card">
      <div class="course-img"><img src="{{ asset('website/img/banner/13.png') }}" alt="Health and medical care" loading="lazy"></div>
      <h4>Health &amp; Medical Care</h4>
     </article>
    </div>
    <div class="col-12 col-md-6 col-lg-4">
     <article class="course-card">
      <div class="course-img"><img src="{{ asset('website/img/banner/14.png') }}" alt="Administration and education" loading="lazy"></div>
      <h4>Administration &amp; Education</h4>
     </article>
    </div>
    <div class="col-12 col-md-6 col-lg-4">
     <article class="course-card">
      <div class="course-img"><img src="{{ asset('website/img/banner/15.png') }}" alt="Health, safety and food hygiene" loading="lazy"></div>
      <h4>Health, Safety &amp; Food Hygiene</h4>
     </article>
    </div>
    <div class="col-12 col-md-6 col-lg-4">
     <article class="course-card">
      <div class="course-img"><img src="{{ asset('website/img/banner/16.png') }}" alt="Professional development" loading="lazy"></div>
      <h4>Professional Development</h4>
     </article>
    </div>
    <div class="col-12 col-md-6 col-lg-4">
     <article class="course-card">
      <div class="course-img"><img src="{{ asset('website/img/banner/17.png') }}" alt="Adults and children safeguarding" loading="lazy"></div>
      <h4>Adults &amp; Children Safeguarding</h4>
     </article>
    </div>
    <div class="col-12 col-md-6 col-lg-4">
     <article class="course-card">
      <div class="course-img"><img src="{{ asset('website/img/banner/18.png') }}" alt="Employability workshops" loading="lazy"></div>
      <h4>Employability Workshops</h4>
     </article>
    </div>
   </div>
  </div>

  <!-- ENTERPRISE -->
  <div id="enterprise" class="course-group border-0 pb-0">
   <h3 class="group-title">Enterprise &amp; Creative Skills</h3>
   <p class="group-desc">Our Enterprise &amp; Creative Skills programmes help learners turn their passions into real income opportunities. Whether you love crafting, baking, or design, we’ll teach you how to build a small business, develop products, and sell your work confidently.</p>
   <div class="row g-4 g-lg-5">
    <div class="col-12 col-md-6">
     <article class="course-card course-card-wide">
      <div class="course-img"><img src="{{ asset('website/img/banner/19.png') }}" alt="Creative workshops" loading="lazy"></div>
      <h4>Creative Workshops</h4>
     </article>
    </div>
    <div class="col-12 col-md-6">
     <article class="course-card course-card-wide">
      <div class="course-img"><img src="{{ asset('website/img/banner/20.png') }}" alt="Entrepreneurship and mentorship" loading="lazy"></div>
      <h4>Entrepreneurship &amp; Mentorship</h4>
     </article>
    </div>
   </div>
   <p class="group-note">We also work with local businesses and community organisations to deliver flexible group training. If you think these courses could benefit your staff or clients, let’s connect!</p>
  </div>
 </section>

 <!-- CONTACT -->
 <section id="contact" class="contact">
  <div class="container-xl">
   <h2 class="contact-title text-center text-uppercase">Contact us</h2>

   <div class="row g-5">
    <!-- FORM -->
    <div class="col-lg-6">
     <h3 class="contact-h">Get in Touch!</h3>

     <form id="contactForm" action="{{ route('contact.store') }}" method="POST" enctype="multipart/form-data" novalidate>
      @csrf
      <input type="text" name="website" class="d-none" tabindex="-1" autocomplete="off" aria-hidden="true">

      <div class="cf-field">
       <label class="visually-hidden" for="cfName">Name</label>
       <input id="cfName" name="name" class="cf-input" placeholder="Name" autocomplete="name">
       <div class="cf-error" data-error="name"></div>
      </div>

      <div class="cf-field">
       <label class="visually-hidden" for="cfEmail">Email</label>
       <input id="cfEmail" name="email" type="email" class="cf-input" placeholder="Email*" required autocomplete="email">
       <div class="cf-error" data-error="email"></div>
      </div>

      <div class="cf-field">
       <label class="visually-hidden" for="cfMsg">Message</label>
       <textarea id="cfMsg" name="message" class="cf-input cf-textarea" placeholder="Message"></textarea>
       <div class="cf-error" data-error="message"></div>
      </div>

      <!-- Attachments -->
      <div class="cf-attach">
       <button type="button" class="cf-attach-btn" id="attachBtn">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"/></svg>
        Attach Files
       </button>
       <span class="cf-attach-count">Attachments (<span id="attachCount">0</span>)</span>
       <input type="file" id="fileInput" multiple accept=".pdf,.doc,.docx,.jpg,.jpeg,.png" hidden>
      </div>
      <ul id="fileList" class="cf-files list-unstyled"></ul>
      <div class="cf-error" data-error="attachments"></div>

      <button class="cf-send" type="submit" id="sendBtn">Send</button>

      <div id="cfStatus" class="cf-status" role="status" aria-live="polite"></div>

      <p class="cf-legal">This site is protected by reCAPTCHA and the Google <a href="#">Privacy Policy</a> and <a href="#">Terms of Service</a> apply.</p>
     </form>
    </div>

    <!-- DETAILS -->
    <div class="col-lg-6">
     <h3 class="contact-h">Are you ready to get started?</h3>
     <p class="contact-p">If you have questions about the opportunities available in our programs, feel free to send us a message. We will get back to you as soon as possible.</p>

     <h3 class="contact-h mt-5">Skill Up Notts LTD</h3>
     <p class="contact-p">Leaworks House, 10 Ronald Street, Nottingham, UK</p>
     <p class="contact-p contact-strong">
      <a href="tel:01157277256">0115 727 7256</a><br>
      <a href="mailto:info@skillupnotts.co.uk">info@skillupnotts.co.uk</a>
     </p>

     <h3 class="contact-h mt-5">Hours</h3>
     <div class="hours-box">
      <button type="button" class="hours-toggle" id="hoursToggle" aria-expanded="false" aria-controls="hoursList">
       <span class="hours-label">Today</span>
       <span class="hours-today" id="hoursToday">Closed</span>
       <svg class="hours-chev" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><polyline points="6 9 12 15 18 9"/></svg>
      </button>

      <table class="hours" id="hoursList" hidden>
       <tr data-day="1"><th>Mon</th><td>09:00 – 17:00</td></tr>
       <tr data-day="2"><th>Tue</th><td>09:00 – 17:00</td></tr>
       <tr data-day="3"><th>Wed</th><td>09:00 – 17:00</td></tr>
       <tr data-day="4"><th>Thu</th><td>09:00 – 17:00</td></tr>
       <tr data-day="5"><th>Fri</th><td>09:00 – 17:00</td></tr>
       <tr data-day="6"><th>Sat</th><td>Closed</td></tr>
       <tr data-day="0"><th>Sun</th><td>Closed</td></tr>
      </table>
     </div>
    </div>
   </div>
  </div>
 </section>

 <!-- MAP -->
 <section class="map-wrap" aria-label="Map showing Skill Up Notts location">
  <iframe
   src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2403.5072670990626!2d-1.171359223403823!3d52.957288503762506!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4879c18bd6866099%3A0x8a8f6d26f05a3937!2sLeaworks%20House%2C%2010%20Ronald%20St%2C%20Nottingham%20NG7%203GY!5e0!3m2!1sen!2suk!4v1792199606442!5m2!1sen!2suk"
   title="Leaworks House, 10 Ronald Street, Nottingham"
   allowfullscreen
   loading="lazy"
   referrerpolicy="strict-origin-when-cross-origin"></iframe>

  <a class="map-directions" target="_blank" rel="noopener"
     href="https://www.google.com/maps/dir/?api=1&destination=Leaworks+House+10+Ronald+Street+Nottingham+NG7+3GY">
   <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M3 11l19-9-9 19-2-8-8-2z"/></svg>
   Get directions
  </a>
 </section>

 <!-- PARTNERS -->
 <section class="partners container-xl text-center">
  <h2 class="partners-title">Our Partners</h2>
  <div class="row align-items-center g-4 g-md-5">
   <div class="col-12 col-md-4">
    <div class="partner-logo">
     <img src="{{ asset('website/img/banner/21.png') }}" alt="Trinity College London – Secure English Language Tests, Approved Service Provider" loading="lazy">
    </div>
   </div>
   <div class="col-12 col-md-4">
    <div class="partner-logo">
     <img src="{{ asset('website/img/banner/22.png') }}" alt="Flexebee – The future is certified" loading="lazy">
    </div>
   </div>
   <div class="col-12 col-md-4">
    <div class="partner-logo">
     <img src="{{ asset('website/img/banner/23.png') }}" alt="NOCN – Part of NOCN Group, Approved Centre" loading="lazy">
    </div>
   </div>
  </div>
 </section>

</main>

<footer class="text-center small text-secondary pb-4">
 <div class="container">Copyright © 2026 Skill Up Notts LTD – All Rights Reserved.<br><a href="#" class="link-secondary">Privacy Policy</a></div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
// Header: visible by default, becomes sticky (fixed) once you scroll past it
(function () {
  const header = document.getElementById('siteHeader');
  const spacer = document.getElementById('headerSpacer');
  let headerH = header.offsetHeight;
  let ticking = false;

  function measure() {
    if (!header.classList.contains('is-stuck')) {
      headerH = header.offsetHeight;
      spacer.style.height = headerH + 'px';
    }
  }
  function onScroll() {
    const stuck = window.scrollY > headerH;
    if (stuck !== header.classList.contains('is-stuck')) {
      header.classList.toggle('is-stuck', stuck);
    }
    ticking = false;
  }
  window.addEventListener('scroll', function () {
    if (!ticking) { requestAnimationFrame(onScroll); ticking = true; }
  }, { passive: true });
  window.addEventListener('resize', measure);
  window.addEventListener('load', function () { measure(); onScroll(); });
  measure(); onScroll();
})();
</script>

<script>
// Contact form (AJAX + attachments)
(function () {
  const form = document.getElementById('contactForm');
  if (!form) return;

  const fileInput = document.getElementById('fileInput');
  const attachBtn = document.getElementById('attachBtn');
  const fileList  = document.getElementById('fileList');
  const countEl   = document.getElementById('attachCount');
  const sendBtn   = document.getElementById('sendBtn');
  const statusEl  = document.getElementById('cfStatus');
  const MAX_FILES = 5, MAX_SIZE = 5 * 1024 * 1024;
  let files = [];

  attachBtn.addEventListener('click', () => fileInput.click());

  fileInput.addEventListener('change', () => {
    clearError('attachments');
    for (const f of fileInput.files) {
      if (files.length >= MAX_FILES) { showError('attachments', 'You can attach up to 5 files.'); break; }
      if (f.size > MAX_SIZE) { showError('attachments', f.name + ' is larger than 5 MB.'); continue; }
      files.push(f);
    }
    fileInput.value = '';
    renderFiles();
  });

  function renderFiles() {
    countEl.textContent = files.length;
    fileList.innerHTML = '';
    files.forEach((f, i) => {
      const li = document.createElement('li');
      const nm = document.createElement('span');
      nm.className = 'nm'; nm.textContent = f.name;
      const rm = document.createElement('button');
      rm.type = 'button'; rm.setAttribute('aria-label', 'Remove ' + f.name); rm.innerHTML = '&times;';
      rm.addEventListener('click', () => { files.splice(i, 1); renderFiles(); });
      li.append(nm, rm); fileList.appendChild(li);
    });
  }

  function showError(field, msg) {
    const el = form.querySelector('[data-error="' + field + '"]');
    if (el) el.textContent = msg;
    const input = form.querySelector('[name="' + field + '"]');
    if (input) input.classList.add('is-invalid');
  }
  function clearError(field) {
    const el = form.querySelector('[data-error="' + field + '"]');
    if (el) el.textContent = '';
    const input = form.querySelector('[name="' + field + '"]');
    if (input) input.classList.remove('is-invalid');
  }
  function clearAll() {
    ['name','email','message','attachments'].forEach(clearError);
    statusEl.textContent = ''; statusEl.className = 'cf-status';
  }

  form.addEventListener('submit', async (e) => {
    e.preventDefault();
    clearAll();

    const email = form.email.value.trim();
    if (!email || !/^\S+@\S+\.\S+$/.test(email)) {
      showError('email', 'Please enter a valid email address.');
      form.email.focus();
      return;
    }

    const fd = new FormData(form);
    files.forEach(f => fd.append('attachments[]', f));

    sendBtn.disabled = true; sendBtn.textContent = 'Sending…';
    try {
      const res = await fetch(form.action, {
        method: 'POST',
        body: fd,
        headers: { 'Accept': 'application/json', 'X-Requested-With': 'XMLHttpRequest' }
      });
      const data = await res.json().catch(() => ({}));

      if (res.status === 422 && data.errors) {
        Object.entries(data.errors).forEach(([key, msgs]) => {
          const field = key.startsWith('attachments') ? 'attachments' : key;
          showError(field, msgs[0]);
        });
      } else if (res.status === 429) {
        statusEl.textContent = 'Too many attempts. Please wait a minute and try again.';
        statusEl.className = 'cf-status err';
      } else if (res.ok) {
        statusEl.textContent = data.message || 'Thank you! Your message has been sent.';
        statusEl.className = 'cf-status ok';
        form.reset(); files = []; renderFiles();
      } else {
        statusEl.textContent = 'Something went wrong. Please try again.';
        statusEl.className = 'cf-status err';
      }
    } catch (err) {
      statusEl.textContent = 'Network error. Please check your connection and try again.';
      statusEl.className = 'cf-status err';
    } finally {
      sendBtn.disabled = false; sendBtn.textContent = 'Send';
    }
  });
})();
</script>

<script>
// Hours: collapsed line shows today's hours (UK time); list bolds today
(function () {
  const toggle = document.getElementById('hoursToggle');
  const list   = document.getElementById('hoursList');
  const label  = document.getElementById('hoursToday');
  if (!toggle || !list) return;

  const names = ['Sun','Mon','Tue','Wed','Thu','Fri','Sat'];
  const wk  = new Intl.DateTimeFormat('en-GB', { weekday: 'short', timeZone: 'Europe/London' }).format(new Date());
  const idx = names.indexOf(wk.slice(0, 3));
  const row = list.querySelector('tr[data-day="' + idx + '"]');
  if (row) {
    row.classList.add('today');
    label.textContent = row.querySelector('td').textContent;
  }

  toggle.addEventListener('click', () => {
    const open = toggle.getAttribute('aria-expanded') === 'true';
    toggle.setAttribute('aria-expanded', String(!open));
    list.hidden = open;
  });
})();
</script>

</body>
</html>