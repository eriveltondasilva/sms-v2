<?php

declare(strict_types=1);

namespace App\Contexts;

use RuntimeException;

abstract class Context
{
    protected mixed $context = null;

    abstract protected function message(): string;

    public function has(): bool
    {
        return $this->context !== null;
    }

    protected function resolve(): mixed
    {
        throw_unless(
            $this->has(),
            RuntimeException::class,
            $this->message()
        );

        return $this->context;
    }
}
