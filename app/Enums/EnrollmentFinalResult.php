<?php

declare(strict_types=1);

namespace App\Enums;

enum EnrollmentFinalResult: string
{
    case Approved = 'approved';
    case Failed = 'failed';
    case Transferred = 'transferred';
    case Dropout = 'dropout';
}
