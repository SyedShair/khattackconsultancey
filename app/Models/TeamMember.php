<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Traits\LogsActivity;

class TeamMember extends Model
{
    use LogsActivity;
    protected $fillable = [
        'name',
        'designation',
        'photo',
        'facebook_url',
        'twitter_url',
        'skype_url',
        'link',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function getPhotoUrlAttribute(): ?string
    {
        return $this->photo ? Storage::disk('public')->url($this->photo) : null;
    }

    public function getLinkOrDefaultAttribute(): string
    {
        return $this->link ?: '#';
    }
}