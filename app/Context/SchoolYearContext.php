<?php

declare(strict_types=1);

namespace App\Context;

use App\Models\SchoolYear;
use Illuminate\Container\Attributes\Scoped;
use RuntimeException;

#[Scoped]
final class SchoolYearContext
{
    private ?SchoolYear $schoolYear = null;

    public function set(SchoolYear $schoolYear): void
    {
        $this->schoolYear = $schoolYear;
    }

    public function get(): SchoolYear
    {
        throw_unless(
            $this->schoolYear instanceof SchoolYear,
            RuntimeException::class, 'SchoolYearContext não foi inicializado para esta request.'
        );

        return $this->schoolYear;
    }

    public function id(): int
    {
        return $this->get()->id;
    }

    public function hasSchoolYear(): bool
    {
        return $this->schoolYear instanceof SchoolYear;
    }
}
