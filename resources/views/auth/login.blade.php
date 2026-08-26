<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — {{ config('app.name') }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@4.0.0-beta3/dist/css/adminlte.min.css">
</head>
<body style="margin:0; min-height:100vh; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; background:#F7F9F8;">

@php
    $settings = \App\Models\Setting::first();
    $companyName = $settings->app_name ?? config('app.name');
@endphp

<div class="d-flex" style="min-height:100vh;">

    {{-- ============== Left branding panel ============== --}}
    <div class="d-none d-lg-flex flex-column justify-content-between login-brand-panel"
         style="width:46%; padding:56px 64px; background:linear-gradient(150deg, #13201C 0%, #2B3D37 55%, #3E5B54 100%); color:#fff; position:relative; overflow:hidden;">

        <div style="position:absolute; top:-80px; right:-80px; width:280px; height:280px; border-radius:50%; background:rgba(96,117,112,0.25);"></div>
        <div style="position:absolute; bottom:-100px; left:-60px; width:220px; height:220px; border-radius:50%; background:rgba(96,117,112,0.15);"></div>

        <div style="position:relative; z-index:1;">
            @if($settings->logo ?? false)
                <img src="{{ Storage::url($settings->logo) }}" alt="{{ $companyName }}" style="height:36px; display:block; margin-bottom:48px; border-radius:6px;">
            @else
                <div style="font-size:20px; font-weight:700; margin-bottom:48px;">{{ $companyName }}</div>
            @endif

            <h1 class="login-brand-heading" style="font-weight:700; line-height:1.25; margin-bottom:16px;">
                Sign in to manage<br>your workspace
            </h1>
            <p style="font-size:15px; color:rgba(255,255,255,0.7); line-height:1.7; max-width:380px;">
                One dashboard for your team, clients, and operations — secure, fast, and built around how your company works.
            </p>
        </div>

        <div style="position:relative; z-index:1; display:flex; flex-direction:column; gap:18px;">
            <div style="display:flex; align-items:center; gap:14px;">
                <span style="width:38px; height:38px; min-width:38px; border-radius:10px; background:rgba(255,255,255,0.1); display:flex; align-items:center; justify-content:center;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10Z"/></svg>
                </span>
                <span style="font-size:14px; color:rgba(255,255,255,0.85);">Enterprise-grade security & encrypted sessions</span>
            </div>
            <div style="display:flex; align-items:center; gap:14px;">
                <span style="width:38px; height:38px; min-width:38px; border-radius:10px; background:rgba(255,255,255,0.1); display:flex; align-items:center; justify-content:center;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
                </span>
                <span style="font-size:14px; color:rgba(255,255,255,0.85);">Real-time access across all your devices</span>
            </div>
            <div style="display:flex; align-items:center; gap:14px;">
                <span style="width:38px; height:38px; min-width:38px; border-radius:10px; background:rgba(255,255,255,0.1); display:flex; align-items:center; justify-content:center;">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"/></svg>
                </span>
                <span style="font-size:14px; color:rgba(255,255,255,0.85);">24/7 support for every team member</span>
            </div>
        </div>

        <p style="position:relative; z-index:1; font-size:12px; color:rgba(255,255,255,0.45); margin:0;">
            &copy; {{ date('Y') }} {{ $companyName }}. All rights reserved.
        </p>
    </div>

    {{-- ============== Right form panel ============== --}}
    <div class="d-flex align-items-center justify-content-center login-form-panel" style="flex:1; min-width:0;">
        <div class="login-form-inner" style="width:100%; max-width:400px;">

            <div class="d-lg-none text-center login-mobile-logo">
                @if($settings->logo ?? false)
                    <img src="{{ $settings->logo }}" alt="{{ $companyName }}" style="height:32px; max-width:100%; border-radius:6px;">
                @else
                    <span style="font-size:20px; font-weight:700; color:#13201C;">{{ $companyName }}</span>
                @endif
            </div>

            <h2 class="login-form-heading" style="font-weight:700; color:#13201C; margin-bottom:6px;">Welcome back</h2>
            <p style="font-size:14px; color:#5F6C76; margin-bottom:28px;">Enter your credentials to continue</p>

            @if ($errors->any())
                <div class="alert" style="background:#fdecea; border:1px solid #f5c2c0; color:#8a1f16; border-radius:10px; font-size:13.5px; padding:12px 16px; word-break:break-word;">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if (session('status'))
                <div class="alert" style="background:#eaf7ef; border:1px solid #bfe6cc; color:#1e6b3c; border-radius:10px; font-size:13.5px; padding:12px 16px; word-break:break-word;">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="mb-3">
                    <label class="form-label" style="font-size:13px; font-weight:700; color:#13201C;">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}"
                           class="form-control login-input" placeholder="you@company.com" required autofocus>
                </div>

                <div class="mb-3">
                    <label class="form-label" style="font-size:13px; font-weight:700; color:#13201C;">Password</label>
                    <input type="password" name="password" class="form-control login-input" placeholder="Enter your password" required>
                </div>

                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-4">
                    <div class="form-check">
                        <input type="checkbox" name="remember" class="form-check-input" id="remember">
                        <label class="form-check-label" for="remember" style="font-size:13.5px; color:#46435A;">Remember me</label>
                    </div>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" style="font-size:13.5px; color:#4F6B63; font-weight:600; text-decoration:none;">Forgot password?</a>
                    @endif
                </div>

                <button type="submit" class="btn w-100 login-submit">Sign In</button>

            </form>

            @if(app()->environment('local'))
                <p class="text-center text-muted mt-4 small">
                    Seeded admin (local only): admin@admin.com / password
                </p>
            @endif

        </div>
    </div>

</div>

<style>
    .login-input {
        border: 1.5px solid #E9E7F3;
        border-radius: 10px;
        padding: 11px 16px;
        font-size: 14px;
        width: 100%;
        background: #FBFAFE;
        transition: border-color .15s ease, box-shadow .15s ease, background .15s ease;
    }
    .login-input:focus {
        outline: none;
        border-color: #4F6B63;
        background: #fff;
        box-shadow: 0 0 0 4px rgba(79, 107, 99, 0.10);
    }
    .login-submit {
        background: linear-gradient(90deg, #3E5B54, #4F6B63, #607570);
        background-size: 200% auto;
        color: #fff;
        border: none;
        border-radius: 10px;
        padding: 13px;
        font-weight: 700;
        letter-spacing: .3px;
        transition: background-position .4s ease, transform .1s ease;
    }
    .login-submit:hover { background-position: right center; color: #fff; }
    .login-submit:active { transform: scale(0.99); }

    /* ── Fluid type: scales smoothly between breakpoints instead of
         jumping at fixed sizes ── */
    .login-brand-heading { font-size: clamp(26px, 2.4vw, 34px); }
    .login-form-heading  { font-size: clamp(22px, 5vw, 26px); }

    /* ── Right panel: generous padding on desktop, tighter on phones,
         with safe-area support for notches / home indicators ── */
    .login-form-panel {
        padding: 32px calc(32px + env(safe-area-inset-right)) 32px calc(32px + env(safe-area-inset-left));
    }
    .login-mobile-logo { margin-bottom: 28px; }

    @media (max-width: 991.98px) {
        /* Branding panel is hidden below lg, form takes full width —
           cap its inner width a bit wider than mobile since there's
           now a full viewport to work with on tablets. */
        .login-form-inner { max-width: 440px; }
    }

    @media (max-width: 575.98px) {
        .login-form-panel {
            padding: 24px calc(20px + env(safe-area-inset-right)) 24px calc(20px + env(safe-area-inset-left));
        }
        .login-form-inner { max-width: 100%; }
        .login-mobile-logo { margin-bottom: 22px; }
        .login-input { padding: 10px 14px; font-size: 16px; } /* 16px avoids iOS auto-zoom on focus */
        .login-submit { padding: 12px; }
    }

    @media (max-width: 360px) {
        .login-form-panel { padding-left: calc(16px + env(safe-area-inset-left)); padding-right: calc(16px + env(safe-area-inset-right)); }
    }

    /* ── Short / landscape viewports: trim vertical spacing so the
         form doesn't force awkward scrolling on landscape phones ── */
    @media (max-height: 500px) {
        .login-mobile-logo { margin-bottom: 14px; }
        .login-form-heading { margin-bottom: 2px !important; }
        .login-form-panel p { margin-bottom: 16px !important; }
        .login-brand-panel { padding-top: 28px !important; padding-bottom: 28px !important; }
    }
</style>

</body>
</html>