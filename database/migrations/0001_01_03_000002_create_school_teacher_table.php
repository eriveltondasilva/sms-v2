<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('school_teacher', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('teacher_id')->constrained()->cascadeOnDelete();
            $table->foreignId('school_id')->constrained()->cascadeOnDelete();

            $table->string('qualification')->nullable();
            $table->date('hire_date')->nullable();
            $table->date('termination_date')->nullable();
            $table->string('termination_reason', 50)->nullable();

            $table->boolean('is_active')->default(true);

            $table->jsonb('bank_data')->nullable();
            // bank_data (jsonb): dados bancários do professor para pagamento de salário.
            // Estrutura sugerida:
            // {
            //   "bank_code": "341",
            //   "bank_name": "Itaú",
            //   "agency": "1234",
            //   "account": "12345-6",
            //   "account_type": "corrente",
            //   "pix_key": "12345678901",
            //   "pix_key_type": "cpf",
            //   "holder_name": "João Silva",
            //   "holder_cpf": "12345678901"
            // }

            $table->timestamps();

            // #

            $table->unique(['teacher_id', 'school_id']);

            $table->index(['school_id', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('school_teacher');
    }
};
