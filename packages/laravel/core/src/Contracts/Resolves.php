<?php

declare(strict_types=1);

namespace Honed\Core\Contracts;

interface Resolves
{
    /**
     * Evaluate the class properties using the provided parameters and typed parameters.
     *
     * @param  array<string,mixed>  $parameters
     * @param  array<string,mixed>  $typed
     * @return $this
     */
    public function resolve($parameters = [], $typed = []);
}
