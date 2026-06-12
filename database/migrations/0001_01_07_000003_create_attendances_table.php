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
        Schema::create('attendances', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('lesson_id')->constrained()->restrictOnDelete();
            $table->foreignId('enrollment_id')->constrained()->restrictOnDelete();
            $table->foreignId('teaching_assignment_id')->constrained()->restrictOnDelete();
            $table->foreignId('school_id')->constrained()->restrictOnDelete();

            $table->foreignId('recorded_by')->nullable()->constrained('users')->nullOnDelete();

            // #

            $table->string('status', 1)->comment('P = Presente | A = Ausente | J = Falta Justificada');
            $table->text('justification')->nullable();

            $table->timestamps();

            // #

            $table->unique(
                ['enrollment_id', 'lesson_id'],
                'unique_attendance_enrollment_occurrence'
            );

            $table->index(['lesson_id', 'status']);
            $table->index(['school_id', 'enrollment_id', 'status']);
            $table->index(['enrollment_id', 'status']);

            $table->index(['teaching_assignment_id', 'enrollment_id']);
            $table->index(
                ['teaching_assignment_id', 'lesson_id', 'status'],
                'idx_attendances_ta_lesson_status'
            );

            $table->index('recorded_by');
        });

        // # Checks
        DB::statement("
            ALTER TABLE attendances
            ADD CONSTRAINT check_attendance_status
            CHECK (status IN ('P','A','J'))
        ");
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
