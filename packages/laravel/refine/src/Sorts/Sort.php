<?php

declare(strict_types=1);

namespace Honed\Refine\Sorts;

use Honed\Core\Concerns\IsDefault;
use Honed\Refine\Refiner;

use function array_merge;
use function array_pad;
use function is_null;
use function sprintf;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model = \Illuminate\Database\Eloquent\Model
 * @template TBuilder of \Illuminate\Database\Eloquent\Builder<TModel> = \Illuminate\Database\Eloquent\Builder<TModel>
 *
 * @extends \Honed\Refine\Refiner<TModel, TBuilder>
 */
class Sort extends Refiner
{
    use IsDefault;
    use Concerns\HasDirection;

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
     * Provide the instance with any necessary setup.
     * 
     * @return void
     */
    public function setUp()
    {
        parent::setUp();

        $this->definition($this);
    }

    /**
     * Define the sort instance.
     *
     * @param  \Honed\Refine\Sorts\Sort<TModel, TBuilder>  $sort
     * @return \Honed\Refine\Sorts\Sort<TModel, TBuilder>|void
     */
    protected function definition(Sort $sort)
    {
        return $sort;
    }

    /**
     * {@inheritdoc}
     *
     * @return array{string|null, 'asc'|'desc'|null}|null
     */
    public function getValue()
    {
        /** @var array{string|null, 'asc'|'desc'|null}|null */
        return parent::getValue();
    }

    /**
     * {@inheritdoc}
     */
    public function isActive()
    {
        /** @var array{string|null, 'asc'|'desc'|null}|null */
        $value = $this->getValue();

        if (is_null($value)) {
            return false;
        }

        [$value, $direction] = array_pad($value, 2, null);

        $active = $value === $this->getParameter();

        if ($this->isFixed()) {
            return $active && $direction === $this->fixed;
        }

        return $active;
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

    // /**
    //  * {@inheritdoc}
    //  *
    //  * @param  array{string|null, 'asc'|'desc'|null}  $value
    //  */
    // protected function getBindings($value, $builder)
    // {
    //     [$value, $direction] = $value;

    //     return array_merge(parent::getBindings($value, $builder), [
    //         'direction' => $direction,
    //     ]);
    // }

    /**
     * {@inheritdoc}
     *
     * @param  array{string|null, 'asc'|'desc'|null}  $requestValue
     */
    public function refine($builder, $requestValue)
    {
        $applied = parent::refine($builder, $requestValue);

        $value = $this->getValue();

        if ($applied && $value) {
            [$_, $direction] = $value;

            $this->direction($direction);
        }

        return $applied;
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
}
