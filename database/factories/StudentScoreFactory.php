<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Assessment;
use App\Models\Enrollment;
use App\Models\School;
use App\Models\StudentScore;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<StudentScore>
 */
class StudentScoreFactory extends Factory
{
    public function definition(): array
    {
        return [
            'assessment_id' => Assessment::factory(),
            'enrollment_id' => Enrollment::factory(),
            'school_id'     => School::factory(),

            'created_by' => null,

            'score' => fake()->randomFloat(2, 0, 10),
        ];
    }

    public function absent(): static
    {
        return $this->state(['score' => null]);
    }
}
