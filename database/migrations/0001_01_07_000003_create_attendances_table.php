<?php

declare(strict_types=1);

use App\Enums\AttendanceStatus;
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
            // Âncora da chamada: uma ocorrência de aula = uma presença por aluno.
            // Resolve o bug de aulas duplas no mesmo dia — cada lesson é distinto.
            // Independente de lesson_records: chamada e diário são preenchidos em momentos separados.

            $table->foreignId('enrollment_id')->constrained()->restrictOnDelete();

            $table->foreignId('teaching_assignment_id')->constrained()->restrictOnDelete();
            // Denormalizado de lessons.teaching_assignment_id.
            // Evita join em queries frequentes como "total de faltas por disciplina no período".

            $table->foreignId('school_id')->constrained()->restrictOnDelete();
            $table->foreignId('recorded_by')->nullable()->constrained('users')->nullOnDelete();

            $table->string('status', 1)->default(AttendanceStatus::DEFAULT);
            // 'P' = Presente | 'A' = Ausente | 'J' = Falta Justificada
            $table->text('justification')->nullable();

            $table->timestamps();

            // #

            $table->unique(
                ['enrollment_id', 'lesson_id'],
                'unique_attendance_enrollment_occurrence'
            );

            $table->index(['lesson_id', 'status']);
            // "Quem faltou nesta aula?" — chamada de presença na tela do professor.

            $table->index(['teaching_assignment_id', 'enrollment_id']);
            // "Todas as faltas do aluno nesta disciplina." — cálculo de period_results.

            $table->index(['school_id', 'enrollment_id', 'status']);
            // Filtros administrativos por escola.

            $table->index(['enrollment_id', 'status']);
            // "Total de faltas do aluno em todas as disciplinas."

            $table->index('recorded_by');
        });

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
