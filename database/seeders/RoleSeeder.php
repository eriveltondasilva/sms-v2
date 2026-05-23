<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\RoleEnum;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (RoleEnum::cases() as $role) {
            Role::query()->firstOrCreate(['name' => $role->value], [
                'label'       => $role->label(),
                'description' => $role->description(),
                'color'       => $role->color(),
                'guard_name'  => 'web',
            ]);
        }
    }
}
