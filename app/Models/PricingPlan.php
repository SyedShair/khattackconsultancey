<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PricingPlan extends Model
{
    protected $fillable = [
        'title',
        'subtitle',
        'price_monthly',
        'price_yearly',
        'features',
        'button_text',
        'button_link',
        'is_popular',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_popular'    => 'boolean',
        'is_active'     => 'boolean',
        'price_monthly' => 'decimal:2',
        'price_yearly'  => 'decimal:2',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function getFeaturesListAttribute(): array
    {
        return $this->features
            ? array_values(array_filter(array_map('trim', explode("\n", $this->features))))
            : [];
    }

    public function getButtonLinkOrDefaultAttribute(): string
    {
        return $this->button_link ?: '#';
    }
}
