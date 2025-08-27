<?php

declare(strict_types=1);

namespace Honed\Performance\Concerns;

/**
 * @template T = mixed
 */
trait Memoizable
{
    /**
     * The store of memoized values.
     *
     * @var array<string, T>
     */
    protected $memoize = [];

    /**
     * Set a memorized value.
     *
     * @template TValue of T
     *
     * @param  TValue  $value
     * @return TValue
     */
    public function memoize(string $key, $value)
    {
        return $this->memoize[$key] = $value;
    }

    /**
     * Remove a memorized value.
     */
    public function unmemoize(string $key): void
    {
        unset($this->memoize[$key]);
    }

    /**
     * Get a memoized value.
     *
     * @return T
     */
    public function memoized(string $key)
    {
        return $this->memoize[$key];
    }

    /**
     * Determine if a key is memorized.
     */
    public function isMemoized(string $key): bool
    {
        return isset($this->memoize[$key]);
    }

    /**
     * Determine if a key is not memorized.
     */
    public function isNotMemoized(string $key): bool
    {
        return ! $this->isMemoized($key);
    }

    /**
     * Clear the memoize cache.
     */
    public function clearMemoized(): void
    {
        $this->memoize = [];
    }

    /**
     * Generate a hash for a given key.
     */
    public function getHash(mixed ...$values): string
    {
        return hash('md5', json_encode($values, JSON_THROW_ON_ERROR));
    }
}
