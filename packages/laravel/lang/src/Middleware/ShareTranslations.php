<?php

declare(strict_types=1);

namespace Honed\Lang\Middleware;

use Closure;
use Honed\Lang\Facades\Lang;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ShareTranslations
{
    /**
     * Handle the incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next, string ...$files)
    {
        if (! empty($files)) {
            Lang::use(...$files);
        }

        Inertia::share('_lang', fn () => Lang::getTranslations());

        return $next($request);
    }
}
