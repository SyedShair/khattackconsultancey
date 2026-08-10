<?php

use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\AssistantController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ConsultationBookingController;
use App\Http\Controllers\ContactMessageController;
use App\Http\Controllers\HeroSlideController;
use App\Http\Controllers\LiveChatController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PricingPlanController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\PublicContactController;
use App\Http\Controllers\PublicVacancyController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\TeamMemberController;
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
Route::post('/contact', [PublicContactController::class, 'store'])->name('contact.store');

// ── Floating assistant widget ──────────────────────────────────────
Route::prefix('assistant')->name('assistant.')->group(function () {
    Route::post('ai', [AssistantController::class, 'ai'])->name('ai');
    Route::get('available-dates', [AssistantController::class, 'availableDates'])->name('availableDates');
    Route::get('available-slots', [AssistantController::class, 'availableSlots'])->name('availableSlots');
    Route::post('book', [AssistantController::class, 'book'])->name('book');
    Route::post('chat/start', [AssistantController::class, 'startChat'])->name('chat.start');
    Route::post('chat/{uuid}/message', [AssistantController::class, 'sendMessage'])->name('chat.message');
    Route::get('chat/{uuid}/messages', [AssistantController::class, 'fetchMessages'])->name('chat.messages');
});

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

            Route::get('team-members', [TeamMemberController::class, 'index'])->name('team-members.index');
            Route::get('team-members/create', [TeamMemberController::class, 'create'])->name('team-members.create');
            Route::post('team-members', [TeamMemberController::class, 'store'])->name('team-members.store');
            Route::get('team-members/{teamMember}/edit', [TeamMemberController::class, 'edit'])->name('team-members.edit');
            Route::put('team-members/{teamMember}', [TeamMemberController::class, 'update'])->name('team-members.update');
            Route::delete('team-members/{teamMember}', [TeamMemberController::class, 'destroy'])->name('team-members.destroy');
            Route::post('team-members/{teamMember}/toggle-active', [TeamMemberController::class, 'toggleActive'])->name('team-members.toggleActive');
            Route::post('team-members/reorder', [TeamMemberController::class, 'reorder'])->name('team-members.reorder');

            Route::get('contact-messages', [ContactMessageController::class, 'index'])->name('contact-messages.index');
            Route::get('contact-messages/data', [ContactMessageController::class, 'data'])->name('contact-messages.data');
            Route::get('contact-messages/{contactMessage}', [ContactMessageController::class, 'show'])->name('contact-messages.show');
            Route::put('contact-messages/{contactMessage}/status', [ContactMessageController::class, 'updateStatus'])->name('contact-messages.updateStatus');
            Route::delete('contact-messages/{contactMessage}', [ContactMessageController::class, 'destroy'])->name('contact-messages.destroy');

            Route::get('projects', [ProjectController::class, 'index'])->name('projects.index');
            Route::get('projects/create', [ProjectController::class, 'create'])->name('projects.create');
            Route::post('projects', [ProjectController::class, 'store'])->name('projects.store');
            Route::get('projects/{project}/edit', [ProjectController::class, 'edit'])->name('projects.edit');
            Route::put('projects/{project}', [ProjectController::class, 'update'])->name('projects.update');
            Route::delete('projects/{project}', [ProjectController::class, 'destroy'])->name('projects.destroy');
            Route::post('projects/{project}/toggle-active', [ProjectController::class, 'toggleActive'])->name('projects.toggleActive');
            Route::post('projects/reorder', [ProjectController::class, 'reorder'])->name('projects.reorder');

            Route::get('consultation-bookings', [ConsultationBookingController::class, 'index'])->name('consultation-bookings.index');
            Route::get('consultation-bookings/data', [ConsultationBookingController::class, 'data'])->name('consultation-bookings.data');
            Route::get('consultation-bookings/{consultationBooking}', [ConsultationBookingController::class, 'show'])->name('consultation-bookings.show');
            Route::put('consultation-bookings/{consultationBooking}/status', [ConsultationBookingController::class, 'updateStatus'])->name('consultation-bookings.updateStatus');
            Route::delete('consultation-bookings/{consultationBooking}', [ConsultationBookingController::class, 'destroy'])->name('consultation-bookings.destroy');

            Route::get('pricing-plans', [PricingPlanController::class, 'index'])->name('pricing-plans.index');
            Route::get('pricing-plans/create', [PricingPlanController::class, 'create'])->name('pricing-plans.create');
            Route::post('pricing-plans', [PricingPlanController::class, 'store'])->name('pricing-plans.store');
            Route::get('pricing-plans/{pricingPlan}/edit', [PricingPlanController::class, 'edit'])->name('pricing-plans.edit');
            Route::put('pricing-plans/{pricingPlan}', [PricingPlanController::class, 'update'])->name('pricing-plans.update');
            Route::delete('pricing-plans/{pricingPlan}', [PricingPlanController::class, 'destroy'])->name('pricing-plans.destroy');
            Route::post('pricing-plans/{pricingPlan}/toggle-active', [PricingPlanController::class, 'toggleActive'])->name('pricing-plans.toggleActive');
            Route::post('pricing-plans/{pricingPlan}/toggle-popular', [PricingPlanController::class, 'togglePopular'])->name('pricing-plans.togglePopular');
            Route::post('pricing-plans/reorder', [PricingPlanController::class, 'reorder'])->name('pricing-plans.reorder');

            Route::get('live-chat', [LiveChatController::class, 'index'])->name('live-chat.index');
            Route::get('live-chat/data', [LiveChatController::class, 'data'])->name('live-chat.data');
            Route::get('live-chat/notifications', [LiveChatController::class, 'notifications'])->name('live-chat.notifications');
            Route::get('live-chat/{uuid}', [LiveChatController::class, 'show'])->name('live-chat.show');
            Route::get('live-chat/{uuid}/poll', [LiveChatController::class, 'poll'])->name('live-chat.poll');
            Route::post('live-chat/{uuid}/typing', [LiveChatController::class, 'typing'])->name('live-chat.typing');
            Route::post('live-chat/{uuid}/reply', [LiveChatController::class, 'reply'])->name('live-chat.reply');
            Route::post('live-chat/{uuid}/close', [LiveChatController::class, 'close'])->name('live-chat.close');

        });

    });

});