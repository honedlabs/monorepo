<?php

declare(strict_types=1);

namespace Honed\Upload\Events;

class PresignFailed
{
    /**
     * The route instance.
     *
     * @var \Illuminate\Routing\Route
     */
    public $route;

    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    public $request;

    /**
     * Create a new event instance.
     *
     * @param  \Illuminate\Routing\Route  $route
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    public function __construct($route, $request)
    {
        $this->route = $route;
        $this->request = $request;
    }
}
