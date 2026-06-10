<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\EnrollmentStatus;
use App\Enums\Gender;
use App\Enums\StudentStatus;
use Database\Factories\StudentFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

/**
 * @property-read Gender $gender
 * @property-read StudentStatus $status
 */
#[Fillable([
    'school_id', 'public_id', 'registration', 'full_name', 'social_name', 'gender',
    'birth_date', 'birth_place', 'nationality', 'color_race', 'rg', 'cpf',
    'phone', 'email', 'address', 'status', 'status_notes', 'health_data', 'special_needs',
])]
class Student extends Model
{
    /** @use HasFactory<StudentFactory> */
    use HasFactory;

    use SoftDeletes;

    protected static function booted(): void
    {
        static::creating(fn (Student $student) => $student->public_id ??= (string) Str::uuid());
    }

    protected function casts(): array
    {
        return [
            'gender' => Gender::class,
            'status' => StudentStatus::class,

            'birth_date' => 'date',

            'health_data'   => 'array',
            'special_needs' => 'array',
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
     * @return BelongsToMany<Guardian, $this, Pivot>
     */
    public function guardians(): BelongsToMany
    {
        return $this->belongsToMany(Guardian::class, 'student_guardian')
            ->withPivot(['relationship', 'is_primary'])
            ->withTimestamps();
    }

    /**
     * @return HasMany<Enrollment, $this>
     */
    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class);
    }

    /**
     * @return HasOne<Enrollment, $this>
     */
    public function activeEnrollment(): HasOne
    {
        return $this->hasOne(Enrollment::class)->where('status', EnrollmentStatus::Active);
    }

    // # Scopes

    #[Scope]
    protected function active(Builder $query): Builder
    {
        return $query->where('status', StudentStatus::Active);
    }

    #[Scope]
    protected function forSchool(Builder $query, int|School $school): Builder
    {
        return $query->where('school_id', $school instanceof School ? $school->id : $school);
    }

    // # Attributes
    protected function displayName(): Attribute
    {
        return Attribute::get(
            fn () => $this->social_name ?? $this->full_name
        );
    }

    protected function age(): Attribute
    {
        return Attribute::get(
            fn () => $this->birth_date?->age
        );
    }

    // # Helpers

}
