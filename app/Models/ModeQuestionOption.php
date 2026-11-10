<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ModeQuestionOption extends Model
{
    protected $fillable = ['mode_question_id', 'label', 'recommendation_plan_id', 'sort_order'];

    public function question(): BelongsTo
    {
        return $this->belongsTo(ModeQuestion::class, 'mode_question_id');
    }

    /** Rencana langkah kecil yang ditampilkan kalau opsi ini dipilih. */
    public function plan(): BelongsTo
    {
        return $this->belongsTo(RecommendationPlan::class, 'recommendation_plan_id');
    }
}
