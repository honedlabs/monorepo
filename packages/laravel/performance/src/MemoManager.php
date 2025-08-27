<?php

declare(strict_types=1);

namespace Honed\Memo;

use Honed\Memo\Concerns\Memoizable;
use Honed\Memo\Contracts\Memoize;

class MemoManager implements Memoize
{
    use Memoizable;

    /**
     * Get a memoized value.
     */
    public function get(string $key): mixed
    {
        return $this->memoized($key);
    }

    /**
     * Memoize a value.
     *
     * @template TValue
     *
     * @param  TValue  $value
     * @return TValue
     */
    public function put(string $key, $value)
    {
        return $this->memoize($key, $value);
    }

    /**
     * Get a memoized value and remove it from the store.
     */
    public function pull(string $key): mixed
    {
        $value = $this->memoized($key);

        $this->unmemoize($key);

        return $value;
    }

    /**
     * Remove a memoized value from memory.
     */
    public function forget(string $key): void
    {
        $this->unmemoize($key);
    }

    /**
     * Clear the memoized values.
     */
    public function clear(): void
    {
        $this->clearMemoized();
    }
}
