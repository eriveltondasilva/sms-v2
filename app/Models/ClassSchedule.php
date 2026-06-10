<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Weekdays;
use Database\Factories\ClassScheduleFactory;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property-read Weekdays $weekday
 */
class ClassSchedule extends Model
{
    /** @use HasFactory<ClassScheduleFactory> */
    use HasFactory;

    protected function casts(): array
    {
        return [
            'weekday' => Weekdays::class,

            'valid_from'  => 'date',
            'valid_until' => 'date',
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
     * @return BelongsTo<School, $this>
     */
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    /**
     * @return HasMany<Lesson, $this>
     */
    public function lessons(): HasMany
    {
        return $this->hasMany(Lesson::class);
    }

    // # Scopes

    #[Scope]
    protected function active(Builder $query): Builder
    {
        return $query->where(
            fn (\Illuminate\Contracts\Database\Query\Builder $q) => $q->whereNull('valid_until')->orWhere('valid_until', '>=', now())
        );
    }
}
