<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;

trait HasRequest
{
    /**
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

    /**
     * Safely retrieve a query parameter from the request.
     *
     * @param  string  $parameter
     * @return mixed
     */
    public function getQueryParameter($parameter)
    {
        $param = $this->getRequest()->query($parameter);

        return \is_array($param)
            ? Arr::first(Arr::flatten($param))
            : $param;
    }
}
