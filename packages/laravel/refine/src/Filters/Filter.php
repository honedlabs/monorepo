<?php

declare(strict_types=1);

namespace Honed\Refine\Filters;

use Closure;
use Honed\Refine\Refiner;
use Illuminate\Http\Request;
use Honed\Core\Concerns\HasScope;
use Illuminate\Support\Collection;
use Honed\Core\Concerns\Validatable;
use Honed\Refine\Filters\Concerns\HasOptions;
use Honed\Refine\Concerns\InterpretsRequest;
use Honed\Refine\Refinement;

class Filter extends Refiner
{
    use HasScope;
    use Validatable;
    use HasOptions;
    use InterpretsRequest;

    /**
     * The statement, or callback, to use to resolve the filter.
     *
     * @var \Honed\Refine\Refinement|\Closure|null
     */
    protected $using;

    /**
     * Register a closure to use as the filter statement.
     * 
     * @param  \Closure  $using
     * @return $this
     */
    public function using(\Closure $using)
    {
        $this->using = $using;

        return $this;
    }

    /**
     * Register a clause to use as the filter refinement.
     * 
     * @param  string|\Closure  $using
     * @param  mixed  $column
     * @param  mixed  $operator
     * @param  mixed  $value
     * @return $this
     */
    public function refinement($statement, $columnOrRelation = null, $operator = '=', $value = null)
    {
        if ($statement instanceof Closure) {
            return $this->using($statement);
        }

        $this->using = new Refinement(...func_get_args());

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function setUp()
    {
        $this->type('filter');
    }

    /**
     * {@inheritdoc}
     */
    public function getUniqueKey()
    {
        return \sprintf(
            '%s.%s.%s',
            $this->getName(),
            $this->getOperator(),
            $this->getMode(),
        );
    }

    /**
     * Determine if the filter is active.
     *
     * @return bool
     */
    public function isActive()
    {
        return $this->hasValue();
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return \array_merge(parent::toArray(), [
            'value' => $this->getValue(),
            'options' => $this->optionsToArray(),
            'multiple' => $this->isMultiple(),
        ]);
    }

    /**
     * Filter the builder using the request.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model>  $builder
     * @param  \Illuminate\Http\Request  $request
     * @return bool
     */
    public function apply($builder, $request)
    {
        $queryParameter = $this->formatScope($this->getParameter());
        $value = $this->interpret($request, $queryParameter);

        $this->value($value);

        if (! $this->isActive() || ! $this->validate($value)) {
            return false;
        }

        $this->handle($builder, $value);

        return true;
    }

    /**
     * Add the filter query scope to the builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model>  $builder
     * @param  mixed  $value
     * @return void
     */
    public function handle($builder, $value)
    {
        if ($this->hasQueryCallback()) {

            $this->applyQueryCallback($builder, $value);

            return;
        }

        if ($this->hasRefinement()) {

            $this->applyRefinement($builder, $value);

            return;
        }

        $statement = $this->getStatement();
        $column = $this->getColumn();
        $operator = $this->getOperator();
        

        $this->applyBinding($builder, $value);
    }

    /**
     * Set the operator for the filter.
     *
     * @param  string  $operator
     * @return $this
     */
    public function operator($operator)
    {
        $this->operator = $operator;

        return $this;
    }

    /**
     * Set the operator to not.
     *
     * @return $this
     */
    public function not()
    {
        return $this->operator(self::Not);
    }

    /**
     * Set the operator to greater than.
     *
     * @return $this
     */
    public function gt()
    {
        return $this->operator(self::GreaterThan);
    }

    /**
     * Set the operator to less than or equal to.
     *
     * @return $this
     */
    public function lt()
    {
        return $this->operator(self::LessThan);
    }

    /**
     * Get the operator for the filter.
     *
     * @return string
     */
    public function getOperator()
    {
        return $this->operator;
    }
}
