{{-- resources/views/profile/edit.blade.php --}}
{{-- Adjust the extends() below to match your actual layout file name --}}
@extends('layouts.admin')

@section('title', 'My Profile')
@section('page_title', 'My Profile')

@section('breadcrumb')
    <li class="breadcrumb-item active">Profile</li>
@endsection

@push('styles')
<style>
    .avatar-preview-wrapper {
        position: relative;
        width: 120px;
        height: 120px;
        margin: 0 auto 1rem;
    }
    .avatar-preview-wrapper img {
        width: 120px;
        height: 120px;
        object-fit: cover;
        border-radius: 50%;
        border: 3px solid var(--bs-border-color);
    }
    .avatar-preview-wrapper .avatar-edit-btn {
        position: absolute;
        bottom: 0;
        right: 0;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }
    .field-error {
        font-size: .85rem;
    }
    .card-outline{
        b
    }
</style>
@endpush

@section('content')
<div class="row">

    {{-- AVATAR CARD --}}
    <div class="col-md-4">
        <div class="card card-primary card-outline">
            <div class="card-body text-center">

                <div class="avatar-preview-wrapper">
                    <img id="avatarPreview"
                         src="{{ $user->avatar ? asset('storage/' . $user->avatar) : asset('assets/img/user2-160x160.jpg') }}"
                         alt="{{ $user->name }}">
                    <label for="avatarInput" class="avatar-edit-btn btn btn-primary btn-sm mb-0">
                        <i class="bi bi-camera-fill"></i>
                    </label>
                    <input type="file" id="avatarInput" accept="image/png,image/jpeg,image/webp" class="d-none">
                </div>

                <h5 class="mb-0">{{ $user->name }}</h5>
                <p class="text-muted">{{ $user->email }}</p>

                <div id="avatarAlert"></div>
                <div class="field-error text-danger" id="avatarError"></div>

                <button type="button" class="btn btn-outline-primary btn-sm mt-2 d-none" id="avatarSaveBtn">
                    <span class="btn-text">Save Photo</span>
                    <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                </button>
            </div>
        </div>
    </div>

    {{-- INFO + PASSWORD CARDS --}}
    <div class="col-md-8">

        {{-- PROFILE INFO --}}
        <div class="card card-primary card-outline mb-4">
            <div class="card-header">
                <h3 class="card-title">Profile Information</h3>
            </div>

            <form id="infoForm">
                <div class="card-body">

                    <div id="infoAlert"></div>

                    <div class="mb-3">
                        <label class="form-label" for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}">
                        <div class="field-error text-danger" data-error-for="name"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}">
                        <div class="field-error text-danger" data-error-for="email"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="phone">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ $user->phone }}">
                        <div class="field-error text-danger" data-error-for="phone"></div>
                    </div>

                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" id="infoSaveBtn">
                        <span class="btn-text">Save Changes</span>
                        <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                    </button>
                </div>
            </form>
        </div>

        {{-- CHANGE PASSWORD --}}
        <div class="card card-primary card-outline">
            <div class="card-header">
                <h3 class="card-title">Change Password</h3>
            </div>

            <form id="passwordForm">
                <div class="card-body">

                    <div id="passwordAlert"></div>

                    <div class="mb-3">
                        <label class="form-label" for="current_password">Current Password</label>
                        <input type="password" class="form-control" id="current_password" name="current_password">
                        <div class="field-error text-danger" data-error-for="current_password"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="password">New Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                        <div class="field-error text-danger" data-error-for="password"></div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label" for="password_confirmation">Confirm New Password</label>
                        <input type="password" class="form-control" id="password_confirmation" name="password_confirmation">
                    </div>

                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary" id="passwordSaveBtn">
                        <span class="btn-text">Update Password</span>
                        <span class="spinner-border spinner-border-sm d-none" role="status"></span>
                    </button>
                </div>
            </form>
        </div>

    </div>
</div>
@endsection

@push('scripts')
<script>
$(function () {

    const csrfToken = $('meta[name="csrf-token"]').attr('content');

    $.ajaxSetup({
        headers: { 'X-CSRF-TOKEN': csrfToken }
    });

    function clearErrors(form) {
        $(form).find('.field-error').text('');
        $(form).find('.is-invalid').removeClass('is-invalid');
    }

    function showErrors(form, errors) {
        $.each(errors, function (field, messages) {
            $(form).find(`[name="${field}"]`).addClass('is-invalid');
            $(form).find(`[data-error-for="${field}"]`).text(messages[0]);
        });
    }

    function showAlert(container, type, message) {
        $(container).html(`
            <div class="alert alert-${type} alert-dismissible fade show py-2" role="alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `);
    }

    function toggleLoading(btn, loading) {
        $(btn).prop('disabled', loading);
        $(btn).find('.btn-text').toggleClass('d-none', loading);
        $(btn).find('.spinner-border').toggleClass('d-none', !loading);
    }

    // ---------- PROFILE INFO ----------
    $('#infoForm').on('submit', function (e) {
        e.preventDefault();

        const form = this;
        const btn = '#infoSaveBtn';
        clearErrors(form);
        toggleLoading(btn, true);

        $.ajax({
            url: '{{ route('profile.updateInfo') }}',
            method: 'POST',
            data: $(form).serialize(),
            success: function (res) {
                showAlert('#infoAlert', 'success', res.message);
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    showErrors(form, xhr.responseJSON.errors);
                } else {
                    showAlert('#infoAlert', 'danger', 'Something went wrong. Please try again.');
                }
            },
            complete: function () {
                toggleLoading(btn, false);
            }
        });
    });

    // ---------- AVATAR ----------
    $('#avatarInput').on('change', function () {
        const file = this.files[0];
        if (!file) return;

        // live preview
        const reader = new FileReader();
        reader.onload = e => $('#avatarPreview').attr('src', e.target.result);
        reader.readAsDataURL(file);

        $('#avatarSaveBtn').removeClass('d-none');
        $('#avatarError').text('');
    });

    $('#avatarSaveBtn').on('click', function () {
        const fileInput = document.getElementById('avatarInput');
        if (!fileInput.files.length) return;

        const formData = new FormData();
        formData.append('avatar', fileInput.files[0]);

        const btn = '#avatarSaveBtn';
        $('#avatarError').text('');
        toggleLoading(btn, true);

        $.ajax({
            url: '{{ route('profile.updateAvatar') }}',
            method: 'POST',
            data: formData,
            processData: false,
            contentType: false,
            success: function (res) {
                $('#avatarPreview').attr('src', res.avatar_url);
                showAlert('#avatarAlert', 'success', res.message);
                $('#avatarSaveBtn').addClass('d-none');
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    $('#avatarError').text(xhr.responseJSON.errors.avatar?.[0] ?? 'Invalid file.');
                } else {
                    showAlert('#avatarAlert', 'danger', 'Upload failed. Please try again.');
                }
            },
            complete: function () {
                toggleLoading(btn, false);
            }
        });
    });

    // ---------- PASSWORD ----------
    $('#passwordForm').on('submit', function (e) {
        e.preventDefault();

        const form = this;
        const btn = '#passwordSaveBtn';
        clearErrors(form);
        toggleLoading(btn, true);

        $.ajax({
            url: '{{ route('profile.updatePassword') }}',
            method: 'POST',
            data: $(form).serialize(),
            success: function (res) {
                showAlert('#passwordAlert', 'success', res.message);
                form.reset();
            },
            error: function (xhr) {
                if (xhr.status === 422) {
                    showErrors(form, xhr.responseJSON.errors);
                } else {
                    showAlert('#passwordAlert', 'danger', 'Something went wrong. Please try again.');
                }
            },
            complete: function () {
                toggleLoading(btn, false);
            }
        });
    });

});
</script>
@endpush