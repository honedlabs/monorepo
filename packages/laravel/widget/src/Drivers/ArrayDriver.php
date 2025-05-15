<?php

declare(strict_types=1);

namespace Honed\Widget\Drivers;

use Honed\Widget\Contracts\Driver;
use Illuminate\Contracts\Events\Dispatcher;

class ArrayDriver implements Driver
{
    /**
     * The event dispatcher.
     *
     * @var \Illuminate\Contracts\Events\Dispatcher
     */
    protected $events;

    /**
     * Create a new driver instance.
     *
     * @return void
     */
    public function __construct(Dispatcher $events)
    {
        $this->events = $events;
    }
    
}
