<?php

declare(strict_types=1);

namespace App\Models;

use App\Enums\Role as RoleEnum;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Spatie\Permission\Traits\HasRoles;

#[Fillable(['name', 'email', 'password', 'avatar'])]
#[Hidden(['password', 'two_factor_secret', 'two_factor_recovery_codes', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory;

    use HasRoles;
    use Notifiable;
    use SoftDeletes;
    use TwoFactorAuthenticatable;

    protected function casts(): array
    {
        return [
            'password' => 'hashed',

            'is_active' => 'boolean',

            'two_factor_confirmed_at' => 'datetime',
            'email_verified_at'       => 'datetime',
            'last_login_at'           => 'datetime',
        ];
    }

    // # Relations

    /**
     * @return BelongsToMany<School, $this>
     */
    public function schools(): BelongsToMany
    {
        return $this->belongsToMany(School::class, 'school_user')
            ->withPivot('is_active')
            ->withTimestamps();
    }

    // # Helpers

    public function isSuperAdmin(): bool
    {
        return $this->hasRole(RoleEnum::SuperAdmin);
    }

    public function isAdmin(): bool
    {
        return $this->hasRole(RoleEnum::Admin);
    }

    public function isSecretary(): bool
    {
        return $this->hasRole(RoleEnum::Secretary);
    }

    public function isTeacher(): bool
    {
        return $this->hasRole(RoleEnum::Teacher);
    }

    public function hasAccessToSchool(School $school): bool
    {
        if ($this->isSuperAdmin()) {
            return true;
        }

        return $this->schools()
            ->wherePivot('is_active', true)
            ->where('schools.id', $school->id)
            ->exists();
    }
}
