<?php

declare(strict_types=1);

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SchoolController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth', 'role:super-admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function (): void {

        Route::get('dashboard', DashboardController::class);

        Route::resource('schools', SchoolController::class);
        Route::resource('users', UserController::class);
    });
