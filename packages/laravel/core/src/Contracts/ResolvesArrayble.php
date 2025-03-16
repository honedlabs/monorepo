<?php

declare(strict_types=1);

namespace Honed\Core\Contracts;

interface ResolvesArrayable
{
    /**
     * Resolve the closures and get the arrayable result.
     *
     * @param  array<string,mixed>  $parameters
     * @param  array<class-string,mixed>  $typed
     * @return array<string,mixed>
     */
    public function resolveToArray($parameters = [], $typed = []);
}
