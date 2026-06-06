<?php

declare(strict_types=1);

namespace App\Context;

use App\Models\School;
use Illuminate\Container\Attributes\Scoped;
use RuntimeException;

#[Scoped]
final class SchoolContext
{
    private ?School $school = null;

    public function set(School $school): void
    {
        $this->school = $school;
    }

    public function get(): School
    {
        throw_unless(
            $this->school instanceof School,
            RuntimeException::class, 'SchoolContext não foi inicializado para esta request.'
        );

        return $this->school;
    }

    public function id(): int
    {
        return $this->get()->id;
    }

    public function hasSchool(): bool
    {
        return $this->school instanceof School;
    }
}
