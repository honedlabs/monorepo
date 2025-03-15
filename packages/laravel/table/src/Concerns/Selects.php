<?php

declare(strict_types=1);

namespace Honed\Table\Concerns;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * @template TBuilder of \Illuminate\Database\Eloquent\Builder<TModel>
 */
trait Selects
{
    /**
     * Whether to do column selection.
     *
     * @var bool|null
     */
    protected $select;

    /**
     * The columns to always have selected.
     *
     * @var array<int,string>|null
     */
    protected $selects;

    /**
     * Set whether to do column selection.
     *
     * @param  bool  $select
     * @return $this
     */
    public function select($select)
    {
        $this->select = $select;

        return $this;
    }

    /**
     * Whether to do column selection.
     *
     * @return bool
     */
    public function selects()
    {
        return (bool) ($this->select ?? $this->fallbackSelects());
    }

    /**
     * Whether to do column selection from the config.
     *
     * @return bool
     */
    public function fallbackSelects()
    {
        return (bool) config('table.selects', false);
    }

    /**
     * Apply the column selection to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model>  $builder
     * @param  array<int,string>  $columns
     * @return void
     */
    public function selectColumns($builder, $columns)
    {
        if (! $this->selects()) {
            return;
        }

        // $builder->select
    }
}