<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Honed\Core\Contracts\Builds;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * @template TBuilder of \Illuminate\Database\Eloquent\Builder<TModel>
 */
trait HasBuilderInstance
{
    /**
     * The builder instance.
     *
     * @var TBuilder|null
     */
    protected $builder;

    /**
     * Set the builder instance.
     *
     * @param  TBuilder|TModel|class-string<TModel>  $builder
     * @return $this
     *
     * @throws \InvalidArgumentException
     */
    public function builder($builder)
    {
        $this->builder = $this->createBuilder($builder);

        return $this;
    }

    /**
     * Get the builder instance.
     *
     * @return TBuilder
     *
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    public function getBuilder()
    {
        if (isset($this->builder)) {
            return $this->builder;
        }

        if ($this instanceof Builds) {
            return $this->builder ??= $this->createBuilder($this->for());
        }

        static::throwBuilderException();
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
     * Create a new builder instance.
     *
     * @param  TBuilder|TModel|class-string<TModel>  $query
     * @return TBuilder
     */
    public static function createBuilder($query)
    {
        if ($query instanceof Builder) {
            return $query;
        }

        if ($query instanceof Model) {
            return $query::query();
        }

        if (\is_string($query) && \class_exists($query)) {
            return $query::query();
        }

        static::throwInvalidBuilderException();
    }

    /**
     * Throw a missing builder exception.
     *
     * @param  string  $message
     * @return never
     */
    protected static function throwBuilderException()
    {
        throw new \RuntimeException(\sprintf(
            'Builder instance has not been set for [%s].',
            static::class
        ));
    }

    /**
     * Throw an invalid builder exception.
     *
     * @param  string  $message
     * @return never
     */
    protected static function throwInvalidBuilderException()
    {
        throw new \InvalidArgumentException(\sprintf(
            'No builder instance can be synthesized for [%s].',
            static::class
        ));
    }
}
