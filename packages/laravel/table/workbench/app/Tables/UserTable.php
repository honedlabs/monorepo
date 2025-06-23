<?php

declare(strict_types=1);

namespace Workbench\App\Tables;

use Honed\Table\Table;
use Honed\Refine\Sorts\Sort;
use Honed\Table\Columns\Column;
use Workbench\App\Enums\Status;
use Honed\Refine\Filters\Filter;
use Honed\Refine\Searches\Search;
use Workbench\App\Models\Product;
use Honed\Table\Columns\KeyColumn;
use Honed\Table\Columns\DateColumn;
use Honed\Table\Columns\TextColumn;
use Honed\Table\Columns\NumberColumn;
use Honed\Table\Columns\BooleanColumn;
use Honed\Table\Contracts\ShouldToggle;
use Honed\Action\Operations\BulkOperation;
use Honed\Action\Operations\PageOperation;
use Honed\Action\Operations\InlineOperation;
use Workbench\App\Models\User;

/**
 * @template TModel of \Workbench\App\Models\User
 * @template TBuilder of \Illuminate\Database\Eloquent\Builder<TModel>
 *
 * @extends Table<TModel, TBuilder>
 */
class UserTable extends Table
{
    /**
     * Define the table.
     *
     * @param  $this  $table
     * @return $this
     */
    protected function definition(Table $table): Table
    {
        return $table->for(User::class);
    }
}
