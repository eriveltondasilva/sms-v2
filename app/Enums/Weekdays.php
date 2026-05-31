<?php

declare(strict_types=1);

namespace App\Enums;

enum Weekdays: int
{
    case MONDAY = 1;
    case TUESDAY = 2;
    case WEDNESDAY = 3;
    case THURSDAY = 4;
    case FRIDAY = 5;
    case SATURDAY = 6;

    public function label(): string
    {
        return match ($this) {
            self::MONDAY    => 'Segunda-feira',
            self::TUESDAY   => 'Terça-feira',
            self::WEDNESDAY => 'Quarta-feira',
            self::THURSDAY  => 'Quinta-feira',
            self::FRIDAY    => 'Sexta-feira',
            self::SATURDAY  => 'Sábado',
        };
    }
}
