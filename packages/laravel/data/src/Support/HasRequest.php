<?php

declare(strict_types=1);

namespace Honed\Data\Support;

use Illuminate\Http\Request;

abstract class HasRequest
{
    /**
     * Get the request.
     */
    public function getRequest(): Request
    {
        /** @var Request */
        return app('request');
    }
}
