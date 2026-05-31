<?php

declare(strict_types=1);

namespace App\Enums;

enum AttendanceStatus: string
{
    case Present = 'P';
    case Absent = 'A';
    case Justified = 'J';

    public const DEFAULT = self::Present->value;

    public function label(): string
    {
        return match ($this) {
            self::Present   => 'Presente',
            self::Absent    => 'Ausente',
            self::Justified => 'Justificado',
        };
    }
}
