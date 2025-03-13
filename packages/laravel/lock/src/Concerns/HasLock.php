<?php

declare(strict_types=1);

namespace Honed\Lock\Concerns;

trait HasLock
{
    /**
     * Define the locks that are available.
     */
    abstract public function locks();

    public function getLocks()
    {

    }
}