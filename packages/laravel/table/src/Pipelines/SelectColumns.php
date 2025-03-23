<?php

declare(strict_types=1);

namespace Honed\Table\Pipelines;

use Honed\Table\Table;
use Illuminate\Support\Arr;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * @template TBuilder of \Illuminate\Database\Eloquent\Builder<TModel>
 */
class SelectColumns
{
    /**
     * Select the columns to be displayed.
     *
     * @param  \Honed\Table\Table<TModel, TBuilder>  $table
     * @param  \Closure(Table<TModel, TBuilder>): Table<TModel, TBuilder>  $next
     * @return \Honed\Table\Table<TModel, TBuilder>
     */
    public function __invoke($table, $next)
    {
        if (! $table->isSelectable()) {
            return $next($table);
        }

        $builder = $table->getBuilder();

        $selects = [];

        foreach ($table->getCachedColumns() as $column) {
            $selects[] = $column->getSelect();
        }

        $selects = \array_unique(Arr::flatten($selects), SORT_STRING);

        $builder->select($selects);

        return $next($table);
    }
}
