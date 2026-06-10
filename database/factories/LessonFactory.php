<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\LessonStatus;
use App\Models\ClassSchedule;
use App\Models\Lesson;
use App\Models\School;
use App\Models\TeachingAssignment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Lesson>
 */
class LessonFactory extends Factory
{
    public function definition(): array
    {
        return [
            'class_schedule_id'      => ClassSchedule::factory(),
            'teaching_assignment_id' => TeachingAssignment::factory(),
            'school_id'              => School::factory(),

            'cancelled_by' => null,

            'lesson_date' => fake()->dateTimeBetween('-3 months', 'now')->format('Y-m-d'),

            'start_time' => '08:00:00',

            'status'              => LessonStatus::Scheduled,
            'cancellation_reason' => null,
        ];
    }

    public function held(): static
    {
        return $this->state(['status' => LessonStatus::Held]);
    }

    public function cancelled(): static
    {
        return $this->state([
            'status'              => LessonStatus::Cancelled,
            'cancellation_reason' => fake()->sentence(),
        ]);
    }

    public function makeup(): static
    {
        return $this->state([
            'status'            => LessonStatus::Makeup,
            'class_schedule_id' => null,
        ]);
    }
}
