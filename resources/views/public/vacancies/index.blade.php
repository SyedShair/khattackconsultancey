<!DOCTYPE html>
<html lang="en-GB">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Careers | Skill Up Notts</title>
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
<style>
    .careers-intro{background:#f4f6f9;padding:3.5rem 0 3rem;border-bottom:1px solid #eef0f4}
    .careers-intro h1{font-size:clamp(1.8rem,4vw,2.5rem);font-weight:600;color:var(--navy);margin-bottom:.75rem}
    .careers-intro p{max-width:60ch;margin:0;color:#4a5568}

    .btn-navy{background:var(--navy);border-color:var(--navy);color:#fff;font-weight:500;padding:.65rem 1.25rem}
    .btn-navy:hover,.btn-navy:focus-visible{background:#232d40;border-color:#232d40;color:#fff}

    .careers .form-control{border-radius:0;border-color:#d5d9e1;padding:.65rem .85rem}
    .careers .form-control:focus{border-color:var(--navy);box-shadow:0 0 0 .2rem rgba(47,59,82,.15)}
    .careers .form-label{font-size:.85rem;font-weight:500;color:var(--navy)}

    .job-card{display:flex;flex-direction:column;padding:1.5rem;background:#fff;border:1px solid #e3e6ec;border-top:3px solid var(--navy);color:inherit;text-decoration:none;transition:box-shadow .2s ease}
    .job-card:hover,.job-card:focus-visible{box-shadow:0 8px 24px rgba(20,30,50,.1);color:inherit}
    .job-card h2{color:var(--navy);font-weight:600;margin-bottom:.35rem}
    .job-card__meta{font-size:.85rem;color:#6b7385;margin-bottom:.75rem}
    .job-card__desc{font-size:.9rem;color:#4a5568;flex:1}
    .job-card__foot{display:flex;justify-content:space-between;align-items:center;gap:.5rem;margin-top:1rem}
    .job-card__type{background:#eef0f4;color:var(--navy);font-weight:500}

    .apply-card{background:#fff;border:1px solid #e3e6ec;border-top:3px solid var(--navy);padding:2rem}
    .apply-card h2{color:var(--navy);font-weight:600}
    @media (max-width:575.98px){.apply-card{padding:1.25rem}}
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

<main id="careers" class="careers">

    {{-- Intro --}}
    <section class="careers-intro">
        <div class="container-xl">
            <h1>Careers at Skill Up Notts</h1>
            <p>Help adult learners in Nottingham build the language, digital and vocational skills they need for work and everyday life.</p>
        </div>
    </section>

    <section class="py-5">
        <div class="container-xl">

            @if(session('status'))
                <div class="alert alert-success text-center">
                    {{ session('status') }}
                    @if(session('download_url'))
                        <br>Your application PDF should download automatically.
                        <a href="{{ session('download_url') }}" id="appDownload" class="alert-link">Download it again</a>
                    @endif
                </div>
            @endif

            @if($vacancies->count() > 0)

                {{-- Search / filter --}}
                <form method="GET" class="row g-2 mb-4 careers-filter" role="search">
                    <div class="col-md-5">
                        <label for="search" class="visually-hidden">Job title or department</label>
                        <input type="text" id="search" name="search" class="form-control"
                               placeholder="Job title or department" value="{{ request('search') }}">
                    </div>
                    <div class="col-md-4">
                        <label for="location" class="visually-hidden">Location</label>
                        <input type="text" id="location" name="location" class="form-control"
                               placeholder="Location" value="{{ request('location') }}">
                    </div>
                    <div class="col-md-3 d-grid">
                        <button type="submit" class="btn btn-navy">Search jobs</button>
                    </div>
                </form>

                {{-- Job cards --}}
                <div class="row g-4">
                    @foreach($vacancies as $vacancy)
                        <div class="col-lg-4 col-md-6">
                            <a href="{{ route('vacancies.public.show', $vacancy) }}" class="job-card h-100">
                                <h2 class="h5">{{ $vacancy->title }}</h2>

                                @if($vacancy->department || $vacancy->location)
                                    <p class="job-card__meta">
                                        {{ collect([$vacancy->department, $vacancy->location])->filter()->implode(', ') }}
                                    </p>
                                @endif

                                <p class="job-card__desc">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($vacancy->description), 110) }}
                                </p>

                                <div class="job-card__foot">
                                    <span class="badge job-card__type">{{ \App\Models\Vacancy::TYPES[$vacancy->type] }}</span>
                                    @if($vacancy->deadline)
                                        <span class="small text-secondary">Apply by {{ $vacancy->deadline->format('j M Y') }}</span>
                                    @endif
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <div class="d-flex justify-content-center mt-5">
                    {{ $vacancies->links() }}
                </div>

            @else

                {{-- No openings: general application --}}
                <div class="row justify-content-center">
                    <div class="col-lg-7 col-md-10">

                        <div class="alert alert-light border mb-4">
                            We have no open roles right now. Send us your details and we'll contact you when a suitable role opens.
                        </div>

                        <div class="apply-card">
                            <h2 class="h5 mb-1">Send us your details</h2>
                            <p class="text-secondary small mb-4">We'll get in touch if a role opens up.</p>

                            @if($errors->any())
                                <div class="alert alert-danger">
                                    <ul class="mb-0">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('vacancies.public.applyGeneral') }}" method="POST" enctype="multipart/form-data" id="generalApplyForm">
                                @csrf

                                <div class="mb-3">
                                    <label for="name" class="form-label">Full name</label>
                                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" autocomplete="name" required>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" autocomplete="email" required>
                                </div>

                                <div class="mb-3">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="tel" id="phone" name="phone" class="form-control" value="{{ old('phone') }}" autocomplete="tel" required>
                                </div>

                                <div class="mb-4">
                                    <label for="generalResumeInput" class="form-label">Resume</label>
                                    <input type="file" name="resume" id="generalResumeInput" class="form-control" accept=".pdf,.doc,.docx" required>
                                    <div class="form-text">PDF or Word, up to 5 MB.</div>
                                </div>

                                <button type="submit" class="btn btn-navy w-100">Send my details</button>
                            </form>
                        </div>

                    </div>
                </div>

            @endif

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
<script>
// After a successful application, start the PDF download once
(function () {
  const link = document.getElementById('appDownload');
  if (link) setTimeout(() => { window.location.href = link.href; }, 600);
})();
</script>
</body>
</html>