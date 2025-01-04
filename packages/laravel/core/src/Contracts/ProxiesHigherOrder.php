<?php

declare(strict_types=1);

namespace Honed\Core\Contracts;

/**
 * @template T
 */
interface ProxiesHigherOrder
{
    /**
     * Dynamically forward calls to the underlying proxies.
     *
     * @return HigherOrder<T>
     */
    public function __get(string $property): HigherOrder;
}
