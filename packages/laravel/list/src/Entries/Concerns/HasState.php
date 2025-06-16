<?php

declare(strict_types=1);

namespace Honed\List\Entries\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

trait HasState
{
    /**
     * The record to be used to generate a state.
     * 
     * @var array<string, mixed>|\Illuminate\Database\Eloquent\Model|null
     */
    protected array|Model|null $record = null;

    /**
     * The retrieval method for the state.
     * 
     * @var string|\Closure
     */
    protected string|\Closure|null $state = null;

    /**
     * The resolved state of the entry.
     * 
     * @var mixed
     */
    protected mixed $resolved = null;

    /**
     * Set the record to be used to generate a state.
     * 
     * @param  array<string, mixed>|\Illuminate\Database\Eloquent\Model  $record
     * @return $this
     */
    public function record(array|Model $record): static
    {
        $this->record = $record;

        return $this;
    }

    /**
     * Get the record to be used to generate a state.
     * 
     * @return array<string, mixed>|\Illuminate\Database\Eloquent\Model|null
     */
    public function getRecord(): array|Model|null
    {
        return $this->record;
    }

    /**
     * Set how the state of the entry is generated.
     * 
     * @param  string|\Closure  $state
     * @return $this
     */
    public function state(string|\Closure $state): static
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get the resolved state of the entry.
     * 
     * @return mixed
     */
    public function getState(): mixed
    {
        if (is_null($this->resolved)) {
            $this->resolveState();
        }

        return $this->resolved;
    }

    /**
     * Resolve the state of the entry.
     * 
     * @return mixed
     */
    protected function resolveState(): mixed
    {
        return $this->resolved = match (true) {
            is_string($this->state) => Arr::get($this->getRecord(), $this->state),
            is_callable($this->state) => $this->evaluate($this->state),
            default => null,
        };
    }
}