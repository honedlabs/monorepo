<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Illuminate\Contracts\Database\Eloquent\Builder as BuilderContract;
use Illuminate\Database\Eloquent\Builder;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * @template TBuilder of \Illuminate\Database\Eloquent\Builder<TModel>
 */
trait HasQueryClosure
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
    public function queryClosure($query)
    {
        $this->query = $query;

        return $this;
    }

    /**
     * Get the query closure.
     *
     * @return \Closure(mixed...):void|null
     */
    public function getQueryClosure()
    {
        if (\method_exists($this, 'query')) {
            return \Closure::fromCallable([$this, 'query']);
        }

        return $this->query;
    }

    /**
     * Determine if the query modifier is set.
     *
     * @return bool
     */
    public function hasQueryClosure()
    {
        return isset($this->query) || \method_exists($this, 'query');
    }

    /**
     * Modify the given query using the bindings.
     *
     * @param  TBuilder  $builder
     * @param  array<string, mixed>  $bindings
     */
    public function modifyQuery($builder, $bindings = [])
    {
        $callback = $this->getQueryClosure();

        if (\is_null($callback)) {
            return;
        }

        $callback = $this->rebindQueryClosure($callback, $bindings);

        $callback($builder);
    }

    /**
     * Rebind the query closure with the bindings injected to closure arguments.
     *
     * @param  \Closure(mixed...):void  $closure
     * @param  array<string, mixed>  $bindings
     * @return \Closure(TBuilder):void
     */
    public function rebindQueryClosure($closure, $bindings)
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
