<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RecommendationStep extends Model
{
    protected $fillable = ['plan_id', 'position', 'instruction', 'estimated_minutes'];

    protected function casts(): array
    {
        return [
            'position' => 'integer',
            'estimated_minutes' => 'integer',
        ];
    }

    public function plan(): BelongsTo
    {
        return $this->belongsTo(RecommendationPlan::class, 'plan_id');
    }
}
