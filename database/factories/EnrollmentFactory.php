<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\EnrollmentStatus;
use App\Models\Classroom;
use App\Models\Enrollment;
use App\Models\School;
use App\Models\SchoolYear;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Enrollment>
 */
class EnrollmentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'student_id'     => Student::factory(),
            'classroom_id'   => Classroom::factory(),
            'school_year_id' => SchoolYear::factory(),
            'school_id'      => School::factory(),

            'previous_enrollment_id' => null,

            'status' => EnrollmentStatus::Active,
            'notes'  => null,

            'final_result'               => null,
            'final_result_calculated_at' => null,

            'enrolled_date'  => now()->toDateString(),
            'finalized_date' => null,
        ];
    }

    public function finished(): static
    {
        return $this->state([
            'status'         => EnrollmentStatus::Finished,
            'finalized_date' => now()->toDateString(),
        ]);
    }

    public function transferred(): static
    {
        return $this->state([
            'status'         => EnrollmentStatus::Transferred,
            'finalized_date' => now()->toDateString(),
        ]);
    }
}
