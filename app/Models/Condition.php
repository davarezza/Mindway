<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Condition extends Model
{
    protected $fillable = ['slug', 'title', 'description', 'icon', 'color', 'sort_order', 'is_active'];

    protected function casts(): array
    {
        return ['is_active' => 'boolean'];
    }

    public function emotions(): BelongsToMany
    {
        return $this->belongsToMany(Emotion::class, 'condition_emotion');
    }

    /** Butir checklist untuk kondisi ini, sudah terurut sesuai tabel pivot. */
    public function signals(): BelongsToMany
    {
        return $this->belongsToMany(Signal::class, 'condition_signal')
            ->withPivot('sort_order')
            ->orderBy('condition_signal.sort_order');
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
