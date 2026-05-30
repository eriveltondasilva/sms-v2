<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('offered_grade_levels', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            $table->foreignId('grade_level_id')->constrained()->cascadeOnDelete();

            $table->string('display_name');
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            // #

            $table->unique(['school_id', 'grade_level_id'], 'unq_ogl_per_school');

            $table->index(['school_id', 'is_active']);
            $table->index(['grade_level_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('offered_grade_levels');
    }
};
