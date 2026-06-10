<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Contexts\SchoolContext;
use App\Contexts\SchoolYearContext;
use App\Enums\ProgressStatus;
use App\Models\SchoolYear;
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
        $schoolYear = SchoolYear::query()
            ->where('school_id', $this->schoolContext->id())
            ->where('status', ProgressStatus::InProgress)
            ->first();

        if ($schoolYear) {
            $this->schoolYearContext->set($schoolYear);
        }

        return $next($request);
    }
}
