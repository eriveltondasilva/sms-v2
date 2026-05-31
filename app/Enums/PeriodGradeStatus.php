<?php

declare(strict_types=1);

namespace App\Enums;

enum PeriodGradeStatus: string
{
    case Pending = 'pending';
    case Passing = 'passing';
    case NeedsRecovery = 'needs_recovery';
    case Failed = 'failed';

    public const DEFAULT = self::Pending->value;

    public function label(): string
    {
        return match ($this) {
            self::Pending       => 'Pendente',
            self::Passing       => 'Aprovado',
            self::NeedsRecovery => 'Recuperação',
            self::Failed        => 'Reprovado',
        };
    }
}
