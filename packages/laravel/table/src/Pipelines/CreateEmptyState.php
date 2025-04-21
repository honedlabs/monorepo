<?php

declare(strict_types=1);

namespace Honed\Table\Pipelines;

use Honed\Table\Table;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * @template TBuilder of \Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model>
 */
class CreateEmptyState
{
    /**
     * Create the empty state of the table considering the refiners, filters and search.
     *
     * @param  \Honed\Table\Table<TModel, TBuilder>  $table
     * @param  \Closure(Table<TModel, TBuilder>): Table<TModel, TBuilder>  $next
     * @return \Honed\Table\Table<TModel, TBuilder>
     */
    public function __invoke($table, $next)
    {
        // Get the empty state and run it through the defaults.
        $state = $table->getEmptyState();
        $table->defineEmptyState($state);

        // $isSearching = $table->isSearching();
        // $isFiltering = $table->isFiltering();
        // $isRefining = $isSearching || $isFiltering;

        // if ($isSearching && $searching = $table->getSearchingState()) {
        //     $searching($state);
        // } else if ($isFiltering && $filtering = $table->getFilteringState()) {
        //     $filtering($state);
        // } else if ($isRefining && $refining = $table->getRefiningState()) {
        //     $refining($state);
        // }
        
        return $next($table);
    }
}
