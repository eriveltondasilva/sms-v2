<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\AttendanceStatus;
use App\Models\Attendance;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\School;
use App\Models\TeachingAssignment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Attendance>
 */
class AttendanceFactory extends Factory
{
    public function definition(): array
    {
        return [
            'lesson_id'              => Lesson::factory(),
            'enrollment_id'          => Enrollment::factory(),
            'teaching_assignment_id' => TeachingAssignment::factory(),
            'school_id'              => School::factory(),

            'recorded_by' => null,

            'status'        => AttendanceStatus::Present,
            'justification' => null,
        ];
    }

    public function absent(): static
    {
        return $this->state(['status' => AttendanceStatus::Absent]);
    }

    public function justified(): static
    {
        return $this->state([
            'status'        => AttendanceStatus::Justified,
            'justification' => fake()->sentence(),
        ]);
    }
}
