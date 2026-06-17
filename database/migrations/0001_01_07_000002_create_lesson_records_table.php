<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('lesson_records', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('lesson_id')->unique()->constrained()->restrictOnDelete();
            $table->foreignId('lesson_plan_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('school_id')->constrained()->restrictOnDelete();

            $table->foreignId('recorded_by')->nullable()->constrained('users')->nullOnDelete();

            // #

            $table->string('topic');
            $table->timestamp('diary_filled_at')->nullable();

            $table->timestamps();

            // #

            $table->index('lesson_plan_id');
            $table->index('recorded_by');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lesson_records');
    }
};
