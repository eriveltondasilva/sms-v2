<?php

declare(strict_types=1);

namespace App\Enums;

enum AssessmentCategory: string
{
    case Regular = 'regular';
    case Makeup = 'makeup';
    case PeriodRecovery = 'period_recovery';
    case FinalExam = 'final_exam';

    public const DEFAULT = self::Regular->value;
}
