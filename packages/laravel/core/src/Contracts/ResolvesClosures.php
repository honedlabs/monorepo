<?php

declare(strict_types=1);

namespace Honed\Core\Contracts;

interface ResolvesClosures
{
    /**
     * Resolve any properties which are closures.
     *
     * @param  array<string,mixed>  $parameters
     * @param  array<string,mixed>  $typed
     * @return $this
     */
    public function resolve($parameters = [], $typed = []): static;
}
