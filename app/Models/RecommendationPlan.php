<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RecommendationPlan extends Model
{
    protected $fillable = ['mode_id', 'slug', 'title', 'intro'];

    public function mode(): BelongsTo
    {
        return $this->belongsTo(Mode::class);
    }

    public function steps(): HasMany
    {
        return $this->hasMany(RecommendationStep::class, 'plan_id')->orderBy('position');
    }
}
