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
        Schema::create('class_schedules', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('teaching_assignment_id')->constrained()->restrictOnDelete();
            $table->foreignId('school_id')->constrained()->restrictOnDelete();

            $table->unsignedSmallInteger('weekday');
            $table->time('start_time');

            $table->date('valid_from');
            $table->date('valid_until')->nullable();

            $table->timestamps();

            // #

            $table->unique(
                ['teaching_assignment_id', 'weekday', 'start_time', 'valid_from'],
                'unq_cs_ta_weekday_time_from'
            );

            $table->index(['school_id', 'weekday']);
            $table->index(['teaching_assignment_id', 'valid_from', 'valid_until']);
        });

        DB::statement('
            ALTER TABLE class_schedules
            ADD CONSTRAINT chk_cs_weekday
            CHECK (weekday BETWEEN 1 AND 6)
        ');

        DB::statement('
            ALTER TABLE class_schedules
            ADD CONSTRAINT chk_cs_valid_dates
            CHECK (valid_until IS NULL OR valid_until > valid_from)
        ');
    }

    public function down(): void
    {
        Schema::dropIfExists('class_schedules');
    }
};
