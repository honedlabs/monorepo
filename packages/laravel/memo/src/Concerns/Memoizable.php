<?php

declare(strict_types=1);

namespace Honed\Memo\Concerns;

/**
 * @template T = mixed
 */
trait Memoizable
{
    /**
     * Sentinel value for memoized values.
     */
    public const SENTINEL = '__laravel_memoized';

    /**
     * The store of memoized values.
     *
     * @var array<string, T>
     */
    protected $memoized = [];

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
        $this->memoized[$key] = $value ?? self::SENTINEL;

        return $value;
    }

    /**
     * Remove a memorized value.
     */
    public function unmemoize(string $key): void
    {
        unset($this->memoized[$key]);
    }

    /**
     * Get a memoized value.
     *
     * @return T
     */
    public function memoized(string $key)
    {
        $value = $this->memoized[$key] ?? null;

        return $value === self::SENTINEL ? null : $value;
    }

    /**
     * Determine if a key is memorized.
     */
    public function isMemoized(string $key): bool
    {
        return isset($this->memoized[$key]);
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
        $this->memoized = [];
    }

    /**
     * Generate a hash for a given key.
     */
    public function getHash(mixed ...$values): string
    {
        return hash('md5', json_encode($values, JSON_THROW_ON_ERROR));
    }
}
