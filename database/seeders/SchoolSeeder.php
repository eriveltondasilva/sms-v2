<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\School;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Context;

class SchoolSeeder extends Seeder
{
    public function run(): void
    {
        $school = School::query()->firstOrCreate(
            ['slug' => 'escola-demo'],
            [
                'full_name'  => 'Escola Demo',
                'short_name' => 'ED',
                'motto'      => 'Adipisicing duis anim deserunt aute adipisicing deserunt qui consequat consequat.',

                'inep_code' => '00000000',
                'cnpj'      => $this->digitsOnly('00.000.000/0001-00'),
                'phone'     => $this->digitsOnly('(82) 9 8765-4321'),

                'email'     => 'contato@escola-demo.com',
                'address'   => 'Av. Brasil, 123, Bairro, Cidade - Estado',

                'is_active' => true,
            ],
        );

        Context::add('school-demo', $school);
    }

      private function digitsOnly(string $value): string
    {
        return preg_replace('/\D/', '', $value);
    }
}
