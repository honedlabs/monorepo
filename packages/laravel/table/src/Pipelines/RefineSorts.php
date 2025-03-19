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
class RefineSorts extends BaseRefineSorts
{
    /**
     * Apply the sorts refining logic.
     *
     * @param  \Honed\Refine\Refine<TModel, TBuilder>  $table
     * @return \Honed\Refine\Refine<TModel, TBuilder>
     */
    public function __invoke(Table $table, Closure $next): Table
    {
        if (! $table->isSorting()) {
            return $next($table);
        }

        $request = $table->getRequest();
        $for = $table->getFor();

        $sortsKey = $table->formatScope($table->getSortsKey());

        $value = $this->nameAndDirection($request, $sortsKey);

        $sorts = \array_merge($table->getSorts(),
            \array_map(
                static fn (Column $column) => $column->getSort(),
                \array_values(
                    \array_filter(
                        $table->getColumns(), 
                        static fn (Column $column) => $column->isSortable()
                    )
                )
            )
        );

        $applied = false;

        foreach ($sorts as $sort) {
            $applied |= $sort->refine($for, $value);
        }

        if (! $applied && $sort = $table->getDefaultSort()) {
            [$_, $direction] = $value;

            $value = [$sort->getParameter(), $direction];

            $sort->refine($for, $value);
        }

        return $next($table);
    }
}
