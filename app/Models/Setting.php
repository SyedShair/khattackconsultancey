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
}