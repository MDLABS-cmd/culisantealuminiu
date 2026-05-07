<?php

namespace App\Http\Middleware;

use App\Services\SystemService;
use App\Settings\TopbarSettings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Inertia\Middleware;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
        $cachePeriod = now()->addHour();
        $cachedSystems = Cache::remember(
            'active_systems_v2',
            $cachePeriod,
            fn() => app(SystemService::class)->getActiveSystemsArray(),
        );
        $cachedTopbar = Cache::remember(
            'topbar_settings_v1',
            $cachePeriod,
            function (): array {
                $topbarSettings = app(TopbarSettings::class);

                return [
                    'phoneNumber' => $topbarSettings->phone_number,
                    'email' => $topbarSettings->email,
                ];
            },
        );

        $normalizedSystems = collect($cachedSystems)->values()->all();

        return [
            ...parent::share($request),
            'name' => config('app.name'),
            'auth' => [
                'user' => $request->user(),
            ],
            'sidebarOpen' => ! $request->hasCookie('sidebar_state') || $request->cookie('sidebar_state') === 'true',
            'activeSystems' => $normalizedSystems,
            'topbar' => $cachedTopbar,
            'flash' => [
                'submissionId' => $request->session()->get('submissionId'),
                'submissionType' => $request->session()->get('submissionType'),
            ],
        ];
    }
}
