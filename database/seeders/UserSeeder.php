<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\Role;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Context;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        $school = Context::get('school-demo');

        foreach (Role::cases() as $role) {
            $user = User::factory()->create([
                'name'  => $role->label(),
                'email' => "{$role->value}@example.com",
            ]);

            $user->assignRole($role->value);

            if (! $role->isGlobal()) {
                $user->schools()->attach($school->id, ['is_revoked' => false]);
            }
        }
    }
}
