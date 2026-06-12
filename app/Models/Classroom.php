<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ClassroomShift;
use Database\Factories\ClassroomFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read ClassroomShift $shift
 */
#[Fillable([
    'school_id',
    'school_year_id',
    'grade_level_id',
    'main_teacher_id',
    'name',
    'room',
    'shift',
    'student_max',
    'is_active',
])]
class Classroom extends Model
{
    /** @use HasFactory<ClassroomFactory> */
    use HasFactory;

    use SoftDeletes;

    protected function casts(): array
    {
        return [
            'shift' => ClassroomShift::class,

            'student_max' => 'integer',

            'is_active' => 'boolean',
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
     * @return BelongsTo<GradeLevel, $this>
     */
    public function gradeLevel(): BelongsTo
    {
        return $this->belongsTo(GradeLevel::class);
    }

    /**
     * @return BelongsTo<School, $this>
     */
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    /**
     * @return BelongsTo<Teacher, $this>
     */
    public function mainTeacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class, 'main_teacher_id');
    }

    /**
     * @return HasMany<TeachingAssignment, $this>
     */
    public function teachingAssignments(): HasMany
    {
        return $this->hasMany(TeachingAssignment::class);
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
        return $query->where('is_active', true);
    }

    #[Scope]
    protected function forYear(Builder $query, int|SchoolYear $schoolYear): Builder
    {
        return $query->where('school_year_id', $schoolYear instanceof SchoolYear ? $schoolYear->id : $schoolYear);
    }
}
