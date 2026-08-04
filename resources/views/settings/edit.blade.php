@extends('layouts.admin')

@section('title', 'Settings')
@section('page_title', 'Settings')

@section('breadcrumb')
    <li class="breadcrumb-item active">Settings</li>
@endsection

@section('content')

    <div class="row">
        <div class="col-md-8 col-lg-6">

            <div class="card">
                <div class="card-header">
                    <h5 class="card-title mb-0">Application Settings</h5>
                </div>

                <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="card-body">

                        @if(session('status'))
                            <div class="alert alert-success">{{ session('status') }}</div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {{-- Logo --}}
                        <div class="mb-4 text-center">
                            <img id="logoPreview" 
                                 src="{{ asset('storage/' . $setting->logo) ?? asset('adminlte/img/AdminLTELogo.png') }}"
                                 alt="Current logo"
                                 class="mb-2 rounded"
                                 style="max-width: 160px; max-height: 160px; object-fit: contain;">

                            <input type="file" name="logo" id="logoInput" accept="image/*"
                                   class="form-control form-control-sm">
                            <div class="form-text">PNG, JPG, SVG or WEBP. Max 2MB.</div>
                        </div>

                        {{-- App name --}}
                        <div class="mb-4">
                            <label class="form-label">Application Name</label>
                            <input type="text" name="app_name" class="form-control"
                                   value="{{ old('app_name', $setting->app_name) }}" required>
                        </div>

                        {{-- Theme --}}
                        <div class="mb-2">
                            <label class="form-label d-block">Theme</label>

                            <div class="btn-group w-100" role="group">

                                <input type="radio" class="btn-check" name="theme" id="themeLight"
                                       value="light" autocomplete="off"
                                       {{ old('theme', $setting->theme) === 'light' ? 'checked' : '' }}>
                                <label class="btn btn-outline-secondary" for="themeLight">
                                    <i class="bi bi-sun-fill me-1"></i> Light
                                </label>

                                <input type="radio" class="btn-check" name="theme" id="themeDark"
                                       value="dark" autocomplete="off"
                                       {{ old('theme', $setting->theme) === 'dark' ? 'checked' : '' }}>
                                <label class="btn btn-outline-secondary" for="themeDark">
                                    <i class="bi bi-moon-stars-fill me-1"></i> Dark
                                </label>

                            </div>
                        </div>

                    </div>

                    <div class="card-footer text-end">
                        <button type="submit" class="btn btn-primary">Save Settings</button>
                    </div>

                </form>
            </div>

        </div>
    </div>

@endsection

@push('scripts')
<script>
    document.getElementById('logoInput').addEventListener('change', function () {
        if (this.files[0]) {
            document.getElementById('logoPreview').src = URL.createObjectURL(this.files[0]);
        }
    });
</script>
@endpush