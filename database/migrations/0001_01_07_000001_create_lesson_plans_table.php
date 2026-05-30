<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('lesson_plans', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('teaching_assignment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('academic_period_id')->constrained()->cascadeOnDelete();
            $table->foreignId('school_id')->constrained()->restrictOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();

            $table->string('title');
            $table->text('content');

            $table->text('objectives')->nullable();
            $table->text('methodology')->nullable();
            $table->jsonb('bncc_codes')->nullable();

            $table->date('starts_on');
            $table->date('ends_on')->nullable();

            $table->timestamps();

            // #

            $table->unique(
                ['teaching_assignment_id', 'starts_on'],
                'unq_lp_ta_starts_on'
            );

            $table->index(['school_id', 'academic_period_id']);
            $table->index(['teaching_assignment_id', 'starts_on']);
            $table->index('created_by');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lesson_plans');
    }
};
