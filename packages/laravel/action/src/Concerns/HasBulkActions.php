<?php

declare(strict_types=1);

namespace Honed\Action\Concerns;

use Illuminate\Support\Collection;
use Honed\Action\Contracts\ShouldChunk;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection as DatabaseCollection;

trait HasBulkActions
{
    use HasAction;
    use Support\ActsOnRecord;

    /**
     * Whether the action should be chunked.
     *
     * @var bool|null
     */
    protected $chunk;

    /**
     * Whether the bulk action should chunk the records by id.
     *
     * @var bool|null
     */
    protected $chunkById;

    /**
     * The size of the chunk to use when chunking the records.
     *
     * @var int|null
     */
    protected $chunkSize;

    /**
     * Set the action to chunk the records.
     *
     * @param  bool|null  $chunk
     * @return $this
     */
    public function chunk($chunk = true): static
    {
        $this->chunk = $chunk;

        return $this;
    }

    /**
     * Determine if the action should be chunked.
     *
     * @return bool
     */
    public function isChunked(): bool
    {
        if ($this instanceof ShouldChunk) {
            return true;
        }

        if (isset($this->chunk)) {
            return $this->chunk;
        }

        return $this->fallbackChunked();
    }

    /**
     * Determine if the action should be chunked from the config.
     *
     * @return bool
     */
    public function fallbackChunked(): bool
    {
        return (bool) config('action.chunk', false);
    }

    /**
     * Set the action to chunk the records by id.
     *
     * @param  bool|null  $chunkById
     * @return $this
     */
    public function chunkById($chunkById = true)
    {
        $this->chunkById = $chunkById;

        return $this;
    }

    /**
     * Determine if the action should chunk the records by id.
     *
     * @return bool
     */
    public function chunksById(): bool
    {
        return (bool) ($this->chunkById ?? $this->fallbackChunksById());
    }

    /**
     * Determine if the action should chunk the records by id from the config.
     *
     * @return bool
     */
    public function fallbackChunksById(): bool
    {
        return (bool) config('action.chunk_by_id', true);
    }

    /**
     * Set the size of the chunk to use when chunking the records.
     *
     * @param  int|null  $size
     * @return $this
     */
    public function chunkSize($size)
    {
        $this->chunkSize = $size;

        return $this;
    }

    /**
     * Get the size of the chunk to use when chunking the records.
     *
     * @return int
     */
    public function getChunkSize()
    {
        return $this->chunkSize ?? $this->fallbackChunkSize();
    }

    /**
     * Get the size of the chunk to use when chunking the records from the config.
     *
     * @return int
     */
    public function fallbackChunkSize(): int
    {
        return type(config('action.chunk_size', 1000))->asInt();
    }

    /**
     * Execute the bulk action on the given query.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model>  $builder
     * @return mixed
     */
    public function execute($builder)
    {
        $handler = $this->getHandler();

        if (! $handler) {
            return;
        }

        if ($this->isChunked()) {
            return $this->executeWithChunking($builder, $handler);
        }

        [$named, $typed] = $this->getEvaluationParameters($builder);

        return $this->evaluate($handler, $named, $typed);
    }

    /**
     * Handle the chunking of the records.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model>  $builder
     * @param  callable  $handler
     * @return mixed
     */
    protected function executeWithChunking($builder, $handler)
    {
        if ($this->chunksById()) {
            return $builder->chunkById(
                $this->getChunkSize(),
                $this->performChunk($handler)
            );
        }

        return $builder->chunk(
            $this->getChunkSize(),
            $this->performChunk($handler)
        );
    }

    /**
     * Select whether the handler should be called on a record basis, or
     * operates on the collection of records.
     *
     * @param  callable  $handler
     * @return \Closure(Collection<int,\Illuminate\Database\Eloquent\Model>):mixed
     */
    protected function performChunk($handler)
    {
        if ($this->actsOnRecord()) {
            return static fn (Collection $records) => $records
                ->each(static fn ($record) => \call_user_func($handler, $record));
        }

        return static fn (Collection $records) => \call_user_func($handler, $records);
    }

    /**
     * Get the named and typed parameters to use for callable evaluation.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<\Illuminate\Database\Eloquent\Model>  $records
     * @return array{array<string, mixed>,  array<class-string, mixed>}
     */
    protected function getEvaluationParameters($records)
    {
        [$model, $singular, $plural] = $this->getParameterNames($records);

        if ($this->actsOnRecord()) {
            $records = $records->get();
        }

        $named = [
            'model' => $records,
            'record' => $records,
            'builder' => $records,
            'query' => $records,
            'records' => $records,
            $singular => $records,
            $plural => $records,
        ];

        $typed = [
            Builder::class => $records,
            DatabaseCollection::class => $records,
            Collection::class => $records,
            Model::class => $records,
            $model::class => $records,
        ];

        return [$named, $typed];
    }
}
