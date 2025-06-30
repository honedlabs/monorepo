<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Illuminate\Contracts\Container\Container;

trait HasContainer
{
    /**
     * The container instance.
     */
    protected Container $container;

    /**
     * Set the request instance.
     *
     * @return $this
     */
    public function container(Container $container)
    {
        $this->container = $container;

        return $this;
    }

    /**
     * Get the request instance.
     */
    public function getContainer(): Container
    {
        return $this->container;
    }
}
