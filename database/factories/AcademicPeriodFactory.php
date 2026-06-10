<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\ProgressStatus;
use App\Models\AcademicPeriod;
use App\Models\SchoolYear;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<AcademicPeriod>
 */
class AcademicPeriodFactory extends Factory
{
    public function definition(): array
    {
        return [
            'school_year_id' => SchoolYear::factory(),

            'name'  => fake()->randomElement(['1º Bimestre', '2º Bimestre', '3º Bimestre', '4º Bimestre']),
            'order' => fake()->numberBetween(1, 4),

            'start_date' => fake()->dateTimeBetween('-6 months', '-3 months')->format('Y-m-d'),
            'end_date'   => fake()->dateTimeBetween('-2 months', 'now')->format('Y-m-d'),

            'status' => ProgressStatus::Planned,
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
