<?php

declare(strict_types=1);
use App\Enums\ProgressStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::create('academic_periods', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('school_year_id')->constrained()->cascadeOnDelete();

            $table->string('name', 50);
            $table->smallInteger('order')->unsigned();

            $table->date('start_date');
            $table->date('end_date');

            $table->string('status', 20)->default(ProgressStatus::DEFAULT);

            $table->timestamps();

            // #

            $table->unique(['school_year_id', 'order'], 'unq_period_order_per_sy');

            $table->index(['school_year_id', 'start_date', 'end_date']);
            $table->index(['school_year_id', 'status']);
        });

        DB::statement("
            ALTER TABLE academic_periods
            ADD CONSTRAINT chk_ap_status
            CHECK (status IN ('planned','in_progress','finished'))
        ");

        DB::statement('
            ALTER TABLE academic_periods
            ADD CONSTRAINT chk_ap_order
            CHECK ("order" BETWEEN 1 AND 6)
        ');

        DB::statement('
            ALTER TABLE academic_periods
            ADD CONSTRAINT chk_ap_dates
            CHECK (end_date > start_date)
        ');
    }

    public function down(): void
    {
        Schema::dropIfExists('academic_periods');
    }
};
