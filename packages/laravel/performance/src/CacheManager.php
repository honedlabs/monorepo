<?php

declare(strict_types=1);

namespace Honed\Memo;

use Illuminate\Cache\CacheManager as LaravelCacheManager;

class CacheManager extends LaravelCacheManager
{
    /**
     * Resolve the given store.
     *
     * @param  string  $name
     * @return \Illuminate\Contracts\Cache\Repository
     *
     * @throws \InvalidArgumentException
     */
    public function resolve($name)
    {
        return new MemoStore(parent::resolve($name));
    }
}