<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Subject as SubjectEnum;
use App\Models\School;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Subject>
 */
class SubjectFactory extends Factory
{
    public function definition(): array
    {
        $subject = fake()->randomElement(SubjectEnum::cases());

        return [
            'school_id' => School::factory(),

            'name' => $subject->value,
            'code' => $subject->code(),

            'week_hours' => $subject->weekHours(),

            'is_active' => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(['is_active' => false]);
    }
}
