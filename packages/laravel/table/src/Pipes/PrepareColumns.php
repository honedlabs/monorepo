<?php

declare(strict_types=1);

namespace Honed\Table\Pipes;

use Honed\Core\Pipe;
use Illuminate\Support\Str;

/**
 * @template TClass of \Honed\Table\Table
 *
 * @extends Pipe<TClass>
 */
class PrepareColumns extends Pipe
{
    /**
     * The methods to prepare.
     *
     * @var array<int, string>
     */
    protected $methods = [
        'search',
        'filter',
        'sort',
        'query',
    ];

    /**
     * Run the after refining logic.
     *
     * @param  TClass  $instance
     * @return void
     */
    public function run($instance)
    {
        foreach ($instance->getColumns() as $column) {
            foreach ($this->methods as $method) {
                $column->{'prepare'.Str::studly($method)}($instance, $column);
            }
        }
    }

    /**
     * Prepare the column search state.
     *
     * @param  TClass  $instance
     * @param  \Honed\Table\Columns\Column  $column
     * @return void
     */
    protected function prepareSearch($instance, $column) {}

    /**
     * Prepare the column filter state.
     *
     * @param  TClass  $instance
     * @param  \Honed\Table\Columns\Column  $column
     * @return void
     */
    protected function prepareFilter($instance, $column)
    {
        //
    }

    /**
     * Prepare the column sort state.
     *
     * @param  TClass  $instance
     * @param  \Honed\Table\Columns\Column  $column
     * @return void
     */
    protected function prepareSort($instance, $column)
    {
        //
    }

    /**
     * Prepare the column query state.
     *
     * @param  TClass  $instance
     * @param  \Honed\Table\Columns\Column  $column
     * @return void
     */
    protected function prepareQuery($instance, $column)
    {
        //
    }
}
