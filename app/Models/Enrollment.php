<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\EnrollmentFinalResult;
use App\Enums\EnrollmentStatus;
use Database\Factories\EnrollmentFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read EnrollmentStatus $status
 * @property-read EnrollmentFinalResult $final_result
 */
#[Fillable([
    'student_id',
    'classroom_id',
    'school_year_id',
    'school_id',
    'previous_enrollment_id',
    'status',
    'notes',
    'enrolled_date',
    'finalized_date',
])]
class Enrollment extends Model
{
    /** @use HasFactory<EnrollmentFactory> */
    use HasFactory;

    use SoftDeletes;

    protected function casts(): array
    {
        return [
            'status'       => EnrollmentStatus::class,
            'final_result' => EnrollmentFinalResult::class,

            'enrolled_date'  => 'date',
            'finalized_date' => 'date',

            'final_result_calculated_at' => 'datetime',
        ];
    }

    // # Relations
    /**
     * @return BelongsTo<Student, $this>
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * @return BelongsTo<Classroom, $this>
     */
    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }

    /**
     * @return BelongsTo<SchoolYear, $this>
     */
    public function schoolYear(): BelongsTo
    {
        return $this->belongsTo(SchoolYear::class);
    }

    /**
     * @return BelongsTo<School, $this>
     */
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    /**
     * @return BelongsTo<Enrollment, $this>
     */
    public function previousEnrollment(): BelongsTo
    {
        return $this->belongsTo(self::class, 'previous_enrollment_id');
    }

    /**
     * @return HasMany<Attendance, $this>
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * @return HasMany<StudentScore, $this>
     */
    public function studentScores(): HasMany
    {
        return $this->hasMany(StudentScore::class);
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
        return $query->where('status', EnrollmentStatus::Active);
    }

    // # Helpers
    public function isActive(): bool
    {
        return $this->status === EnrollmentStatus::Active;
    }
}
