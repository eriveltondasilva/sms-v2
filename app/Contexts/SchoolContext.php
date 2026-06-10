<?php

declare(strict_types=1);

namespace App\Contexts;

use App\Models\School;
use Illuminate\Container\Attributes\Scoped;

#[Scoped]
final class SchoolContext extends Context
{
    public function set(School $school): void
    {
        $this->context = $school;
    }

    public function get(): School
    {
        return $this->resolve();
    }

    public function id(): int
    {
        return $this->get()->id;
    }

    protected function message(): string
    {
        return 'SchoolContext não foi inicializado para esta request.';
    }
}
