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
        Schema::create('subjects', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('school_id')->constrained()->cascadeOnDelete();

            // #

            $table->string('name');
            $table->string('code', 10);
            $table->unsignedSmallInteger('week_hours');

            $table->boolean('is_active')->default(true);

            $table->softDeletes();
            $table->timestamps();

            // #

            $table->index(['school_id', 'name']);
            $table->index(['school_id', 'is_active']);
        });

        // # Uniques
        DB::statement('
            CREATE UNIQUE INDEX unique_code_per_school
            ON subjects (school_id, code)
            WHERE deleted_at IS NULL
        ');

        // # Checks
        DB::statement('
            ALTER TABLE subjects
            ADD CONSTRAINT check_subjects_week_hours
            CHECK (week_hours > 0)
        ');
    }

    public function down(): void
    {
        Schema::dropIfExists('subjects');
    }
};
