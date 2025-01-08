<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait Allowable
{
    /**
     * @var \Closure|bool
     */
    protected $allow = true;

    /**
     * Evaluate the closure using injected named and typed parameters.
     *
     * @param mixed $value
     * @param array<string,mixed> $named
     * @param array<string,mixed> $typed
     * @return mixed
     */
    abstract public function evaluate($value, $named = [], $typed = []);

    /**
     * Set the allow condition for the instance.
     * 
     * @param \Closure|bool $allow The allow condition to be set.
     * @return $this
     */
    public function allow($allow)
    {
        $this->allow = $allow;

        return $this;
    }

    /**
     * Determine if the instance allows the given parameters.
     * 
     * @param array<string,mixed> $named The named parameters to inject into the allow condition, if provided.
     * @param array<string,mixed> $typed The typed parameters to inject into the allow condition, if provided.
     * @return bool True if the allow condition evaluates to true, false otherwise.
     */
    public function allows($named = [], $typed = [])
    {
        return (bool) $this->evaluate(
            $this->allow,
            $named,
            $typed
        );
    }

    /**
     * Determine if the instance allows the given model using generated closure parameters to be injected.
     * 
     * @param \Illuminate\Database\Eloquent\Model $model The model to check.
     * @return bool True if the allow condition evaluates to true, false otherwise.
     */
    public function allowsModel($model)
    {
        return $this->allows([
            'model' => $model,
            'record' => $model,
            'resource' => $model,
            str($model->getTable())->singular()->camel()->toString() => $model,
        ], [
            \Illuminate\Database\Eloquent\Model::class => $model,
            $model::class => $model
        ]);
    }
}