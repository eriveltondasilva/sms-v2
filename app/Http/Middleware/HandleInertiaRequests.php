<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Contexts\SchoolContext;
use App\Contexts\SchoolYearContext;
use App\Http\Resources\SchoolResource;
use App\Http\Resources\SchoolYearResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    protected $rootView = 'app';

    public function __construct(
        private readonly SchoolContext $schoolContext,
        private readonly SchoolYearContext $schoolYearContext,
    ) {}

    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    public function share(Request $request): array
    {
        return [
            ...parent::share($request),
            'name'        => config('app.name'),
            'auth'        => fn (): array => $this->authData($request),
            'sidebarOpen' => fn (): bool => $this->sidebarOpen($request),
        ];
    }

    // # Helpers

    private function authData(Request $request): array
    {
        $user = $request->user();

        if (! $user) {
            return [
                'user' => null,

                'availableSchools'  => [],
                'currentSchool'     => null,
                'currentSchoolYear' => null,
            ];
        }

        return [
            'user' => $this->userData($user),

            'availableSchools'  => $this->availableSchools($user),
            'currentSchool'     => $this->currentSchool(),
            'currentSchoolYear' => $this->currentSchoolYear(),
        ];
    }

    private function userData(User $user): array
    {
        return [
            ...$user->only('id', 'name', 'email', 'avatar'),
            'role' => $user->getRoleNames()->first(),
        ];
    }

    private function availableSchools(User $user): Collection
    {
        return Cache::remember(
            "user:{$user->id}:schools",
            now()->addMinutes(30),
            function () use ($user): Collection {
                $schools = $user->schools()
                    ->wherePivot('is_active', true)
                    ->orderBy('full_name')
                    ->get(['schools.id', 'schools.full_name', 'schools.slug']);

                return $schools->count() < 2 ? collect() : $schools;
            }
        );
    }

    private function currentSchool(): ?SchoolResource
    {
        return $this->schoolContext->has()
            ? SchoolResource::make($this->schoolContext->get())
            : null;
    }

    private function currentSchoolYear(): ?SchoolYearResource
    {
        return $this->schoolYearContext->has()
            ? SchoolYearResource::make($this->schoolYearContext->get())
            : null;
    }

    private function sidebarOpen(Request $request): bool
    {
        if (! $request->hasCookie('sidebar_state')) {
            return true;
        }

        return $request->cookie('sidebar_state') === 'true';
    }
}
