<?php

declare(strict_types=1);

namespace Honed\Table\Pipelines;

use Closure;
use Honed\Core\Interpret;
use Honed\Table\Columns\Column;
use Honed\Table\Table;
use Illuminate\Support\Arr;

class SelectColumns
{
    /**
     * Select the columns to be displayed.
     * 
     * @template TModel of \Illuminate\Database\Eloquent\Model
     * @template TBuilder of \Illuminate\Database\Eloquent\Builder<TModel>
     * 
     * @param  \Honed\Table\Table<TModel, TBuilder>  $table
     * @return \Honed\Table\Table<TModel, TBuilder>
     */
    public function __invoke(Table $table, Closure $next): Table
    {
        if (! $table->isSelectable()) {
            return $next($table);
        }

        $for = $table->getFor();

        $select = [];

        foreach ($table->getCachedColumns() as $column) {
            if ($column->isSelectable()) {
                $select[] = $column->getSelect();
            }
        }

        $select = \array_unique(Arr::flatten($select), SORT_STRING);

        $for->select($select);

        return $next($table);
    }
}
