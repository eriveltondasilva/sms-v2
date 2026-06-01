<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GradeLevelSeeder extends Seeder
{
    public function run(): void
    {
        $now = now();

        $gradeLevels = [
            // Ensino Fundamental I (Anos Iniciais)
            [
                'name'       => '1º Ano',
                'stage'      => 'Ensino Fundamental I',
                'code'       => 'EF01',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name'       => '2º Ano',
                'stage'      => 'Ensino Fundamental I',
                'code'       => 'EF02',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name'       => '3º Ano',
                'stage'      => 'Ensino Fundamental I',
                'code'       => 'EF03',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name'       => '4º Ano',
                'stage'      => 'Ensino Fundamental I',
                'code'       => 'EF04',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name'       => '5º Ano',
                'stage'      => 'Ensino Fundamental I',
                'code'       => 'EF05',
                'created_at' => $now,
                'updated_at' => $now,
            ],

            // Ensino Fundamental II (Anos Finais)
            [
                'name'       => '6º Ano',
                'stage'      => 'Ensino Fundamental II',
                'code'       => 'EF06',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name'       => '7º Ano',
                'stage'      => 'Ensino Fundamental II',
                'code'       => 'EF07',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name'       => '8º Ano',
                'stage'      => 'Ensino Fundamental II',
                'code'       => 'EF08',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name'       => '9º Ano',
                'stage'      => 'Ensino Fundamental II',
                'code'       => 'EF09',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        DB::table('grade_levels')->upsert(
            $gradeLevels,
            ['code'],
            ['name', 'stage', 'updated_at']
        );
    }
}
