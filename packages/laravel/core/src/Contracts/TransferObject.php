<?php

declare(strict_types=1);

namespace Honed\Core\Contracts;

interface TransferObject
{
    /**
     * Create a new instance from a request.
     *
     * @param  \Illuminate\Http\Request  $request  The request to create the instance from.
     */
    public static function from($request): static;
}
