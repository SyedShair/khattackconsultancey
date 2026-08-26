<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Traits\LogsActivity;

class Setting extends Model
{
    use LogsActivity;
    protected $fillable = [
        'app_name',
        'logo',
        'theme',
        'address',
        'phone',
        'email',
        'whatsapp_number',
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
     * A ready-to-use https://wa.me/... link built from whatsapp_number,
     * with any spaces, dashes, parentheses, or a leading + stripped out
     * (wa.me requires just digits, country code first, no punctuation).
     */
    public function getWhatsappLinkAttribute(): ?string
    {
        if (! $this->whatsapp_number) {
            return null;
        }

        $digits = preg_replace('/\D+/', '', $this->whatsapp_number);

        return $digits ? "https://wa.me/{$digits}" : null;
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