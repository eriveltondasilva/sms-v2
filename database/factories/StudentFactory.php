<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Gender;
use App\Enums\StudentStatus;
use App\Models\School;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends Factory<Student>
 */
class StudentFactory extends Factory
{
    public function definition(): array
    {
        return [
            'school_id' => School::factory(),

            'public_id'    => (string) Str::uuid(),
            'registration' => fake()->unique()->numerify('########'),

            'full_name'   => fake()->name(),
            'social_name' => null,

            'gender' => fake()->randomElement(Gender::cases())->value,

            'birth_date'  => fake()->dateTimeBetween('-18 years', '-6 years')->format('Y-m-d'),
            'birth_place' => fake()->city(),
            'nationality' => 'Brasileira',

            'cpf'     => fake()->unique()->numerify('###########'),
            'phone'   => fake()->numerify('###########'),
            'email'   => fake()->safeEmail(),
            'address' => fake()->address(),

            'status' => StudentStatus::Active,
        ];
    }

    public function inactive(): static
    {
        return $this->state(['status' => StudentStatus::Inactive]);
    }

    public function transferred(): static
    {
        return $this->state(['status' => StudentStatus::Transferred]);
    }
}
