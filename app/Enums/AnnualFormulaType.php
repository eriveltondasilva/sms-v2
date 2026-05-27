<?php

declare(strict_types=1);

namespace App\Enums;

enum AnnualFormulaType: string
{
    case Sum = 'sum';
    case SimpleAvg = 'simple_avg';
    case WeightedAvg = 'weighted_avg';

    public const DEFAULT = self::Sum->value;
}
