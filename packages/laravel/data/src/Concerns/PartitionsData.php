<?php

declare(strict_types=1);

namespace Honed\Data\Concerns;

use BackedEnum;
use Honed\Data\Exceptions\PartitionKeyNotSetException;

/**
 * @phpstan-require-implements \Spatie\LaravelData\Contracts\IncludeableData
 * @phpstan-require-implements \Honed\Data\Contracts\Partitionable
 */
trait PartitionsData
{
    /**
     * Define the partitions for the data.
     *
     * @return array<string, list<string>>
     */
    abstract public function partitions(): array;

    /**
     * Get a partition of the data.
     *
     * @return $this
     *
     * @throws PartitionKeyNotSetException
     */
    public function partition(string|BackedEnum $key, bool $exclude = false): static
    {
        $keys = $this->getPartition(is_string($key) ? $key : $key->value);

        if ($keys === null) {
            PartitionKeyNotSetException::throw($key, $this);
        }

        if ($exclude) {
            return $this->except(...$keys);
        }

        return $this->only(...$keys);
    }

    /**
     * Get the partition for the given key.
     *
     * @return ?list<string>
     */
    protected function getPartition(string $key): ?array
    {
        $parts = $this->partitions();

        if (! isset($parts[$key])) {
            return null;
        }

        return $parts[$key];
    }
}
