<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\LessonStatus;
use Database\Factories\LessonFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * @property-read LessonStatus $status
 */
#[Fillable([
    'class_schedule_id',
    'teaching_assignment_id',
    'school_id',
    'lesson_date',
    'start_time',
    'status',
    'cancellation_reason',
])]
class Lesson extends Model
{
    /** @use HasFactory<LessonFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'status' => LessonStatus::class,

            'lesson_date' => 'date',
        ];
    }

    /**
     * @return BelongsTo<ClassSchedule, $this>
     */
    public function classSchedule(): BelongsTo
    {
        return $this->belongsTo(ClassSchedule::class);
    }

    /**
     * @return BelongsTo<TeachingAssignment, $this>
     */
    public function teachingAssignment(): BelongsTo
    {
        return $this->belongsTo(TeachingAssignment::class);
    }

    /**
     * @return BelongsTo<School, $this>
     */
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function cancelledBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'cancelled_by');
    }

    /**
     * @return HasOne<LessonRecord, $this>
     */
    public function record(): HasOne
    {
        return $this->hasOne(LessonRecord::class);
    }

    /**
     * @return HasMany<Attendance, $this>
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    // # Scopes

    #[Scope]
    protected function held(Builder $query): Builder
    {
        return $query->where('status', LessonStatus::Held);
    }

    #[Scope]
    protected function forPeriod(Builder $query, AcademicPeriod $period): Builder
    {
        return $query->whereBetween('lesson_date', [$period->start_date, $period->end_date]);
    }

    // # Helpers
    public function isHeld(): bool
    {
        return $this->status === LessonStatus::Held;
    }
}
