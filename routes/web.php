<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\HeroSlideController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PublicVacancyController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VacancyController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| This is the COMPLETE routes/web.php for this project.
| Replace the default routes/web.php entirely with this file.
|--------------------------------------------------------------------------
*/

// ── Public website ────────────────────────────────────────────────────
Route::get('/', fn () => view('front.home'))->name('home');

Route::get('/vacancies', [PublicVacancyController::class, 'index'])->name('vacancies.public.index');
Route::get('/vacancies/{vacancy:slug}', [PublicVacancyController::class, 'show'])->name('vacancies.public.show');
Route::post('/vacancies/{vacancy:slug}/apply', [PublicVacancyController::class, 'apply'])->name('vacancies.public.apply');
Route::post('/careers/apply', [PublicVacancyController::class, 'applyGeneral'])->name('vacancies.public.applyGeneral');

// ── Guest routes (login) ─────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

// ── Authenticated routes ─────────────────────────────────────────────
Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');

    // Admin-only: user + role + permission + settings + recruitment management
    Route::middleware('role:admin')->group(function () {

        Route::get('users', [UserController::class, 'index'])->name('users.index');
        Route::get('users/data', [UserController::class, 'data'])->name('users.data');
        Route::get('users/{user}', [UserController::class, 'show'])->name('users.show');
        Route::post('users', [UserController::class, 'store'])->name('users.store');
        Route::put('users/{user}', [UserController::class, 'update'])->name('users.update');
        Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy');

        Route::resource('roles', RoleController::class)->except(['show']);

        Route::get('permissions', [PermissionController::class, 'index'])->name('permissions.index');
        Route::get('permissions/data', [PermissionController::class, 'data'])->name('permissions.data');
        Route::get('permissions/{permission}', [PermissionController::class, 'show'])->name('permissions.show');
        Route::post('permissions', [PermissionController::class, 'store'])->name('permissions.store');
        Route::put('permissions/{permission}', [PermissionController::class, 'update'])->name('permissions.update');
        Route::post('permissions/{permission}/duplicate', [PermissionController::class, 'duplicate'])->name('permissions.duplicate');
        Route::delete('permissions/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');

        Route::get('settings', [SettingController::class, 'edit'])->name('settings.edit');
        Route::post('settings', [SettingController::class, 'update'])->name('settings.update');

        // Vacancies + applications live under /admin to avoid colliding
        // with the public /vacancies listing above.
        Route::prefix('admin')->group(function () {

            Route::get('vacancies', [VacancyController::class, 'index'])->name('vacancies.index');
            Route::get('vacancies/data', [VacancyController::class, 'data'])->name('vacancies.data');
            Route::get('vacancies/create', [VacancyController::class, 'create'])->name('vacancies.create');
            Route::post('vacancies', [VacancyController::class, 'store'])->name('vacancies.store');
            Route::get('vacancies/{vacancy:id}/edit', [VacancyController::class, 'edit'])->name('vacancies.edit');
            Route::put('vacancies/{vacancy:id}', [VacancyController::class, 'update'])->name('vacancies.update');
            Route::delete('vacancies/{vacancy:id}', [VacancyController::class, 'destroy'])->name('vacancies.destroy');
            Route::post('vacancies/{vacancy:id}/toggle-status', [VacancyController::class, 'toggleStatus'])->name('vacancies.toggleStatus');

            Route::get('applications', [ApplicationController::class, 'index'])->name('applications.index');
            Route::get('applications/data', [ApplicationController::class, 'data'])->name('applications.data');
            Route::get('applications/{application}', [ApplicationController::class, 'show'])->name('applications.show');
            Route::put('applications/{application}/status', [ApplicationController::class, 'updateStatus'])->name('applications.updateStatus');
            Route::delete('applications/{application}', [ApplicationController::class, 'destroy'])->name('applications.destroy');
            Route::get('applications/{application}/resume', [ApplicationController::class, 'resume'])->name('applications.resume');

            Route::get('hero-slides', [HeroSlideController::class, 'index'])->name('hero-slides.index');
            Route::get('hero-slides/create', [HeroSlideController::class, 'create'])->name('hero-slides.create');
            Route::post('hero-slides', [HeroSlideController::class, 'store'])->name('hero-slides.store');
            Route::get('hero-slides/{heroSlide}/edit', [HeroSlideController::class, 'edit'])->name('hero-slides.edit');
            Route::put('hero-slides/{heroSlide}', [HeroSlideController::class, 'update'])->name('hero-slides.update');
            Route::delete('hero-slides/{heroSlide}', [HeroSlideController::class, 'destroy'])->name('hero-slides.destroy');
            Route::post('hero-slides/{heroSlide}/toggle-active', [HeroSlideController::class, 'toggleActive'])->name('hero-slides.toggleActive');
            Route::post('hero-slides/reorder', [HeroSlideController::class, 'reorder'])->name('hero-slides.reorder');

            Route::get('services', [ServiceController::class, 'index'])->name('services.index');
            Route::get('services/create', [ServiceController::class, 'create'])->name('services.create');
            Route::post('services', [ServiceController::class, 'store'])->name('services.store');
            Route::get('services/{service}/edit', [ServiceController::class, 'edit'])->name('services.edit');
            Route::put('services/{service}', [ServiceController::class, 'update'])->name('services.update');
            Route::delete('services/{service}', [ServiceController::class, 'destroy'])->name('services.destroy');
            Route::post('services/{service}/toggle-active', [ServiceController::class, 'toggleActive'])->name('services.toggleActive');
            Route::post('services/reorder', [ServiceController::class, 'reorder'])->name('services.reorder');

        });

    });

});