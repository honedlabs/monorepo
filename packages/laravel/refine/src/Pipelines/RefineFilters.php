<?php

declare(strict_types=1);

namespace Honed\Refine\Pipelines;

use Closure;
use Honed\Refine\Refine;

final readonly class RefineFilters
{
    /**
     * Apply the filters to the query.
     */
    public function __invoke(Refine $refine, Closure $next): Refine
    {
        if (! $refine->filtering()) {
            return $next($refine);
        }

        $scope = $refine->getScope();
        $delimiter = $refine->getDelimiter();

        $for = $refine->getFor();
        $request = $refine->getRequest();

        $filters = $refine->getFilters();

        foreach ($filters as $filter) {
            $filter->scope($scope)
                ->delimiter($delimiter)
                ->refine($for, $request);
        }

        return $next($refine);
    }
}
