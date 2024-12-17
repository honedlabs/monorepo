<?php

namespace Honed\Crumb\Concerns;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;

trait ClosureParameters
{
    /**
     * @var non-empty-array<'named'|'typed',array<string,mixed>>|null
     */
    protected $parameters;
    
    /**
     * Get the binding parameters to pass to a closure.
     * 
     * @return non-empty-array<'named'|'typed',array<string,mixed>>
     */
    private function getClosureParameters(): array
    {
        return $this->parameters ??= $this->makeClosureParameters();
    }

    /**
     * Get the binding parameters from the current route actions.
     * 
     * @return non-empty-array<'named'|'typed',array<string,mixed>>
     */
    private function makeClosureParameters(): array
    {
        $parameters = Route::current()?->parameters() ?? [];
        $request = Request::capture();
        $route = Route::current();
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