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
        Schema::create('assessment_templates', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('school_id')->constrained()->cascadeOnDelete();

            // #

            $table->string('name', 100);
            $table->string('description')->nullable();

            $table->decimal('default_max_score', 5, 2)->default(10.00);
            $table->decimal('default_weight', 5, 2)->default(1.00);
            $table->boolean('is_active')->default(true);

            $table->timestamps();

            // #

            $table->index(['school_id', 'is_active']);
        });

        DB::statement('
            ALTER TABLE assessment_templates
            ADD CONSTRAINT check_at_defaults_positive
            CHECK (default_max_score > 0 AND default_weight > 0)
        ');
    }

    public function down(): void
    {
        Schema::dropIfExists('assessment_templates');
    }
};
