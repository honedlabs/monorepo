<?php

declare(strict_types=1);

namespace Honed\Flash\Middleware;

use Closure;
use Honed\Flash\Facades\Flash;
use Illuminate\Http\Request;
use Illuminate\Session\Store;
use Inertia\Inertia;

class ShareFlash
{
    public function __construct(
        protected Store $session,
    ) {}

    /**
     * Handle the incoming request.
     *
     * @return Closure
     */
    public function handle(Request $request, Closure $next)
    {
        $property = Flash::getProperty();

        Inertia::share($property, fn () => $this->session->get($property, null));

        return $next($request);
    }
}
