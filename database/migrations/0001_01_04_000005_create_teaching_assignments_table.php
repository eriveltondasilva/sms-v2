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
        Schema::create('teaching_assignments', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('classroom_id')->constrained()->cascadeOnDelete();
            $table->foreignId('subject_id')->constrained()->restrictOnDelete();
            $table->foreignId('teacher_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('school_id')->constrained()->restrictOnDelete();

            // #

            $table->unsignedSmallInteger('workload_hours')->nullable();

            $table->date('start_date');
            $table->date('end_date')->nullable();

            $table->boolean('is_active')->default(true);

            $table->softDeletes();
            $table->timestamps();

            // #

            $table->index(['school_id', 'is_active']);
            $table->index(['classroom_id', 'subject_id', 'is_active']);
            $table->index('teacher_id');
            $table->index('subject_id');
        });

        // # Uniques
        DB::statement('
            CREATE UNIQUE INDEX unique_ta_classroom_subject
            ON teaching_assignments (classroom_id, subject_id)
            WHERE deleted_at IS NULL
        ');

        // # Checks
        DB::statement('
            ALTER TABLE teaching_assignments
            ADD CONSTRAINT check_ta_dates
            CHECK (end_date IS NULL OR end_date > start_date)
        ');
    }

    public function down(): void
    {
        Schema::dropIfExists('teaching_assignments');
    }
};
