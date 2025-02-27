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
     * @return $this
     */
    public function request(Request $request): static
    {
        $this->request = $request;

        return $this;
    }

    /**
     * Get the request on the instance.
     */
    public function getRequest(): Request
    {
        return $this->request;
    }

    /**
     * Safely retrieve a query parameter from the request.
     */
    public function getQueryParameter(string $parameter): mixed
    {
        $param = $this->getRequest()->query($parameter);

        return \is_array($param)
            ? Arr::first(Arr::flatten($param))
            : $param;
    }
}
