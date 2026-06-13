<?php

declare(strict_types=1);

namespace App\Enums;

enum EnrollmentFinalResult: string
{
    case Approved = 'approved';
    case Transferred = 'transferred';
    case Failed = 'failed';
    case Dropout = 'dropout';
}
