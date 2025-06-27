<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Honed\Core\Exceptions\InvalidResourceException;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use InvalidArgumentException;

use function is_string;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model = \Illuminate\Database\Eloquent\Model
 * @template TBuilder of \Illuminate\Database\Eloquent\Builder<TModel> = \Illuminate\Database\Eloquent\Builder<TModel>
 */
trait HasResource
{
    /**
     * The builder instance.
     *
     * @var TBuilder|array<int, array<string, mixed>>|null
     */
    protected $resource;

    /**
     * Set the resource to be used.
     *
     * @param  TModel|array<int, array<string, mixed>>|Arrayable<int, mixed>|TBuilder|class-string<TModel>  $resource
     * @return $this
     *
     * @throws InvalidResourceException
     */
    public function resource($resource)
    {
        $this->resource = $this->resolveResource($resource);

        return $this;
    }

    /**
     * Set the resource to be used.
     *
     * @param  TModel|array<int, array<string, mixed>>|Arrayable<int, mixed>|TBuilder|class-string<TModel>  $resource
     * @return $this
     */
    public function for($resource)
    {
        return $this->resource($resource);
    }

    /**
     * Get a builder instance of the resource.
     *
     * @return TBuilder
     *
     * @throws InvalidArgumentException
     */
    public function getBuilder()
    {
        if ($this->resource && $this->resource instanceof Builder) {
            return $this->resource;
        }

        $this->throwMissingResource();
    }

    /**
     * Get a model instance.
     *
     * @return TModel
     *
     * @throws InvalidArgumentException
     */
    public function getModel()
    {
        return $this->getBuilder()->getModel();
    }

    /**
     * Get the resource.
     *
     * @return TBuilder|array<int, array<string, mixed>>|null
     */
    public function getResource()
    {
        return $this->resource;
    }

    /**
     * Create a new builder instance from a resource.
     *
     * @param  TBuilder|TModel|class-string<TModel>|null  $resource
     * @return TBuilder|null
     *
     * @throws InvalidArgumentException
     */
    protected function resolveResource($resource)
    {
        return match (true) {
            $resource instanceof Builder => $resource,
            $resource instanceof Model => $resource::query(),
            is_string($resource) => $resource::query(),
            $resource instanceof Arrayable => $resource->toArray(),
            is_array($resource) => $resource,
            default => throw new InvalidArgumentException(
                'The provided resource for ['.get_class($this).'] is invalid.'
            ),
        };
    }

    /**
     * Throw an invalid resource exception.
     *
     * @return never
     *
     * @throws InvalidArgumentException
     */
    protected function throwMissingResource()
    {
        throw new InvalidArgumentException(
            'No resource has been set for ['.get_class($this).'].'
        );
    }
}
