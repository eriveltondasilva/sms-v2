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
        Schema::create('assessments', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('teaching_assignment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('academic_period_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('school_id')->constrained()->restrictOnDelete();
            $table->foreignId('assessment_template_id')->nullable()->constrained()->nullOnDelete();

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();

            // #

            $table->string('name');
            $table->string('description')->nullable();

            $table->unsignedTinyInteger('order');
            $table->string('category', 20);

            $table->decimal('max_score', 5, 2);
            $table->decimal('weight', 5, 2);

            $table->date('date')->nullable();

            $table->timestamps();

            // #

            $table->unique(
                ['teaching_assignment_id', 'academic_period_id', 'name'],
                'unique_assessment_ta_period_name'
            );

            $table->index(['school_id', 'academic_period_id']);
            $table->index(['academic_period_id', 'date']);
            $table->index('assessment_template_id');
            $table->index('created_by');
        });

        // # Checks
        DB::statement("
                ALTER TABLE assessments
                ADD CONSTRAINT check_assessment_category
                CHECK (category IN ('regular', 'period_recovery', 'final_exam'))
        ");

        DB::statement('
            ALTER TABLE assessments
            ADD CONSTRAINT check_assessment_order
            CHECK ("order" > 0)
        ');

        DB::statement('
            ALTER TABLE assessments
            ADD CONSTRAINT check_assessment_scores_positive
            CHECK (max_score > 0 AND weight > 0)
        ');
    }

    public function down(): void
    {
        Schema::dropIfExists('assessments');
    }
};
