<?php

declare(strict_types=1);

use App\Enums\PeriodGradeStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('period_grades', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('enrollment_id')->constrained()->restrictOnDelete();
            $table->foreignId('teaching_assignment_id')->constrained()->restrictOnDelete();
            $table->foreignId('academic_period_id')->constrained()->restrictOnDelete();

            $table->decimal('calculated_grade', 5, 2);
            $table->decimal('recovery_grade', 5, 2)->nullable();
            $table->decimal('final_grade', 5, 2);

            $table->string('status', 20)->default(PeriodGradeStatus::Pending->value);
            $table->boolean('is_locked')->default(false);
            $table->timestamp('locked_at')->nullable();

            $table->jsonb('calculation_snapshot')->nullable();
            // calculation_snapshot (jsonb) exemplo:
            // {
            //   "formula": "weighted_avg",
            //   "recovery_method": "best_score",
            //   "assessments": [
            //     {"id": 1, "name": "Prova 1", "score": 8.5, "weight": 4.0, "category": "regular"},
            //     {"id": 2, "name": "Trabalho", "score": 9.0, "weight": 3.0, "category": "regular"}
            //   ],
            //   "recovery_assessments": [{"id": 3, "score": 7.0}],
            //   "calculated_at": "2025-05-20T10:00:00Z"
            // }

            $table->timestamps();

            // #

            $table->unique(
                ['enrollment_id', 'teaching_assignment_id', 'academic_period_id'],
                'unq_period_grade'
            );

            $table->index(['academic_period_id', 'status']);
            $table->index(['teaching_assignment_id', 'status']);
        });

        DB::statement("
            ALTER TABLE period_grades
            ADD CONSTRAINT chk_pg_status
            CHECK (status IN ('pending','passing','needs_recovery','failed'))
        ");

        DB::statement('
            ALTER TABLE period_grades
            ADD CONSTRAINT chk_pg_calculated_grade
            CHECK (calculated_grade >= 0)
        ');

        DB::statement('
            ALTER TABLE period_grades
            ADD CONSTRAINT chk_pg_recovery_grade
            CHECK (recovery_grade IS NULL OR recovery_grade >= 0)
        ');

        DB::statement('
            ALTER TABLE period_grades
            ADD CONSTRAINT chk_pg_final_grade
            CHECK (final_grade >= 0)
        ');
    }

    public function down(): void
    {
        Schema::dropIfExists('period_grades');
    }
};
