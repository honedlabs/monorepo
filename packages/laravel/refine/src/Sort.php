<?php

declare(strict_types=1);

namespace Honed\Refine;

use Honed\Core\Concerns\HasQueryClosure;
use Honed\Core\Concerns\InterpretsRequest;
use Honed\Core\Concerns\IsDefault;
use Illuminate\Support\Str;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * @template TBuilder of \Illuminate\Database\Eloquent\Builder<TModel>
 */
class Sort extends Refiner
{
    use InterpretsRequest;
    use IsDefault;

    /**
     * The request direction of the sort.
     *
     * @var 'asc'|'desc'|null
     */
    protected $direction;

    /**
     * Indicate that the sort only acts in a single direction.
     *
     * @var 'asc'|'desc'|null
     */
    protected $only;

    /**
     * Invert the direction for sorts which are not singular.
     *
     * @var bool
     */
    protected $invert = false;

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
        $isMatching = $this->getValue() === $this->getParameter();

        if ($this->isSingularDirection()) {
            return $isMatching && $this->getDirection() === $this->only;
        }

        return $isMatching;
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
     * Get the expression partials supported by the sort.
     *
     * @return array<int,string>
     */
    public function expressions()
    {
        return [
            'orderBy',
            'latest',
            'oldest',
        ];
    }

    /**
     * Set the sort to be ascending.
     *
     * @return $this
     */
    public function asc()
    {
        $this->only = 'asc';

        return $this;
    }

    /**
     * Set the sort to be descending.
     *
     * @return $this
     */
    public function desc()
    {
        $this->only = 'desc';

        return $this;
    }

    /**
     * Determine if the sort only acts in a single direction.
     *
     * @return bool
     */
    public function isSingularDirection()
    {
        return isset($this->only);
    }

    /**
     * Invert the direction of the sort.
     *
     * @return $this
     */
    public function invert()
    {
        $this->invert = true;

        return $this;
    }

    /**
     * Determine if the sort is inverted.
     *
     * @return bool
     */
    public function isInverted()
    {
        return $this->invert;
    }

    /**
     * Retrieve the sort value and direction from a request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $key
     * @return array{0: string|null, 1: 'asc'|'desc'|null}
     */
    public function prepareSortAndDirection($request, $key)
    {
        $sort = static::interpretStringable($request, $key);

        // The direction is determined by the presence of a preceding '-'
        // character. Any values after that represent the sort parameter name.
        return match (true) {
            \is_null($sort),
            $sort->isEmpty() => [null, null],
            $sort->startsWith('-') => [$sort->after('-')->value(), 'desc'],
            default => [$sort->value(), 'asc'],
        };
    }

    /**
     * Get the direction to use for the query parameter.
     *
     * @return 'asc'|'desc'|null
     */
    public function getDirection()
    {
        return $this->isSingularDirection() ? $this->only : $this->direction;
    }

    /**
     * Get the next value to use for the query parameter.
     *
     * @return string|null
     */
    public function getNextDirection()
    {
        // If the sort is singular, the next direction can only ever be the
        // direction it is singular in.
        if ($this->isSingularDirection()) {
            return $this->only === 'desc'
                ? $this->getDescendingValue()
                : $this->getAscendingValue();
        }

        // The sort is a FSM, the default being null -> asc -> desc -> null. The
        // user can opt to invert this by calling the `invert` method, which will
        // switch the direction of the sort to be null -> desc -> asc -> null.
        if ($this->isInverted()) {
            return match (true) {
                $this->direction === 'desc' => $this->getAscendingValue(),
                $this->direction === 'asc' => null,
                default => $this->getDescendingValue(),
            };
        }

        // If the sort is not inverted, we can use the default FSM to determine
        // the next direction.
        return match (true) {
            $this->direction === 'desc' => null,
            $this->direction === 'asc' => $this->getDescendingValue(),
            default => $this->getAscendingValue(),
        };
    }

    /**
     * {@inheritdoc}
     */
    public function getParameter()
    {
        return $this->getAlias()
            ?? Str::of($this->getName())
                ->afterLast('.')
                ->when($this->isSingularDirection(),
                    fn ($string) => $string->append('_',
                        type($this->only)->asString())
                )
                ->value();
    }

    /**
     * Get the value for the sort indicating a descending direction.
     *
     * @return string
     */
    public function getDescendingValue()
    {
        if ($this->isSingularDirection()) {
            return $this->getParameter();
        }

        return \sprintf('-%s', $this->getParameter());
    }

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
     * Order the builder using the request.
     *
     * @param  TBuilder  $builder
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $key
     * @return bool
     */
    public function refine($builder, $request, $key)
    {
        [$value, $direction] = $this->prepareSortAndDirection($request, $key);

        $this->value($value);

        if (! $this->isActive()) {
            return false;
        }

        $this->direction($direction);

        if ($this->isSingularDirection()) {
            $direction = $this->only;
        }

        $bindings = [
            'direction' => $direction,
            'value' => $value,
            'column' => $this->getName(),
        ];

        if (! $this->hasQueryClosure()) {
            $this->queryClosure(\Closure::fromCallable([$this, 'defaultQuery']));
        }

        $this->modifyQuery($builder, $bindings);

        return true;
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
