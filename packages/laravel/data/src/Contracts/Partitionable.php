<?php

declare(strict_types=1);

namespace Honed\Data\Contracts;

use BackedEnum;

interface Partitionable
{
    /**
     * Get a partition of the data.
     * 
     * @return $this
     */
    public function partition(string|BackedEnum $key, bool $exclude = false): static;

    /**
     * Define the partitions for the data.
     * 
     * @return array<string, list<string>>
     */
    public function partitions(): array;
}
