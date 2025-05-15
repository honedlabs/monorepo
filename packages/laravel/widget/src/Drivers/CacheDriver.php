<?php

declare(strict_types=1);

namespace Honed\Widget\Drivers;

use Honed\Widget\Contracts\Driver;
use Illuminate\Cache\CacheManager;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Config\Repository;
class CacheDriver implements Driver
{
    /**
     * The cache manager.
     *
     * @var \Illuminate\Cache\CacheManager
     */
    protected $cache;

    /**
     * The event dispatcher.
     *
     * @var \Illuminate\Contracts\Events\Dispatcher
     */
    protected $events;

    /**
     * The user configuration.
     *
     * @var \Illuminate\Config\Repository
     */
    protected $config;

    /**
     * Create a new driver instance.
     *
     * @return void
     */
    public function __construct(
        CacheManager $cache,
        Dispatcher $events,
        Repository $config
    ) {
        $this->cache = $cache;
        $this->events = $events;
        $this->config = $config;
    }
    
}
