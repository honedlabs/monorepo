<?php

declare(strict_types=1);

namespace Honed\Core\Contracts;

/**
 * @template-covariant T
 */
interface HigherOrder
{
    /**
     * @param  array<mixed>  $parameters
     * @return T
     */
    public function __call(string $method, array $parameters);
}
