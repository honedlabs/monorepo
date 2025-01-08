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
     * @param \Closure|bool $allow
     * @return $this
     */
    public function allow($allow)
    {
        $this->allow = $allow;

        return $this;
    }

    /**
     * @param array<string,mixed> $named
     * @param array<string,mixed> $typed
     * @return bool
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
     * @param \Illuminate\Database\Eloquent\Model $model
     * @return bool
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