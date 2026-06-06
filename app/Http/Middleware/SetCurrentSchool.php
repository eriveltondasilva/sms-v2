<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Context\SchoolContext;
use App\Models\School;
use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Symfony\Component\HttpFoundation\Response;

class SetCurrentSchool
{
    public function __construct(
        private readonly SchoolContext $schoolContext,
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        $school = School::query()
            ->slug($request->route('school'))
            ->active()
            ->firstOrFail();

        /** @var User $user */
        $user = $request->user();

        abort_unless(
            $user->hasAccessToSchool($school),
            403,
            'Acesso negado a esta escola.'
        );

        $this->schoolContext->set($school);

        URL::defaults(['school' => $school->slug]);

        return $next($request);
    }
}
