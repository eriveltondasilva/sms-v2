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
        Schema::create('lesson_plans', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('teaching_assignment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('academic_period_id')->constrained()->cascadeOnDelete();
            $table->foreignId('school_id')->constrained()->restrictOnDelete();

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();

            // #

            $table->string('content');

            $table->text('objectives')->nullable();
            $table->text('methodology')->nullable();
            $table->text('resources')->nullable();

            $table->jsonb('bncc_codes')->nullable();
            // bncc_codes (jsonb): códigos de habilidades da Base Nacional Comum Curricular (BNCC).
            // Estrutura:
            // [
            //   "EF01LP01",
            //   "EF01LP02",
            //   "EF02MA07"
            // ]

            $table->date('start_date');
            $table->date('end_date');

            $table->timestamps();

            // #

            $table->unique(['teaching_assignment_id', 'start_date'], 'unique_lp_ta_start_date');

            $table->index(['teaching_assignment_id', 'start_date', 'end_date'], 'idx_lp_ta_date_range');
            $table->index(['school_id', 'academic_period_id']);
            $table->index('academic_period_id');
            $table->index('created_by');
        });

        DB::statement("
            ALTER TABLE lesson_plans
            ADD CONSTRAINT check_lesson_plan_date_range
            CHECK (end_date >= start_date)
        ");
    }

    public function down(): void
    {
        Schema::dropIfExists('lesson_plans');
    }
};
