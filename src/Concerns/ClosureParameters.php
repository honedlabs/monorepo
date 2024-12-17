<?php

namespace Honed\Crumb\Concerns;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;

trait ClosureParameters
{
    /**
     * Get the binding parameters to pass to a closure.
     * 
     * @return non-empty-array{array<string,mixed>,array<string,mixed>}
     */
    private function getClosureParameters(): array
    {
        $parameters = Route::current()?->parameters() ?? [];
        $request = Request::capture();
        $route = Request::current();
        $values = \array_values($parameters);

        $mapped = \array_combine(
            \array_map(static fn ($value) => \is_object($value) ? \get_class($value) : \gettype($value), $values),
            $values
        );

        return [
            [
                'request' => $request,
                'route' => $route,
                ...$parameters,
            ],
            [
                Request::class => $request,
                Route::class => $route,
                ...$mapped,
            ],
        ];
    }
}