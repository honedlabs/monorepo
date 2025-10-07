<?php

declare(strict_types=1);

namespace Honed\Lang\Middleware;

use Closure;
use Honed\Lang\Facades\Lang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;

class Localize
{
    /**
     * Handle the incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->route('locale')) {
            $locale = (string) $request->route('locale');

            Lang::locale($locale);
        } elseif (Lang::usesSession() && Session::has('_lang')) {
            /** @var string */
            $locale = Session::get('_lang');

            Lang::locale($locale);
        }

        URL::defaults(['locale' => Lang::getLocale()]);

        return $next($request);
    }
}
