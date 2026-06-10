<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AfterLoginController extends Controller
{
    public function __invoke(): RedirectResponse
    {
        $user = Auth::user();

        if ($user->isSuperAdmin()) {
            return to_route('admin.dashboard');
        }

        $school = $user
            ->schools()
            ->wherePivot('is_active', true)
            ->orderBy('full_name')
            ->firstOrFail();

        return to_route('schools.dashboard', $school->slug);
    }
}
