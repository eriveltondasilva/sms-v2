<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Weekdays;
use App\Models\ClassSchedule;
use App\Models\School;
use App\Models\TeachingAssignment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ClassSchedule>
 */
class ClassScheduleFactory extends Factory
{
    public function definition(): array
    {
        return [
            'teaching_assignment_id' => TeachingAssignment::factory(),
            'school_id'              => School::factory(),

            'weekday' => fake()->randomElement(Weekdays::cases())->value,

            'start_time' => fake()->randomElement(['07:00', '08:00', '09:00', '10:00', '13:00', '14:00']),

            'valid_from'  => fake()->dateTimeBetween('-6 months', '-3 months')->format('Y-m-d'),
            'valid_until' => null,
        ];
    }
}
