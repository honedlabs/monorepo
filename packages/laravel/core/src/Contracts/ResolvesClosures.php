<?php

namespace Honed\Core\Contracts;

interface ResolvesClosures
{
    /**
     * Resolve the instance closures.
     *
     * @param  array<string,mixed>|\Illuminate\Database\Eloquent\Model  $parameters
     * @param  array<string,mixed>  $typed
     * @return $this
     */
    public function resolve($parameters = [], $typed = []): static;
}
