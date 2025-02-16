<?php

declare(strict_types=1);

namespace Honed\Crumb\Middleware;

use Closure;
use Honed\Crumb\Facades\Crumbs;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
 
class ShareCrumb
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ?string $crumb): Response
    {
        $crumb ??= config('crumb.default');

        if ($crumb) {
            Crumbs::get($crumb)->share();
        }

        return $next($request);
    }
}