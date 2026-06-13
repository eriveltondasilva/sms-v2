<?php

declare(strict_types=1);

namespace App\Enums;

enum PeriodGradeStatus: string
{
    case Pending = 'pending';
    case Passing = 'passing';
    case NeedsRecovery = 'needs_recovery';
    case Failed = 'failed';
    case NotApplicable = 'not_applicable';
}
