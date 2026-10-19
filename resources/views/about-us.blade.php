<!DOCTYPE html>
<html lang="en-GB">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>About Us | Skill Up Notts</title>
<meta name="description" content="Skill Up Notts is an adult education college in Radford, Nottingham, helping people of all backgrounds gain the skills, confidence and qualifications they need.">
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

/* ---------- About ---------- */
.about{background:var(--slate);color:#fff;padding-block:clamp(2rem,5vw,3.5rem) clamp(2.5rem,6vw,4.5rem)}
.about h1{text-align:center;font-size:clamp(1.8rem,4.5vw,2.75rem);text-transform:uppercase;margin-bottom:clamp(1.5rem,4vw,2.5rem)}
.about-hero{display:block;width:100%;aspect-ratio:16/9;object-fit:cover;object-position:50% 30%}
.about-block{margin-top:clamp(2rem,5vw,3.25rem)}
.about h2{font-family:"Poppins",system-ui,sans-serif;font-weight:500;font-size:clamp(1.2rem,2vw,1.45rem);margin-bottom:1rem}
.about p{font-size:.95rem;line-height:1.8;color:#e3e8f0;max-width:75ch;margin-bottom:.9rem}
.about strong{color:#fff;font-weight:600}
.values{list-style:none;margin:0;padding:0}
.values li{padding:.15rem 0 .15rem 1rem;border-left:3px solid var(--gold);margin-bottom:1.1rem;font-size:.95rem;line-height:1.6;color:#e3e8f0}
.facilities{display:block;width:100%;height:auto;background:#fafafa}
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
      <li class="nav-item"><a class="nav-link active" aria-current="page" href="{{ url('/about-us') }}">About us</a></li>
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
      <li class="nav-item"><a class="nav-link" href="{{ url('/trinity-selt-preparation') }}">Trinity SELT Preparation</a></li>
      <li class="nav-item"><a class="nav-link" href="{{ route('vacancies.public.index') }}">Vacancies</a></li>
     </ul>
    </div>
   </div>
  </div>
 </nav>
</header>
</div>

<main class="about">
 <div class="container-xl">

  <h1 class="serif">About Skill Up Notts Ltd</h1>

  <img class="about-hero" src="{{ asset('website/img/about/about-hero.png') }}"
       alt="Smiling adult learners sitting together and talking" width="1024" height="1024">

  <section class="about-block">
   <h2>About us</h2>
   <p>At Skill Up Notts LTD, we believe that everyone has the potential to learn and grow, regardless of their background or experience, and every step forward starts with learning.</p>
   <p>We are an adult education college based in <strong>Radford, Nottingham</strong>, dedicated to helping people of all backgrounds gain the skills, confidence, and qualifications they need to succeed in life and work.</p>
   <p>Our mission is simple: to make learning accessible, practical, and inspiring for everyone. Whether you’re returning to education, improving your English, gaining a vocational qualification, or building digital skills, Skill Up Notts provides the support and training to help you achieve your goals.</p>
   <p>We are committed to providing a supportive and inclusive environment where all students can thrive and achieve their goals.</p>
  </section>

  <div class="row g-4 g-lg-5 about-block">
   <section class="col-lg-6">
    <h2>Our story</h2>
    <p>Skill Up Notts began as a local initiative to meet the growing demand for adult education and skills training in our community.</p>
    <p>We saw how many people wanted to learn, improve, and find better opportunities, but didn’t always know where to start.</p>
    <p>Today, we’re proud to offer a wide range of courses from <strong>ESOL and English</strong>, to <strong>Digital Skills</strong>, <strong>Vocational Training</strong>, <strong>Employability Training</strong> and <strong>Enterprise &amp; Creative Programmes</strong>, leading to further education, local placements, employment or entrepreneurship.</p>
    <p>Our learners include adults from all walks of life: professionals upskilling for work, parents returning to study, and community members discovering new talents.</p>
   </section>

   <section class="col-lg-6">
    <h2>Our values</h2>
    <ul class="values">
     <li><strong>Empowerment:</strong> Every learner has potential.</li>
     <li><strong>Inclusivity:</strong> Everyone is welcome, whatever their background.</li>
     <li><strong>Progress:</strong> Small steps lead to big change.</li>
     <li><strong>Community:</strong> We grow stronger together.</li>
    </ul>
   </section>
  </div>

  <div class="about-block">
   <img class="facilities" src="{{ asset('website/img/about/about-facilities.png') }}"
        alt="Skill Up Notts centre: classrooms with tables and blue chairs, a computer suite, a teaching screen and a children’s play corner"
        width="2000" height="1545" loading="lazy">
  </div>

  <section class="about-block">
   <h2>Our resources</h2>
   <p>At <strong>Skill Up Notts</strong>, we’re proud to offer a wide range of resources designed to make learning practical, accessible, and inspiring. Our aim is to give every learner the tools and support they need to succeed.</p>
   <p>We provide up-to-date learning materials, interactive online resources, and specialist study guides tailored to each course. Whether you’re developing new digital skills, improving your English, or working towards a vocational qualification, you’ll always have clear, structured materials to guide your progress.</p>
   <p>Our learners also benefit from access to dedicated study areas, computers, and online learning platforms, all supported by friendly staff who are here to help. We combine traditional teaching with modern technology, ensuring you can learn in ways that suit your style and pace.</p>
   <p>Beyond the classroom, our support team can connect you with career advice, job-search tools, and local opportunities, so you can put your new skills into action.</p>
   <p>At <strong>Skill Up Notts</strong>, every resource we offer is designed to help you learn with confidence and build a brighter future.</p>
  </section>

 </div>
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