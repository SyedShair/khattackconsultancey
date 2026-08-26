<?php

namespace App\Listeners;

use App\Models\ActivityLog;
use Illuminate\Auth\Events\Login;

class LogUserLogin
{
    public function handle(Login $event): void
    {
        ActivityLog::create([
            'user_id'     => $event->user->id,
            'user_name'   => $event->user->name,
            'action'      => 'login',
            'description' => "{$event->user->name} logged in",
            'properties'  => [
                'user_agent' => request()->userAgent(),
            ],
            'ip_address'  => request()->ip(),
        ]);
    }
}