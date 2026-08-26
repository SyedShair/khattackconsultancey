<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;
use App\Traits\LogsActivity;

class Vacancy extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'title',
        'slug',
        'department',
        'location',
        'type',
        'description',
        'requirements',
        'salary_min',
        'salary_max',
        'status',
        'deadline',
    ];

    protected $casts = [
        'deadline' => 'date',
    ];

    public const TYPES = [
        'full-time'  => 'Full-time',
        'part-time'  => 'Part-time',
        'contract'   => 'Contract',
        'internship' => 'Internship',
        'remote'     => 'Remote',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function applications(): HasMany
    {
        return $this->hasMany(Application::class);
    }

    public function scopeOpen($query)
    {
        return $query->where('status', 'open')
            ->where(function ($q) {
                $q->whereNull('deadline')->orWhere('deadline', '>=', now()->toDateString());
            });
    }

    public function getIsOpenAttribute(): bool
    {
        return $this->status === 'open'
            && (! $this->deadline || $this->deadline->isFuture() || $this->deadline->isToday());
    }

    public function getSalaryRangeAttribute(): ?string
    {
        if (! $this->salary_min && ! $this->salary_max) {
            return null;
        }

        if ($this->salary_min && $this->salary_max) {
            return number_format($this->salary_min) . ' – ' . number_format($this->salary_max);
        }

        return number_format($this->salary_min ?? $this->salary_max);
    }

    protected static function booted(): void
    {
        static::creating(function (Vacancy $vacancy) {
            if (empty($vacancy->slug)) {
                $vacancy->slug = static::uniqueSlug($vacancy->title);
            }
        });
    }

    public static function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);
        $slug = $base;
        $i = 1;

        while (
            static::where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = "{$base}-" . ++$i;
        }

        return $slug;
    }
}