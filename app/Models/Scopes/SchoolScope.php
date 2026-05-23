<?php

declare(strict_types=1);

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;
use Illuminate\Support\Facades\Auth;

class SchoolScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        if (! Auth::check()) {
            return;
        }

        $user = Auth::user();

        if ($user->isSuperAdmin()) {
            return;
        }

        $schoolId = session('active_school_id');

        if (! $schoolId) {
            // Sem escola ativa na sessão, não retorna nada
            $builder->whereRaw('1 = 0');

            return;
        }

        $builder->where($model->getTable() . 'school_id', $user->school_id);
    }
}
