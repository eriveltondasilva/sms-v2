<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('grade_levels', function (Blueprint $table): void {
            $table->id();

            $table->string('name');
            $table->string('stage', 10);
            $table->string('code', 10)->unique();
            $table->smallInteger('order')->unsigned();

            $table->timestamps();

            // #

            $table->index('order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('grade_levels');
    }
};
