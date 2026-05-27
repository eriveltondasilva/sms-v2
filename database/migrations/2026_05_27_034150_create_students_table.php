<?php

declare(strict_types=1);

use App\Enums\Gender;
use App\Enums\StudentStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('school_id')->constrained()->restrictOnDelete();

            $table->uuid('public_id')->unique();
            $table->string('registration', 20);

            $table->string('full_name');
            $table->string('social_name')->nullable();

            $table->char('gender', 1)->default(Gender::DEFAULT);
            $table->date('birth_date')->nullable();
            $table->string('birth_place')->nullable();

            $table->string('rg', 9)->nullable();
            $table->string('cpf', 11);

            $table->string('phone', 11)->nullable();
            $table->string('email')->nullable();
            $table->text('address')->nullable();

            $table->string('status', 50)->default(StudentStatus::DEFAULT);
            $table->text('status_notes')->nullable();

            $table->jsonb('health_data')->nullable();
            // health_data (jsonb): consolida dados de saúde opcionais sem tabela separada.
            // Estrutura sugerida:
            // {
            //   "blood_type": "A+",
            //   "sus_card": "123456789012345",
            //   "health_conditions": "Asma leve",
            //   "allergies": "Dipirona",
            //   "medications": "Salbutamol",
            //   "emergency_contact": "Maria Silva",
            //   "emergency_phone": "82999990000"
            // }

            $table->softDeletes();
            $table->timestamps();

            // #

            $table->unique(['school_id', 'registration'], 'unq_registration_per_school');

            $table->index('cpf');
            $table->index(['school_id', 'full_name']);
            $table->index(['school_id', 'status']);
        });

        DB::statement("
            ALTER TABLE students
            ADD CONSTRAINT check_students_gender
            CHECK (gender IN ('M','F','N'))
        ");

    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};
