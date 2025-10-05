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
     */
    public function handle(Request $request, Closure $next): Closure
    {
        $translations = Lang::getTranslations();

        if (! empty($translations)) {
            Inertia::share([
                '_lang' => $translations,
            ]);
        }

        return $next($request);
    }
}
