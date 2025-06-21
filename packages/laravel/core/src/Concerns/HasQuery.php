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
trait HasQuery
{
    /**
     * The query closure to modify the Eloquent builder.
     *
     * @var (\Closure(TBuilder, ...mixed):TBuilder|null)|null
     */
    protected $query;

    /**
     * Set the query closure.
     *
     * @param  (\Closure(TBuilder, ...mixed):TBuilder|null)|void|null  $query
     * @return $this
     */
    public function query($query)
    {
        $this->query = $query;

        return $this;
    }

    /**
     * Get the query closure.
     *
     * @return (\Closure(TBuilder, ...mixed):TBuilder|null)|null
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * Determine if the query modifier is set.
     *
     * @return bool
     */
    public function hasQuery()
    {
        return filled($this->query);
    }

    /**
     * Modify the given query using the bindings.
     *
     * @param  TBuilder  $builder
     * @param  array<string, mixed>  $bindings
     */
    public function modifyQuery($builder, $bindings = [])
    {
        $callback = $this->getQuery();

        if (! $callback) {
            return;
        }

        $callback = $this->rebindQuery($callback, $bindings);

        $callback($builder);
    }

    /**
     * Rebind the query closure with the bindings injected to closure arguments.
     *
     * @param  (\Closure(TBuilder, ...mixed):TBuilder|null)|void  $closure
     * @param  array<string, mixed>  $bindings
     * @return (\Closure(TBuilder, ...mixed):TBuilder|null)|void
     */
    public function rebindQuery($closure, $bindings = [])
    {
        return fn ($builder) => $this->evaluate($closure, [
            'builder' => $builder,
            'query' => $builder,
            ...$bindings,
        ], [
            Builder::class => $builder,
            BuilderContract::class => $builder,
        ]);
    }
}
