<?php

declare(strict_types=1);

namespace App\Enums;

enum EnrollmentStatus: string
{
    case Active = 'active';
    case Transferred = 'transferred';
    case Finished = 'finished';
    case Dropout = 'dropout';

    public const DEFAULT = self::Active->value;
}
