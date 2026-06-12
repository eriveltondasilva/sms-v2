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
        Schema::create('lessons', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('class_schedule_id')->nullable()->constrained()->restrictOnDelete();
            $table->foreignId('teaching_assignment_id')->constrained()->restrictOnDelete();
            $table->foreignId('school_id')->constrained()->restrictOnDelete();

            $table->foreignId('cancelled_by')->nullable()->constrained('users')->nullOnDelete();

            // #

            $table->date('lesson_date');

            $table->time('start_time')->nullable();

            $table->string('status', 20);
            // scheduled → aula prevista, ainda não ocorreu.
            // held      → aula realizada.
            // cancelled → aula cancelada.

            $table->text('cancellation_reason')->nullable();

            $table->timestamps();

            // #

            $table->index(['school_id', 'lesson_date']);
            $table->index(['school_id', 'status']);

            $table->index(['teaching_assignment_id', 'lesson_date']);
            $table->index(
                ['teaching_assignment_id', 'status', 'lesson_date'],
                'idx_lessons_ta_status_date'
            );

            $table->index('class_schedule_id');
            $table->index('cancelled_by');
        });

        // # Uniques
        DB::statement('
            CREATE UNIQUE INDEX unique_lesson_per_schedule_date
            ON lessons (class_schedule_id, lesson_date)
            WHERE class_schedule_id IS NOT NULL
        ');

        // # Checks
        DB::statement("
            ALTER TABLE lessons
            ADD CONSTRAINT check_lessons_status
            CHECK (status IN ('scheduled','held','cancelled'))
        ");
    }

    public function down(): void
    {
        Schema::dropIfExists('lessons');
    }
};
