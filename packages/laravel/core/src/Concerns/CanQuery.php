<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Closure;
use Illuminate\Database\Eloquent\Builder;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model = \Illuminate\Database\Eloquent\Model
 * @template TBuilder of \Illuminate\Database\Eloquent\Builder<TModel> = \Illuminate\Database\Eloquent\Builder<TModel>
 */
trait CanQuery
{
    /**
     * The query closure to modify the Eloquent builder.
     *
     * @var (\Closure(TBuilder, ...mixed):mixed|void)|null
     */
    protected $query;

    /**
     * Set a callback to modify the Eloquent builder.
     *
     * @param  (\Closure(TBuilder, ...mixed):mixed|void)|null  $callback
     * @return $this
     */
    public function query($callback)
    {
        $this->query = $callback;

        return $this;
    }

    /**
     * Get the callback to modify the Eloquent builder.
     *
     * @return (\Closure(TBuilder, ...mixed):mixed|void)|null
     */
    public function queryCallback()
    {
        return $this->query;
    }

    /**
     * Call the callback to modify the Eloquent builder.
     *
     * @param  array<string, mixed>  $named
     * @param  array<class-string, mixed>  $typed
     * @return mixed
     */
    public function callQuery($named = [], $typed = [])
    {
        return $this->evaluate($this->queryCallback(), $named, $typed);
    }
}
