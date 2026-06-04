<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('student_scores', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('assessment_id')->constrained()->restrictOnDelete();
            $table->foreignId('enrollment_id')->constrained()->restrictOnDelete();
            $table->foreignId('school_id')->constrained()->restrictOnDelete();

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();

            // #

            $table->decimal('score', 5, 2)->nullable();

            $table->timestamps();

            // #

            $table->unique(['enrollment_id', 'assessment_id'], 'unique_enrollment_and_assessment');

            $table->index('assessment_id');
            $table->index(['school_id', 'enrollment_id']);
            $table->index('created_by');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('student_scores');
    }
};
