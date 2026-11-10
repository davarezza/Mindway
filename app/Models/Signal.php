<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Signal extends Model
{
    protected $fillable = ['slug', 'label', 'pattern_id', 'weight', 'is_red_flag'];

    protected function casts(): array
    {
        return [
            'weight' => 'integer',
            'is_red_flag' => 'boolean',
        ];
    }

    /** Null untuk sinyal keselamatan (tidak masuk skor). */
    public function pattern(): BelongsTo
    {
        return $this->belongsTo(Pattern::class);
    }

    public function conditions(): BelongsToMany
    {
        return $this->belongsToMany(Condition::class, 'condition_signal')->withPivot('sort_order');
    }
}
