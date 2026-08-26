<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use App\Traits\LogsActivity;

class Service extends Model
{
    use LogsActivity;
    protected $fillable = [
        'title',
        'description',
        'icon',
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

    public function getIconUrlAttribute(): ?string
    {
        return $this->icon ? Storage::disk('public')->url($this->icon) : null;
    }

    public function getLinkOrDefaultAttribute(): string
    {
        return $this->link ?: '#tb__service';
    }
}