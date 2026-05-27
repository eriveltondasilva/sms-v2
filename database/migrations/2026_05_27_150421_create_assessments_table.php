<?php

declare(strict_types=1);

use App\Enums\AssessmentCategory;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('assessments', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('teaching_assignment_id')->constrained()->cascadeOnDelete();
            $table->foreignId('academic_period_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('assessment_type_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('school_id')->constrained()->restrictOnDelete();

            $table->string('name');
            $table->string('description')->nullable();
            $table->string('category', 20)->default(AssessmentCategory::DEFAULT);
            $table->decimal('max_score', 5, 2)->default(10.00);
            $table->decimal('weight', 5, 2)->default(1.00);
            $table->date('date')->nullable();

            $table->timestamps();

            // #

            $table->index(['school_id', 'academic_period_id']);
            $table->index(['academic_period_id', 'date']);
            $table->index(['teaching_assignment_id', 'academic_period_id']);
            $table->index('teaching_assignment_id');
            $table->index('assessment_type_id');
            $table->index('created_by');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessments');
    }
};
