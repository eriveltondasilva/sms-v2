<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\PeriodAttendanceStatus;
use App\Enums\PeriodGradeStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read PeriodGradeStatus $grade_status
 * @property-read PeriodAttendanceStatus $attendance_status
 */
class PeriodResult extends Model
{
    protected function casts(): array
    {
        return [
            'grade_status'      => PeriodGradeStatus::class,
            'attendance_status' => PeriodAttendanceStatus::class,

            'total_classes'        => 'integer',
            'attended_classes'     => 'integer',
            'justified_absences'   => 'integer',
            'unjustified_absences' => 'integer',

            'calculated_grade'      => 'decimal:2',
            'recovery_grade'        => 'decimal:2',
            'final_grade'           => 'decimal:2',
            'attendance_percentage' => 'decimal:2',

            'grade_locked_at'      => 'datetime',
            'attendance_locked_at' => 'datetime',

            'calculation_snapshot' => 'array',
        ];
    }

    // # Relations
    /**
     * @return BelongsTo<Enrollment, $this>
     */
    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(Enrollment::class);
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

    // #Helpers

    public function isGradeLocked(): bool
    {
        return $this->grade_locked_at !== null;
    }

    public function isAttendanceLocked(): bool
    {
        return $this->attendance_locked_at !== null;
    }

    public function isFullyLocked(): bool
    {
        return $this->isGradeLocked() && $this->isAttendanceLocked();
    }
}
