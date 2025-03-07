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
    use HasOptions {
        multiple as protected setMultiple;
    }
    use InterpretsRequest;

    /**
     * The refinement, or callback, to use to resolve the filter.
     *
     * @var \Honed\Refine\Refinement|\Closure|null
     */
    protected $using;

    /**
     * The operator to use for the filter.
     * 
     * @var string
     */
    protected $operator = '=';

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
    public function refinement($statement, $columnOrRelation, $operator = '=', $value = null)
    {
        if ($statement instanceof Closure) {
            return $this->using($statement);
        }

        $this->using = new Refinement(...func_get_args());

        return $this;
    }

    /**
     * Allow multiple values to be used.
     * 
     * @return $this
     */
    public function multiple()
    {
        $this->setMultiple();
        $this->asArray();
        $this->type('set');

        return $this;
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

    /**
     * Determine if the value is invalid.
     * 
     * @param  mixed  $value
     * @return bool
     */
    public function invalidValue($value)
    {
        return ! $this->isActive() || ! $this->validate($value);
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
        $key = $this->formatScope($this->getParameter());
        $value = $this->interpret($request, $key);

        $this->value($value);

        if ($this->invalidValue($value)) {
            return false;
        }

        match (true) {
            $this->using instanceof Closure => $this->handleCallback($builder, $value),
            $this->using instanceof Refinement => $this->handleRefinement($builder, $value),
            default => $this->handle($builder, $value),
        };
        
        return true;
    }

    /**
     * Handle the filter callback using a refiner.
     * 
     * @param  \Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model>  $builder
     * @param  mixed  $value
     * @return void
     */
    protected function handleCallback($builder, $value)
    {
        $model = $builder->getModel();

        $this->evaluate($this->getCallback(), [
            'builder' => $builder,
            'query' => $builder,
            'value' => $value,
            'table' => $model->getTable(),
            'options' => $this->getOptions(),
        ], [
            Builder::class => $builder,
            $model::class => $model,
        ]);
    }

    /**
     * Handle the filter refinement using a custom refinement.
     * 
     * @param  \Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model>  $builder
     * @param  mixed  $value
     * @return void
     */
    protected function handleRefinement($builder, $value)
    {
        $this->using->refine($builder, $value);
    }

    /**
     * Handle the filter using a default refinement.
     * 
     * @param  \Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model>  $builder
     * @param  mixed  $value
     * @return void
     */
    protected function handle($builder, $value)
    {
        $column = $builder->qualifyColumn($this->getName());
        $operator = $this->getOperator();

        $statement = match (true) {
            \in_array($operator, 
                ['like', 'not like', 'ilike', 'not ilike']
            ) => $builder->whereRaw("{$column} {$operator} ?", ['%'.$value.'%']),

            $this->isMultiple(),
            $this->interpretsArray() => $builder->whereIn($column, $value),

            $this->interpretsDate() => $builder->whereDate($column, $operator, $value),

            $this->interpretsTime() => $builder->whereTime($column, $operator, $value),

            default => $builder->where($column, $operator, $value),
        };

        $statement->toSql();
    }

    /**
     * Get the operator to use for the filter.
     * 
     * @return string
     */
    public function getOperator()
    {
        return $this->operator;
    }

    /**
     * Set the operator to use for the filter.
     * 
     * @param  string  $operator
     * @return $this
     */
    public function operator($operator)
    {
        $this->operator = $operator;

        return $this;
    }
}
