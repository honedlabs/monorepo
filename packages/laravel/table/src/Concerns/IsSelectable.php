<?php

declare(strict_types=1);

namespace Honed\Table\Concerns;

use Honed\Table\Columns\Column;
use Honed\Table\Contracts\ShouldSelect;
use Illuminate\Support\Arr;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * @template TBuilder of \Illuminate\Database\Eloquent\Builder<TModel>
 */
trait IsSelectable
{
    /**
     * Whether to do column selection.
     *
     * @var bool|null
     */
    protected $selectable;

    /**
     * The columns to always have selected.
     *
     * @var array<int,string>|null
     */
    protected $selects;

    /**
     * Set whether to do column selection.
     *
     * @param  bool  $selectable
     * @return $this
     */
    public function selectable($selectable = true)
    {
        $this->selectable = $selectable;

        return $this;
    }

    /**
     * Determine whether to do column selection.
     *
     * @return bool
     */
    public function isSelectable()
    {
        if (isset($this->selectable)) {
            return $this->selectable;
        }

        if ($this instanceof ShouldSelect) {
            return true;
        }

        return static::fallbackSelectable();
    }

    /**
     * Whether to do column selection from the config.
     *
     * @return bool
     */
    public function fallbackSelectable()
    {
        return (bool) config('table.selectable', false);
    }

    /**
     * Set the columns to always have selected.
     *
     * @param  array<int,string>  $selects
     * @return $this
     */
    public function selects(...$selects)
    {
        $selects = Arr::flatten($selects);

        $this->selects = \array_merge($this->selects ?? [], $selects);

        return $this;
    }

    /**
     * Get the columns to always have selected.
     *
     * @return array<int,string>|null
     */
    public function getSelects()
    {
        return $this->selects;
    }

    /**
     * Apply the column selection to the builder.
     *
     * @param  TBuilder  $builder
     * @param  array<int,\Honed\Table\Columns\Column<TModel, TBuilder>>  $columns
     * @return void
     */
    public function select($builder, $columns = [])
    {
        if (! $this->isSelectable()) {
            return;
        }

        /** @var array<int,string> */
        $selects = \array_map(
            static fn (Column $column) => $column->getName(),
            \array_values(
                \array_filter(
                    $columns,
                    static fn (Column $column) => ! $column->hasAs()
                )
            )
        );

        $selects = \array_merge($selects, $this->getSelects() ?? []);

        if (filled($selects)) {
            $builder->select($selects);
        }
    }
}