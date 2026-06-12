<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'school_id',
    'name',
    'description',
    'default_max_score',
    'default_weight',
    'is_active',
])]
class AssessmentTemplate extends Model
{
    protected function casts(): array
    {
        return [
            'default_max_score' => 'decimal:2',
            'default_weight'    => 'decimal:2',

            'is_active' => 'boolean',
        ];
    }

    // # Relations
    /**
     * @return BelongsTo<School, $this>
     */
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    /**
     * @return HasMany<Assessment, $this>
     */
    public function assessments(): HasMany
    {
        return $this->hasMany(Assessment::class, 'assessment_template_id');
    }
}
