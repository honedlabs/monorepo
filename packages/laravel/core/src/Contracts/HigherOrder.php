<?php

declare(strict_types=1);

namespace Honed\Core\Contracts;


interface HigherOrder
{
    /**
     * Dynamically call methods on an underlying object.
     *
     * @param  array<mixed>  $parameters
     */
    public function __call(string $method, array $parameters);
}
