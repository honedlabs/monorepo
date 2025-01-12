<?php

declare(strict_types=1);

namespace Honed\Core\Contracts;

/**
 * @template TProxy
 */
interface ProxiesHigherOrder
{
    /**
     * Dynamically forward calls to the underlying proxies.
     *
     * @param  string  $property
     * @return HigherOrder<T>
     */
    public function __get($property);
}
