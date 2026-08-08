@extends('layouts.admin')

@section('title', 'Settings')
@section('page_title', 'Settings')

@section('breadcrumb')
    <li class="breadcrumb-item active">Settings</li>
@endsection

@section('content')

    <form action="{{ route('settings.update') }}" method="POST" enctype="multipart/form-data">
        @csrf

        @if($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="row">

            {{-- ============== General (logo, name, theme) ============== --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">General</h5>
                    </div>
                    <div class="card-body">

                        <div class="mb-4 text-center">
                            <img id="logoPreview"
                                 src="{{ $setting->logo_url ?? asset('adminlte/img/AdminLTELogo.png') }}"
                                 alt="Current logo"
                                 class="mb-2 rounded"
                                 style="max-width: 160px; max-height: 160px; object-fit: contain;">

                            <input type="file" name="logo" id="logoInput" accept="image/*"
                                   class="form-control form-control-sm">
                            <div class="form-text">PNG, JPG, SVG or WEBP. Max 2MB.</div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label">Application Name</label>
                            <input type="text" name="app_name" class="form-control"
                                   value="{{ old('app_name', $setting->app_name) }}" required>
                        </div>

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
                </div>
            </div>

            {{-- ============== Contact & Map ============== --}}
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Contact Information</h5>
                    </div>
                    <div class="card-body">

                        <div class="mb-3">
                            <label class="form-label"><i class="bi bi-geo-alt me-1"></i> Address</label>
                            <textarea name="address" class="form-control" rows="2">{{ old('address', $setting->address) }}</textarea>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label"><i class="bi bi-telephone me-1"></i> Phone</label>
                                <input type="text" name="phone" class="form-control"
                                       value="{{ old('phone', $setting->phone) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label"><i class="bi bi-envelope me-1"></i> Email</label>
                                <input type="email" name="email" class="form-control"
                                       value="{{ old('email', $setting->email) }}">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label"><i class="bi bi-whatsapp me-1"></i> WhatsApp Number</label>
                                <input type="text" name="whatsapp_number" class="form-control"
                                       placeholder="e.g. +92 300 1234567"
                                       value="{{ old('whatsapp_number', $setting->whatsapp_number) }}">
                                <div class="form-text">Include country code. Spaces/dashes are fine — cleaned up automatically. Leave blank to hide the floating WhatsApp button on the website.</div>
                            </div>
                        </div>

                        <div class="mb-2">
                            <label class="form-label"><i class="bi bi-map me-1"></i> Google Maps Embed URL</label>
                            <input type="url" name="map_url" id="mapUrl" class="form-control"
                                   placeholder="https://www.google.com/maps/embed?pb=..."
                                   value="{{ old('map_url', $setting->map_url) }}">
                            <div class="form-text">
                                In Google Maps: Share &rarr; Embed a map &rarr; copy the URL inside the
                                <code>src="..."</code> of the iframe code, and paste it here.
                            </div>

                            @if($setting->map_url)
                                <div class="ratio ratio-16x9 mt-2" id="mapPreviewWrap">
                                    <iframe id="mapPreview" src="{{ $setting->map_url }}"
                                            style="border:0;" loading="lazy" allowfullscreen></iframe>
                                </div>
                            @else
                                <div class="ratio ratio-16x9 mt-2 d-none" id="mapPreviewWrap">
                                    <iframe id="mapPreview" src="" style="border:0;" loading="lazy" allowfullscreen></iframe>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>

            {{-- ============== Opening Hours ============== --}}
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0"><i class="bi bi-clock me-1"></i> Opening Hours</h5>
                    </div>
                    <div class="card-body p-0">
                        <table class="table mb-0 align-middle">
                            <thead>
                                <tr>
                                    <th style="width: 100px;">Day</th>
                                    <th style="width: 160px;">Open</th>
                                    <th style="width: 160px;">Close</th>
                                    <th>Closed</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(\App\Models\Setting::DAYS as $key => $label)
                                    @php
                                        $day = $setting->opening_hours_normalized[$key];
                                        $closed = old("opening_hours.$key.closed", $day['closed']);
                                    @endphp
                                    <tr>
                                        <td class="fw-semibold">{{ $label }}</td>
                                        <td>
                                            <input type="time" name="opening_hours[{{ $key }}][open]"
                                                   class="form-control form-control-sm day-open-{{ $key }}"
                                                   value="{{ old("opening_hours.$key.open", $day['open']) }}"
                                                   {{ $closed ? 'disabled' : '' }}>
                                        </td>
                                        <td>
                                            <input type="time" name="opening_hours[{{ $key }}][close]"
                                                   class="form-control form-control-sm day-close-{{ $key }}"
                                                   value="{{ old("opening_hours.$key.close", $day['close']) }}"
                                                   {{ $closed ? 'disabled' : '' }}>
                                        </td>
                                        <td>
                                            <div class="form-check form-switch">
                                                <input type="checkbox" class="form-check-input day-closed-toggle"
                                                       name="opening_hours[{{ $key }}][closed]"
                                                       data-day="{{ $key }}"
                                                       value="1"
                                                       {{ $closed ? 'checked' : '' }}>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        <div class="text-end mb-4">
            <button type="submit" class="btn btn-primary">Save Settings</button>
        </div>

    </form>


    <!-- =========================
         TOAST CONTAINER
    ========================== -->
    <div class="toast-container position-fixed bottom-0 end-0 p-3" style="z-index: 1080;" id="toastContainer"></div>

@endsection

@push('scripts')
<script>
    // ── Toast helper (shared pattern — same as Vacancies page) ────────
    function showToast(message, type = 'success') {
        const colors = { success: 'text-bg-success', error: 'text-bg-danger', info: 'text-bg-primary' };
        const icons = { success: 'bi-check-circle', error: 'bi-x-circle', info: 'bi-info-circle' };

        const toastEl = document.createElement('div');
        toastEl.className = `toast align-items-center ${colors[type] ?? colors.info} border-0`;
        toastEl.setAttribute('role', 'alert');
        toastEl.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi ${icons[type] ?? icons.info} me-2"></i>${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;

        document.getElementById('toastContainer').appendChild(toastEl);
        const toast = new bootstrap.Toast(toastEl, { delay: 3500 });
        toast.show();
        toastEl.addEventListener('hidden.bs.toast', () => toastEl.remove());
    }

    // Show a toast for the redirect-back success message, instead of a static alert box
    @if(session('status'))
        showToast(@json(session('status')), 'success');
    @endif

    // Show a toast summary too when validation fails (detailed list stays inline above)
    @if($errors->any())
        showToast('Please fix the {{ $errors->count() }} error(s) below.', 'error');
    @endif

    // Live logo preview
    document.getElementById('logoInput').addEventListener('change', function () {
        if (this.files[0]) {
            document.getElementById('logoPreview').src = URL.createObjectURL(this.files[0]);
        }
    });

    // Live map embed preview
    const mapUrlInput = document.getElementById('mapUrl');
    const mapPreview = document.getElementById('mapPreview');
    const mapPreviewWrap = document.getElementById('mapPreviewWrap');
    mapUrlInput.addEventListener('input', function () {
        const url = this.value.trim();
        if (url) {
            mapPreview.src = url;
            mapPreviewWrap.classList.remove('d-none');
        } else {
            mapPreviewWrap.classList.add('d-none');
        }
    });

    // Disable open/close time inputs per day when "Closed" is toggled
    document.querySelectorAll('.day-closed-toggle').forEach(toggle => {
        toggle.addEventListener('change', function () {
            const day = this.dataset.day;
            const openInput = document.querySelector(`.day-open-${day}`);
            const closeInput = document.querySelector(`.day-close-${day}`);
            openInput.disabled = this.checked;
            closeInput.disabled = this.checked;
            if (this.checked) {
                openInput.value = '';
                closeInput.value = '';
            }
        });
    });
</script>
@endpush