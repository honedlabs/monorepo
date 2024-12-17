<?php

namespace Honed\Crumb\Middleware;

use Honed\Crumb\Attributes\Crumb;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Contracts\Routing\Registrar;


class SharesCrumbs
{
    public function handle(Request $request, \Closure $next, string $crumb = null)
    {
        $response = $next($request);
        
        dd(Route::getCurrentRoute()->getAction());
        return $response;
    }
}

