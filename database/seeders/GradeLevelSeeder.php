<?php

declare(strict_types=1);

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GradeLevelSeeder extends Seeder
{
    public function run(): void
    {
        $levels = [
            // Educação Infantil
            ['stage' => 'Educação Infantil', 'name' => 'Berçário I',   'code' => 'EI-BI1',  'order' => 1],
            ['stage' => 'Educação Infantil', 'name' => 'Berçário II',  'code' => 'EI-BI2',  'order' => 2],
            ['stage' => 'Educação Infantil', 'name' => 'Maternal I',   'code' => 'EI-MAT1', 'order' => 3],
            ['stage' => 'Educação Infantil', 'name' => 'Maternal II',  'code' => 'EI-MAT2', 'order' => 4],
            ['stage' => 'Educação Infantil', 'name' => 'Pré I',        'code' => 'EI-PRE1', 'order' => 5],
            ['stage' => 'Educação Infantil', 'name' => 'Pré II',       'code' => 'EI-PRE2', 'order' => 6],

            // Ensino Fundamental — Anos Iniciais
            ['stage' => 'Ensino Fundamental I', 'name' => '1º Ano', 'code' => 'EF-1A', 'order' => 1],
            ['stage' => 'Ensino Fundamental I', 'name' => '2º Ano', 'code' => 'EF-2A', 'order' => 2],
            ['stage' => 'Ensino Fundamental I', 'name' => '3º Ano', 'code' => 'EF-3A', 'order' => 3],
            ['stage' => 'Ensino Fundamental I', 'name' => '4º Ano', 'code' => 'EF-4A', 'order' => 4],
            ['stage' => 'Ensino Fundamental I', 'name' => '5º Ano', 'code' => 'EF-5A', 'order' => 5],

            // Ensino Fundamental — Anos Finais
            ['stage' => 'Ensino Fundamental II', 'name' => '6º Ano', 'code' => 'EF-6A', 'order' => 1],
            ['stage' => 'Ensino Fundamental II', 'name' => '7º Ano', 'code' => 'EF-7A', 'order' => 2],
            ['stage' => 'Ensino Fundamental II', 'name' => '8º Ano', 'code' => 'EF-8A', 'order' => 3],
            ['stage' => 'Ensino Fundamental II', 'name' => '9º Ano', 'code' => 'EF-9A', 'order' => 4],

            // Ensino Médio
            ['stage' => 'Ensino Médio', 'name' => '1ª Série', 'code' => 'EM-1S', 'order' => 1],
            ['stage' => 'Ensino Médio', 'name' => '2ª Série', 'code' => 'EM-2S', 'order' => 2],
            ['stage' => 'Ensino Médio', 'name' => '3ª Série', 'code' => 'EM-3S', 'order' => 3],
        ];

        DB::table('grade_levels')->insertOrIgnore($levels);
    }
}
