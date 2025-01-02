<?php

declare(strict_types=1);

namespace Honed\Core\Contracts;

/**
 * @template T
 */
interface ProxiesHigherOrder
{
    /**
     * @return HigherOrder<T>
     */
    public function __get(string $property): HigherOrder;
}
