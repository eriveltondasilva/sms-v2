<?php

declare(strict_types=1);

namespace App\Enums;

enum StudentStatus: string
{
    case Active = 'active';
    case Inactive = 'inactive';
    case Transferred = 'transferred';
    case Graduated = 'graduated';
    case Dropout = 'dropout';

    public const DEFAULT = self::Active->value;
}
