<?php

declare(strict_types=1);

namespace Honed\Table\Concerns;

use Honed\Table\Columns\Column;
use Illuminate\Support\Arr;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model = \Illuminate\Database\Eloquent\Model
 * @template TBuilder of \Illuminate\Database\Eloquent\Builder<TModel> = \Illuminate\Database\Eloquent\Builder<TModel>
 */
trait HasColumns
{
    /**
     * The columns to be used for the table.
     *
     * @var array<int,\Honed\Table\Columns\Column<TModel, TBuilder>>
     */
    protected $columns = [];

    /**
     * The cached column headings.
     *
     * @var array<int,\Honed\Table\Columns\Column>
     */
    protected $headings = [];

    /**
     * Merge a set of columns with the existing columns.
     *
     * @param  \Honed\Table\Columns\Column|array<int,\Honed\Table\Columns\Column>  $columns
     * @return $this
     */
    public function columns($columns)
    {
        /** @var array<int,\Honed\Table\Columns\Column> */
        $columns = is_array($columns) ? $columns : func_get_args();

        $this->columns = [...$this->columns, ...$columns];

        return $this;
    }

    /**
     * Retrieve the columns.
     *
     * @return array<int,\Honed\Table\Columns\Column<TModel, TBuilder>>
     */
    public function getColumns()
    {
        return array_values(
            array_filter(
                $this->columns,
                static fn (Column $column) => $column->isAllowed()
            )
        );
    }

    /**
     * Set the cached headings.
     *
     * @param  array<int,\Honed\Table\Columns\Column<TModel, TBuilder>>  $headings
     * @return void
     */
    public function setHeadings($headings)
    {
        $this->headings = $headings;
    }

    /**
     * Get the cached heading columns.
     *
     * @return array<int,\Honed\Table\Columns\Column<TModel, TBuilder>>
     */
    public function getHeadings()
    {
        return $this->headings;
    }

    /**
     * Get the columns as an array.
     *
     * @return array<int,array<string,mixed>>
     */
    public function columnsToArray()
    {
        return array_map(
            static fn (Column $column) => $column->toArray(),
            $this->getColumns()
        );
    }
}
