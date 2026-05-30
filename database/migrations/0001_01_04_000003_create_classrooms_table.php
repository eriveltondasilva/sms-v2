<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('classrooms', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('school_year_id')->constrained()->restrictOnDelete();
            $table->foreignId('offered_grade_level_id')->constrained()->restrictOnDelete();
            $table->foreignId('main_teacher_id')->nullable()->constrained('teachers')->nullOnDelete();
            $table->foreignId('school_id')->constrained()->restrictOnDelete();

            $table->string('name', 50);
            $table->string('room', 30)->nullable();
            $table->string('shift', 20)->nullable();

            $table->unsignedSmallInteger('student_max')->default(30);

            $table->boolean('is_active')->default(true);

            $table->softDeletes();
            $table->timestamps();

            // #

            $table->unique(
                ['school_year_id', 'offered_grade_level_id', 'name'],
                'unq_classrooms_sy_ogl_name'
            );

            $table->index(['school_id', 'is_active']);
            $table->index(['school_year_id', 'is_active']);
            $table->index(['school_year_id', 'name']);
            $table->index(['offered_grade_level_id', 'is_active']);
            $table->index('main_teacher_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('classrooms');
    }
};
