<?php

declare(strict_types=1);

namespace App\Enums;

enum ClassroomShift: string
{
    case Morning = 'morning';
    case Afternoon = 'afternoon';
    case Evening = 'evening';
}
