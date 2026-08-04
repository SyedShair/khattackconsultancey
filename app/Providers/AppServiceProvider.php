<?php

namespace App\Providers;

use App\Models\Setting;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Makes $appSetting (app_name, logo_url, theme) available in every
        // Blade view, so layouts.admin can render the logo/name/theme
        // without every controller having to pass it manually.
        View::composer('*', function ($view) {
            $view->with('appSetting', once(fn () => Setting::first()));
        });
    }
}