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

            $table->foreignId('lesson_record_id')->constrained()->cascadeOnDelete();
            $table->foreignId('enrollment_id')->constrained()->restrictOnDelete();
            $table->foreignId('school_id')->constrained()->restrictOnDelete();
            $table->foreignId('recorded_by')->nullable()->constrained('users')->nullOnDelete();

            $table->string('status', 20)->default(AttendanceStatus::DEFAULT);
            $table->text('justification')->nullable();

            $table->timestamps();

            // #

            $table->unique(
                ['lesson_record_id', 'enrollment_id'],
                'unique_lesson_record_and_enrollment'
            );

            $table->index('lesson_record_id');
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
