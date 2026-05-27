<?php

declare(strict_types=1);

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Scope;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property int $school_id
 * @property Carbon $starts_at
 * @property Carbon $ends_at
 * @property bool $is_active
 */
#[Fillable(['school_id', 'name', 'starts_at', 'ends_at', 'is_active'])]
class AcademicYear extends Model
{
    use HasFactory;
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
        return $this->starts_at->isPast() && $this->ends_at->isFuture();
    }
}
