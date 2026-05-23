<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserBelongsToSchool
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        abort_unless($user, Response::HTTP_UNAUTHORIZED);

        if ($user->isSuperAdmin()) {
            return $next($request);
        }

        abort_if($user->school_id === null, Response::HTTP_FORBIDDEN, 'Usuário não vinculado a nenhuma escola.');

        abort_unless($user->school?->is_active, Response::HTTP_FORBIDDEN, 'Escola inativa.');

        return $next($request);
    }
}
