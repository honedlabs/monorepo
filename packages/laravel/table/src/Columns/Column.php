<?php

declare(strict_types=1);

namespace Honed\Table\Columns;

use Honed\Core\Concerns\Allowable;
use Honed\Core\Concerns\HasAlias;
use Honed\Core\Concerns\HasExtra;
use Honed\Core\Concerns\HasIcon;
use Honed\Core\Concerns\HasLabel;
use Honed\Core\Concerns\HasName;
use Honed\Core\Concerns\HasQuery;
use Honed\Core\Concerns\HasType;
use Honed\Core\Concerns\HasValue;
use Honed\Core\Concerns\IsActive;
use Honed\Core\Concerns\Transformable;
use Honed\Core\Primitive;
use Honed\Refine\Concerns\HasQualifier;
use Honed\Refine\Sort;
use Honed\Table\Columns\Concerns\HasState;
use Honed\Table\Concerns\IsVisible;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model = \Illuminate\Database\Eloquent\Model
 * @template TBuilder of \Illuminate\Database\Eloquent\Builder<TModel> = \Illuminate\Database\Eloquent\Builder<TModel>
 */
class Column extends Primitive
{
    use Allowable;
    use HasAlias;
    use HasExtra;
    use HasIcon;
    use HasLabel;
    use HasName;
    use HasQualifier;

    /** @use \Honed\Core\Concerns\HasQuery<TModel, TBuilder> */
    use HasQuery;

    use HasType;
    use IsActive;
    use Concerns\HasState;
    use Concerns\CanBeKey;
    // use Concerns\CanHavePlaceholder;
    // use Concerns\CanBeSortable;
    // use Concerns\CanBeSearchable;
    // use Concerns\CanBeFilterable;
    // use Concerns\Exportable;
    // use Concerns\Selectable;
    // use Concerns\Toggleable;

    /**
     * The identifier to use for evaluation.
     *
     * @var string
     */
    protected $evaluationIdentifier = 'column';

    /**
     * A callback or fixed value to be used in place of a retrieved value.
     * 
     * @var mixed
     */
    protected $using;

    /**
     * Whether this column is hidden.
     *
     * @var bool
     */
    protected $hidden = false;

    /**
     * The column sort.
     *
     * @var \Honed\Refine\Sort<TModel, TBuilder>|null
     */
    protected $sort;

    /**
     * The database columns to search on.
     *
     * @var bool|string|array<int, string>
     */
    protected $search = false;

    /**
     * How to select this column
     *
     * @var string|bool|array<int,string>
     */
    protected $select = true;

    /**
     * How this column should be exported.
     *
     * @var bool|array<int,string>
     */
    protected $export = true;

    /**
     * The format to export the column in.
     * 
     * @var string|null
     */
    protected $exportFormat;

    /**
     * The style to export the column in.
     * 
     * @var array<string,mixed>|(\Closure(\PhpOffice\PhpSpreadsheet\Style\Style):void)|null
     */
    protected $exportStyle;

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
     * Set the column as sortable.
     *
     * @param  \Honed\Refine\Sort<TModel, TBuilder>|string|bool  $sort
     * @return $this
     */
    public function sort($sort = true)
    {
        $this->sort = match (true) {
            ! $sort => null,
            $sort instanceof Sort => $sort,
            default => $this->newSort($sort),
        };

        return $this;
    }

    /**
     * Create a new sort instance using the column properties.
     *
     * @param  string|bool  $sort
     * @return \Honed\Refine\Sort<TModel, TBuilder>
     */
    protected function newSort($sort)
    {
        $sort = \is_string($sort) ? $sort : $this->getName();

        return Sort::make($sort, $this->getLabel())
            ->qualifies($this->getQualifier())
            ->alias($this->getParameter());
    }

    /**
     * Get the sort.
     *
     * @return \Honed\Refine\Sort<TModel, TBuilder>|null
     */
    public function getSort()
    {
        return $this->sort;
    }

    /**
     * Determine if the column is sortable.
     *
     * @return bool
     */
    public function sorts()
    {
        return (bool) $this->sort;
    }

    /**
     * Set the column as searchable.
     *
     * @param  bool|string|array<int, string>  $search
     * @return $this
     */
    public function search($search = true)
    {
        $this->search = $search;

        return $this;
    }

    /**
     * Get the search columns.
     *
     * @return bool|string|array<int, string>
     */
    public function getSearch()
    {
        if (! $this->search) {
            return false;
        }

        return $this->search;
    }

    /**
     * Determine if the column is searchable.
     *
     * @return bool
     */
    public function searches()
    {
        return (bool) $this->search;
    }

    /**
     * Set how to select this column.
     *
     * @param  bool|string|array<int,string>  $select
     * @return $this
     */
    public function select($select = true)
    {
        $this->select = $select;

        return $this;
    }

    /**
     * Set the column to not be selectable.
     *
     * @return $this
     */
    public function doNotSelect()
    {
        return $this->select(false);
    }

    /**
     * Set the column to not be selectable.
     *
     * @return $this
     */
    public function dontSelect()
    {
        return $this->doNotSelect();
    }

    /**
     * Get the properties to select.
     *
     * @return string|array<int,string>
     */
    public function getSelects()
    {
        if (\is_bool($this->select)) {
            return $this->getName();
        }

        return $this->select;
    }

    /**
     * Determine if the column can be selected.
     *
     * @return bool
     */
    public function selects()
    {
        return (bool) $this->select;
    }

    /**
     * Set whether, and how, the column should be exported.
     * 
     * @param  bool|(\Closure(mixed, TModel):mixed)  $as
     * @param  string|null  $format
     * @param  array<string,mixed>|(\Closure(\PhpOffice\PhpSpreadsheet\Style\Style):void)|null  $style
     * @return $this
     */
    public function export($as = true, $format = null, $style = null)
    {
        $this->export = $as;

        if ($format) {
            $this->exportFormat($format);
        }

        if ($style) {
            $this->exportStyle($style);
        }

        return $this;
    }

    /**
     * Register the callback to be used to export the content of a column.
     * 
     * @param  \Closure(mixed, TModel):mixed  $callback
     * @return $this
     */
    public function exportUsing($callback)
    {
        $this->export = $callback;

        return $this;
    }

    /**
     * Set the column to not be exportable.
     *
     * @return $this
     */
    public function doNotExport()
    {
        return $this->export(false);
    }

    /**
     * Set the column to not be exportable.
     *
     * @return $this
     */
    public function dontExport()
    {
        return $this->export(false);
    }

    /**
     * Get the exporter for the column.
     * 
     * @return bool|\Closure(mixed, TModel):mixed|null
     */
    public function getExporter()
    {
        return $this->export;
    }

    /**
     * Determine if this column is exportable.
     * 
     * @return bool
     */
    public function exports()
    {
        return (bool) $this->export;
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
     * Create a record entry for the column.
     *
     * @param  TModel  $record
     * @param  array<string,mixed>  $named
     * @param  array<class-string,mixed>  $typed
     * @return array<string,array{value:mixed, extra:array<string,mixed>}>
     */
    public function entry($record, $named = [], $typed = [])
    {
        $valueUsing = $this->getValue();

        $value = $this->apply((bool) $valueUsing
            ? $this->evaluate($valueUsing, $named, $typed)
            : Arr::get($record, $this->getName())
        );

        /**
         * [
         *  'v' => mixed // value
         *  'e' => mixed // extra
         *  'c' => string|null // class
         *  'f' => boolean // fallback
         *  ]
         * ]
         */

        return [
            $this->getParameter() => [
                'value' => $value,
                'extra' => $this->getExtra(
                    \array_merge($named, ['value' => $value]),
                    $typed,
                ),
            ],
        ];
    }

    /**
     * Provide the instance with any necessary setup.
     * 
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->active();

        $this->definition($this);
    }

    /**
     * Define the column.
     * 
     * @param $this $column
     * @return $this
     */
    public function definition(Column $column): Column
    {
        return $column;
    }

    /**
     * Add a relationship count to the column.
     * 
     * @param string|array<string, \Closure> $relationship
     * @return $this
     */
    public function count($relationship)
    {
        $this->query(fn (Builder $query) => $query->withCount($relationship));

        return $this;
    }

    public function exists()
    {

    }

    public function avg()
    {

    }

    public function average()
    {

    }

    public function sum()
    {

    }

    public function min()
    {

    }

    public function max()
    {

    }

    /**
     * Get the sort instance as an array.
     *
     * @return array<string,mixed>|null
     */
    public function sortToArray()
    {
        $sort = $this->getSort();

        if (! $sort) {
            return null;
        }

        return [
            'active' => $sort->isActive(),
            'direction' => $sort->getDirection(),
            'next' => $sort->getNextDirection(),
        ];
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
            'toggles' => $this->isToggleable(),
            'icon' => $this->getIcon(),
            'class' => $this->getClass(),
            'sort' => $this->sortToArray(),
        ];
    }
}
