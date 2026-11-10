<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Emotion extends Model
{
    protected $fillable = ['slug', 'label', 'icon', 'color', 'sort_order'];

    public function conditions(): BelongsToMany
    {
        return $this->belongsToMany(Condition::class, 'condition_emotion');
    }

    public function scopeOrdered(Builder $query): Builder
    {
        return $query->orderBy('sort_order');
    }
}
