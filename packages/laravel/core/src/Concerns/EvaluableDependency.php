<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

/**
 * @internal
 */
trait EvaluableDependency
{
    /**
     * Evaluate the closure using injected named and typed parameters.
     *
     * @param  mixed  $value
     * @param  array<string,mixed>  $named
     * @param  array<string,mixed>  $typed
     * @return mixed
     */
    abstract public function evaluate($value, $named = [], $typed = []);

    /**
     * Evaluate the trait method from a model. This method should have the name overriden to prevent clashes.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $value  The model to evaluate the trait from.
     * @param  string  $method  The method to call on the class
     * @return mixed The evaluated trait.
     */
    private function evaluateModelForTrait($value, $method)
    {
        return \call_user_func([$this, $method], [ // @phpstan-ignore-line
            'model' => $value,
            'record' => $value,
            'resource' => $value,
            str($value->getTable())->singular()->camel()->toString() => $value,
        ], [
            \Illuminate\Database\Eloquent\Model::class => $value,
            $value::class => $value,
        ]);
    }
}
