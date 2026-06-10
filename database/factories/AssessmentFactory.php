<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\AssessmentCategory;
use App\Models\AcademicPeriod;
use App\Models\Assessment;
use App\Models\School;
use App\Models\TeachingAssignment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Assessment>
 */
class AssessmentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'teaching_assignment_id' => TeachingAssignment::factory(),
            'academic_period_id'     => AcademicPeriod::factory(),
            'school_id'              => School::factory(),
            'assessment_template_id' => null,

            'created_by' => null,

            'name'        => 'Prova ' . fake()->numberBetween(1, 4),
            'description' => null,

            'max_score' => 10.00,
            'weight'    => 1.00,

            'category' => AssessmentCategory::Regular,

            'date' => fake()->dateTimeBetween('-2 months', 'now')->format('Y-m-d'),
        ];
    }

    public function periodRecovery(): static
    {
        return $this->state(['category' => AssessmentCategory::PeriodRecovery]);
    }

    public function finalExam(): static
    {
        return $this->state([
            'category'           => AssessmentCategory::FinalExam,
            'academic_period_id' => null,
        ]);
    }

    public function makeup(): static
    {
        return $this->state(['category' => AssessmentCategory::Makeup]);
    }
}
