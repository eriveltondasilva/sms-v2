<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\School;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Context;

class SchoolSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $school = School::query()->firstOrCreate(
            ['slug' => 'escola-demo'],
            [
                'full_name'  => 'Escola Demo',
                'short_name' => 'ED',
                'slug'       => 'escola-demo',
                'motto'      => 'Adipisicing duis anim deserunt aute adipisicing deserunt qui consequat consequat.',
                'inep_code'  => '00000000',
                'cnpj'       => '00.000.000/0001-00',
                'phone'      => '(82) 99999-9999',
                'email'      => 'contato@escola-demo.com',
                'address'    => 'Av. Brasil, 123, Bairro, Cidade - Estado',
                'is_active'  => true,
            ],
        );

        Context::add('school-demo', $school);
    }
}
