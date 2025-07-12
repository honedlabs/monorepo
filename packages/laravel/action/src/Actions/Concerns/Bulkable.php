<?php

declare(strict_types=1);

namespace Honed\Action\Actions\Concerns;

use Closure;
use Honed\Action\Contracts\Action;
use Honed\Action\Operations\Concerns\CanChunk;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;

/**
 * @template TModel of \Illuminate\Database\Eloquent\Model
 * @template TAction of \Honed\Action\Contracts\Action
 * 
 * @phpstan-require-implements \Honed\Action\Contracts\RequiresModel
 */
trait Bulkable
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
     * @return Builder<TModel>
     */
    protected function query($models): Builder
    {
        if (! Arr::accessible($models)) {
            $models = Arr::wrap($models);
        }
        
        $model = $this->getModel();

        /** @var Builder<TModel> */
        return $model::query()
            ->whereIn($model->getKeyName(), $models);
    }

    /**
     * Get the model to use.
     *
     * @return TModel
     */
    protected function getModel(): Model
    {
        $model = $this->model();

        return new $model();
    }

    /**
     * Run the action on the given models.
     * 
     * @template T of int|string|TModel|null
     * 
     * @param T|iterable<int, T> $models
     * @param (Closure(TModel):mixed) $callback
     */
    protected function run($models, Closure $callback): void
    {
        $query = $this->getQuery($models);

        match (true) {
            $this->isChunkedById() => $query
                /** @var \Illuminate\Support\Collection<int, TModel> */
                ->chunkById($this->getChunkSize(),
                    static fn (Collection $models) => $models->each($callback)
                ),
            $this->isChunked() => $query
                /** @var \Illuminate\Support\Collection<int, TModel> */
                ->chunk($this->getChunkSize(), 
                    static fn (Collection $models) => $models->each($callback)
                ),
            default => $query->get()->each($callback)
        };
    }
}