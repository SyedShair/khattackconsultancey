<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Str;

/**
 * Add `use LogsActivity;` to any model to automatically record every
 * create/update/delete as an admin activity log entry.
 *
 * Deliberately only logs when there's an authenticated user — public
 * visitor-created records (job applications, consultation bookings,
 * contact messages, chat sessions) stay out of the admin activity trail
 * when created by a guest, but DO get logged when an admin updates them
 * (e.g. changing an application's status, closing a chat).
 *
 * Optional per-model customization:
 *   protected $activityLogName = 'job vacancy'; // human label, defaults to the class name
 *   protected $activityLogTitleField = 'title';  // which field to show as the record's name
 */
trait LogsActivity
{
    protected static function bootLogsActivity(): void
    {
        static::created(function ($model) {
            $model->recordActivity('created');
        });

        static::updated(function ($model) {
            $model->recordActivity('updated');
        });

        static::deleted(function ($model) {
            $model->recordActivity('deleted');
        });
    }

    public function recordActivity(string $action): void
    {
        // This is an ADMIN activity trail — skip anything created/changed
        // by an unauthenticated visitor (public forms, widget bookings, etc).
        if (! auth()->check()) {
            return;
        }

        $changes = [];
        if ($action === 'updated') {
            $changes = $this->getChanges();
            unset($changes['updated_at']);
            if (empty($changes)) {
                return; // nothing meaningful changed
            }
        }

        $label = $this->activityLogName ?? Str::snake(class_basename($this), ' ');
        $title = $this->resolveActivityLogTitle();

        ActivityLog::create([
            'user_id'      => auth()->id(),
            'user_name'    => auth()->user()->name ?? 'Unknown',
            'action'       => $action,
            'subject_type' => static::class,
            'subject_id'   => $this->getKey(),
            'description'  => ucfirst($action) . " {$label}" . ($title ? ": {$title}" : ''),
            'properties'   => $changes ?: null,
            'ip_address'   => request()->ip(),
        ]);
    }

    protected function resolveActivityLogTitle(): ?string
    {
        $field = $this->activityLogTitleField ?? null;

        if ($field && isset($this->attributes[$field])) {
            return (string) $this->attributes[$field];
        }

        foreach (['title', 'name', 'first_name', 'email'] as $fallbackField) {
            if (isset($this->attributes[$fallbackField])) {
                return (string) $this->attributes[$fallbackField];
            }
        }

        return null;
    }
}