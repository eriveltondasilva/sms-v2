<?php

declare(strict_types=1);
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('school_years', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('school_id')->constrained()->restrictOnDelete();

            // #

            $table->unsignedSmallInteger('year');
            $table->string('status', 20);

            $table->date('start_date');
            $table->date('end_date');

            $table->unsignedTinyInteger('grade_decimal_places');

            $table->unsignedSmallInteger('total_school_days')->default(200);
            $table->unsignedSmallInteger('total_school_hours')->default(800);

            $table->string('period_formula_type', 20);
            $table->string('annual_formula_type', 20);

            $table->string('period_recovery_method', 20);
            $table->string('annual_recovery_method', 20);

            $table->string('rounding_mode', 20);

            $table->decimal('min_passing_score', 5, 2);
            $table->decimal('min_period_score', 4, 2);

            $table->decimal('min_attendance_percentage', 5, 2);

            $table->boolean('allows_final_exam')->default(true);

            $table->softDeletes();
            $table->timestamps();

            // #

            $table->unique(['school_id', 'year'], 'unique_sy_year_per_school');

            $table->index(['school_id', 'status']);
        });

        // # Unique
        DB::statement("
            CREATE UNIQUE INDEX unique_sy_in_progress
            ON school_years (school_id)
            WHERE status = 'in_progress'
        ");

        // # Checks
        DB::statement("
            ALTER TABLE school_years
            ADD CONSTRAINT check_school_year_status
            CHECK (status IN ('planned','in_progress','finished'))
        ");

        DB::statement("
            ALTER TABLE school_years
            ADD CONSTRAINT check_sy_rounding_mode
            CHECK (rounding_mode IN ('half_up','ceiling'))
        ");

        DB::statement('
            ALTER TABLE school_years
            ADD CONSTRAINT check_sy_dates
            CHECK (end_date > start_date)
        ');

        DB::statement('
            ALTER TABLE school_years
            ADD CONSTRAINT check_sy_grade_decimal_places
            CHECK (grade_decimal_places BETWEEN 0 AND 2)
        ');

        DB::statement('
            ALTER TABLE school_years
            ADD CONSTRAINT check_sy_positive_counts
            CHECK (total_school_days > 0 AND total_school_hours > 0)
        ');

        DB::statement('
            ALTER TABLE school_years
            ADD CONSTRAINT check_sy_score_ranges
            CHECK (
                min_passing_score >= 0
                AND min_period_score >= 0
                AND min_attendance_percentage BETWEEN 0 AND 100
            )
        ');
    }

    public function down(): void
    {
        Schema::dropIfExists('school_years');
    }
};
