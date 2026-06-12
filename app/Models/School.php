<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\ProgressStatus;
use App\Policies\SchoolPolicy;
use Database\Factories\SchoolFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Attributes\UsePolicy;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable([
    'full_name',
    'short_name',
    'motto',
    'slug',
    'cnpj',
    'inep_code',
    'phone',
    'email',
    'address',
    'is_active',
    'social_medias',
])]
#[UsePolicy(SchoolPolicy::class)]
class School extends Model
{
    /** @use HasFactory<SchoolFactory> */
    use HasFactory;

    use SoftDeletes;

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',

            'social_medias' => 'array',
        ];
    }

    // region Relationships

    /**
     * @return BelongsToMany<User, $this, Pivot>
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class)
            ->withPivot('is_active')
            ->withTimestamps();
    }

    /**
     * @return HasMany<SchoolYear, $this>
     */
    public function schoolYears(): HasMany
    {
        return $this->hasMany(SchoolYear::class);
    }

    /**
     * @return HasOne<SchoolYear, $this>
     */
    public function currentYear(): HasOne
    {
        return $this->hasOne(SchoolYear::class)
            ->where('status', ProgressStatus::InProgress);
    }

    /**
     * @return HasMany<Subject, $this>
     */
    public function subjects(): HasMany
    {
        return $this->hasMany(Subject::class);
    }

    // endregion

    #[Scope]
    protected function active(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    #[Scope]
    protected function slug(Builder $query, string $slug): Builder
    {
        return $query->where('slug', $slug);
    }
}
