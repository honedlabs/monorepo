<?php

declare(strict_types=1);

namespace Honed\Table\Columns;

use Honed\Core\Primitive;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Honed\Core\Concerns\HasIcon;
use Honed\Core\Concerns\HasName;
use Honed\Core\Concerns\HasType;
use Honed\Core\Concerns\HasAlias;
use Honed\Core\Concerns\HasExtra;
use Honed\Core\Concerns\HasLabel;
use Honed\Core\Concerns\IsActive;
use Honed\Core\Concerns\IsHidden;
use Honed\Core\Concerns\Allowable;
use Honed\Core\Concerns\Transformable;
use Honed\Core\Concerns\HasQueryClosure;
use Honed\Refine\Sort;
use Honed\Table\Concerns\IsDisplayable;
use Honed\Table\Concerns\HasClass;
use Honed\Table\Columns\Concerns\IsSortable;
use Honed\Table\Columns\Concerns\IsSearchable;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * @template TBuilder of \Illuminate\Database\Eloquent\Builder<TModel>
 *
 * @extends Primitive<string, mixed>
 */
class Column extends Primitive
{
    use Allowable;
    use HasClass;
    use IsDisplayable;
    use HasAlias;
    use HasExtra;
    use HasIcon;
    use HasLabel;
    use HasName;
    use HasType;
    use IsActive;
    use IsHidden;
    use Transformable;
    /** @use HasQueryClosure<TModel, TBuilder> */
    use HasQueryClosure;

    /**
     * Whether this column represents the record key.
     * 
     * @var bool
     */
    protected $key = false;

    /**
     * The value to display when the column is empty.
     *
     * @var mixed
     */
    protected $fallback;

    /**
     * Set a column as a callback or fixed value.
     *
     * @var mixed
     */
    protected $as;

    /**
     * The column sort.
     * 
     * @var \Honed\Refine\Sort<TModel, TBuilder>|null
     */
    protected $sort;

    /**
     * Whether to search on the column.
     * 
     * @var bool
     */
    protected $searchable = false;


    /**
     * Create a new column instance.
     *
     * @param  string  $name
     * @param  string|null  $label
     * @return static
     */
    public static function make($name, $label = null)
    {
        return resolve(static::class)
            ->name($name)
            ->label($label ?? static::makeLabel($name));
    }


    /**
     * Set this column to represent the record key.
     *
     * @param  bool  $key
     * @return $this
     */
    public function key($key = true)
    {
        $this->key = $key;

        return $this;
    }

    /**
     * Determine whether this column represents the record key.
     *
     * @return bool
     */
    public function isKey()
    {
        return $this->key;
    }

        /**
     * Set the fallback value for the column.
     *
     * @param  mixed  $fallback
     * @return $this
     */
    public function fallback($fallback)
    {
        $this->fallback = $fallback;

        return $this;
    }

    /**
     * Get the fallback value for the column.
     *
     * @return mixed
     */
    public function getFallback()
    {
        return $this->fallback;
    }

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->active(true);
        $this->type('column');
    }

    /**
     * Set how the column value is retrieved.
     *
     * @param  mixed  $as
     * @return $this
     */
    public function as($as)
    {
        $this->as = $as;

        return $this;
    }

    /**
     * Get how the column value is retrieved.
     *
     * @return mixed
     */
    public function getAs()
    {
        return $this->as;
    }

    /**
     * Determine if the column has a retrieved value.
     *
     * @return bool
     */
    public function hasAs()
    {
        return isset($this->as);
    }

    /**
     * Set the column as sortable.
     *
     * @param  \Honed\Refine\Sort<TModel, TBuilder>|string|bool  $sortable
     * @param  string|null  $alias
     * @param  bool  $default
     * @return $this
     */
    public function sortable($sortable = true, $alias = null, $default = false)
    {
        if (! $sortable) {
            return $this->disableSorting();
        }

        return $this->enableSorting($sortable, $alias, $default);
    }

    /**
     * Determine if the column is sortable.
     *
     * @return bool
     */
    public function isSortable()
    {
        return isset($this->sort);
    }

    /**
     * Get the sort instance.
     *
     * @return \Honed\Refine\Sort<TModel, TBuilder>|null
     */
    public function getSort()
    {
        return $this->sort;
    }

        /**
     * Disable sorting for the column.
     *
     * @return $this
     */
    protected function disableSorting()
    {
        $this->sort = null;

        return $this;
    }

    /**
     * Enable sorting for the column.
     *
     * @param  \Honed\Refine\Sort<TModel, TBuilder>|string|bool  $sortable
     * @param  string|null  $alias
     * @param  bool  $default
     * @return $this
     */
    protected function enableSorting($sortable = true, $alias = null, $default = false)
    {
        $this->sort = match (true) {
            $sortable instanceof Sort => $sortable,

            \is_string($sortable) => Sort::make($sortable)
                ->alias($alias ?? $this->getParameter())
                ->default($default),

            default => Sort::make($this->getName())
                ->alias($alias ?? $this->getParameter())
                ->default($default),
        };

        return $this;
    }

    /**
     * Get the sort instance as an array.
     *
     * @return array<string,mixed>
     */
    public function sortToArray()
    {
        $sort = $this->getSort();

        if (! $sort) {
            return [];
        }

        return [
            'active' => $sort->isActive(),
            'direction' => $sort->getDirection(),
            'next' => $sort->getNextDirection(),
        ];
    }

    /**
     * Set the column as searchable.
     *
     * @param  bool  $searchable
     * @return $this
     */
    public function searchable($searchable = true)
    {
        $this->searchable = $searchable;

        return $this;
    }

    /**
     * Determine if the column is searchable.
     *
     * @return bool
     */
    public function isSearchable()
    {
        return $this->searchable;
    }

    /**
     * Get the parameter for the column.
     *
     * @return string
     */
    public function getParameter()
    {
        return $this->getAlias()
            ?? Str::of($this->getName())
                ->replace('.', '_')
                ->value();
    }

    /**
     * Apply the column's transform and format value.
     *
     * @param  mixed  $value
     * @return mixed
     */
    public function apply($value)
    {
        $value = $this->transform($value);

        return $this->formatValue($value);
    }

    /**
     * Format the value of the column.
     *
     * @param  mixed  $value
     * @return mixed
     */
    public function formatValue($value)
    {
        return $value ?? $this->getFallback();
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return [
            'name' => $this->getParameter(),
            'label' => $this->getLabel(),
            'type' => $this->getType(),
            'hidden' => $this->isHidden(),
            'active' => $this->isActive(),
            'toggleable' => $this->isToggleable(),
            'icon' => $this->getIcon(),
            'class' => $this->getClass(),
            'sort' => $this->isSortable() ? $this->sortToArray() : null,
        ];
    }

    /**
     * Get the value of the column to form a record.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  array<string,mixed>  $named
     * @param  array<class-string,mixed>  $typed
     * @return array<string,array{value: mixed, extra: mixed}>
     */
    public function createRecord($model, $named, $typed)
    {
        $as = $this->getAs();

        $value = $as
            ? $this->evaluate($as, $named, $typed)
            : Arr::get($model, $this->getName());

        return [
            $this->getParameter() => [
                'value' => $this->apply($value),
                'extra' => $this->resolveExtra($named, $typed),
            ],
        ];
    }
}
