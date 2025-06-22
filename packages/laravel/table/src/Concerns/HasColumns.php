<?php

declare(strict_types=1);

namespace Honed\Table\Concerns;

use Honed\Table\Columns\Column;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model = \Illuminate\Database\Eloquent\Model
 * @template TBuilder of \Illuminate\Database\Eloquent\Builder<TModel> = \Illuminate\Database\Eloquent\Builder<TModel>
 */
trait HasColumns
{
    /**
     * The columns to be used for the table.
     *
     * @var array<int,Column<TModel, TBuilder>>
     */
    protected $columns = [];

    /**
     * The cached column headings.
     *
     * @var array<int,Column>
     */
    protected $headings = [];

    /**
     * Merge a set of columns with the existing columns.
     *
     * @param  Column|array<int,Column>  $columns
     * @return $this
     */
    public function columns($columns)
    {
        /** @var array<int,Column> */
        $columns = is_array($columns) ? $columns : func_get_args();

        $this->columns = [...$this->columns, ...$columns];

        return $this;
    }

    /**
     * Retrieve the columns.
     *
     * @return array<int,Column<TModel, TBuilder>>
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
     * @param  array<int,Column<TModel, TBuilder>>  $headings
     * @return void
     */
    public function setHeadings($headings)
    {
        $this->headings = $headings;
    }

    /**
     * Get the cached heading columns.
     *
     * @return array<int,Column<TModel, TBuilder>>
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
