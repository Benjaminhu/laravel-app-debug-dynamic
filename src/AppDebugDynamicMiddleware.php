<?php

namespace Benjaminhu\LaravelAppDebugDynamic;

use Closure;
use Exception;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Config;

class AppDebugDynamicMiddleware
{
    private string $cookieName;

    private string $cookieSecret;

    private array $authorizedIps;

    /**
     * AppDebugDynamicMiddleware constructor.
     * @throws Exception
     */
    public function __construct()
    {
        $this->cookieName = trim(config('app-debug-dynamic.cookie_name'));
        $this->cookieSecret = trim(config('app-debug-dynamic.cookie_secret'));
        $this->authorizedIps = (array)config('app-debug-dynamic.allowed_ips');
    }

    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $this->handleAppDebugDynamic($request);

        return $next($request);
    }

    private function handleAppDebugDynamic(Request $request): void
    {
        $result = $this->isCookieAllowed($request);
        $result &= $this->isIpAllowed($request);
        if ($result) {
            $this->switchOnAppDebug();
        }
    }

    private function isCookieAllowed(Request $request): bool
    {
        if (!$request->hasCookie($this->cookieName)) {
            return false;
        }

        $requestCookieSecret = trim($request->cookie($this->cookieName));
        if (!$requestCookieSecret) {
            return false;
        }

        if ($requestCookieSecret === $this->cookieSecret) {
            return true;
        }

        return false;
    }

    /**
     * Empty IP -> allow all || allowed ips only
     *
     * @param Request $request
     * @return bool
     */
    protected function isIpAllowed(Request $request): bool
    {
        return (
            ! count($this->authorizedIps)
            || in_array($request->ip(), $this->authorizedIps, true)
        );
    }

    private function switchOnAppDebug(): void
    {
        Config::set('app.debug', true);
    }
}
