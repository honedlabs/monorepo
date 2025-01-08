<?php

declare(strict_types=1);

namespace Honed\Core\Contracts;

interface Transfer
{
    /**
     * Create a new instance from a request.
     * 
     * @param \Illuminate\Http\Request $request The request to create the instance from.
     * @return static
     */
    public static function from($request);
}
