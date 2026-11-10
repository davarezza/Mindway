<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ModeQuestion extends Model
{
    protected $fillable = ['mode_id', 'prompt', 'helper', 'sort_order'];

    public function mode(): BelongsTo
    {
        return $this->belongsTo(Mode::class);
    }

    public function options(): HasMany
    {
        return $this->hasMany(ModeQuestionOption::class)->orderBy('sort_order');
    }
}
