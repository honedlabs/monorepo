<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Illuminate\Contracts\Container\Container;
use Illuminate\Http\Request;

trait HasRequest
{
    /**
     * The container instance.
     *
     * @var \Illuminate\Contracts\Container\Container
     */
    protected $container;

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
