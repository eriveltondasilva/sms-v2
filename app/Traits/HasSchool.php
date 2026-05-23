<?php

declare(strict_types=1);

namespace App\Traits;

use App\Models\School;
use App\Models\Scopes\SchoolScope;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

trait HasSchool
{
    public static function bootHasSchool(): void
    {
        static::addGlobalScope(new SchoolScope());

        static::creating(function (self $model): void {
            if ($model->school_id === null) {
                $model->school_id = session('active_school_id');
            }
        });
    }

    /**
     * @return BelongsTo<School, $this>
     */
    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }
}
