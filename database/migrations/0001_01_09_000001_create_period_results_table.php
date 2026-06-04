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
        Schema::create('period_results', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('enrollment_id')->constrained()->restrictOnDelete();
            $table->foreignId('teaching_assignment_id')->constrained()->restrictOnDelete();
            $table->foreignId('academic_period_id')->constrained()->restrictOnDelete();
            $table->foreignId('school_id')->constrained()->restrictOnDelete();

            // --- GRADE ---

            $table->decimal('calculated_grade', 5, 2);
            $table->decimal('recovery_grade', 5, 2)->nullable();
            $table->decimal('final_grade', 5, 2);

            $table->string('grade_status', 20);
            $table->timestamp('grade_locked_at')->nullable();

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

            // --- ATTENDANCE ---

            $table->unsignedSmallInteger('total_classes')->default(0);

            $table->unsignedSmallInteger('attended_classes')->default(0);
            $table->unsignedSmallInteger('justified_absences')->default(0);
            $table->unsignedSmallInteger('unjustified_absences')->default(0);

            $table->decimal('attendance_percentage', 5, 2)->default(0.00);

            $table->string('attendance_status', 20);
            $table->timestamp('attendance_locked_at')->nullable();

            $table->timestamps();

            // #

            $table->unique(
                ['enrollment_id', 'teaching_assignment_id', 'academic_period_id'],
                'unique_period_result'
            );

            $table->index(['school_id', 'academic_period_id']);
            $table->index(['academic_period_id', 'grade_status']);
            $table->index(['academic_period_id', 'attendance_status']);
            $table->index(['teaching_assignment_id', 'grade_status']);
            $table->index(['teaching_assignment_id', 'attendance_status']);
        });

        DB::statement("
            ALTER TABLE period_results
            ADD CONSTRAINT check_pr_grade_status
            CHECK (grade_status IN ('pending','passing','needs_recovery','failed'))
        ");

        DB::statement("
            ALTER TABLE period_results
            ADD CONSTRAINT check_pr_attendance_status
            CHECK (attendance_status IN ('sufficient','insufficient'))
        ");
    }

    public function down(): void
    {
        Schema::dropIfExists('period_results');
    }
};
