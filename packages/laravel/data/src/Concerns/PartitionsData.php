<?php

declare(strict_types=1);

namespace Honed\Data\Concerns;

use BackedEnum;
use Exception;

/**
 * @phpstan-require-extends \Spatie\LaravelData\Data
 *
 * @phpstan-require-implements \Honed\Data\Contracts\Partitionable
 */
trait PartitionsData
{
    /**
     * Get a partition of the data.
     * 
     * @return $this
     * 
     * @throws \Exception
     */
    public function partition(string|BackedEnum $key, bool $exclude = false): static
    {
        $keys = $this->getPartition(is_string($key) ? $key : $key->value);

        if ($keys === null) {
            throw new Exception(
                sprintf("Partition key [%s] does exist for data class [%s].", $key, static::class)
            );
        }

        if ($exclude) {
            return $this->except(...$keys);
        }

        return $this->only(...$keys);
    }

    /**
     * Get the partition for the given key.
     * 
     * @return list<string>|null
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
