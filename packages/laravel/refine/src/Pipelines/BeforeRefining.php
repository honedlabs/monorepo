<?php

declare(strict_types=1);

namespace Honed\Refine\Pipelines;

use Closure;
use Honed\Refine\Refine;

final readonly class BeforeRefining
{
    /**
     * 
     */
    public function __invoke(Refine $refine, Closure $next): Refine
    {
        // $before = match (true) {

        // }

        // $refine->evaluate($before);

        return $next($refine);
    }
}
