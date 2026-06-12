<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'teaching_assignment_id',
    'academic_period_id',
    'school_id',
    'content',
    'objectives',
    'methodology',
    'resources',
    'bncc_codes',
    'start_date',
    'end_date',
])]
class LessonPlan extends Model
{
    protected function casts(): array
    {
        return [
            'bncc_codes' => 'array',

            'start_date' => 'date',
            'end_date'   => 'date',
        ];
    }

    // # Relations
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
     * @return BelongsTo<User, $this>
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * @return HasMany<LessonRecord, $this>
     */
    public function lessonRecords(): HasMany
    {
        return $this->hasMany(LessonRecord::class);
    }
}
