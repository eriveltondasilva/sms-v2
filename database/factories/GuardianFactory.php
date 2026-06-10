<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Guardian;
use App\Models\School;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Guardian>
 */
class GuardianFactory extends Factory
{
    public function definition(): array
    {
        return [
            'school_id' => School::factory(),

            'name' => fake()->name(),

            'cpf'   => fake()->unique()->numerify('###########'),
            'phone' => fake()->numerify('###########'),

            'email'   => fake()->safeEmail(),
            'address' => fake()->address(),
        ];
    }
}
