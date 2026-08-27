<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Service extends Model
{
    protected $fillable = [
        'title',
        'slug',
        'description',
        'link',
        'icon',
        'is_active',
        'sort_order',
        'detail_image',
        'content',
        'planning_image',
        'planning_heading',
        'planning_text',
        'execution_heading',
        'execution_text',
        'brochure_pdf',
        'brochure_doc',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // NOTE: no getRouteKeyName() override here — admin routes (toggle-active,
    // edit, destroy, reorder) keep binding by `id` as normal. Only the public
    // web.php route explicitly asks for slug binding via {service:slug},
    // so the two don't conflict.

    protected static function booted(): void
    {
        static::creating(function (Service $service) {
            if (empty($service->slug)) {
                $service->slug = static::uniqueSlug($service->title);
            }
        });
    }

    public static function uniqueSlug(string $title, ?int $ignoreId = null): string
    {
        $base = Str::slug($title);
        $slug = $base ?: 'service';
        $i = 1;

        while (
            static::where('slug', $slug)
                ->when($ignoreId, fn ($q) => $q->where('id', '!=', $ignoreId))
                ->exists()
        ) {
            $slug = "{$base}-" . $i++;
        }

        return $slug;
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Where the homepage card should link to: the custom `link` field if
     * one was set in admin, otherwise this service's own details page.
     */
    public function getLinkOrDefaultAttribute(): string
    {
        if ($this->link) {
            return $this->link;
        }

        return $this->slug
            ? route('services.show', $this)
            : url('/#tb__service');
    }

    public function getIconUrlAttribute(): ?string
    {
        return $this->icon ? Storage::url($this->icon) : null;
    }

    public function getDetailImageUrlAttribute(): ?string
    {
        return $this->detail_image ? Storage::url($this->detail_image) : null;
    }

    public function getPlanningImageUrlAttribute(): ?string
    {
        return $this->planning_image ? Storage::url($this->planning_image) : null;
    }

    public function getBrochurePdfUrlAttribute(): ?string
    {
        return $this->brochure_pdf ? Storage::url($this->brochure_pdf) : null;
    }

    public function getBrochureDocUrlAttribute(): ?string
    {
        return $this->brochure_doc ? Storage::url($this->brochure_doc) : null;
    }
}