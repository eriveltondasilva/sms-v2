<?php

declare(strict_types=1);

use App\Enums\SchoolEventType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('school_events', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('school_year_id')->constrained()->cascadeOnDelete();
            $table->foreignId('classroom_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('subject_id')->nullable()->constrained()->nullOnDelete();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();

            $table->string('title');
            $table->text('description')->nullable();
            $table->string('location')->nullable();

            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();

            $table->string('type', 20)->default(SchoolEventType::DEFAULT);
            $table->boolean('blocks_lessons')->default(true);
            $table->boolean('affects_attendance')->default(true);

            $table->timestamps();

            // #

            $table->index(['school_year_id', 'type', 'start_date']);
            $table->index(['school_year_id', 'start_date']);
            $table->index(['classroom_id', 'start_date']);
            $table->index('subject_id');
            $table->index('created_by');
        });

        DB::statement('
            ALTER TABLE school_events
            ADD CONSTRAINT chk_event_dates
            CHECK (end_date IS NULL OR end_date >= start_date)
        ');
    }

    public function down(): void
    {
        Schema::dropIfExists('school_events');
    }
};
