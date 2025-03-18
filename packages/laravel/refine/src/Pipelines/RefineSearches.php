<?php

declare(strict_types=1);

namespace Honed\Refine\Pipelines;

use Closure;
use Honed\Core\Interpreter;
use Honed\Refine\Refine;
use Illuminate\Http\Request;

final readonly class RefineSearches
{
    /**
     * Apply the searches to the query.
     */
    public function __invoke(Refine $refine, Closure $next): Refine
    {
        if (! $refine->searching()) {
            return $next($refine);
        }

        $request = $refine->getRequest();

        $searchKey = $refine->formatScope($refine->getSearchesKey());
        $matchesKey = $refine->formatScope($refine->getMatchesKey());
        $delimiter = $refine->getDelimiter();

        $term = $this->term($request, $searchKey);
        $columns = $this->columns($request, $matchesKey, $delimiter);

        $for = $refine->getFor();
        $searches = $refine->getSearches();
        $applied = false;

        foreach ($searches as $search) {
            $boolean = $applied ? 'or' : 'and';

            $matched = empty($columns) || 
                \in_array($search->getParameter(), $columns);

            if ($matched) {
                $applied |= $search->boolean($boolean)->refine($for, $term);
            }
        }

        return $next($refine);
    }

    /**
     * Get the search term from a request.
     */
    public function term(Request $request, string $key): ?string
    {
        $term = Interpreter::interpretString($request, $key);

        if (empty($term)) {
            return null;
        }

        return \str_replace('+', ' ', $term);
    }

    /**
     * Get the search columns from a request.
     * 
     * @return array<int,string>|null
     */
    public function columns(Request $request, string $key, string $delimiter): ?array
    {
        return Interpreter::interpretArray($request, $key, $delimiter);
        
        
    }
}
