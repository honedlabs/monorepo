<?php

declare(strict_types=1);

namespace Honed\Action\Actions;

use Closure;
use Honed\Action\Contracts\Action;
use Honed\Action\Concerns\CanChunk;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * @template TAction of \Honed\Action\Contracts\Action
 * 
 * @extends \Honed\Action\Actions\EloquentAction<TModel>
 * 
 * @internal
 */
abstract class BulkAction extends EloquentAction
{
    use CanChunk;

    /**
     * Get the action to use.
     * 
     * @return class-string<TAction>
     */
    abstract public function action(): string;

    /**
     * Create the action from the container.
     * 
     * @return TAction
     */
    protected function getAction(): Action
    {
        return resolve($this->action());
    }

    /**
     * Get the query for the models.
     *
     * @template T of int|string|TModel|null
     * 
     * @param T|array<int, T>|\Illuminate\Contracts\Support\Arrayable<int, T> $models
     * @return \Illuminate\Database\Eloquent\Builder<TModel>|\Illuminate\Database\Eloquent\Relations\Relation<TModel, *, *>
     */
    protected function getQuery($models): Builder
    {
        if (! Arr::accessible($models)) {
            $models = Arr::wrap($models);
        }
        
        $query = $this->query();

        return $query->whereIn($this->getKey($query), $models);
    }

    /**
     * Get the key for the model.
     *
     * @param \Illuminate\Database\Eloquent\Builder<TModel>|\Illuminate\Database\Eloquent\Relations\Relation<TModel, *, *> $source
     */
    protected function getKey($source): string
    {
        return $source->getModel()->getKeyName();
    }

    /**
     * Run the action on the given models.
     * 
     * @template T of int|string|TModel|null
     * 
     * @param T|array<int, T>|\Illuminate\Support\Collection<int, T> $models
     * @param (Closure(TModel):mixed) $callback
     */
    protected function run($models, Closure $callback): void
    {
        $query = $this->getQuery($models);

        match (true) {
            $this->isChunkedById() => $query
                ->chunkById($this->getChunkSize(),
                    static fn (Collection $models) => $models->each($callback)
                ),
            $this->isChunked() => $query
                ->chunk($this->getChunkSize(),
                    static fn (Collection $models) => $models->each($callback)
                ),
            // @phpstan-ignore-next-line argument.type
            default => $query->get()->each($callback)
        };
    }
}