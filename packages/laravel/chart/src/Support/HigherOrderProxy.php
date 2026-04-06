<?php

declare(strict_types=1);

namespace Honed\Chart\Support;

use Closure;
use Honed\Chart\Chartable;

/**
 * Proxies method calls to a lazily resolved component. Fluent returns that match the
 * component instance are swapped for the parent chart — same as
 * {@see \Illuminate\Support\Traits\ForwardsCalls::forwardDecoratedCallTo()}.
 *
 * @template TParent of Chartable
 */
final class HigherOrderProxy
{
    /**
     * @param  TParent  $parent
     * @param  Closure():object  $resolveComponent
     * @param  callable(object, string, array<int, mixed>): mixed  $forwardDecoratedCallTo
     */
    public function __construct(
        protected Chartable $parent,
        protected Closure $resolveComponent,
        protected mixed $forwardDecoratedCallTo,
    ) {}

    /**
     * Nested property reads on the component (e.g. only public / magic properties).
     * Protected members stay on the component; callers should use methods for those.
     *
     * @return mixed
     */
    public function __get(string $name)
    {
        $target = ($this->resolveComponent)();

        return $target->{$name};
    }

    public function __isset(string $name): bool
    {
        $target = ($this->resolveComponent)();

        return isset($target->{$name});
    }

    /**
     * @param  array<int, mixed>  $parameters
     * @return mixed
     */
    public function __call(string $method, array $parameters): mixed
    {
        $target = ($this->resolveComponent)();

        return ($this->forwardDecoratedCallTo)($target, $method, $parameters);
    }
}
