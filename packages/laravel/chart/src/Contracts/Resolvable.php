<?php

declare(strict_types=1);

namespace Honed\Chart\Contracts;

interface Resolvable
{
    /**
     * Resolve the component with the given data.
     */
    public function resolve(mixed $data): void;
}