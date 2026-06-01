<?php

declare(strict_types=1);

namespace App\Models;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\Pivot;

#[Fillable([
    'full_name',
    'short_name',
    'slug',
    'motto',
    'inep_code',
    'cnpj',
    'phone',
    'email',
    'address',
    'social_medias',
])]
class School extends Model
{
    use HasFactory;

    protected function casts(): array
    {
        return [
            'is_active'     => 'boolean',
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

    // endregion

    #[Scope]
    protected function active(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }
}
