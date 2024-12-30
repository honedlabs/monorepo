<?php

namespace Honed\Table\Concerns;

use Closure;
use RuntimeException;
use Illuminate\Support\Stringable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

trait HasResource
{
    /**
     * The model class-string, or Eloquent Builder instance to use for the table.
     * 
     * @var \Illuminate\Contracts\Database\Eloquent\Builder|class-string<\Illuminate\Database\Eloquent\Model>|string
     */
    protected $resource;

    /**
     * Modify the resource query before it is used on a per controller basis.
     * 
     * @var (\Closure(\Illuminate\Database\Eloquent\Builder):(\Illuminate\Database\Eloquent\Builder)|null)|null
     */
    protected $resourceModifier = null;

    /**
     * Get the resource to use for the table as an Eloquent query builder.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     *
     * @throws \RuntimeException
     */
    public function getResource()
    {
        // @phpstan-ignore-next-line
        $this->resource ??= match (true) {
            \method_exists($this, 'resource') => $this->resource(),
            \property_exists($this, 'resource') => $this->resource,
            default => (new Stringable(static::class))
                ->classBasename()
                ->beforeLast('Table')
                ->singular()
                ->prepend('\\App\\Models\\')
                ->toString()
        };

        return match (true) {
            $this->resource instanceof Builder => $this->resource,
            $this->resource instanceof Model => $this->resource->newQuery(),
            \is_string($this->resource) => $this->resource::query(),
            default => throw new RuntimeException(sprintf('[%s] requires a class-string, model or Eloquent resource.', static::class)),
        };
    }

        /**
     * Set the resource to use for the table.
     *
     * @param  \Illuminate\Contracts\Database\Eloquent\Builder|class-string<\Illuminate\Database\Eloquent\Model>|null  $resource
     */
    public function setResource(Model|Builder|Closure|string|null $resource): void
    {
        if (\is_null($resource)) {
            return;
        }

        $this->resource = $resource;
    }

    /**
     * Retrieve the resource modifier.
     * 
     * @return (\Closure(\Illuminate\Database\Eloquent\Builder):(\Illuminate\Database\Eloquent\Builder|null))|null
     */
    public function getResourceModifier(): ?Closure
    {
        return $this->resourceModifier;
    }

    /**
     * Determine if the table has a resource modifier.
     */
    public function hasResourceModifier(): bool
    {
        return ! \is_null($this->resourceModifier);
    }

    /**
     * Set the resource modifier.
     * 
     * @param  \Closure(\Illuminate\Database\Eloquent\Builder):(\Illuminate\Database\Eloquent\Builder)  $resourceModifier
     */
    public function setResourceModifier(Closure $resourceModifier): void
    {
        $this->resourceModifier = $resourceModifier;
    }

    /**
     * Resolve a model instance from the given key.
     */
    public function resolveModel(int|string $key): Model
    {
        $modelClass = $this->getModelClass();
        $resolver = $this->modelResolver ?? fn (string $modelClass, int|string $key) => $modelClass::findOrFail($key);

        return \call_user_func($resolver, $modelClass, $key);
    }

    /**
     * Get the model class used by the resource.
     */
    public function getModelClass(): Model
    {
        return $this->getResource()->getModel();
    }

    /**
     * Get the model class as a name.
     */
    public function getModelClassName(): string
    {
        return strtolower(class_basename($this->getModelClass()));
    }

    // public function getKeyName(): string
    // {
    //     return $this->getResource()->getKeyName();
    // }
}
