<?php

declare(strict_types=1);

namespace Honed\Table\Pipelines;

use Closure;
use Honed\Table\Table;
use Honed\Table\Columns\Column;
use Honed\Refine\Pipelines\RefineSorts as BaseRefineSorts;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * @template TBuilder of \Illuminate\Database\Eloquent\Builder<TModel>
 */
class MergeColumnFilters
{
    /**
     * Apply the sorts refining logic.
     *
     * @param  \Honed\Refine\Refine<TModel, TBuilder>  $table
     * @return \Honed\Refine\Refine<TModel, TBuilder>
     */
    public function __invoke(Table $table, Closure $next): Table
    {
        return $next($table);
    }
}
