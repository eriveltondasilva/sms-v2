<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\School;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/** @extends Factory<School> */
class SchoolFactory extends Factory
{
    public function definition(): array
    {
        $name = fake()->company();

        return [
            'full_name'  => $name,
            'short_name' => Str::of($name)->slug()->limit(8, '')->upper()->toString(),

            'slug' => Str::slug($name) . '-' . fake()->unique()->numberBetween(1, 9999),

            'cnpj'      => fake()->unique()->numerify('##############'),
            'inep_code' => fake()->unique()->numerify('########'),

            'phone'   => fake()->numerify('###########'),
            'email'   => fake()->companyEmail(),
            'address' => fake()->address(),

            'is_active' => true,
        ];
    }

    public function inactive(): static
    {
        return $this->state(['is_active' => false]);
    }
}
