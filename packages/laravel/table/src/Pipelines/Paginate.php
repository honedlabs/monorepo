<?php

declare(strict_types=1);

namespace Honed\Table\Pipelines;

use Closure;
use Honed\Action\InlineAction;
use Honed\Table\Columns\Column;
use Honed\Table\Table;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * @template TBuilder of \Illuminate\Database\Eloquent\Builder<TModel>
 */
class Paginate
{
    /**
     * Apply the filters to the query.
     * 
     * @param  \Honed\Table\Table<TModel, TBuilder>  $table
     * @return \Honed\Table\Table<TModel, TBuilder>
     */
    public function __invoke(Table $table, Closure $next): Table
    {
        [$records, $paginationData] = $table->paginate($table);
        
        $table->setRecords($records);
        $table->setPaginationData($paginationData);

        return $next($table);
    }
}
