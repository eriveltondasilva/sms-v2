<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('schools', function (Blueprint $table): void {
            $table->id();

            $table->string('full_name');
            $table->string('short_name', 50);
            $table->string('slug', 100)->unique();

            $table->string('motto')->nullable();

            $table->string('cnpj', 14)->unique();
            $table->string('inep_code', 8)->nullable()->unique();

            $table->string('phone', 11)->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();

            $table->boolean('is_active')->default(true);

            $table->jsonb('social_medias')->nullable();

            $table->softDeletes();
            $table->timestamps();

            // #

            $table->index(['full_name', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schools');
    }
};
