<?php

declare(strict_types=1);

namespace Honed\Table\Pipelines;

use Closure;
use Honed\Refine\Filter;
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
        $columns = $table->getCachedColumns();

        /** @var array<int,\Honed\Refine\Filter<TModel, TBuilder>> */
        $filters = \array_map(
            static fn (Column $column) => static::createFilter($column),
            \array_values(
                \array_filter(
                    $columns,
                    static fn (Column $column) => $column->isFilterable()
                )
            )
        );

        $table->withFilters($filters);
        return $next($table);
    }

    /**
     * Extract the type to use for the filter.
     *
     * @param  \Honed\Table\Columns\Column<TModel, TBuilder>  $column
     * @return \Honed\Refine\Filter<TModel, TBuilder>
     */
    public static function createFilter(Column $column)
    {
        $filter = Filter::make($column->getName(), $column->getLabel())
            ->alias($column->getParameter());

        $type = $column->getType();

        match ($type) {
            'date' => $filter->date(),
            'boolean' => $filter->boolean(),
            'number' => $filter->integer(),
            'text' => $filter->string(),
        };

        return $filter;
    }
}
