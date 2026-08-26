<?php

namespace App\Listeners;

use App\Models\ActivityLog;
use Illuminate\Auth\Events\Logout;

class LogUserLogout
{
    public function handle(Logout $event): void
    {
        // $event->user can be null in edge cases (e.g. session already expired)
        if (! $event->user) {
            return;
        }

        ActivityLog::create([
            'user_id'     => $event->user->id,
            'user_name'   => $event->user->name,
            'action'      => 'logout',
            'description' => "{$event->user->name} logged out",
            'ip_address'  => request()->ip(),
        ]);
    }
}