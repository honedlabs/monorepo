<?php

declare(strict_types=1);

namespace Honed\Infolist\Entries\Concerns;

use Closure;
use Honed\Core\Concerns\HasRecord;
use Illuminate\Support\Arr;

trait HasState
{
    use HasRecord;

    /**
     * The retrieval method for the state.
     *
     * @var string|Closure|null
     */
    protected $state = null;

    /**
     * The resolved state of the entry.
     *
     * @var mixed
     */
    protected $resolved = null;

    /**
     * Set how the state of the entry is generated.
     *
     * @param  string|Closure  $state
     * @return $this
     */
    public function state($state)
    {
        $this->state = $state;

        return $this;
    }

    /**
     * Get the resolved state of the entry.
     *
     * @return mixed
     */
    public function getState()
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
    protected function resolveState()
    {
        $record = $this->getRecord();

        if (is_null($record)) {
            return null;
        }

        return $this->resolved = match (true) {
            is_string($this->state) => Arr::get($record, $this->state),
            is_callable($this->state) => $this->evaluate($this->state),
            default => null,
        };
    }
}
