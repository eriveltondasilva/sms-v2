<?php

declare(strict_types=1);

use App\Enums\EnrollmentStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('enrollments', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('student_id')->constrained()->restrictOnDelete();
            $table->foreignId('classroom_id')->constrained()->restrictOnDelete();
            $table->foreignId('school_year_id')->constrained()->restrictOnDelete();
            $table->foreignId('school_id')->constrained()->restrictOnDelete();
            $table->foreignId('previous_enrollment_id')->nullable()->constrained('enrollments')->nullOnDelete();

            $table->string('status', 20)->default(EnrollmentStatus::DEFAULT);
            $table->string('final_result', 20)->nullable();
            $table->timestamp('final_result_calculated_at')->nullable();
            $table->date('enrolled_at')->nullable();
            $table->date('finalized_at')->nullable();
            $table->text('transfer_reason')->nullable();
            $table->text('dropout_reason')->nullable();

            $table->softDeletes();
            $table->timestamps();

            // #

            $table->index(['school_id', 'school_year_id', 'status']);
            $table->index(['school_year_id', 'classroom_id', 'status']);
            $table->index(['student_id', 'school_year_id']);
            $table->index(['school_year_id', 'status']);
            $table->index('previous_enrollment_id');
            $table->index('classroom_id');
        });

        DB::statement("
            ALTER TABLE enrollments
            ADD CONSTRAINT chk_enrollment_final_result
            CHECK (final_result IN ('approved', 'failed', 'transferred', 'dropout') OR final_result IS NULL)
        ");

        DB::statement("
            CREATE UNIQUE
            INDEX unq_active_enrollment
            ON enrollments (student_id, school_year_id)
            WHERE status = 'active'
        ");
    }

    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
