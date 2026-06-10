<?php

declare(strict_types=1);

namespace App\Enums;

enum RoundingMode: string
{
    case HalfUp = 'half_up';
    case Ceiling = 'ceiling';
}
