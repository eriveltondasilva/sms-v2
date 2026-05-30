<?php

declare(strict_types=1);

use App\Enums\AnnualFormulaType;
use App\Enums\PeriodFormulaType;
use App\Enums\RecoveryMethod;
use App\Enums\SchoolYearStatus;
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

            $table->smallInteger('year')->unsigned();
            $table->string('status', 20)->default(SchoolYearStatus::DEFAULT);

            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();

            $table->unsignedSmallInteger('total_school_days')->default(200);
            $table->unsignedSmallInteger('total_school_hours')->default(800);

            $table->string('period_formula_type', 20)->default(PeriodFormulaType::DEFAULT);
            $table->string('annual_formula_type', 20)->default(AnnualFormulaType::DEFAULT);
            $table->string('period_recovery_method', 20)->default(RecoveryMethod::DEFAULT);
            $table->string('annual_recovery_method', 20)->default(RecoveryMethod::Average->value);

            // SEM default — preenchimento obrigatório: valor depende da fórmula anual
            // sum → 24.00 | simple_avg → 6.00
            $table->decimal('min_passing_score', 5, 2);
            $table->decimal('min_period_score', 4, 2)->default(6.00);
            $table->decimal('min_attendance_percentage', 5, 2)->default(75.00);

            $table->boolean('allows_final_exam')->default(true);

            $table->softDeletes();
            $table->timestamps();

            // #

            $table->unique(['school_id', 'year'], 'unique_sy_year_per_school');

            $table->index(['school_id', 'year']);
            $table->index(['school_id', 'status']);
        });

        DB::statement("
            ALTER TABLE school_years
            ADD CONSTRAINT check_school_year_status
            CHECK (status IN ('planned','in_progress','finished'))
        ");

        DB::statement('
            ALTER TABLE school_years
            ADD CONSTRAINT chk_sy_attendance_pct
            CHECK (min_attendance_percentage BETWEEN 0 AND 100)
        ');

        DB::statement("
            CREATE UNIQUE INDEX unique_sy_in_progress
            ON school_years (school_id)
            WHERE status = 'in_progress'
        ");
    }

    public function down(): void
    {
        DB::statement('DROP INDEX IF EXISTS unique_sy_in_progress');
        Schema::dropIfExists('school_years');
    }
};
