<?php

declare(strict_types=1);

namespace Honed\Nav\Middleware;

use Closure;
use Honed\Nav\Facades\Nav;
use Honed\Nav\Support\Parameters;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShareNavigation
{
    /**
     * Handle the incoming request.
     *
     * @return \Closure
     */
    public function handle(Request $request, Closure $next, string ...$groups)
    {
        Inertia::share(
            Parameters::PROP,
            static fn () => Nav::share(...$groups),
        );

        return $next($request);
    }
}
