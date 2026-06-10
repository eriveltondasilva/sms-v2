<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Classroom;
use App\Models\School;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TeachingAssignment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<TeachingAssignment>
 */
class TeachingAssignmentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'classroom_id' => Classroom::factory(),
            'subject_id'   => Subject::factory(),
            'teacher_id'   => Teacher::factory(),
            'school_id'    => School::factory(),

            'workload_hours' => fake()->numberBetween(20, 80),

            'start_date' => fake()->dateTimeBetween('-6 months', '-3 months')->format('Y-m-d'),
            'end_date'   => null,

            'is_active' => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(['is_active' => false]);
    }
}
