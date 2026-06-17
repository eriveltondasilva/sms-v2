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
        Schema::create('academic_periods', function (Blueprint $table): void {
            $table->id();

            $table->foreignId('school_year_id')->constrained()->cascadeOnDelete();

            // #

            $table->string('name', 50);
            $table->unsignedTinyInteger('order');
            $table->decimal('weight', 5, 2)->nullable();

            $table->date('start_date');
            $table->date('end_date');

            $table->string('status', 20);

            $table->timestamps();

            // #

            $table->unique(['school_year_id', 'order'], 'unique_period_order_per_sy');

            $table->index(['school_year_id', 'start_date', 'end_date']);
            $table->index(['school_year_id', 'status']);
        });

        // # Checks
        DB::statement("
            ALTER TABLE academic_periods
            ADD CONSTRAINT check_academic_period_status
            CHECK (status IN ('planned','in_progress','finished'))
        ");

        DB::statement('
            ALTER TABLE academic_periods
            ADD CONSTRAINT check_academic_period_order
            CHECK ("order" > 0)
        ');

        DB::statement('
            ALTER TABLE academic_periods
            ADD CONSTRAINT check_ap_weight_positive
            CHECK (weight IS NULL OR weight > 0)
        ');

        DB::statement('
            ALTER TABLE academic_periods
            ADD CONSTRAINT check_academic_period_dates
            CHECK (end_date > start_date)
        ');
    }

    public function down(): void
    {
        Schema::dropIfExists('academic_periods');
    }
};
