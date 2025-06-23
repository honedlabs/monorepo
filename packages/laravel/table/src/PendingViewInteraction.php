<?php

declare(strict_types=1);

namespace Honed\Table;

use JsonSerializable;

class PendingViewInteraction
{
    /**
     * The view driver.
     * 
     * @var \Honed\Table\Drivers\Driver
     */
    protected $driver;
}