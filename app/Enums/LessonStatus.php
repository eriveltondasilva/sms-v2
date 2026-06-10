<?php

declare(strict_types=1);

namespace App\Enums;

enum LessonStatus: string
{
    case Scheduled = 'scheduled';
    case Held = 'held';
    case Cancelled = 'cancelled';
    case Makeup = 'makeup';
}
