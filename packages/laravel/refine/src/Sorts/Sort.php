<?php

declare(strict_types=1);

namespace Honed\Refine\Sorts;

use Closure;
use Honed\Core\Concerns\IsDefault;
use Honed\Refine\Refiner;

use function array_merge;
use function sprintf;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model = \Illuminate\Database\Eloquent\Model
 * @template TBuilder of \Illuminate\Database\Eloquent\Builder<TModel> = \Illuminate\Database\Eloquent\Builder<TModel>
 *
 * @extends \Honed\Refine\Refiner<TModel, TBuilder>
 */
class Sort extends Refiner
{
    use Concerns\HasDirection;
    use IsDefault;

    /**
     * Provide the instance with any necessary setup.
     *
     * @return void
     */
    protected function setUp()
    {
        parent::setUp();

        $this->definition($this);
    }

    /**
     * Define the type of the sort.
     *
     * @return string
     */
    public function type()
    {
        return 'sort';
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

        return sprintf('-%s', $parameter);
    }

    /**
     * Get the next value to use for the query parameter.
     *
     * @return string|null
     */
    public function getNextDirection()
    {
        return match (true) {
            $this->isFixed() => $this->getFixedValue(),
            $this->isInverted() => $this->getInvertedValue(),
            default => match (true) {
                $this->isAscending() => $this->getDescendingValue(),
                $this->isDescending() => $this->getAscendingValue(),
                default => null,
            },
        };
    }

    /**
     * {@inheritdoc}
     *
     * @param  array{string|null, 'asc'|'desc'|null}  $requestValue
     */
    public function handle($query, $parameter, $direction)
    {
        $this->active(
            $active = $this->checkIfActive($parameter, $direction)
        );

        if (! $active) {
            return false;
        }

        if (! $this->hasQuery()) {
            $this->query(Closure::fromCallable([$this, 'apply']));
        }

        $this->modifyQuery($query, [
            ...$this->getBindings($parameter, $query),
            'parameter' => $parameter,
            'direction' => $direction,
        ]);

        return true;
    }

    /**
     *  Apply the default sort query scope to the builder.
     *
     * @param  TBuilder  $builder
     * @param  string  $column
     * @param  'asc'|'desc'|null  $direction
     * @return void
     */
    public function apply($builder, $column, $direction)
    {
        $builder->orderBy($column, $direction ?? 'asc');
    }

    /**
     * {@inheritDoc}
     */
    public function toArray($named = [], $typed = [])
    {
        return array_merge(parent::toArray(), [
            'direction' => $this->getDirection(),
            'next' => $this->getNextDirection(),
        ]);
    }

    /**
     * Define the sort instance.
     *
     * @param  Sort<TModel, TBuilder>  $sort
     * @return Sort<TModel, TBuilder>|void
     */
    protected function definition(self $sort)
    {
        return $sort;
    }

    /**
     * Get the fixed direction.
     *
     * @return 'asc'|'desc'|null
     */
    protected function getFixedValue()
    {
        if ($this->isNotFixed()) {
            return null;
        }

        return $this->isFixedAscending()
            ? $this->getAscendingValue()
            : $this->getDescendingValue();
    }

    /**
     * Get the inverted value.
     *
     * @return string|null
     */
    protected function getInvertedValue()
    {
        return match (true) {
            $this->isAscending() => null,
            $this->isDescending() => $this->getAscendingValue(),
            default => $this->getDescendingValue(),
        };
    }

    /**
     * {@inheritdoc}
     */
    protected function checkIfActive($parameter, $direction)
    {
        $match = $parameter === $this->getParameter();

        return match (true) {
            $this->isFixed($direction) => $match,
            default => $match,
        };
    }

    /**
     * {@inheritdoc}
     */
    protected function guessParameter()
    {
        $parameter = parent::guessParameter();

        if ($this->fixed) {
            $parameter = $parameter.'_'.$this->fixed;
        }

        return $parameter;
    }
}
