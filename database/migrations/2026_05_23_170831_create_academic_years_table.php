<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('academic_years', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();

            $table->string('name');
            $table->date('starts_at');
            $table->date('ends_at');

            $table->boolean('is_active')->default(false);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['school_id', 'is_active']);
        });

        DB::statement('
            CREATE UNIQUE INDEX unique_active_year_per_school
            ON academic_years (school_id)
            WHERE is_active = true
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_years');
    }
};
