<?php

declare(strict_types=1);

namespace Honed\Table\Columns;

use Honed\Core\Primitive;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;
use Honed\Core\Concerns\IsKey;
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
use Honed\Table\Columns\Concerns\HasClass;
use Honed\Table\Columns\Concerns\IsSortable;
use Honed\Table\Columns\Concerns\IsSearchable;
use Honed\Table\Columns\Concerns\IsToggleable;

/**
 * @extends Primitive<string, mixed>
 */
class Column extends Primitive
{
    use Allowable;
    use HasClass;
    use IsSearchable;
    use IsSortable;
    use IsToggleable;
    use HasAlias;
    use HasExtra;
    use HasIcon;
    use HasLabel;
    use HasName;
    use HasType;
    use IsActive;
    use IsHidden;
    use IsKey;
    use Transformable;

    /**
     * A closure to augment the builder.
     *
     * @var \Closure(\Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model>):void|null
     */
    protected $augment;

    /**
     * The value to display when the column is empty.
     *
     * @var mixed
     */
    protected $fallback;

    /**
     * Set a column using a callback or fixed value.
     *
     * @var mixed
     */
    protected $using;

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->active(true);
        $this->type('column');
    }

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
     * Augment the builder for the column.
     *
     * @param  \Closure(\Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model>):void  $augment
     * @return $this
     */
    public function augment($augment)
    {
        $this->augment = $augment;

        return $this;
    }

    /**
     * Get the augment callback for the column.
     *
     * @return \Closure(\Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model>):void|null
     */
    public function getAugment()
    {
        return $this->augment;
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
     * Set how the column value is retrieved.
     *
     * @param  mixed  $using
     * @return $this
     */
    public function using($using)
    {
        $this->using = $using;

        return $this;
    }

    /**
     * Get how the column value is retrieved.
     *
     * @return mixed
     */
    public function getUsing()
    {
        return $this->using;
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
        $using = $this->getUsing();

        $value = $using
            ? $this->evaluate($using, $named, $typed)
            : Arr::get($model, $this->getName());

        return [
            $this->getParameter() => [
                'value' => $this->apply($value),
                'extra' => $this->resolveExtra($named, $typed),
            ],
        ];
    }
}
