@extends('layouts.front')

@section('title', $vacancy->title . ' | Careers | ' . ($appSetting->app_name ?? config('app.name')))

@section('content')

<div class="service sp_bottom_140 special__spacing inner__page__spacing" id="tb__vacancy__page">
    <div class="container">

        <a href="{{ route('vacancies.public.index') }}" class="d-inline-block mb-4 text-decoration-none back-link">
            &larr; Back to all vacancies
        </a>

        @if(session('status'))
            <div class="alert alert-success text-center">{{ session('status') }}</div>
        @endif

        <div class="row g-4">

            {{-- ============== Job details ============== --}}
            <div class="col-lg-7">
                <div class="section__title section__title--2 sp_bottom_30">
                    <div class="section__title__heading">
                        <h3 class="mb-2">{{ $vacancy->title }}</h3>
                    </div>
                </div>

                <div class="job-meta mb-3">
                    <span class="job-meta__pill job-meta__pill--accent">{{ \App\Models\Vacancy::TYPES[$vacancy->type] }}</span>
                    @if($vacancy->department)
                        <span class="job-meta__pill"><i class="icofont-briefcase"></i> {{ $vacancy->department }}</span>
                    @endif
                    @if($vacancy->location)
                        <span class="job-meta__pill"><i class="icofont-location-pin"></i> {{ $vacancy->location }}</span>
                    @endif
                    @if($vacancy->salary_range)
                        <span class="job-meta__pill"><i class="icofont-money"></i> {{ $vacancy->salary_range }}</span>
                    @endif
                </div>

                @if($vacancy->deadline)
                    <div class="alert alert-warning py-2 d-inline-flex align-items-center gap-2">
                        <i class="icofont-clock-time"></i> Applications close on {{ $vacancy->deadline->format('M d, Y') }}
                    </div>
                @endif

                <h5 class="mt-4">Job Description</h5>
                <div class="mb-4 job-body" style="white-space: pre-line;">{{ $vacancy->description }}</div>

                @if($vacancy->requirements)
                    <h5>Requirements</h5>
                    <div class="job-body" style="white-space: pre-line;">{{ $vacancy->requirements }}</div>
                @endif
            </div>

            {{-- ============== Apply form ============== --}}
            <div class="col-lg-5">
                <div class="apply-card">

                    <div class="apply-card__accent"></div>

                    <div class="apply-card__body">
                        <div class="apply-card__header mb-4">
                            <span class="apply-card__icon"><i class="icofont-paper-plane"></i></span>
                            <div>
                                <h5 class="mb-0">Apply for this position</h5>
                                <p class="text-muted small mb-0">Takes less than 2 minutes</p>
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

                        <form action="{{ route('vacancies.public.apply', $vacancy) }}" method="POST" enctype="multipart/form-data" id="applyForm">
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

                            <div class="apply-field mb-3">
                                <label class="apply-label">Resume</label>
                                <label class="apply-dropzone" for="resumeInput" id="dropzoneLabel">
                                    <i class="icofont-upload-alt apply-dropzone__icon"></i>
                                    <span class="apply-dropzone__text" id="dropzoneText">
                                        <strong>Click to upload</strong> your resume<br>
                                        <span class="text-muted small">PDF or Word, max 5MB</span>
                                    </span>
                                </label>
                                <input type="file" name="resume" id="resumeInput" class="apply-dropzone__input" accept=".pdf,.doc,.docx" required>
                            </div>

                            <div class="apply-field mb-4">
                                <label class="apply-label">Cover Letter <span class="text-muted small">(optional)</span></label>
                                <textarea name="cover_letter" rows="4" class="apply-textarea" placeholder="Tell us why you're a great fit...">{{ old('cover_letter') }}</textarea>
                            </div>

                            <button type="submit" class="apply-submit" id="applySubmit">
                                <span id="applySubmitText">Submit Application</span>
                                <i class="icofont-arrow-right ms-1"></i>
                            </button>

                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

@endsection

@push('styles')
<style>
    .back-link {
        color: #0A0624;
        font-weight: 600;
        transition: opacity .15s ease;
    }
    .back-link:hover { opacity: .65; }

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
        background: linear-gradient(90deg, #00229E, #6E1299, #FE0094);
        color: #fff;
    }
    .job-body { color: #46435A; line-height: 1.8; }

    /* ============== Apply card ============== */
    .apply-card {
        position: sticky;
        top: 110px;
        background: #fff;
        border-radius: 20px;
        box-shadow: 0 20px 50px rgba(10, 6, 36, 0.10);
        overflow: hidden;
    }
    .apply-card__accent {
        height: 6px;
        background: linear-gradient(90deg, #00229E, #6E1299, #FE0094);
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
        background: linear-gradient(135deg, #00229E, #FE0094);
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
    .apply-input-group {
        position: relative;
        display: flex;
        align-items: center;
    }
    .apply-input-icon {
        position: absolute;
        left: 16px;
        color: #A6A3B8;
        font-size: 16px;
    }
    .apply-input {
        width: 100%;
        padding: 13px 16px 13px 44px;
        border: 1.5px solid #E9E7F3;
        border-radius: 12px;
        font-size: 14px;
        background: #FBFAFE;
        transition: border-color .15s ease, box-shadow .15s ease, background .15s ease;
    }
    .apply-input:focus, .apply-textarea:focus {
        outline: none;
        border-color: #6E1299;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(110, 18, 153, 0.08);
    }
    .apply-textarea {
        width: 100%;
        padding: 13px 16px;
        border: 1.5px solid #E9E7F3;
        border-radius: 12px;
        font-size: 14px;
        background: #FBFAFE;
        resize: vertical;
        transition: border-color .15s ease, box-shadow .15s ease, background .15s ease;
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
    .apply-dropzone:hover {
        border-color: #6E1299;
        background: #F8F6FC;
    }
    .apply-dropzone--filled {
        border-style: solid;
        border-color: #2ecc71;
        background: #F3FCF6;
    }
    .apply-dropzone__icon {
        font-size: 22px;
        color: #6E1299;
    }
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
        background: linear-gradient(90deg, #00229E, #6E1299, #FE0094);
        background-size: 200% auto;
        transition: background-position .4s ease, transform .1s ease;
    }
    .apply-submit:hover { background-position: right center; }
    .apply-submit:active { transform: scale(0.99); }
    .apply-submit:disabled { opacity: .7; cursor: not-allowed; }

    @media (max-width: 991px) {
        .apply-card { position: static; }
    }
</style>
@endpush

@push('scripts')
<script>
    const resumeInput = document.getElementById('resumeInput');
    const dropzoneLabel = document.getElementById('dropzoneLabel');
    const dropzoneText = document.getElementById('dropzoneText');

    resumeInput.addEventListener('change', function () {
        if (this.files[0]) {
            dropzoneLabel.classList.add('apply-dropzone--filled');
            dropzoneText.innerHTML = `<strong>${this.files[0].name}</strong><br><span class="text-muted small">Click to change file</span>`;
        }
    });

    document.getElementById('applyForm').addEventListener('submit', function () {
        const btn = document.getElementById('applySubmit');
        document.getElementById('applySubmitText').textContent = 'Submitting...';
        btn.disabled = true;
    });
</script>
@endpush