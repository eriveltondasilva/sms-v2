<?php

declare(strict_types=1);

namespace App\Models;

use App\Traits\HasSchool;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

#[Fillable(['school_id', 'name', 'starts_at', 'ends_at', 'is_active'])]
class AcademicYear extends Model
{
    use HasFactory;
    use HasSchool;
    use SoftDeletes;

    protected function casts(): array
    {
        return [
            'starts_at' => 'date:Y-m-d',
            'ends_at'   => 'date:Y-m-d',

            'is_active' => 'boolean',
        ];
    }

    #[Scope]
    protected function active(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    public function activate(): void
    {
        static::query()->withoutGlobalScopes()
            ->where('school_id', $this->school_id)
            ->whereNot('id', $this->id)
            ->update(['is_active' => false]);

        $this->update(['is_active' => true]);
    }

    public function isOngoing(): bool
    {
        $today = now()->toDateString();

        return $this->starts_at->{$today}
            && $this->ends_at->toDateString() >= $today;
    }
}
