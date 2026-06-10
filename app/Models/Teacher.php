<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Gender;
use Database\Factories\TeacherFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property-read Gender $gender
 */
#[Fillable(['user_id', 'name', 'gender', 'birth_date', 'cpf', 'rg', 'phone', 'email', 'address', 'is_active'])]
class Teacher extends Model
{
    /** @use HasFactory<TeacherFactory> */
    use HasFactory;

    use SoftDeletes;

    protected function casts(): array
    {
        return [
            'gender' => Gender::class,

            'birth_date' => 'date',
            'is_active'  => 'boolean',
        ];
    }

    // # Relations
    /**
     * @return BelongsTo<User, $this>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsToMany<School, $this, Pivot>
     */
    public function schools(): BelongsToMany
    {
        return $this->belongsToMany(School::class, 'school_teacher')
            ->withPivot(['qualification', 'hire_date', 'termination_date', 'termination_reason', 'is_active', 'bank_data'])
            ->withTimestamps();
    }

    /**
     * @return HasMany<TeachingAssignment, $this>
     */
    public function teachingAssignments(): HasMany
    {
        return $this->hasMany(TeachingAssignment::class);
    }

    // # Scopes

    #[Scope]
    protected function active(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    #[Scope]
    protected function forSchool(Builder $query, int|School $school): Builder
    {
        return $query->whereHas('schools', fn (Builder $query) => $query->where('schools.id', $school instanceof School ? $school->id : $school));
    }
}
