<?php

namespace Honed\Lock\Concerns;

use Honed\Lock\Facades\Lock;
use Honed\Lock\Support\Parameters;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Gate;

/**
 * @phpstan-require-extends \Illuminate\Database\Eloquent\Model
 */
trait HasLocks
{
    /**
     * Define the locks this model has.
     * 
     * @return array<string,bool>|$this
     */
    public function defineLocks()
    {
        return $this;
    }

    /**
     * Initialize the locks trait for an instance.
     * 
     * @return void
     */
    public function initializeHasLocks(): void
    {
        if (Lock::includesLocks() && ! $this->appendsLocks()) {
            $this->appends[] = Parameters::APPENDS;
        }
    }

    /**
     * Retrieve the locks this model has.
     * 
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    public function locks(): Attribute
    {
        return Attribute::get(
            fn () => $this->getLocks()
        )->shouldCache();
    }

    /**
     * Get the locks for the model.
     * 
     * @return array<string,bool>
     */
    public function getLocks()
    {
        $locks = $this->defineLocks();

        if (\is_array($locks)) {
            return $locks;
        }

        return collect(Lock::getAbilitiesFromPolicy($locks))
            ->mapWithKeys(fn ($ability) => [
                $ability => Gate::allows($ability, $locks)
            ])
            ->toArray();
    }

    /**
     * Determine if the model appends the locks.
     * 
     * @return bool
     */
    public function appendsLocks()
    {
        return \in_array(Parameters::APPENDS, $this->appends ?? []);
    }

    /**
     * Make available the locks to the model.
     * 
     * @return $this
     */
    public function withLocks()
    {
        if (! $this->appendsLocks()) {
            $this->appends[] = Parameters::APPENDS;
        }

        return $this;
    }

    /**
     * Make unavailable the locks from the model.
     * 
     * @return $this
     */
    public function withoutLocks()
    {
        $this->appends = \array_values(
            \array_diff($this->appends, [Parameters::APPENDS])
        );

        return $this;
    }
}
