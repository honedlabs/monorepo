<?php

declare(strict_types=1);

namespace Honed\Memo;

use BadMethodCallException;
use Honed\Memo\Concerns\Memoizable;
use Illuminate\Cache\Repository;
use Illuminate\Contracts\Cache\LockProvider;
use Illuminate\Contracts\Cache\Repository as RepositoryContract;
use Illuminate\Contracts\Cache\Store;
use Illuminate\Support\Arr;

class MemoCacheDecorator implements LockProvider, Store
{
    use Memoizable;

    /**
     * The decorated repository.
     *
     * @var RepositoryContract
     */
    protected $repository;

    /**
     * Create a new cache decorator.
     */
    public function __construct(RepositoryContract $repository)
    {
        $this->repository($repository);
    }

    /**
     * Get the decorated repository.
     */
    public function getRepository(): Repository
    {
        /** @var Repository */
        return $this->repository;
    }

    /**
     * Set the decorated repository.
     */
    public function repository(RepositoryContract $repository): void
    {
        $this->repository = $repository;
    }

    /**
     * Retrieve an item from the cache by key.
     *
     * @param  string  $key
     * @return mixed
     */
    public function get($key)
    {
        $prefixed = $this->prefix($key);

        if ($this->isMemoized($prefixed)) {
            return $this->memoized($prefixed);
        }

        return $this->memoize($prefixed, $this->getRepository()->get($prefixed));
    }

    /**
     * Retrieve multiple items from the cache by key.
     *
     * Items not found in the cache will have a null value.
     *
     * @param  array<int, string>  $keys
     * @return array<string, mixed>
     */
    public function many(array $keys)
    {
        $memoized = [];
        $found = [];
        $missing = [];

        foreach ($keys as $key) {
            $prefixedKey = $this->prefix($key);

            if ($this->isMemoized($prefixedKey)) {
                $memoized[$key] = $this->memoized($prefixedKey);
            } else {
                $missing[] = $key;
            }
        }

        if (count($missing) > 0) {
            $found = tap($this->getRepository()->many($missing), function ($values) {
                $this->memoized = [
                    ...$this->memoized,
                    ...Arr::mapWithKeys(
                        $values,
                        fn ($value, $key) => [$this->prefix($key) => $value]
                    ),
                ];
            });
        }

        $result = [...$memoized, ...$found];

        return array_replace(array_flip($keys), $result);

    }

    /**
     * Store an item in the cache for a given number of seconds.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @param  int  $seconds
     * @return bool
     */
    public function put($key, $value, $seconds)
    {
        $this->forgetMemoized($key);

        return $this->getRepository()->put($key, $value, $seconds);
    }

    /**
     * Store multiple items in the cache for a given number of seconds.
     *
     * @param  array<string, mixed>  $values
     * @param  int  $seconds
     * @return bool
     */
    public function putMany(array $values, $seconds)
    {
        foreach ($values as $key => $value) {
            $this->forgetMemoized($key);
        }

        return $this->getRepository()->putMany($values, $seconds);
    }

    /**
     * Increment the value of an item in the cache.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return int|bool
     */
    public function increment($key, $value = 1)
    {
        $this->forgetMemoized($key);

        return $this->getRepository()->increment($key, $value);
    }

    /**
     * Decrement the value of an item in the cache.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return int|bool
     */
    public function decrement($key, $value = 1)
    {
        $this->forgetMemoized($key);

        return $this->getRepository()->decrement($key, $value);
    }

    /**
     * Store an item in the cache indefinitely.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return bool
     */
    public function forever($key, $value)
    {
        $this->forgetMemoized($key);

        return $this->getRepository()->forever($key, $value);
    }

    /**
     * Get a lock instance.
     *
     * @param  string  $name
     * @param  int  $seconds
     * @param  string|null  $owner
     * @return \Illuminate\Contracts\Cache\Lock
     */
    public function lock($name, $seconds = 0, $owner = null)
    {
        $store = $this->getRepository()->getStore();

        if (! $store instanceof LockProvider) {
            throw new BadMethodCallException('This cache store does not support locks.');
        }

        return $store->lock($name, $seconds, $owner);
    }

    /**
     * Restore a lock instance using the owner identifier.
     *
     * @param  string  $name
     * @param  string  $owner
     * @return \Illuminate\Contracts\Cache\Lock
     */
    public function restoreLock($name, $owner)
    {
        $store = $this->getRepository()->getStore();

        if (! $store instanceof LockProvider) {
            throw new BadMethodCallException('This cache store does not support locks.');
        }

        return $store->restoreLock($name, $owner);
    }

    /**
     * Remove an item from the cache.
     *
     * @param  string  $key
     * @return bool
     */
    public function forget($key)
    {
        $this->forgetMemoized($key);

        return $this->getRepository()->forget($key);
    }

    /**
     * Remove all items from the cache.
     *
     * @return bool
     */
    public function flush()
    {
        $this->clearMemoized();

        return $this->getRepository()->flush();
    }

    /**
     * Get the cache key prefix.
     *
     * @return string
     */
    public function getPrefix()
    {
        return $this->getRepository()->getPrefix();
    }

    /**
     * Forget a memoized key with prefix.
     */
    protected function forgetMemoized(string $key): void
    {
        $this->unmemoize($this->prefix($key));
    }

    /**
     * Prefix a key.
     */
    protected function prefix(string|int $key): string
    {
        return $this->getPrefix().$key;
    }
}
