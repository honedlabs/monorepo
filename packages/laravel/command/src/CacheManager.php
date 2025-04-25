<?php

declare(strict_types=1);

namespace Honed\Command;

use Illuminate\Support\Facades\Cache;

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
     * @return string|list<string>
     */
    abstract public function key();

    /**
     * Define the value of the cache.
     * 
     * @return mixed
     */
    abstract public function value();

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
     * @return string
     */
    public function getKey()
    {
        $key = $this->key();

        if (\is_array($key)) {
            $key = \implode('.', $key);
        }

        return $key;
    }


    /**
     * Get the value of the cache.
     */
    public static function get()
    {
        return resolve(static::class)->retrieve();

    }

    /**
     * Retrieve the cache value.
     * 
     * @return mixed
     */
    public function retrieve()
    {
        $duration = $this->getDuration();

        $key = $this->getKey();

        return match (true) {
            \is_array($duration) => Cache::flexible(
                $key,
                $duration,
                fn () => $this->value()
            ),

            $duration > 0 => Cache::remember(
                $key,
                $duration,
                fn () => $this->value()
            ),

            $duration < 0 => $this->value(),

            default => Cache::rememberForever(
                $key,
                fn () => $this->value()
            ),
        };
    }

    /**
     * Forget the cache value.
     */
    public static function forget()
    {
        return resolve(static::class)->flush();
    }

    /**
     * Flush all caches under the same namespace.
     */
    public function flush()
    {
        if ($this->getDuration() < 0) {
            return;
        }

        Cache::forget($this->getKey());
    }
}
