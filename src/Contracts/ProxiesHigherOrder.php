<?php

declare(strict_types=1);

namespace Conquest\Core\Contracts;

interface ProxiesHigherOrder
{
    public function __get(string $property): HigherOrder;
}
