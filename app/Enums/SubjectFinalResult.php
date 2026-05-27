<?php

declare(strict_types=1);

namespace App\Enums;

enum SubjectFinalResult: string
{
    case Approved = 'approved';
    case FailedByGrade = 'failed_by_grade';
    case FailedByAttendance = 'failed_by_attendance';
    case FailedBoth = 'failed_both';

    public const DEFAULT = self::Approved->value;
}
