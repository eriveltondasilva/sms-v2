<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use App\Context\SchoolContext;
use App\Context\SchoolYearContext;
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
            'auth'        => $this->authData($request),
            'sidebarOpen' => $this->sidebarOpen($request),
        ];
    }

    // #

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
            'user'              => $this->userData($user),
            'availableSchools'  => $this->availableSchools($user),
            'currentSchool'     => $this->currentSchool(),
            'currentSchoolYear' => $this->currentSchoolYear(),
        ];
    }

    private function userData(User $user): array
    {
        return [
            ...$user->only('id', 'name', 'email', 'avatar'),
            'role' => $user->roles->first()?->name,
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
                    ->orderBy('name')
                    ->limit(2)
                    ->get(['schools.id', 'schools.full_name', 'schools.slug']);

                if ($schools->count() < 2) {
                    return collect();
                }

                return $user->schools()
                    ->wherePivot('is_active', true)
                    ->orderBy('name')
                    ->get(['schools.id', 'schools.full_name', 'schools.slug']);
            }
        );
    }

    private function currentSchool(): ?SchoolResource
    {
        return $this->schoolContext->hasSchool()
            ? SchoolResource::make($this->schoolContext->get())
            : null;
    }

    private function currentSchoolYear(): ?SchoolYearResource
    {
        return $this->schoolYearContext->hasSchoolYear()
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
