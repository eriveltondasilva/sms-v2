<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\AnnualFormulaType;
use App\Enums\PeriodFormulaType;
use App\Enums\ProgressStatus;
use App\Enums\RecoveryMethod;
use App\Models\School;
use App\Models\SchoolYear;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<SchoolYear>
 */
class SchoolYearFactory extends Factory
{
    public function definition(): array
    {
        $year = fake()->numberBetween(2020, 2030);

        return [
            'school_id' => School::factory(),

            'year' => $year,

            'start_date' => "{$year}-02-01",
            'end_date'   => "{$year}-12-20",

            'status' => ProgressStatus::Planned,

            'period_formula_type'    => PeriodFormulaType::WeightedAvg,
            'annual_formula_type'    => AnnualFormulaType::Sum,
            'period_recovery_method' => RecoveryMethod::BestScore,
            'annual_recovery_method' => RecoveryMethod::BestScore,

            'min_passing_score'         => 24.00,
            'min_period_score'          => 6.00,
            'min_attendance_percentage' => 75.00,

            'total_school_days'  => 200,
            'total_school_hours' => 800,

            'allows_final_exam' => true,
        ];
    }

    public function inProgress(): static
    {
        return $this->state(['status' => ProgressStatus::InProgress]);
    }

    public function finished(): static
    {
        return $this->state(['status' => ProgressStatus::Finished]);
    }
}
