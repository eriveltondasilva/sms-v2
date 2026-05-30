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
        Schema::create('student_guardian', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('student_id')->constrained()->cascadeOnDelete();
            $table->foreignId('guardian_id')->constrained()->cascadeOnDelete();

            $table->string('relationship', 50);
            $table->boolean('is_primary')->default(false);

            $table->timestamps();

            // #

            $table->unique(['student_id', 'guardian_id']);

            $table->index('guardian_id');
        });

        DB::statement('
    CREATE UNIQUE INDEX unq_one_primary_guardian_per_student
    ON student_guardian (student_id)
    WHERE is_primary = true
');
    }

    public function down(): void
    {
        Schema::dropIfExists('student_guardian');
    }
};
