<?php

namespace Honed\Core\Contracts;

interface ResolvesClosures
{
    /**
     * Resolve the instance closures.
     * 
     * @param array<string,mixed> $named
     * @param array<string,mixed> $typed
     * @return mixed
     */
    public function resolve($named = [], $typed = []);
}
