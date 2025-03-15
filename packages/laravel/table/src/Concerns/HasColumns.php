<?php

declare(strict_types=1);

namespace Honed\Table\Concerns;

use Honed\Table\Columns\Column;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

trait HasColumns
{
    /**
     * The columns to be used for the table.
     *
     * @var array<int,\Honed\Table\Columns\Column>|null
     */
    protected $columns;

    /**
     * Whether the columns should be retrievable.
     *
     * @var bool
     */
    protected $withoutColumns = false;

    /**
     * Merge a set of columns with the existing columns.
     *
     * @param  array<int,\Honed\Table\Columns\Column>|Collection<int,\Honed\Table\Columns\Column>  $columns
     * @return $this
     */
    public function addColumns($columns)
    {
        if ($columns instanceof Collection) {
            $columns = $columns->all();
        }

        $this->columns = \array_merge($this->columns ?? [], $columns);

        return $this;
    }

    /**
     * Add a single column to the list of columns.
     *
     * @param  \Honed\Table\Columns\Column  $column
     * @return $this
     */
    public function addColumn($column)
    {
        $this->columns[] = $column;

        return $this;
    }

    /**
     * Set the columns to not be retrieved.
     *
     * @return $this
     */
    public function withoutColumns()
    {
        $this->withoutColumns = true;

        return $this;
    }

    /**
     * Determine if the columns should not be retrieved.
     *
     * @return bool
     */
    public function isWithoutColumns()
    {
        return $this->withoutColumns;
    }

    /**
     * Get the columns for the table.
     *
     * @return array<int,\Honed\Table\Columns\Column>
     */
    public function getColumns()
    {
        return once(function () {

            $columns = \method_exists($this, 'columns') ? $this->columns() : [];
            
            $columns = \array_merge($columns, $this->columns ?? []);

            return \array_values(
                \array_filter(
                    $columns,
                    static fn (Column $column) => $column->isAllowed()
                )
            );
        });
    }

    /**
     * Determine if the table has columns.
     *
     * @return bool
     */
    public function hasColumns()
    {
        return filled($this->getColumns());
    }

    /**
     * Get the columns as an array.
     *
     * @return array<int,array<string,mixed>>
     */
    public function columnsToArray()
    {
        if ($this->isWithoutColumns()) {
            return [];
        }

        return \array_map(
            static fn (Column $column) => $column->toArray(),
            $this->getColumns()
        );
    }

    /**
     * Augment the builder using the column callbacks.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model>  $builder
     * @param  array<int,\Honed\Table\Columns\Column>  $columns
     * @return void
     */
    public static function augment($builder, $columns)
    {
        foreach ($columns as $column) {
            $callback = $column->getAugment();

            if ($callback) {
                $callback($builder);
            }
        }
    }
}
