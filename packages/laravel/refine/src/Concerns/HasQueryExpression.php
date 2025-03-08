<?php

namespace Honed\Refine\Concerns;

use BadMethodCallException;
use Closure;
use Illuminate\Database\Eloquent\Builder;

trait HasQueryExpression
{
    /**
     * The callback or query method to resolve the refiner.
     * 
     * @var array<string, mixed>|\Closure|null
     */
    protected $using;

    // /**
    //  * Provide a list of supported expressions. This will do a starts with check
    //  * on the statement to determine if it is supported.
    //  * 
    //  * @return array<int,string>
    //  */
    // abstract public function supportedExpressions();

    /**
     * Register the query expression to resolve the refiner.
     * 
     * @param string|\Closure $statement
     * @param string|null $reference
     * @param mixed $operator
     * @param mixed $value 
     * @return $this
     */
    public function using($statement, $reference = null, $operator = null, $value = null)
    {
        if ($statement instanceof Closure) {
            $this->using = $statement;
            return $this;
        }

        if ($reference === null) {
            throw new BadMethodCallException(
                'A column or relation reference is required.'
            );
        }

        $this->using = func_get_args();

        return $this;
    }

    /**
     * Determine if the refiner has a query expression.
     * 
     * @return bool
     */
    public function hasQueryExpression()
    {
        return isset($this->using);
    }

    /**
     * Express the query on the builder.
     * 
     * @param  \Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model>  $builder
     * @param  array<string, mixed>  $bindings
     * @return void
     */
    public function expressQuery($builder, $bindings = [])
    {
        /** @var array<string, mixed>|\Closure $using */
        $using = $this->using;

        // If the expression is a direct closure, we evaluate it immediately.
        // We will apply the bindings directly to the closure without rebinding.
        if ($using instanceof Closure) {
            $this->expressClosure($using, $builder, $bindings);
            return;
        }

        // The behaviour of the expression is now dependent on the number of 
        // arguments, as it will determine whether the arguments can be closures
        // and whether we need to replace bindings.
        $numArgs = \count($using);

        [$statement, $reference, $operator, $value] = \array_pad($using, 4, null);

        // If there are only 2 arguments, we have a query method and a column
        // or relation reference. As we know this is a string, we should replace
        // any bindings if they exist. This is applicable to all expressions.
        $reference = $this->replaceBindings($reference, $bindings);

        if ($numArgs === 2) {
            $builder->{$statement}($reference);
            return;
        }

        // We need to make an assumption about the operator. Some query builder
        // methods (`whereHas`) require this to be a closure. However, this value
        // may also not be a specific value, or operator. If it is a closure, we
        // need to rebind it as it may be requiring a binding injection.
        if ($operator instanceof Closure) {
            $builder->{$statement}($reference, $this->rebindClosure($operator, $builder, $bindings));
            return;
        }

        // As it is not a closure, we need to determine whether the operator is 
        // an operator or refers to a value.
        [$operator, $value] = $this->prepareOperator($operator, $value, $builder, $bindings);

        $builder->{$statement}($reference, $operator, $value);
    }

    /**
     * Express the callback on the builder.
     * 
     * @param  \Closure  $closure
     * @param  \Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model>  $builder
     * @param  array<string, mixed>  $bindings
     * @return void
     */
    public function expressClosure($closure, $builder, $bindings)
    {
        $model = $builder->getModel();

        $this->evaluate($closure, [
            'builder' => $builder,
            'query' => $builder,
            ...$bindings,
        ], [
            Builder::class => $builder,
            $model::class => $model,
        ]);
    }

    /**
     * Replace the bindings in the reference.
     * 
     * @param string $reference
     * @param array<string, mixed> $bindings
     * @return string
     */
    public function replaceBindings($reference, $bindings)
    {
        if (! \is_string($reference)) {
            return $reference;
        }

        foreach ($bindings as $key => $value) {
            if ($reference === ':'.$key) {
                return $value;
            }
            $reference = \str_replace(':' . $key, $value, $reference);
        }

        return $reference;
    }

    public function rebindClosure($closure)
    {
        dd($closure);
        return fn ($builder) => $closure($builder, $this->value);
    }

    /**
     * Prepare the value and operator for a query clause.
     * 
     * @param mixed $value
     * @param mixed $operator
     * @param \Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model> $builder
     * @return array<mixed, mixed>
     */
    public function prepareOperator($operator, $value, $builder, $useDefault)
    {
        if ($operator && $this->invalidOperatorAndValue($operator, $value)) {
            throw new InvalidArgumentException('Illegal operator and value combination.');
        }

        return [$value, $operator];
    }

    /**
     * Determine if the given operator and value combination is legal.
     *
     * Prevents using Null values with invalid operators.
     *
     * @param  string  $operator
     * @param  mixed  $value
     * @return bool
     */
    protected function invalidOperatorAndValue($operator, $value)
    {
        return is_null($value) && in_array($operator, $this->operators) &&
             ! in_array($operator, ['=', '<>', '!=']);
    }

    public function __call($method, $parameters)
    {
        return $this->using($method, ...$parameters);
    }
}