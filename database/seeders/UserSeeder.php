<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $role = Role::SuperAdmin;

        $user = User::factory()->create([
            'name'  => $role->value,
            'email' => "{$role->value}@example.com",
        ]);

        $user->assignRole($role->value);
    }
}
