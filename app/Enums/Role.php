<?php

declare(strict_types=1);

namespace App\Enums;

enum Role: string
{
    case SuperAdmin = 'super-admin';
    case Admin = 'admin';
    case Secretary = 'secretary';
    case Teacher = 'teacher';

    public function isGlobal(): bool
    {
        return $this === self::SuperAdmin;
    }
}
