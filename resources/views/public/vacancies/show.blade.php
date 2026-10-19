<!DOCTYPE html>
<html lang="en-GB">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>{{ $vacancy->title }} | Skill Up Notts</title>
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
    :root{--gold:#f5b21b;--ink:#222a38;--muted:#5d6676;--line:#e3e6ec;--bg:#f5f6f9}
    body{background:#fff}
    .vacancy{background:var(--bg)}

    /* Buttons */
    .btn-navy{background:var(--navy);border:1.5px solid var(--navy);color:#fff;font-weight:500;padding:.75rem 1.5rem;border-radius:10px}
    .btn-navy:hover,.btn-navy:focus-visible{background:#232d40;border-color:#232d40;color:#fff}
    .btn-navy:disabled{opacity:.7}
    .btn-gold{background:var(--gold);border:0;color:#1c2536;font-weight:600;padding:.8rem 1.6rem;border-radius:10px}
    .btn-gold:hover,.btn-gold:focus-visible{background:#e3a20f;color:#1c2536}

    /* Hero */
    .vhero{background:linear-gradient(135deg,#2f3b52 0%,#243044 100%);color:#fff;padding:clamp(2rem,5vw,3.5rem) 0 clamp(2.25rem,5vw,3.75rem)}
    .back-link{display:inline-flex;align-items:center;gap:.4rem;margin-bottom:1.25rem;color:#cfd7e4;font-size:.88rem;text-decoration:none}
    .back-link:hover{color:#fff}
    .vhero h1{font-size:clamp(1.75rem,4.2vw,2.75rem);font-weight:600;line-height:1.2;margin:0 0 1.25rem;max-width:22ch}
    .chips{display:flex;flex-wrap:wrap;gap:.5rem;margin-bottom:1.75rem}
    .chip{display:inline-flex;align-items:center;background:rgba(255,255,255,.1);border:1px solid rgba(255,255,255,.22);color:#fff;font-size:.82rem;font-weight:500;padding:.35rem .85rem;border-radius:999px}
    .chip--type{background:var(--gold);border-color:var(--gold);color:#1c2536;font-weight:600}
    .vhero .btn-gold{width:100%}
    @media (min-width:576px){.vhero .btn-gold{width:auto}}

    /* Content cards */
    .vbody{padding-block:clamp(1.75rem,4vw,3rem)}
    .panel{background:#fff;border:1px solid var(--line);border-radius:16px;padding:clamp(1.25rem,3vw,2.25rem);margin-bottom:1.5rem;box-shadow:0 1px 2px rgba(20,30,50,.04)}
    .panel > h2{font-size:1.2rem;font-weight:600;color:var(--navy);margin:0 0 1.1rem;padding-left:.85rem;border-left:4px solid var(--gold);line-height:1.2}
    .job-body{color:#333c4d;line-height:1.8;font-size:.97rem}
    .job-body h3{font-size:1.02rem;font-weight:600;color:var(--navy);margin:1.6rem 0 .5rem}
    .job-body h3:first-child{margin-top:0}
    .job-body p{margin:0 0 .8rem}
    .job-body ul{padding-left:1.25rem;margin:0 0 1rem}
    .job-body li{margin-bottom:.4rem}
    .job-body li::marker{color:var(--gold)}

    /* Overview sidebar */
    .overview{background:#fff;border:1px solid var(--line);border-radius:16px;padding:1.5rem;box-shadow:0 1px 2px rgba(20,30,50,.04)}
    .overview h2{font-size:1.05rem;font-weight:600;color:var(--navy);margin:0 0 1.1rem}
    .overview dl{margin:0}
    .overview dt{font-size:.72rem;font-weight:600;letter-spacing:.07em;text-transform:uppercase;color:var(--muted);margin-bottom:.15rem}
    .overview dd{margin:0 0 1rem;font-weight:500;color:var(--ink)}
    .overview .deadline{background:#fff7e0;border:1px solid #f3dd9a;border-radius:10px;padding:.7rem .9rem;font-size:.88rem;color:#6b4e00;margin-bottom:1.1rem}
    @media (min-width:992px){.overview{position:sticky;top:96px}}

    /* Application form */
    .apply{scroll-margin-top:96px}
    .apply .lead-note{color:var(--muted);font-size:.9rem;margin:-.5rem 0 0}
    .form-section{margin-top:2rem;padding-top:1.75rem;border-top:1px solid #edf0f4}
    .form-section:first-of-type{border-top:0;padding-top:0;margin-top:1.5rem}
    .section-head{display:flex;align-items:center;gap:.75rem;margin-bottom:1.1rem}
    .section-head .num{display:inline-flex;align-items:center;justify-content:center;flex:0 0 2rem;width:2rem;height:2rem;border-radius:50%;background:var(--navy);color:#fff;font-size:.85rem;font-weight:600}
    .section-head h3{font-size:1.02rem;font-weight:600;color:var(--navy);margin:0}
    .apply .form-label,.apply legend.form-label{font-size:.85rem;font-weight:500;color:var(--navy);margin-bottom:.4rem}
    .apply legend.form-label{float:none;width:auto;padding:0;display:block}
    .apply .form-control,.apply .form-select{border:1.5px solid #d5d9e1;border-radius:10px;padding:.7rem .9rem;font-size:.95rem;background-color:#fcfcfd}
    .apply .form-control:focus,.apply .form-select:focus{border-color:var(--navy);background-color:#fff;box-shadow:0 0 0 .2rem rgba(47,59,82,.14)}
    .apply .is-invalid{border-color:#c0392b}
    .req{color:#c0392b}
    .field-error{color:#b02a1c;font-size:.82rem;margin-top:.35rem}

    .seg{display:flex;flex-wrap:wrap;gap:.5rem}
    .btn-seg{border:1.5px solid #d5d9e1;border-radius:10px;padding:.55rem 1.6rem;font-weight:500;color:var(--navy);background:#fff;min-width:5.5rem}
    .btn-seg:hover{border-color:var(--navy);color:var(--navy)}
    .btn-check:checked + .btn-seg{background:var(--navy);border-color:var(--navy);color:#fff}
    .btn-check:focus-visible + .btn-seg{box-shadow:0 0 0 .2rem rgba(47,59,82,.25)}

    .declaration{background:#f5f6f9;border:1px solid var(--line);border-radius:12px;padding:1rem 1.1rem}
    .declaration .form-check-input{width:1.15em;height:1.15em;margin-top:.2em;border:1.5px solid #9aa3b2}
    .declaration .form-check-input:checked{background-color:var(--navy);border-color:var(--navy)}
    .declaration .form-check-label{font-size:.9rem;line-height:1.6;color:#333c4d}
    .submit-row{margin-top:2rem}
    .submit-row .btn{width:100%;padding:.9rem 1.5rem;font-size:1rem}
    @media (min-width:576px){.submit-row .btn{width:auto;min-width:240px}}

    /* Alerts */
    .alert{border-radius:12px}

    /* Mobile sticky apply bar */
    .apply-bar{position:fixed;left:0;right:0;bottom:0;z-index:1020;background:#fff;border-top:1px solid var(--line);box-shadow:0 -6px 18px rgba(20,30,50,.08);padding:.75rem 1rem calc(.75rem + env(safe-area-inset-bottom,0px));transition:transform .25s ease}
    .apply-bar.is-hidden{transform:translateY(110%)}
    @media (max-width:991.98px){body{padding-bottom:5rem}}
    @media (min-width:992px){.apply-bar{display:none}}
    @media (prefers-reduced-motion:reduce){.apply-bar{transition:none}}
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
        <li><a class="dropdown-item" href="{{ route('vacancies.index') }}">Vacancies</a></li>
       </ul>
      </li>
     </ul>
    </div>
   </div>
  </div>
 </nav>
</header>
</div>

<main class="vacancy">

    {{-- Hero --}}
    <section class="vhero">
        <div class="container-xl">
            <a href="{{ route('vacancies.public.index') }}" class="back-link">&larr; Back to all vacancies</a>
            <h1>{{ $vacancy->title }}</h1>

            <div class="chips">
                <span class="chip chip--type">{{ \App\Models\Vacancy::TYPES[$vacancy->type] }}</span>
                @if($vacancy->department)<span class="chip">{{ $vacancy->department }}</span>@endif
                @if($vacancy->location)<span class="chip">{{ $vacancy->location }}</span>@endif
                @if($vacancy->salary_range)<span class="chip">{{ $vacancy->salary_range }}</span>@endif
            </div>

            <a href="#apply" class="btn btn-gold">Apply now</a>
        </div>
    </section>

    <div class="vbody">
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

            @if($errors->any())
                <div class="alert alert-danger">
                    Your application wasn’t sent. Please check the highlighted fields in the <a href="#apply" class="alert-link">application form</a>.
                </div>
            @endif

            <div class="row g-4 g-xl-5">

                {{-- Sidebar: job overview (first on mobile, right on desktop) --}}
                <aside class="col-lg-4 order-1 order-lg-2">
                    <div class="overview">
                        <h2>Job overview</h2>

                        @if($vacancy->deadline)
                            <div class="deadline">Applications close on <strong>{{ $vacancy->deadline->format('j M Y') }}</strong></div>
                        @endif

                        <dl>
                            <dt>Job type</dt>
                            <dd>{{ \App\Models\Vacancy::TYPES[$vacancy->type] }}</dd>
                            @if($vacancy->department)
                                <dt>Department</dt>
                                <dd>{{ $vacancy->department }}</dd>
                            @endif
                            @if($vacancy->location)
                                <dt>Location</dt>
                                <dd>{{ $vacancy->location }}</dd>
                            @endif
                            @if($vacancy->salary_range)
                                <dt>Salary</dt>
                                <dd>{{ $vacancy->salary_range }}</dd>
                            @endif
                        </dl>

                        <a href="#apply" class="btn btn-navy w-100">Apply for this job</a>
                    </div>
                </aside>

                {{-- Main content --}}
                <div class="col-lg-8 order-2 order-lg-1">

                    <section class="panel">
                        <h2>Job description</h2>
                        <div class="job-body">{!! \App\Support\JobText::format($vacancy->description) !!}</div>
                    </section>

                    @if($vacancy->requirements)
                        <section class="panel">
                            <h2>Requirements</h2>
                            <div class="job-body">{!! \App\Support\JobText::format($vacancy->requirements) !!}</div>
                        </section>
                    @endif

                    {{-- Application form --}}
                    <section class="panel apply" id="apply">
                        <h2>Apply for this job</h2>
                        <p class="lead-note">Fields marked <span class="req">*</span> are required.</p>

                        <form action="{{ route('vacancies.public.apply', $vacancy) }}" method="POST" enctype="multipart/form-data" id="applyForm" novalidate>
                            @csrf

                            {{-- 1. Personal details --}}
                            <div class="form-section">
                                <div class="section-head"><span class="num">1</span><h3>Personal details</h3></div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="name" class="form-label">Full name <span class="req">*</span></label>
                                        <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" autocomplete="name" required>
                                        @error('name')<div class="field-error">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="email" class="form-label">Email address <span class="req">*</span></label>
                                        <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" autocomplete="email" required>
                                        @error('email')<div class="field-error">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="phone" class="form-label">Contact number <span class="req">*</span></label>
                                        <input type="tel" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}" autocomplete="tel" required>
                                        @error('phone')<div class="field-error">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="current_location" class="form-label">Current location (town/city) <span class="req">*</span></label>
                                        <input type="text" id="current_location" name="current_location" class="form-control @error('current_location') is-invalid @enderror" value="{{ old('current_location') }}" autocomplete="address-level2" required>
                                        @error('current_location')<div class="field-error">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>

                            {{-- 2. Qualifications and experience --}}
                            <div class="form-section">
                                <div class="section-head"><span class="num">2</span><h3>Qualifications and experience</h3></div>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <label for="highest_qualification" class="form-label">Highest qualification <span class="req">*</span></label>
                                        <select id="highest_qualification" name="highest_qualification" class="form-select @error('highest_qualification') is-invalid @enderror" required>
                                            <option value="">Select…</option>
                                            @foreach(\App\Models\Application::QUALIFICATIONS as $value => $label)
                                                <option value="{{ $value }}" @selected(old('highest_qualification') === $value)>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                        @error('highest_qualification')<div class="field-error">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="col-md-6">
                                        <label for="years_experience" class="form-label">Years of relevant experience <span class="req">*</span></label>
                                        <select id="years_experience" name="years_experience" class="form-select @error('years_experience') is-invalid @enderror" required>
                                            <option value="">Select…</option>
                                            @foreach(\App\Models\Application::EXPERIENCE as $value => $label)
                                                <option value="{{ $value }}" @selected(old('years_experience') === $value)>{{ $label }}</option>
                                            @endforeach
                                        </select>
                                        @error('years_experience')<div class="field-error">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>

                            {{-- 3. Right to work --}}
                            <div class="form-section">
                                <div class="section-head"><span class="num">3</span><h3>Right to work</h3></div>
                                <div class="row g-4">
                                    <div class="col-md-6">
                                        <fieldset>
                                            <legend class="form-label">Do you currently have the right to work in the UK? <span class="req">*</span></legend>
                                            <div class="seg" role="radiogroup">
                                                @foreach(['yes' => 'Yes', 'no' => 'No'] as $value => $label)
                                                    <input type="radio" class="btn-check" name="right_to_work" id="rtw_{{ $value }}" value="{{ $value }}" autocomplete="off" @checked(old('right_to_work') === $value) required>
                                                    <label class="btn btn-seg" for="rtw_{{ $value }}">{{ $label }}</label>
                                                @endforeach
                                            </div>
                                            @error('right_to_work')<div class="field-error">{{ $message }}</div>@enderror
                                        </fieldset>
                                    </div>
                                    <div class="col-md-6">
                                        <fieldset>
                                            <legend class="form-label">Will you require visa sponsorship? <span class="req">*</span></legend>
                                            <div class="seg" role="radiogroup">
                                                @foreach(['yes' => 'Yes', 'no' => 'No'] as $value => $label)
                                                    <input type="radio" class="btn-check" name="requires_sponsorship" id="spons_{{ $value }}" value="{{ $value }}" autocomplete="off" @checked(old('requires_sponsorship') === $value) required>
                                                    <label class="btn btn-seg" for="spons_{{ $value }}">{{ $label }}</label>
                                                @endforeach
                                            </div>
                                            @error('requires_sponsorship')<div class="field-error">{{ $message }}</div>@enderror
                                        </fieldset>
                                    </div>
                                </div>
                            </div>

                            {{-- 4. Supporting information --}}
                            <div class="form-section">
                                <div class="section-head"><span class="num">4</span><h3>Supporting information</h3></div>
                                <label for="suitability" class="form-label">Why do you consider yourself suitable for this position? <span class="text-secondary fw-normal">(maximum 150 words)</span></label>
                                <textarea id="suitability" name="suitability" rows="6" class="form-control @error('suitability') is-invalid @enderror">{{ old('suitability') }}</textarea>
                                <div class="d-flex justify-content-between gap-3 mt-1">
                                    <div>@error('suitability')<div class="field-error mt-0">{{ $message }}</div>@enderror</div>
                                    <small id="wordCount" class="text-secondary text-nowrap">0 / 150 words</small>
                                </div>
                            </div>

                            {{-- 5. Upload CV --}}
                            <div class="form-section">
                                <div class="section-head"><span class="num">5</span><h3>Upload CV</h3></div>
                                <label for="resumeInput" class="form-label">Upload CV (PDF or Word) <span class="req">*</span></label>
                                <input type="file" name="resume" id="resumeInput" class="form-control @error('resume') is-invalid @enderror" accept=".pdf,.doc,.docx" required>
                                <div class="form-text">PDF or Word, up to 5 MB.</div>
                                @error('resume')<div class="field-error">{{ $message }}</div>@enderror
                            </div>

                            {{-- 6. Declaration --}}
                            <div class="form-section">
                                <div class="section-head"><span class="num">6</span><h3>Declaration</h3></div>
                                <div class="declaration">
                                    <div class="form-check mb-0">
                                        <input class="form-check-input @error('declaration') is-invalid @enderror" type="checkbox" name="declaration" id="declaration" value="1" @checked(old('declaration')) required>
                                        <label class="form-check-label" for="declaration">
                                            I confirm that the information provided is accurate and agree to my personal information being processed for recruitment purposes in accordance with the privacy notice. <span class="req">*</span>
                                        </label>
                                    </div>
                                </div>
                                @error('declaration')<div class="field-error">{{ $message }}</div>@enderror
                            </div>

                            <div class="submit-row">
                                <button type="submit" class="btn btn-navy" id="applySubmit">Submit application</button>
                            </div>
                        </form>
                    </section>

                </div>
            </div>
        </div>
    </div>

</main>

{{-- Mobile sticky apply button --}}
<div class="apply-bar" id="applyBar">
    <a href="#apply" class="btn btn-gold w-100">Apply now</a>
</div>

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
<script>
(function () {
  // Live word counter for the 150-word answer
  const t = document.getElementById('suitability'), c = document.getElementById('wordCount');
  function count() {
    const n = (t.value.trim().match(/\S+/g) || []).length;
    c.textContent = n + ' / 150 words';
    c.classList.toggle('text-danger', n > 150);
    c.classList.toggle('text-secondary', n <= 150);
  }
  t.addEventListener('input', count); count();
  @if($errors->any())
  document.getElementById('apply').scrollIntoView();
  @endif
})();
</script>
<script>
// Hide the mobile "Apply now" bar once the form is on screen
(function () {
  const bar = document.getElementById('applyBar'), form = document.getElementById('apply');
  if (!bar || !form || !('IntersectionObserver' in window)) return;
  new IntersectionObserver(function (e) { bar.classList.toggle('is-hidden', e[0].isIntersecting); }, { threshold: 0.05 }).observe(form);
})();
</script>
<script>
document.getElementById('applyForm').addEventListener('submit', function () {
  const b = document.getElementById('applySubmit');
  b.textContent = 'Submitting...';
  b.disabled = true;
});
</script>
</body>
</html>