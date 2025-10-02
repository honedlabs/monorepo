<?php

namespace Honed\Lang\Middleware;

use Closure;
use Inertia\Inertia;
use Honed\Lang\Facades\Lang;

class ShareTranslations
{
    public const KEY = '_lang';
    
    public function handle($request, Closure $next)
    {
        $translations = Lang::getTranslations();

        if (! empty($translations)) {
            Inertia::share([
                static::KEY => $translations,
            ]);
        }

        return $next($request);
    }
}