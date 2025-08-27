<?php

declare(strict_types=1);

namespace Honed\Memo;

use Illuminate\Cache\CacheManager as LaravelCacheManager;
use Illuminate\Contracts\Cache\Store;
use InvalidArgumentException;

class CacheManager extends LaravelCacheManager
{
    /**
     * Resolve the given store.
     *
     * @param  array<string, mixed>  $config
     * @return \Illuminate\Contracts\Cache\Repository
     *
     * @throws InvalidArgumentException
     */
    public function repository(Store $store, array $config = [])
    {
        return parent::repository(
            new CacheDecorator(parent::repository($store, $config)),
            ['events' => false]
        );
    }
}
