<?php

declare(strict_types=1);

namespace Conquest\Core\Contracts;

interface HigherOrder
{
    public function __call(string $method, array $parameters);
}
