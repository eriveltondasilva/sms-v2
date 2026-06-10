<?php

declare(strict_types=1);

namespace App\Contexts;

use App\Models\SchoolYear;
use Illuminate\Container\Attributes\Scoped;

#[Scoped]
final class SchoolYearContext extends Context
{
    public function set(SchoolYear $schoolYear): void
    {
        $this->context = $schoolYear;
    }

    public function get(): SchoolYear
    {
        return $this->resolve();
    }

    public function id(): int
    {
        return $this->get()->id;
    }

    protected function message(): string
    {
        return 'SchoolYearContext não foi inicializado para esta request.';
    }
}
