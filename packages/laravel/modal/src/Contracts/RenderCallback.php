<?php

declare(strict_types=1);

namespace Honed\Modal\Contracts;

use Illuminate\Http\Request;
use Illuminate\Http\Response;

interface RenderCallback
{
    /**
     * Define a callback to be executed before the base route is rerendered.
     */
    public function __invoke(Request $request, Response $response): void;
}