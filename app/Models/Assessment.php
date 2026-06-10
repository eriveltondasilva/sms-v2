<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\AssessmentCategory;
use Database\Factories\AssessmentFactory;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property-read AssessmentCategory $category
 */
class Assessment extends Model
{
    /** @use HasFactory<AssessmentFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'category' => AssessmentCategory::class,

            'date' => 'date',

            'max_score' => 'decimal:2',
            'weight'    => 'decimal:2',
        ];
    }

    /**
     * @return BelongsTo<TeachingAssignment, $this>
     */
    public function teachingAssignment(): BelongsTo
    {
        return $this->belongsTo(TeachingAssignment::class);
    }

    /**
     * @return BelongsTo<AcademicPeriod, $this>
     */
    public function academicPeriod(): BelongsTo
    {
        return $this->belongsTo(AcademicPeriod::class);
    }

    /**
     * @return BelongsTo<School, $this>
     */
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    /**
     * @return BelongsTo<AssessmentTemplate, $this>
     */
    public function template(): BelongsTo
    {
        return $this->belongsTo(AssessmentTemplate::class, 'assessment_template_id');
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * @return HasMany<StudentScore, $this>
     */
    public function studentScores(): HasMany
    {
        return $this->hasMany(StudentScore::class);
    }

    // # Scopes

    #[Scope]
    protected function forPeriod(Builder $query, int|AcademicPeriod $period): Builder
    {
        return $query->where('academic_period_id', $period instanceof AcademicPeriod ? $period->id : $period);
    }

    #[Scope]
    protected function regular(Builder $query): Builder
    {
        return $query->whereIn('category', [
            AssessmentCategory::Regular->value,
            AssessmentCategory::Makeup->value,
        ]);

    }

    // # Helpers

    public function isRegular(): bool
    {
        return $this->category === AssessmentCategory::Regular;
    }

    public function isPeriodRecovery(): bool
    {
        return $this->category === AssessmentCategory::PeriodRecovery;
    }

    public function isFinalExam(): bool
    {
        return $this->category === AssessmentCategory::FinalExam;
    }
}
