<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Contexts\SchoolContext;
use App\Contexts\SchoolYearContext;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetCurrentSchoolYear
{
    public function __construct(
        private readonly SchoolContext $schoolContext,
        private readonly SchoolYearContext $schoolYearContext,
    ) {}

    public function handle(Request $request, Closure $next): Response
    {
        $schoolYear = $this->schoolContext->get()->currentYear;

        if ($schoolYear) {
            $this->schoolYearContext->set($schoolYear);
        }

        return $next($request);
    }
}
