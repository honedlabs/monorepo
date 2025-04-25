<?php

declare(strict_types=1);

namespace Honed\Command\Concerns;

use Honed\Command\CacheManager;
use Honed\Command\Attributes\Cache;

/**
 * @template TCache of \Honed\Command\CacheManager
 * @template TReturn of mixed = mixed
 */
trait HasCache 
{
    /**
     * The cache manager instance.
     * 
     * @var class-string<TCache>
     */
    protected static $cache;

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
            return new static::$cache();
        }

        if ($cache = static::getCacheAttribute()) {
            return new $cache();
        }

        return null;
    }

    /**
     * Get the cache from the Cache class attribute.
     *
     * @return class-string<TCache>|null
     */
    protected static function getCacheAttribute()
    {
        $attributes = (new \ReflectionClass(static::class))
            ->getAttributes(Cache::class);

        if ($attributes !== []) {
            $cache = $attributes[0]->newInstance();

            return $cache->cache;
        }

        return null;
    }
}
