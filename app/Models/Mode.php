<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mode extends Model
{
    protected $fillable = [
        'slug', 'title', 'tagline', 'help_label', 'icon', 'color',
        'closing_title', 'closing_message', 'sort_order', 'is_active',
    ];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function questions(): HasMany
    {
        return $this->hasMany(ModeQuestion::class)->orderBy('sort_order');
    }

    public function plans(): HasMany
    {
        return $this->hasMany(RecommendationPlan::class);
    }

    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order');
    }
}
