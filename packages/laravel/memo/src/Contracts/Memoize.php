<?php

declare(strict_types=1);

namespace Honed\Memo\Contracts;

/**
 * @see \Honed\Memo\MemoManager
 */
interface Memoize
{
    /**
     * Get a memoized value.
     */
    public function get(string $key): mixed;

    /**
     * Memoize a value.
     *
     * @template TValue
     *
     * @param  TValue  $value
     * @return TValue
     */
    public function put(string $key, $value);

    /**
     * Get a memoized value and remove it from memory.
     */
    public function pull(string $key): mixed;

    /**
     * Remove a memoized value from memory.
     */
    public function forget(string $key): void;

    /**
     * Clear the memoized values.
     */
    public function clear(): void;
}
