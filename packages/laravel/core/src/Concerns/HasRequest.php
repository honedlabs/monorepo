<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasRequest
{
    /**
     * The request on the instance.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Set the request on the instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return $this
     */
    public function request($request)
    {
        $this->request = $request;

        return $this;
    }

    /**
     * Get the request on the instance.
     *
     * @return \Illuminate\Http\Request
     */
    public function getRequest()
    {
        return $this->request;
    }
}
