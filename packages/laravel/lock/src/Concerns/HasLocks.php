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
    public function locks()
    {
        return $this;
    }

    /**
     * Initialize the locks trait for an instance.
     *
     * @return void
     */
    public function initializeHasLocks()
    {
        if (Lock::appendsToModels() && ! $this->isLocking()) {
            $this->appends[] = Parameters::PROP;
        }
    }

    /**
     * Retrieve the locks this model has.
     */
    public function lock(): Attribute
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
        $lock = $this->locks();

        if (\is_array($lock)) {
            return $lock;
        }

        return collect(Lock::fromPolicy($lock))
            ->mapWithKeys(fn ($ability) => [
                $ability => Gate::allows($ability, $lock),
            ])
            ->toArray();
    }

    /**
     * Determine if the model appends the locks.
     *
     * @return bool
     */
    public function isLocking()
    {
        return \in_array(Parameters::PROP, $this->appends ?? []);
    }

    /**
     * Make available the locks to the model.
     *
     * @return $this
     */
    public function withLocks()
    {
        if (! $this->isLocking()) {
            $this->appends[] = Parameters::PROP;
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
            \array_diff($this->appends, [Parameters::PROP])
        );

        return $this;
    }
}
