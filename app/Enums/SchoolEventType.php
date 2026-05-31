<?php

declare(strict_types=1);

namespace App\Enums;

enum SchoolEventType: string
{
    case General = 'general';
    case Holiday = 'holiday';
    case Exam = 'exam';
    case Meeting = 'meeting';
    case Recess = 'recess';

    public const DEFAULT = self::General->value;

    public function label(): string
    {
        return match ($this) {
            self::General => 'Geral',
            self::Holiday => 'Feriado',
            self::Exam    => 'Exame',
            self::Meeting => 'Reunião',
            self::Recess  => 'Recesso',
        };
    }
}
