<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\ClassroomShift;
use App\Models\Classroom;
use App\Models\School;
use App\Models\SchoolYear;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Classroom>
 */
class ClassroomFactory extends Factory
{
    public function definition(): array
    {
        return [
            'school_id'      => School::factory(),
            'school_year_id' => SchoolYear::factory(),
            // 'grade_level_id' => GradeLevel::factory(),

            'main_teacher_id' => null,

            'name'  => fake()->randomElement(['A', 'B', 'C']) . fake()->numberBetween(1, 5),
            'room'  => 'Sala ' . fake()->numberBetween(1, 20),
            'shift' => fake()->randomElement(ClassroomShift::cases()),

            'student_max' => fake()->numberBetween(20, 40),

            'is_active' => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(['is_active' => false]);
    }
}
