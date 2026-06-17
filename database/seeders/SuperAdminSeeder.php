<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class SuperAdminSeeder extends Seeder
{
    public function run(): void
    {
        $role = Role::SuperAdmin;

        $user = User::factory()->create([
            'name'     => $role->value,
            'email'    => config('services.super_admin.email'),
            'password' => config('services.super_admin.password'),
        ]);

        $user->assignRole($role->value);
    }
}
