<?php

declare(strict_types=1);

namespace Honed\Flash\Middleware;

use Closure;
use Honed\Flash\Support\Parameters;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Inertia\Inertia;

class ShareFlash
{
    public function __construct(protected Store $session)
    {
        //
    }

    /**
     * Handle the incoming request.
     *
     * @return Closure
     */
    public function handle(Request $request, Closure $next)
    {
        Inertia::share(
            Parameters::PROP,
            fn () => $this->session->get(Parameters::PROP, null)
        );

        return $next($request);
    }
}
