<?php

declare(strict_types=1);

namespace Honed\Command\Concerns;

use Honed\Command\Attributes\UseCache;
use Honed\Command\CacheManager;
use ReflectionClass;

/**
 * @template TCache of \Honed\Command\CacheManager
 * @template TReturn = mixed
 *
 * @property string $cache
 */
trait HasCache
{
    /**
     * Get the cache manager instance.
     *
     * @return TCache
     */
    public static function cache()
    {
        return static::newCache()
            ?? CacheManager::cacheForModel(static::class);
    }

    /**
     * Get the cached value for this class.
     *
     * @return TReturn
     */
    public function cached()
    {
        return static::cache()->retrieve($this);
    }

    /**
     * Forget the cached value for this class.
     *
     * @return void
     */
    public function forgetCached()
    {
        static::cache()->flush($this);
    }

    /**
     * Create a new cache instance for the model.
     *
     * @return TCache|null
     */
    protected static function newCache()
    {
        if (isset(static::$cache)) {
            return resolve(static::$cache);
        }

        if ($cache = static::getUseCacheAttribute()) {
            return resolve($cache);
        }

        return null;
    }

    /**
     * Get the cache from the Cache class attribute.
     *
     * @return class-string<TCache>|null
     */
    protected static function getUseCacheAttribute()
    {
        $attributes = (new ReflectionClass(static::class))
            ->getAttributes(UseCache::class);

        if ($attributes !== []) {
            $cache = $attributes[0]->newInstance();

            return $cache->cacheClass;
        }

        return null;
    }
}
