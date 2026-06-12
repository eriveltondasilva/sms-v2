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
        Schema::create('grade_levels', function (Blueprint $table): void {
            $table->id();

            // #

            $table->string('name');
            $table->string('stage');
            $table->unsignedTinyInteger('order');

            $table->string('code', 10)->unique();

            $table->timestamps();

            // #
            $table->unique(['stage', 'order'], 'unique_gl_stage_order');
        });

        // # Checks
        DB::statement('
            ALTER TABLE grade_levels
            ADD CONSTRAINT check_gl_order
            CHECK ("order" > 0)
        ');
    }

    public function down(): void
    {
        Schema::dropIfExists('grade_levels');
    }
};
