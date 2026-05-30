<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('school_user', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('school_id')->constrained()->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();

            $table->boolean('is_active')->default(true);

            $table->timestamps();

            // #

            $table->unique(['user_id', 'school_id']);

            $table->index(['school_id', 'is_active']);
            $table->index(['user_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_user');
    }
};
