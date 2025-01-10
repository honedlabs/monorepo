<?php

namespace Honed\Core\Contracts;

interface ResolvesClosures
{
    /**
     * Resolve the instance closures.
     * 
     * @param mixed $parameters
     * @param array<string,mixed>|null $typed
     * @return mixed
     */
    public function resolve($parameters = null, $typed = null);
}
