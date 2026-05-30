<?php

declare(strict_types=1);

use App\Enums\AttendanceStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('teaching_assignment_id')->constrained()->restrictOnDelete();
            $table->foreignId('enrollment_id')->constrained()->restrictOnDelete();
            $table->foreignId('school_id')->constrained()->restrictOnDelete();
            $table->foreignId('recorded_by')->nullable()->constrained('users')->nullOnDelete();

            $table->date('lesson_date');
            $table->string('status', 1)->default(AttendanceStatus::DEFAULT);
            $table->text('justification')->nullable();

            $table->timestamps();

            // #

            $table->unique(
                ['enrollment_id', 'teaching_assignment_id', 'lesson_date'],
                'unq_attendance_enrollment_ta_date'
            );

            $table->index(['teaching_assignment_id', 'lesson_date']);
            $table->index(['school_id', 'enrollment_id', 'status']);
            $table->index(['enrollment_id', 'status']);
            $table->index('recorded_by');
        });

        DB::statement("
            ALTER TABLE attendances
            ADD CONSTRAINT chk_attendance_status
            CHECK (status IN ('P','A','J'))
        ");
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
