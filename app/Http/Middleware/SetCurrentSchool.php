<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Contexts\SchoolContext;
use App\Models\School;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class SetCurrentSchool
{
    public function __construct(
        private readonly SchoolContext $schoolContext,
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        $slug = $request->route('school');

        $school = Cache::remember(
            "school_slug:{$slug}",
            now()->addMinutes(60),
            fn () => School::query()->slug($slug)->firstOrFail()
        );

        abort_unless(
            $school->is_active,
            403,
            'Esta escola encontra-se inativa no momento. Entre em contato com a administração.'
        );

        /** @var User|null $user */
        $user = $request->user();

        abort_unless(
            $user && $user->hasAccessToSchool($school),
            403,
            'Acesso negado a esta escola.'
        );

        $this->schoolContext->set($school);

        URL::defaults(['school' => $school->slug]);

        return $next($request);
    }
}
