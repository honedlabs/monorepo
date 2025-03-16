<?php

declare(strict_types=1);

namespace Honed\Refine;

use Honed\Core\Concerns\InterpretsRequest;
use Honed\Core\Concerns\IsDefault;
use Honed\Refine\Concerns\HasDirection;
use Illuminate\Support\Str;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * @template TBuilder of \Illuminate\Database\Eloquent\Builder<TModel>
 */
class Sort extends Refiner
{
    use IsDefault;
    use HasDirection;

    /**
     * Get the value for the sort indicating an ascending direction.
     *
     * @return string
     */
    public function getAscendingValue()
    {
        return $this->getParameter();
    }

    /**
     * Get the value for the sort indicating a descending direction.
     *
     * @return string
     */
    public function getDescendingValue()
    {
        $parameter = $this->getParameter();

        if ($this->isFixed()) {
            return $parameter;
        }

        return \sprintf('-%s', $parameter);
    }

    /**
     * Get the next value to use for the query parameter.
     *
     * @return string|null
     */
    public function getNextDirection()
    {
        $ascending = $this->getAscendingValue();
        $descending = $this->getDescendingValue();

        if ($this->isFixed()) {
            return $this->only === 'desc' ? $ascending : $descending;
        }

        $inverted = $this->isInverted();

        return match (true) {
            $this->isAscending() => $inverted ? null : $descending,
            $this->isDescending() => $inverted ? $ascending : null,
            default => $inverted ? $descending : $ascending,
        };
    }

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->type('sort');
    }

    /**
     * {@inheritdoc}
     */
    public function isActive()
    {
        [$value, $direction] = \array_pad($this->getValue(), 2, null);

        $active = $value === $this->getParameter();

        if ($this->isFixed()) {
            return $active && $direction === $this->only;
        }

        return $active;
    }

    /**
     * {@inheritdoc}
     * 
     * @param  array{string|null, 'asc'|'desc'|null}  $value
     * @return array{string|null, 'asc'|'desc'|null}
     */
    public function getRequestValue($value)
    {
        [$value, $direction] = $value;

        if ($this->isFixed()) {
            $direction = $this->only;
        }

        return [$value, $direction];
    }

    /**
     * {@inheritdoc}
     */
    public function guessParameter()
    {
        $parameter = parent::guessParameter();

        if ($this->isFixed()) {
            $parameter = $parameter . '_' . $this->only;
        }

        return $parameter;
    }

    /**
     * {@inheritdoc}
     * 
     * @param  array{string|null, 'asc'|'desc'|null}  $value
     */
    public function getBindings($value)
    {
        [$value, $direction] = $value;

        return \array_merge(parent::getBindings($value), [
            'direction' => $direction,
        ]);
    }

    /**
     * {@inheritDoc}
     */
    public function toArray()
    {
        return \array_merge(parent::toArray(), [
            'direction' => $this->getDirection(),
            'next' => $this->getNextDirection(),
        ]);
    }

    /**
     * Apply the default sort query scope to the builder.
     *
     * @param  TBuilder  $builder
     * @param  string  $column
     * @param  'asc'|'desc'|null  $direction
     * @return void
     */
    public function defaultQuery($builder, $column, $direction)
    {
        $column = $builder->qualifyColumn($column);

        $builder->orderBy($column, $direction ?? 'asc');
    }
}
