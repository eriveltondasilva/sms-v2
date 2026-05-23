<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (RoleEnum::cases() as $role) {
            User::factory()
                ->create([
                    'name'  => $role->label(),
                    'email' => "{$role->value}@example.com",
                ])
                ->assignRole($role->value);
        }
    }
}
