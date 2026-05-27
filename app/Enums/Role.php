<?php

declare(strict_types=1);

namespace App\Enums;

enum Role: string
{
    case SuperAdmin = 'super-admin';
    case Admin = 'admin';
    case Secretary = 'secretary';
    case Teacher = 'teacher';

    public function label(): string
    {
        return match ($this) {
            self::SuperAdmin => 'Super Administrador',
            self::Admin      => 'Administrador',
            self::Secretary  => 'Secretaria',
            self::Teacher    => 'Professor',
        };
    }

    public function description(): string
    {
        return match ($this) {
            self::SuperAdmin => 'Acesso global a todas as escolas',
            self::Admin      => 'Gerencia uma escola específica',
            self::Secretary  => 'Operações administrativas da escola',
            self::Teacher    => 'Lançamento de notas e frequência',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::SuperAdmin => 'red',
            self::Admin      => 'blue',
            self::Secretary  => 'yellow',
            self::Teacher    => 'green',
        };
    }

    public function isGlobal(): bool
    {
        return $this === self::SuperAdmin;
    }
}
