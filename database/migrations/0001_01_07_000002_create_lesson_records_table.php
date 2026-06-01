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
            // 1:1 com lessons — cada aula tem no máximo um diário.
            // O professor pode preencher em momento independente da chamada.

            $table->foreignId('lesson_plan_id')->nullable()->constrained()->nullOnDelete();
            // Opcional: vincula o diário ao plano de aula seguido.

            $table->foreignId('school_id')->constrained()->restrictOnDelete();
            $table->foreignId('recorded_by')->nullable()->constrained('users')->nullOnDelete();

            $table->text('topic')->nullable();
            // Assunto/conteúdo trabalhado na aula — campo livre para o professor.

            $table->timestamp('diary_filled_at')->nullable();
            // Momento em que o diário foi efetivamente preenchido (pode ser posterior à aula).

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
