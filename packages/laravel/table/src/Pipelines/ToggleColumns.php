<?php

declare(strict_types=1);

namespace Honed\Table\Pipelines;

use Closure;
use Honed\Core\Interpret;
use Honed\Table\Columns\Column;
use Honed\Table\Table;

class ToggleColumns
{
    /**
     * Toggle the columns that are displayed.
     * 
     * @template TModel of \Illuminate\Database\Eloquent\Model
     * @template TBuilder of \Illuminate\Database\Eloquent\Builder<TModel>
     * 
     * @param  \Honed\Table\Table<TModel, TBuilder>  $table
     * @return \Honed\Table\Table<TModel, TBuilder>
     */
    public function __invoke(Table $table, Closure $next): Table
    {
        if (! $table->isToggleable() || $table->isWithoutToggling()) {
            $table->cacheColumns(
                \array_values(
                    \array_filter(
                        $table->getCachedColumns(),
                        static fn (Column $column) => $column->display()
                    )
                )
            );

            return $next($table);
        }

        $request = $table->getRequest();

        $params = Interpret::array(
            $request,
            $table->formatScope($table->getColumnsKey()),
            $table->getDelimiter(),
            'string'
        );

        if ($table->isRememberable()) {
            $params = $table->configureCookie($request, $params);
        }

        $table->cacheColumns(
            \array_values(
                \array_filter(
                    $table->getCachedColumns(),
                    static fn (Column $column) => $column->display($params)
                )
            )
        );

        return $next($table);
    }
}
