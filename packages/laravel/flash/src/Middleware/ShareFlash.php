<?php

declare(strict_types=1);

namespace Honed\Flash\Middleware;

use Closure;
use Honed\Flash\Support\Parameters;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShareFlash
{
    /**
     * Handle the incoming request.
     *
     * @return \Closure
     */
    public function handle(Request $request, Closure $next)
    {
        Inertia::share(
            Parameters::PROP,
            $request->session()->get(Parameters::PROP)
        );

        return $next($request);
    }
}
