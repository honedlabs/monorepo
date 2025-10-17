<?php

declare(strict_types=1);

namespace Honed\Lang\Middleware;

use Closure;
use Honed\Lang\Facades\Lang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class Localize
{
    /**
     * Handle the incoming request.
     *
     * @param  Closure(Request): (\Symfony\Component\HttpFoundation\Response)  $next
     * @return \Symfony\Component\HttpFoundation\Response
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

        Lang::registerParameter();

        return $next($request);
    }
}
