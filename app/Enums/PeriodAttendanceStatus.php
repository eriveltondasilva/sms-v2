<?php

declare(strict_types=1);

namespace App\Enums;

enum PeriodAttendanceStatus: string
{
    case Sufficient = 'sufficient';
    case Insufficient = 'insufficient';

    public const DEFAULT = self::Sufficient->value;
}
