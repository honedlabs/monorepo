<?php

declare(strict_types=1);

namespace Honed\Table\Pipelines;

use Closure;
use Honed\Table\Table;

class CleanupTable
{
    /**
     * Cleanup the table.
     * 
     * @template TModel of \Illuminate\Database\Eloquent\Model
     * @template TBuilder of \Illuminate\Database\Eloquent\Builder<TModel>
     * 
     * @param  \Honed\Table\Table<TModel, TBuilder>  $table
     * @return \Honed\Table\Table<TModel, TBuilder>
     */
    public function __invoke(Table $table, Closure $next): Table
    {
        $table->flushCachedColumns();
        
        return $next($table);
    }
}
