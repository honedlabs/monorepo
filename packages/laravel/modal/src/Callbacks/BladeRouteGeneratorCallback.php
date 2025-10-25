<?php

declare(strict_types=1);

namespace Honed\Modal\Callbacks;

use Honed\Modal\Contracts\RenderCallback;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tighten\Ziggy\BladeRouteGenerator;

class BladeRouteGeneratorCallback implements RenderCallback
{
    /**
     * Reset the BladeRouteGenerator state before rendering the base route.
     */
    public function __invoke(Request $request, Response $response): void
    {
        if (class_exists(BladeRouteGenerator::class)) {
            BladeRouteGenerator::$generated = false;
        }
    }
}
