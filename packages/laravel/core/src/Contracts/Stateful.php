<?php

declare(strict_types=1);

namespace Honed\Core\Contracts;

/**
 * @template TKey of array-key = string
 * @template TValue of mixed = mixed
 */
interface Stateful
{
    /**
     * Get a snapshot of the current state of the instance.
     *
     * @return array<TKey,TValue>
     */
    public function toState(): array;
}
