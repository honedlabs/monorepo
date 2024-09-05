<?php

namespace Conquest\Core\Contracts;

interface ProxiesHigherOrder
{
    public function __get(string $property): HigherOrder;
}