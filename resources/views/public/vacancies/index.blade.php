@extends('layouts.front')

@section('title', 'Careers | ' . ($appSetting->app_name ?? config('app.name')))

@section('page_banner')
    <h1>Careers</h1>
    <p>Join the {{ $appSetting->app_name ?? config('app.name') }} team.</p>
@endsection

@section('content')

<div class="service sp_bottom_140 special__spacing sp_top_160" id="tb__careers__page">
    <div class="container">

        <div class="row">
            <div class="col-xl-12">
                <div class="section__title text-center sp_bottom_90">
                    <div class="section__title__button"><span class="text__gradient">Careers</span></div>
                    <div class="section__title__heading">
                        <h3>JOIN THE {{ strtoupper($appSetting->app_name ?? config('app.name')) }} TEAM</h3>
                    </div>
                    <div class="section__title__text">
                        <p>Explore our current openings below.</p>
                    </div>
                </div>
            </div>
        </div>

        @if(session('status'))
            <div class="alert alert-success text-center">{{ session('status') }}</div>
        @endif

        @if($vacancies->count() > 0)

            {{-- ============== Search / filter ============== --}}
            <form method="GET" class="row g-2 justify-content-center mb-5">
                <div class="col-md-4">
                    <input type="text" name="search" class="contact__common__input" placeholder="Job title, department..."
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-3">
                    <input type="text" name="location" class="contact__common__input" placeholder="Location"
                           value="{{ request('location') }}">
                </div>
                <div class="col-md-2">
                    <button type="submit" class="default__button w-100">SEARCH</button>
                </div>
            </form>

            {{-- ============== Job cards ============== --}}
            <div class="row">
                @foreach($vacancies as $vacancy)
                    <div class="col-xl-4 col-lg-4 col-md-6 col-sm-6 col-12 mb-4" data-aos="fade-up">
                        <a href="{{ route('vacancies.public.show', $vacancy) }}" class="text-decoration-none">
                            <div class="service__single__wraper common__gradient__bg single__transform h-100">
                                <div class="service__single__inner">
                                    <div class="service__content">
                                        <div class="service__heading">
                                            <h5>{{ $vacancy->title }}</h5>
                                        </div>
                                        <div class="service__text">
                                            <p class="mb-1">
                                                @if($vacancy->department)
                                                    <i class="icofont-briefcase"></i> {{ $vacancy->department }}
                                                @endif
                                                @if($vacancy->location)
                                                    &nbsp;·&nbsp;<i class="icofont-location-pin"></i> {{ $vacancy->location }}
                                                @endif
                                            </p>
                                            <p>{{ \Illuminate\Support\Str::limit(strip_tags($vacancy->description), 110) }}</p>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <span class="badge text-bg-light border">{{ \App\Models\Vacancy::TYPES[$vacancy->type] }}</span>
                                            @if($vacancy->deadline)
                                                <span class="small text-muted">Apply by {{ $vacancy->deadline->format('M d, Y') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="d-flex justify-content-center mt-3">
                {{ $vacancies->links() }}
            </div>

        @else

            {{-- ============== No openings: simple apply form ============== --}}
            <div class="row justify-content-center">
                <div class="col-xl-7 col-lg-8 col-md-10 col-12">

                    <div class="alert alert-info text-center mb-4">
                        We have no open positions right now, but we're always interested in meeting talented people.
                        Leave your details below and we'll reach out when a suitable role opens up.
                    </div>

                    <div class="apply-card">
                        <div class="apply-card__accent"></div>
                        <div class="apply-card__body">

                            <div class="apply-card__header mb-4">
                                <span class="apply-card__icon"><i class="icofont-paper-plane"></i></span>
                                <div>
                                    <h5 class="mb-0">Submit Your Details</h5>
                                    <p class="text-muted small mb-0">We'll reach out if a role opens up</p>
                                </div>
                            </div>

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

                                <div class="apply-field mb-3">
                                    <label class="apply-label">Full Name</label>
                                    <div class="apply-input-group">
                                        <i class="icofont-user apply-input-icon"></i>
                                        <input type="text" name="name" class="apply-input" placeholder="Jane Doe" value="{{ old('name') }}" required>
                                    </div>
                                </div>

                                <div class="apply-field mb-3">
                                    <label class="apply-label">Email</label>
                                    <div class="apply-input-group">
                                        <i class="icofont-envelope apply-input-icon"></i>
                                        <input type="email" name="email" class="apply-input" placeholder="jane@example.com" value="{{ old('email') }}" required>
                                    </div>
                                </div>

                                <div class="apply-field mb-3">
                                    <label class="apply-label">Phone</label>
                                    <div class="apply-input-group">
                                        <i class="icofont-phone apply-input-icon"></i>
                                        <input type="text" name="phone" class="apply-input" placeholder="+92 300 1234567" value="{{ old('phone') }}" required>
                                    </div>
                                </div>

                                <div class="apply-field mb-4">
                                    <label class="apply-label">Resume</label>
                                    <label class="apply-dropzone" for="generalResumeInput" id="generalDropzoneLabel">
                                        <i class="icofont-upload-alt apply-dropzone__icon"></i>
                                        <span class="apply-dropzone__text" id="generalDropzoneText">
                                            <strong>Click to upload</strong> your resume<br>
                                            <span class="text-muted small">PDF or Word, max 5MB</span>
                                        </span>
                                    </label>
                                    <input type="file" name="resume" id="generalResumeInput" class="apply-dropzone__input" accept=".pdf,.doc,.docx" required>
                                </div>

                                <button type="submit" class="apply-submit">
                                    <span>Submit</span>
                                    <i class="icofont-arrow-right ms-1"></i>
                                </button>

                            </form>
                        </div>
                    </div>

                </div>
            </div>

        @endif

    </div>
</div>

@endsection

@push('styles')
<style>
    .job-meta__pill {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #F5F4FA;
        color: #46435A;
        border-radius: 30px;
        padding: 6px 14px;
        font-size: 13px;
        font-weight: 600;
        margin: 0 8px 8px 0;
    }
    .job-meta__pill--accent {
        background: linear-gradient(90deg, #3E5B54, #4F6B63, #607570);
        color: #fff;
    }

    .apply-card {
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 20px 50px rgba(10, 6, 36, 0.10);
        overflow: hidden;
    }
    .apply-card__accent {
        height: 6px;
        background: linear-gradient(90deg, #3E5B54, #4F6B63, #607570);
    }
    .apply-card__body { padding: 32px; }
    .apply-card__header { display: flex; align-items: center; gap: 14px; }
    .apply-card__icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 46px;
        height: 46px;
        min-width: 46px;
        border-radius: 14px;
        background: linear-gradient(135deg, #3E5B54, #607570);
        color: #fff;
        font-size: 18px;
    }

    .apply-label {
        display: block;
        font-size: 13px;
        font-weight: 700;
        color: #0A0624;
        margin-bottom: 6px;
    }
    .apply-input-group { position: relative; display: flex; align-items: center; }
    .apply-input-icon { position: absolute; left: 16px; color: #A6A3B8; font-size: 16px; }
    .apply-input {
        width: 100%;
        padding: 13px 16px 13px 44px;
        border: 1.5px solid #E9E7F3;
        border-radius: 12px;
        font-size: 14px;
        background: #FBFAFE;
        transition: border-color .15s ease, box-shadow .15s ease, background .15s ease;
    }
    .apply-input:focus {
        outline: none;
        border-color: #4F6B63;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(79, 107, 99, 0.08);
    }

    .apply-dropzone {
        display: flex;
        align-items: center;
        gap: 14px;
        border: 1.5px dashed #C9C6DC;
        border-radius: 14px;
        padding: 18px;
        cursor: pointer;
        background: #FBFAFE;
        transition: border-color .15s ease, background .15s ease;
    }
    .apply-dropzone:hover { border-color: #4F6B63; background: #F7F9F8; }
    .apply-dropzone--filled { border-style: solid; border-color: #2ecc71; background: #F3FCF6; }
    .apply-dropzone__icon { font-size: 22px; color: #4F6B63; }
    .apply-dropzone__text { font-size: 14px; color: #46435A; line-height: 1.5; }
    .apply-dropzone__input { display: none; }

    .apply-submit {
        width: 100%;
        border: none;
        border-radius: 12px;
        padding: 15px;
        font-weight: 700;
        letter-spacing: .5px;
        color: #fff;
        background: linear-gradient(90deg, #3E5B54, #4F6B63, #607570);
        background-size: 200% auto;
        transition: background-position .4s ease, transform .1s ease;
    }
    .apply-submit:hover { background-position: right center; }
    .apply-submit:active { transform: scale(0.99); }
</style>
@endpush

@push('scripts')
<script>
    const generalResumeInput = document.getElementById('generalResumeInput');
    if (generalResumeInput) {
        generalResumeInput.addEventListener('change', function () {
            if (this.files[0]) {
                document.getElementById('generalDropzoneLabel').classList.add('apply-dropzone--filled');
                document.getElementById('generalDropzoneText').innerHTML =
                    `<strong>${this.files[0].name}</strong><br><span class="text-muted small">Click to change file</span>`;
            }
        });
    }
</script>
@endpush