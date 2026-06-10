<?php

declare(strict_types=1);

use App\Http\Controllers\AfterLoginController;
use Illuminate\Support\Facades\Route;

use Laravel\Fortify\Features;

Route::inertia('/', 'welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');

Route::get('/redirect', AfterLoginController::class)->middleware('auth')->name('after-login');

require __DIR__ . '/settings.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/school.php';
