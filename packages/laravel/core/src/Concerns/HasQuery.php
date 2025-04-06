<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Honed\Core\Contracts\HasQuery as HasQueryContract;
use Illuminate\Contracts\Database\Eloquent\Builder as BuilderContract;
use Illuminate\Database\Eloquent\Builder;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * @template TBuilder of \Illuminate\Database\Eloquent\Builder<TModel>
 *
 * @method static \Closure(mixed...):void|null defineQuery()
 */
trait HasQuery
{
    /**
     * The query closure to modify the Eloquent builder.
     *
     * @var \Closure(mixed...):void|null
     */
    protected $query;

    /**
     * Set the query closure.
     *
     * @param  \Closure(mixed...):void|null  $query
     * @return $this
     */
    public function query($query)
    {
        $this->query = $query;

        return $this;
    }

    /**
     * Define the query closure.
     *
     * @return \Closure(mixed...):void|null
     */
    public function defineQuery()
    {
        return null;
    }

    /**
     * Get the query closure.
     *
     * @return \Closure(mixed...):void|null
     */
    public function getQuery()
    {
        if (isset($this->query)) {
            return $this->query;
        }

        return $this->query ??= $this->defineQuery();
    }

    /**
     * Determine if the query modifier is set.
     *
     * @return bool
     */
    public function hasQuery()
    {
        return isset($this->getQuery());
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
     * @param  \Closure(mixed...):void  $closure
     * @param  array<string, mixed>  $bindings
     * @return \Closure(TBuilder):void
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
