<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\SchoolEventType;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property-read SchoolEventType $type
 */
#[Fillable([
    'school_year_id',
    'school_id',
    'classroom_id',
    'title',
    'description',
    'location',
    'start_date',
    'end_date',
    'start_time',
    'end_time',
    'type',
    'blocks_lessons',
])]
class SchoolEvent extends Model
{
    protected function casts(): array
    {
        return [
            'type' => SchoolEventType::class,

            'blocks_lessons' => 'boolean',

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
     * @return BelongsTo<School, $this>
     */
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    /**
     * @return BelongsTo<Classroom, $this>
     */
    public function classroom(): BelongsTo
    {
        return $this->belongsTo(Classroom::class);
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
