<?php

declare(strict_types=1);

namespace Honed\Refining\Concerns;

use Illuminate\Http\Request;

trait HasRequest
{
    /**
     * @var \Illuminate\Http\Request
     */
    protected $request;

    public function request(Request $request): static
    {
        $this->request = $request;

        return $this;
    }

    public function getRequest(): Request
    {
        return $this->request;
    }
}