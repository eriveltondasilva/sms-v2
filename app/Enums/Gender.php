<?php

declare(strict_types=1);

namespace App\Enums;

enum Gender: string
{
    case Male = 'M';
    case Female = 'F';
    case NotStated = 'N';

    public function label(): string
    {
        return match ($this) {
            self::Male      => 'Masculino',
            self::Female    => 'Feminino',
            self::NotStated => 'N/A',
        };
    }
}
