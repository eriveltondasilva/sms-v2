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
        Schema::create('lesson_records', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('teaching_assignment_id')->constrained()->restrictOnDelete();
            $table->foreignId('school_id')->constrained()->restrictOnDelete();
            $table->foreignId('recorded_by')->nullable()->constrained('users')->nullOnDelete();

            $table->date('lesson_date');
            $table->unsignedSmallInteger('lessons_given')->default(1);

            $table->timestamp('recorded_at')->nullable();
            $table->timestamps();

            // #

            $table->unique(
                ['teaching_assignment_id', 'lesson_date'],
                'unique_teaching_assignment_and_lesson_date'
            );

            $table->index('teaching_assignment_id');
            $table->index(['school_id', 'lesson_date']);
            $table->index('recorded_by');
        });

        DB::statement('
            ALTER TABLE lesson_records
            ADD CONSTRAINT check_lr_lessons_given
            CHECK (lessons_given >= 1)
        ');
    }

    public function down(): void
    {
        Schema::dropIfExists('lesson_records');
    }
};
