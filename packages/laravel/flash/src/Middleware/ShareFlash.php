<?php

declare(strict_types=1);

namespace Honed\Flash\Middleware;

use Closure;
use Illuminate\Http\Request;

class ShareFlash
{
    /**
     * Handle the incoming request.
     *
     * @return \Closure
     */
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }
}
