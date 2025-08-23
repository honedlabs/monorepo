<?php

namespace Honed\Widget\Drivers;

use Honed\Widget\Contracts\Driver as DriverContract;
use Illuminate\Contracts\Events\Dispatcher;

abstract class Driver implements DriverContract
{
    /**
     * The store's name.
     *
     * @var string
     */
    protected $name;

    /**
     * The event dispatcher.
     *
     * @var \Illuminate\Contracts\Events\Dispatcher
     */
    protected $events;

    public function __construct(string $name, Dispatcher $events)
    {
        $this->name = $name;
        $this->events = $events;
    }
}