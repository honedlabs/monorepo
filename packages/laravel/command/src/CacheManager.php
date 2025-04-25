<?php

declare(strict_types=1);

namespace Honed\Command;

use Illuminate\Support\Facades\Cache;

/**
 * @template TParameter = mixed
 * @template TReturn = mixed
 */
abstract class CacheManager
{
    /**
     * The duration of the cache.
     *
     * @var int|list{int, int}
     */
    protected $duration = 0;

    /**
     * Define the key of the cache.
     *
     * @param  TParameter  $parameter
     * @return string|array<int,string|int>
     */
    abstract public function key($parameter);

    /**
     * Define the value of the cache.
     *
     * @param  TParameter  $parameter
     * @return TReturn
     */
    abstract public function value($parameter);

    /**
     * Define the duration of the cache.
     *
     * @return int|null
     */
    public function duration()
    {
        return null;
    }

    /**
     * Get the duration of the cache.
     *
     * @return int|list{int, int}
     */
    public function getDuration()
    {
        return $this->duration() ?? $this->duration;
    }

    /**
     * Get the key of the cache.
     *
     * @param  TParameter  $parameter
     * @return string
     */
    public function getKey($parameter)
    {
        $key = $this->key($parameter);

        if (\is_array($key)) {
            $key = \implode('.', $key);
        }

        return $key;
    }

    /**
     * Get the value of the cache.
     *
     * @param  TParameter  $parameter
     * @return TReturn
     */
    public static function get($parameter = null)
    {
        return resolve(static::class)->retrieve($parameter);
    }

    /**
     * Retrieve the cache value.
     *
     * @param  TParameter  $parameter
     * @return TReturn
     */
    public function retrieve($parameter)
    {
        $duration = $this->getDuration();

        $key = $this->getKey($parameter);

        return match (true) {
            \is_array($duration) => Cache::flexible(
                $key,
                $duration,
                fn () => $this->value($parameter)
            ),

            $duration > 0 => Cache::remember(
                $key,
                $duration,
                fn () => $this->value($parameter)
            ),

            $duration < 0 => $this->value($parameter),

            default => Cache::rememberForever(
                $key,
                fn () => $this->value($parameter)
            ),
        };
    }

    /**
     * Forget the cache value.
     *
     * @param  TParameter  $parameter
     * @return void
     */
    public static function forget($parameter = null)
    {
        resolve(static::class)->flush($parameter);
    }

    /**
     * Flush all caches under the same namespace.
     *
     * @param  TParameter  $parameter
     * @return void
     */
    public function flush($parameter)
    {
        Cache::forget($this->getKey($parameter));
    }
}
