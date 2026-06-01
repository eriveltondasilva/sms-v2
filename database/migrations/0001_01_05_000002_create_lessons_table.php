<?php

declare(strict_types=1);

use App\Enums\LessonStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('lessons', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('class_schedule_id')->nullable()->constrained()->restrictOnDelete();
            // NULL para aulas de reposição — não possuem agendamento recorrente de origem.

            $table->foreignId('teaching_assignment_id')->constrained()->restrictOnDelete();
            // Denormalizado de class_schedules.teaching_assignment_id.
            // Obrigatório mesmo em reposições — identifica a disciplina/turma.

            $table->foreignId('school_id')->constrained()->restrictOnDelete();

            $table->foreignId('cancelled_by')->nullable()->constrained('users')->nullOnDelete();

            // #

            $table->date('lesson_date');

            $table->time('start_time')->nullable();
            // Denormalizado de class_schedules.start_time para ocorrências regulares.
            // Obrigatório (preenchido manualmente) para aulas de reposição.

            $table->string('status', 20)->default(LessonStatus::DEFAULT);
            // scheduled → aula prevista, ainda não ocorreu.
            // held      → aula realizada.
            // cancelled → aula cancelada.
            // makeup    → aula de reposição

            $table->text('cancellation_reason')->nullable();

            $table->timestamps();

            // #

            $table->index(['teaching_assignment_id', 'lesson_date']);
            $table->index(['school_id', 'lesson_date']);
            $table->index(['school_id', 'status']);
            $table->index(['teaching_assignment_id', 'status']);
            $table->index('class_schedule_id');
            $table->index('cancelled_by');
        });

        DB::statement("
            ALTER TABLE lessons
            ADD CONSTRAINT check_co_status
            CHECK (status IN ('scheduled','held','cancelled','makeup'))
        ");
    }

    public function down(): void
    {
        Schema::dropIfExists('lesson');
    }
};
