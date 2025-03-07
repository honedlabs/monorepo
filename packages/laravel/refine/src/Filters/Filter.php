<?php

declare(strict_types=1);

namespace Honed\Refine\Filters;

use Closure;
use Honed\Refine\Refiner;
use BadMethodCallException;
use Honed\Refine\Refinement;
use Illuminate\Http\Request;
use Honed\Core\Concerns\HasScope;
use Illuminate\Support\Collection;
use Honed\Core\Concerns\Validatable;
use Illuminate\Database\Eloquent\Builder;
use Honed\Refine\Concerns\InterpretsRequest;
use Honed\Refine\Filters\Concerns\HasOptions;

/**
 * @mixin \Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model>
 */
class Filter extends Refiner
{
    use HasScope;
    use Validatable;
    use HasOptions;
    use InterpretsRequest;

    /**
     * The refinement, or callback, to use to resolve the filter.
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

        // Hide the validation of query parameters
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
        if ($this->hasCallback()) {
            $this->handleCallback($builder, $value);
            return;
        }

        if ($this->hasRefinement()) {
            $this->handleRefinement($builder, $value);
            return;
        }

        $statement = $this->getStatement();
        $column = $this->getColumn();
        $operator = $this->getOperator();
        

        $this->applyBinding($builder, $value);
    }

    /**
     * Use the callback to refine the builder.
     * 
     * @param  \Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model>  $builder
     * @param  mixed  $value
     * @return void
     */
    public function useCallback($builder, $value)
    {
        $model = $builder->getModel();

        $this->evaluate($this->getCallback(), [
            'builder' => $builder,
            'query' => $builder,
            'value' => $value,
        ], [
            Builder::class => $builder,
            $model::class => $model,
        ]);

    }

    /**
     * Dynamically handle calls to the class.
     * 
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters)
    {
        try {
            return parent::__call($method, $parameters);
        } catch (BadMethodCallException $e) {
            return $this->refinement($method, ...$parameters);
        }
    }
}
