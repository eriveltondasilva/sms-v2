<?php

declare(strict_types=1);

namespace App\Enums;

enum AcademicPeriodStatus: string
{
    case Planned = 'planned';
    case InProgress = 'in_progress';
    case Finished = 'finished';

    public const DEFAULT = self::Planned->value;
}
