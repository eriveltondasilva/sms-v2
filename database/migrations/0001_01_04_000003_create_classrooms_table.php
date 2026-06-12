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
        Schema::create('classrooms', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('school_year_id')->constrained()->restrictOnDelete();
            $table->foreignId('grade_level_id')->constrained()->restrictOnDelete();
            $table->foreignId('school_id')->constrained()->restrictOnDelete();

            $table->foreignId('main_teacher_id')->nullable()->constrained('teachers')->nullOnDelete();

            // #

            $table->string('name');
            $table->string('room', 50)->nullable();
            $table->string('shift', 20);

            $table->unsignedSmallInteger('student_max');

            $table->boolean('is_active')->default(true);

            $table->softDeletes();
            $table->timestamps();

            // #

            $table->index(['school_id', 'is_active']);
            $table->index(['school_year_id', 'is_active']);
            $table->index(['school_year_id', 'name']);
            $table->index(['grade_level_id', 'is_active']);
            $table->index('main_teacher_id');
        });

        // # Uniques
        DB::statement('
            CREATE UNIQUE INDEX unique_classrooms_sy_ogl_name
            ON classrooms (school_year_id, grade_level_id, name)
            WHERE deleted_at IS NULL
        ');

        // # Checks
        DB::statement("
            ALTER TABLE classrooms
            ADD CONSTRAINT check_classroom_shift
            CHECK (shift IN ('morning','afternoon','evening'))
        ");

        DB::statement('
            ALTER TABLE classrooms
            ADD CONSTRAINT check_classroom_student_max
            CHECK (student_max > 0)
        ');
    }

    public function down(): void
    {
        Schema::dropIfExists('classrooms');
    }
};
