<?php

declare(strict_types=1);

namespace App\Enums;

enum RecoveryMethod: string
{
    case BestScore = 'best_score';
    case Average = 'average';
    case Replace = 'replace';

    public const DEFAULT = self::BestScore->value;
}
