<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->string('avatar')->nullable()->after('password');
            $table->boolean('is_active')->default(true)->after('avatar');
            $table->timestamp('last_login_at')->nullable()->after('is_active');
            $table->softDeletes()->after('last_login_at');

            // #

            $table->index('name');
            $table->index('is_active');
        });

        Schema::table('roles', function (Blueprint $table): void {
            $table->string('label')->nullable()->after('name');
            $table->string('description')->nullable()->after('label');
            $table->string('color')->nullable()->after('description');
        });
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table): void {
            $table->dropIndex(['name']);
            $table->dropIndex(['is_active']);
            $table->dropColumn([
                'avatar',
                'is_active',
                'last_login_at',
            ]);
            $table->dropSoftDeletes();
        });

        Schema::table('roles', function (Blueprint $table): void {
            $table->dropColumn(['label', 'description', 'color']);
        });
    }
};
