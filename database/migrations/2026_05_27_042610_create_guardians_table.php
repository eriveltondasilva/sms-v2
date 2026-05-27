<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('guardians', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();

            $table->string('name');
            $table->string('phone', 11);
            $table->string('email')->nullable();
            $table->string('cpf', 11)->nullable();
            $table->text('address')->nullable();

            $table->timestamps();

            // #

            $table->unique(['school_id', 'cpf'], 'school_guardian_unique');

            $table->index('cpf');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('guardians');
    }
};
