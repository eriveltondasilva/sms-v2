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

        $gradeLevels = collect([
            ['name' => '1º Ano', 'stage' => 'Ensino Fundamental I',  'code' => 'EF01'],
            ['name' => '2º Ano', 'stage' => 'Ensino Fundamental I',  'code' => 'EF02'],
            ['name' => '3º Ano', 'stage' => 'Ensino Fundamental I',  'code' => 'EF03'],
            ['name' => '4º Ano', 'stage' => 'Ensino Fundamental I',  'code' => 'EF04'],
            ['name' => '5º Ano', 'stage' => 'Ensino Fundamental I',  'code' => 'EF05'],
            ['name' => '6º Ano', 'stage' => 'Ensino Fundamental II', 'code' => 'EF06'],
            ['name' => '7º Ano', 'stage' => 'Ensino Fundamental II', 'code' => 'EF07'],
            ['name' => '8º Ano', 'stage' => 'Ensino Fundamental II', 'code' => 'EF08'],
            ['name' => '9º Ano', 'stage' => 'Ensino Fundamental II', 'code' => 'EF09'],
        ])
            ->map(fn (array $level): array => [
                ...$level,
                'created_at' => $now,
                'updated_at' => $now,
            ])
            ->all();

        DB::table('grade_levels')->upsert(
            $gradeLevels,
            ['code'],
            ['name', 'stage', 'updated_at']
        );
    }
}
