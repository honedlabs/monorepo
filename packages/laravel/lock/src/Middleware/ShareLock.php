<?php

declare(strict_types=1);

namespace Honed\Lock\Middleware;

use Closure;
use Honed\Lock\Facades\Lock;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShareLock
{
    /**
     * Handle the incoming request.
     *
     * @return Closure
     */
    public function handle(Request $request, Closure $next)
    {
        Inertia::share(Lock::getProperty(), static fn () => Lock::all());

        return $next($request);
    }
}
