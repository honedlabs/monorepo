<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Closure;
use Illuminate\Contracts\Database\Eloquent\Builder as BuilderContract;
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
     * @param  (\Closure(TBuilder, ...mixed):mixed|void)|null  $query
     * @return $this
     */
    public function query($query)
    {
        $this->query = $query;

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
     * @return mixed
     */
    public function callQuery()
    {
        return $this->evaluate($this->queryCallback());
    }
}
