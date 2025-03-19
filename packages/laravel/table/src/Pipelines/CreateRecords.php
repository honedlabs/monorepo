<?php

declare(strict_types=1);

namespace Honed\Table\Pipelines;

use Closure;
use Honed\Table\Table;

class CreateRecords
{
    /**
     * Apply the filters to the query.
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
            return $next($table);
        }

        $key = $table->getColumnsKey();

        return $next($table);
        
        
    }
}
