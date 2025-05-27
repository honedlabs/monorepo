<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Honed\Core\Exceptions\ResourceNotSetException;
use Honed\Core\Exceptions\InvalidResourceException;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model = \Illuminate\Database\Eloquent\Model
 * @template TBuilder of \Illuminate\Database\Eloquent\Builder<TModel> = \Illuminate\Database\Eloquent\Builder<TModel>
 */
trait HasResource
{
    /**
     * The builder instance.
     *
     * @var TBuilder|mixed|null
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
    public function withResource($resource)
    {
        $this->resource = $this->throughBuilder($resource);

        return $this;
    }

    /**
     * Define the builder resource.
     *
     * @return TBuilder|TModel|class-string<TModel>|null
     */
    public function resource()
    {
        return null;
    }

    /**
     * Get the builder instance.
     *
     * @return TBuilder
     *
     * @throws \Honed\Core\Exceptions\InvalidResourceException
     * @throws \Honed\Core\Exceptions\ResourceNotSetException
     */
    public function getResource()
    {
        $resource = $this->resource ??= $this->throughBuilder($this->resource());

        if (! $resource) {
            ResourceNotSetException::throw(static::class);
        }

        return $resource;
    }

    /**
     * Determine if the builder instance has been set.
     *
     * @return bool
     */
    public function hasResource()
    {
        return filled($this->getResource());
    }

    /**
     * Create a new builder instance from a resource.
     *
     * @param  TBuilder|TModel|class-string<TModel>  $resource
     * @return TBuilder|null
     *
     * @throws \Honed\Core\Exceptions\InvalidResourceException
     */
    public static function throughBuilder($resource)
    {
        return match (true) {
            ! $resource => null,
            $resource instanceof Builder => $resource,
            $resource instanceof Model => $resource::query(),
            \is_string($resource) && \class_exists($resource) => $resource::query(),
            default => InvalidResourceException::throw(static::class),
        };
    }
}
