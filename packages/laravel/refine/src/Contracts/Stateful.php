<?php

declare(strict_types=1);

namespace Honed\Refine\Contracts;

/**
 * @template TKey of array-key
 * @template TValue of mixed
 */
interface Stateful
{
    /**
     * Get an array representation of the state at the current point in time.
     *
     * @return array<TKey,TValue>
     */
    public function toState(): array;
}
