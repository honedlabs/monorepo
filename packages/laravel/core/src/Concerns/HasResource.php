<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * @template TBuilder of \Illuminate\Database\Eloquent\Builder<TModel>
 */
trait HasResource
{
    /**
     * The builder instance.
     *
     * @var TBuilder|null
     */
    protected $resource;

    /**
     * Set the builder resource.
     *
     * @param  TBuilder|TModel|class-string<TModel>  $resource
     * @return $this
     *
     * @throws \InvalidArgumentException
     */
    public function resource($resource)
    {
        $this->resource = $this->createResource($resource);

        return $this;
    }

    /**
     * Define the builder resource.
     *
     * @return TBuilder|TModel|class-string<TModel>|null
     */
    public function defineResource()
    {
        return null;
    }

    /**
     * Get the builder instance.
     *
     * @return TBuilder
     *
     * @throws \RuntimeException
     * @throws \InvalidArgumentException
     */
    public function getResource()
    {
        if (isset($this->resource)) {
            return $this->resource;
        }

        if ($resource = $this->defineResource()) {
            return $this->resource ??= $this->asBuilder($resource);
        }

        static::throwResourceException();
    }

    /**
     * Determine if the builder instance has been set.
     *
     * @return bool
     */
    public function hasResource()
    {
        return isset($this->getResource());
    }

    /**
     * Create a new builder instance from a resource.
     *
     * @param  TBuilder|TModel|class-string<TModel>  $resource
     * @return TBuilder
     */
    public static function asBuilder($resource)
    {
        if ($resource instanceof Builder) {
            return $resource;
        }

        if ($resource instanceof Model) {
            return $resource::query();
        }

        if (\is_string($resource) && \class_exists($resource)) {
            return $resource::query();
        }

        static::throwInvalidResourceException();
    }

    /**
     * Throw a missing resource exception.
     *
     * @param  string  $message
     * @return never
     *
     * @throws \RuntimeException
     */
    public static function throwResourceException()
    {
        throw new \RuntimeException(
            \sprintf(
                'Resource has not been set for [%s].',
                static::class
            )
        );
    }

    /**
     * Throw an invalid builder exception.
     *
     * @param  string  $message
     * @return never
     *
     * @throws \InvalidArgumentException
     */
    public static function throwInvalidResourceException()
    {
        throw new \InvalidArgumentException(
            \sprintf(
                'No builder instance can be synthesized for given resource [%s].',
                static::class
            )
        );
    }
}
