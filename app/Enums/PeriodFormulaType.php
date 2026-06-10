<?php

declare(strict_types=1);

namespace App\Enums;

enum PeriodFormulaType: string
{
    case WeightedAvg = 'weighted_avg';
    case SimpleAvg = 'simple_avg';
}
