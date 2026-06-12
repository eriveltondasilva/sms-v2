<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\AnnualFormulaType;
use App\Enums\PeriodFormulaType;
use App\Enums\ProgressStatus;
use App\Enums\RecoveryMethod;
use App\Enums\RoundingMode;
use Database\Factories\SchoolYearFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
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
 * @property-read RoundingMode $rounding_mode
 */
#[Fillable([
    'school_id',
    'year',
    'status',
    'start_date',
    'end_date',
    'grade_decimal_places',
    'total_school_days',
    'total_school_hours',
    'period_formula_type',
    'annual_formula_type',
    'period_recovery_method',
    'annual_recovery_method',
    'rounding_mode',
    'min_passing_score',
    'min_period_score',
    'min_attendance_percentage',
    'allows_final_exam',
])]
class SchoolYear extends Model
{
    /** @use HasFactory<SchoolYearFactory> */
    use HasFactory;

    use SoftDeletes;

    protected function casts(): array
    {
        return [

            'status' => ProgressStatus::class,

            'rounding_mode' => RoundingMode::class,

            'period_formula_type' => PeriodFormulaType::class,
            'annual_formula_type' => AnnualFormulaType::class,

            'period_recovery_method' => RecoveryMethod::class,
            'annual_recovery_method' => RecoveryMethod::class,

            'start_date' => 'date',
            'end_date'   => 'date',

            'min_passing_score'         => 'decimal:2',
            'min_period_score'          => 'decimal:2',
            'min_attendance_percentage' => 'decimal:2',

            'allows_final_exam' => 'boolean',

            'year' => 'integer',

            'total_school_days'  => 'integer',
            'total_school_hours' => 'integer',

            'grade_decimal_places' => 'integer',
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

    public function isPlanned(): bool
    {
        return $this->status === ProgressStatus::Planned;
    }

    public function isFinished(): bool
    {
        return $this->status === ProgressStatus::Finished;
    }

    public function requiresPeriodWeights(): bool
    {
        return $this->annual_formula_type === AnnualFormulaType::WeightedAvg;
    }
}
