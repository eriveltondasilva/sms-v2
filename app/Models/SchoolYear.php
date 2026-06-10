<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\AnnualFormulaType;
use App\Enums\PeriodFormulaType;
use App\Enums\ProgressStatus;
use App\Enums\RecoveryMethod;
use Database\Factories\SchoolYearFactory;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read ProgressStatus $status
 * @property-read PeriodFormulaType $period_formula_type
 * @property-read AnnualFormulaType $annual_formula_type
 * @property-read RecoveryMethod $period_recovery_method
 * @property-read RecoveryMethod $annual_recovery_method
 */
class SchoolYear extends Model
{
    /** @use HasFactory<SchoolYearFactory> */
    use HasFactory;

    use SoftDeletes;

    protected function casts(): array
    {
        return [
            'status' => ProgressStatus::class,

            'period_formula_type'    => PeriodFormulaType::class,
            'annual_formula_type'    => AnnualFormulaType::class,
            'period_recovery_method' => RecoveryMethod::class,
            'annual_recovery_method' => RecoveryMethod::class,

            'start_date' => 'date',
            'end_date'   => 'date',

            'min_passing_score'         => 'decimal:2',
            'min_period_score'          => 'decimal:2',
            'min_attendance_percentage' => 'decimal:2',

            'allows_final_exam' => 'boolean',
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
     * @return HasMany<AcademicPeriod, $this>
     */
    public function academicPeriods(): HasMany
    {
        return $this->hasMany(AcademicPeriod::class)->orderBy('order');
    }

    /**
     * @return HasMany<Classroom, $this>
     */
    public function classrooms(): HasMany
    {
        return $this->hasMany(Classroom::class);
    }

    /**
     * @return HasMany<Enrollment, $this>
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    // # Scopes

    #[Scope]
    protected function active(Builder $query): Builder
    {
        return $query->where('status', ProgressStatus::InProgress);
    }

    // # Helpers

    public function isActive(): bool
    {
        return $this->status === ProgressStatus::InProgress;
    }
}
