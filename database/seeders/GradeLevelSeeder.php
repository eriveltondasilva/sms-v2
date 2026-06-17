<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Enums\GradeLevelCode;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GradeLevelSeeder extends Seeder
{
    public function run(): void
    {
        $levels = collect(GradeLevelCode::cases())
            ->groupBy(fn (GradeLevelCode $grade): string => $grade->stage())
            ->flatMap(fn ($grades, $stage) => $grades->map(fn (GradeLevelCode $grade, int $index): array => [
                'stage' => $stage,
                'name'  => $grade->label(),
                'code'  => $grade->value,
                'order' => $index + 1,
            ]))
            ->all();

        DB::table('grade_levels')->insertOrIgnore($levels);
    }
}
