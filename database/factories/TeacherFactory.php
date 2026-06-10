<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Enums\Gender;
use App\Models\Teacher;
use Illuminate\Database\Eloquent\Factories\Factory;

/** @extends Factory<Teacher> */
class TeacherFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => null,

            'name'       => fake()->name(),
            'gender'     => fake()->randomElement(Gender::cases())->value,
            'birth_date' => fake()->dateTimeBetween('-60 years', '-25 years')->format('Y-m-d'),

            'cpf' => fake()->unique()->numerify('###########'),
            'rg'  => fake()->numerify('#########'),

            'phone'   => fake()->numerify('###########'),
            'email'   => fake()->unique()->safeEmail(),
            'address' => fake()->address(),

            'is_active' => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(['is_active' => false]);
    }
}
