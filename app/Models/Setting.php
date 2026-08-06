<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Setting extends Model
{
    protected $fillable = [
        'app_name',
        'logo',
        'theme',
        'address',
        'phone',
        'email',
        'map_url',
        'opening_hours',
    ];

    protected $casts = [
        'opening_hours' => 'array',
    ];

    public const DAYS = [
        'mon' => 'Mon',
        'tue' => 'Tue',
        'wed' => 'Wed',
        'thu' => 'Thu',
        'fri' => 'Fri',
        'sat' => 'Sat',
        'sun' => 'Sun',
    ];

    /**
     * Full public URL of the uploaded logo, or null if none set.
     */
    public function getLogoUrlAttribute(): ?string
    {
        return $this->logo ? Storage::disk('public')->url($this->logo) : null;
    }

    /**
     * Convenience accessor: is dark theme currently active.
     */
    public function getIsDarkAttribute(): bool
    {
        return $this->theme === 'dark';
    }

    /**
     * Opening hours normalized with every day always present, even if a
     * day is missing from stored JSON (e.g. after adding a new day).
     */
    public function getOpeningHoursNormalizedAttribute(): array
    {
        $hours = $this->opening_hours ?? [];

        $normalized = [];
        foreach (self::DAYS as $key => $label) {
            $normalized[$key] = $hours[$key] ?? ['open' => null, 'close' => null, 'closed' => true];
        }

        return $normalized;
    }

    /**
     * Human readable line per day, e.g. "Mon: 09:00 – 17:00" or "Sat: Closed".
     */
    public function formattedOpeningHours(): array
    {
        $lines = [];

        foreach ($this->opening_hours_normalized as $key => $day) {
            $label = self::DAYS[$key];
            $lines[$label] = empty($day['closed'])
                ? "{$day['open']} – {$day['close']}"
                : 'Closed';
        }

        return $lines;
    }
}