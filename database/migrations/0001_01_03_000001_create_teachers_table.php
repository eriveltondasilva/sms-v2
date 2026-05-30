<?php

declare(strict_types=1);

use App\Enums\Gender;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('teachers', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('user_id')->nullable()->unique()->constrained()->nullOnDelete();

            $table->string('name');
            $table->char('gender', 1)->default(Gender::DEFAULT);
            $table->date('birth_date')->nullable();

            $table->string('cpf', 11)->unique();
            $table->string('rg', 9)->nullable();

            $table->string('phone', 11)->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();

            $table->boolean('is_active')->default(true);

            $table->softDeletes();
            $table->timestamps();

            // #

            $table->index(['is_active']);
        });

        DB::statement("
            ALTER TABLE teachers
            ADD CONSTRAINT check_teachers_gender
            CHECK (gender IN ('M','F','N'))
        ");
    }

    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
