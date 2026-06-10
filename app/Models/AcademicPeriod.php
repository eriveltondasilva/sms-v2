<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ProgressStatus;
use Database\Factories\AcademicPeriodFactory;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property-read ProgressStatus $status
 * @property-read Carbon $start_date
 * @property-read Carbon $end_date
 */
class AcademicPeriod extends Model
{
    /** @use HasFactory<AcademicPeriodFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'status' => ProgressStatus::class,

            'start_date' => 'date',
            'end_date'   => 'date',
        ];
    }

    // # Relations
    /**
     * @return BelongsTo<SchoolYear, $this>
     */
    public function schoolYear(): BelongsTo
    {
        return $this->belongsTo(SchoolYear::class);
    }

    /**
     * @return HasMany<Assessment, $this>
     */
    public function assessments(): HasMany
    {
        return $this->hasMany(Assessment::class);
    }

    /**
     * @return HasMany<LessonPlan, $this>
     */
    public function lessonPlans(): HasMany
    {
        return $this->hasMany(LessonPlan::class);
    }

    /**
     * @return HasMany<PeriodResult, $this>
     */
    public function periodResults(): HasMany
    {
        return $this->hasMany(PeriodResult::class);
    }

    // # Scopes

    #[Scope]
    protected function active(Builder $query): Builder
    {
        return $query->where('status', ProgressStatus::InProgress);
    }

    // # Helpers

    public function isOpen(): bool
    {
        return $this->status !== ProgressStatus::Finished;
    }
}
