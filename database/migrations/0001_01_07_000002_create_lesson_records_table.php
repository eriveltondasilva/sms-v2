<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('lesson_records', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('teaching_assignment_id')->constrained()->restrictOnDelete();
            $table->foreignId('lesson_plan_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('school_id')->constrained()->restrictOnDelete();
            $table->foreignId('recorded_by')->nullable()->constrained('users')->nullOnDelete();

            $table->date('lesson_date');
            $table->time('start_time');

            $table->text('topic')->nullable();
            $table->timestamp('diary_filled_at')->nullable();

            $table->timestamps();

            // #

            $table->unique(
                ['teaching_assignment_id', 'lesson_date', 'start_time'],
                'unq_lr_ta_date_time'
            );

            $table->index(['school_id', 'lesson_date']);
            $table->index(['teaching_assignment_id', 'lesson_date']);
            $table->index('lesson_plan_id');
            $table->index('recorded_by');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lesson_records');
    }
};
