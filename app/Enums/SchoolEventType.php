<?php

declare(strict_types=1);

namespace App\Enums;

enum SchoolEventType: string
{
    case General = 'general';
    case Holiday = 'holiday';
    case Exam = 'exam';
    case Meeting = 'meeting';
    case Trip = 'trip';
    case Recess = 'recess';

    public const DEFAULT = self::General->value;
}
