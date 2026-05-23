<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('schools', function (Blueprint $table): void {
            $table->id();

            $table->string('full_name');
            $table->string('short_name', 50);
            $table->string('slug', 100)->unique();
            $table->string('motto')->nullable();

            $table->string('inep_code', 8)->nullable()->unique();
            $table->string('cnpj', 14)->nullable()->unique();
            $table->string('phone', 15)->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();

            $table->json('social_medias')->nullable();

            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['full_name', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};
