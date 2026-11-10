<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Pattern extends Model
{
    protected $fillable = [
        'slug', 'title', 'description', 'icon', 'color',
        'now_action', 'can_wait', 'watch_note', 'sort_order',
    ];

    public function signals(): HasMany
    {
        return $this->hasMany(Signal::class);
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order');
    }
}
