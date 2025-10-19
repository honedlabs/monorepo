<?php

declare(strict_types=1);

namespace Honed\Data\Support;

use Illuminate\Contracts\Session\Session;

abstract class HasSession
{
    /**
     * The driver name.
     */
    public ?string $driver = null;

    /**
     * Get the cache repository.
     */
    public function getSession(): Session
    {
        /** @var Session */
        return app('session')->driver($this->driver);
    }
}
