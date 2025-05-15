<?php

declare(strict_types=1);

namespace Honed\Widget\Drivers;

use Honed\Widget\Contracts\Driver;
use Illuminate\Config\Repository;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Cookie\CookieJar;
use Illuminate\Support\Facades\Cookie;

class CookieDriver implements Driver
{
    /**
     * The event dispatcher.
     *
     * @var \Illuminate\Contracts\Events\Dispatcher
     */
    protected $events;

    /**
     * The cookie jar.
     *
     * @var \Illuminate\Cookie\CookieJar
     */
    protected $cookies;
    
    public function __construct(
        CookieJar $cookies,
        Dispatcher $events,
        Repository $config
    ) {
        $this->events = $events;
        $this->cookies = $cookies;
        // $this->config = $config;
    }
    
}
