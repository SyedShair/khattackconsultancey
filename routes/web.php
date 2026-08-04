<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| This is the COMPLETE routes/web.php for this project.
| Replace the default routes/web.php entirely with this file.
|--------------------------------------------------------------------------
*/

// ── Guest routes (login) ─────────────────────────────────────────────
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);
});

// ── Authenticated routes ─────────────────────────────────────────────
Route::middleware('auth')->group(function () {

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');

    // Admin-only: user + role + permission + settings management
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

    });

});

// ── Root redirect ─────────────────────────────────────────────────────
Route::get('/', fn () => redirect(auth()->check() ? '/dashboard' : '/login'));