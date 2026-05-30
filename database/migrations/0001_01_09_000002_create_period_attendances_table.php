<?php

declare(strict_types=1);

use App\Enums\PeriodAttendanceStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('period_attendances', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('enrollment_id')->constrained()->restrictOnDelete();
            $table->foreignId('teaching_assignment_id')->constrained()->restrictOnDelete();
            $table->foreignId('academic_period_id')->constrained()->restrictOnDelete();
            $table->foreignId('school_id')->constrained()->restrictOnDelete();

            $table->unsignedSmallInteger('total_classes')->default(0);
            $table->unsignedSmallInteger('attended_classes')->default(0);
            $table->unsignedSmallInteger('justified_absences')->default(0);
            $table->unsignedSmallInteger('unjustified_absences')->default(0);

            $table->decimal('attendance_percentage', 5, 2)->default(0.00);

            $table->string('status', 20)->default(PeriodAttendanceStatus::Sufficient->value);
            $table->boolean('is_locked')->default(false);
            $table->timestamp('locked_at')->nullable();
            $table->timestamps();

            // #

            $table->unique(
                ['enrollment_id', 'teaching_assignment_id', 'academic_period_id'],
                'unq_period_attendance'
            );

            $table->index(['academic_period_id', 'status']);
            $table->index(['teaching_assignment_id', 'status']);
            $table->index(['school_id', 'academic_period_id']);
        });

        DB::statement("
            ALTER TABLE period_attendances
            ADD CONSTRAINT chk_pa_status
            CHECK (status IN ('sufficient','insufficient'))
        ");

        DB::statement('
            ALTER TABLE period_attendances
            ADD CONSTRAINT chk_pa_attendance_pct
            CHECK (attendance_percentage BETWEEN 0 AND 100)
        ');
    }

    public function down(): void
    {
        Schema::dropIfExists('period_attendances');
    }
};
