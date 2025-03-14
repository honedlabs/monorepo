<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @template TBuilder of \Illuminate\Database\Eloquent\Builder
 * @template TModel of \Illuminate\Database\Eloquent\Model
 */
trait HasBuilderInstance
{
    /**
     * The builder instance for the instance.
     *
     * @var TBuilder<TModel>|null
     */
    protected $builder;

    /**
     * Set the builder instance.
     *
     * @param  TBuilder<TModel>  $builder
     * @return $this
     */
    public function builder($builder)
    {
        $this->builder = $builder;

        return $this;
    }

    /**
     * Determine if the builder instance has been set.
     *
     * @return bool
     */
    public function hasBuilder()
    {
        return isset($this->builder);
    }

    /**
     * Get the builder instance.
     *
     * @return TBuilder<TModel>
     *
     * @throws \RuntimeException
     */
    public function getBuilder()
    {
        if (! $this->hasBuilder()) {
            static::throwMissingBuilderException();
        }

        return $this->builder;
    }

    /**
     * Create a new builder instance.
     *
     * @param  TModel|class-string<TModel>|TBuilder<TModel>  $query
     * @return TBuilder<TModel>
     */
    public static function createBuilder($query)
    {
        if ($query instanceof Model) {
            return $query::query();
        }

        if (\is_string($query) && \class_exists($query)) {
            return $query::query();
        }

        if (! $query instanceof Builder) {
            static::throwInvalidBuilderException();
        }

        return $query;
    }

    /**
     * Throw a missing builder exception.
     *
     * @return never
     *
     * @throws \RuntimeException
     */
    protected static function throwMissingBuilderException()
    {
        throw new \RuntimeException(
            'Builder instance has not been set.'
        );
    }

    /**
     * Throw an invalid builder exception.
     *
     * @return never
     *
     * @throws \InvalidArgumentException
     */
    protected static function throwInvalidBuilderException()
    {
        throw new \InvalidArgumentException(
            'Expected a model class name or a query instance.'
        );
    }
}
