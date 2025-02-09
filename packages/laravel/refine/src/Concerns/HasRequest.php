<?php

declare(strict_types=1);

namespace Honed\Refine\Concerns;

use Illuminate\Http\Request;

trait HasRequest
{
    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * Set the request instance.
     *
     * @return $this
     */
    public function request(Request $request): static
    {
        $this->request = $request;

        return $this;
    }

    /**
     * Get the request instance.
     */
    public function getRequest(): Request
    {
        return $this->request;
    }
}
