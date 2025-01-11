<?php

declare(strict_types=1);

namespace Honed\Core\Contracts;

/**
 * @template-covariant T
 */
interface HigherOrder
{
    /**
     * Dynamically call methods on the underlying object.
     *
     * @param  array<mixed>  $parameters
     * @return T
     */
    public function __call(string $method, array $parameters);
}
