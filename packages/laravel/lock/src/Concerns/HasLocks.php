<?php

declare(strict_types=1);

namespace Honed\Lock\Concerns;

use Honed\Lock\Attributes\Locks;
use Honed\Lock\Facades\Lock;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
use ReflectionClass;

use function array_diff;
use function array_values;
use function is_array;

/**
 * @phpstan-require-extends \Illuminate\Database\Eloquent\Model
 */
trait HasLocks
{
    /**
     * Whether to append the locks to the model.
     *
     * @var bool|null
     */
    protected static $appendLocks;

    /**
     * Determine if the locks should be appended to the model by default.
     *
     * @return bool
     */
    public static function appendsLocks()
    {
        return static::$appendLocks
            ?? static::getLocksAttribute()
            ?? Lock::appendsLocks();
    }

    /**
     * Define the locks available on the model.
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
        if ($this->appendsLocks() && $this->isntLocking()) {
            $this->withLocks();
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

        if (is_array($lock)) {
            return $lock;
        }

        return Arr::mapWithKeys(
            Lock::abilitiesFromPolicy($lock),
            fn ($ability) => [
                $ability => Gate::allows($ability, $lock),
            ]
        );
    }

    /**
     * Determine if the model appends the locks.
     *
     * @return bool
     */
    public function isLocking()
    {
        return $this->hasAppended('lock');
    }

    /**
     * Determine if the model does not append the locks.
     *
     * @return bool
     */
    public function isNotLocking()
    {
        return ! $this->isLocking();
    }

    /**
     * Determine if the model does not append the locks.
     *
     * @return bool
     */
    public function isntLocking()
    {
        return ! $this->isLocking();
    }

    /**
     * Make available the locks to the model.
     *
     * @return $this
     */
    public function withLocks()
    {
        return $this->append('lock');
    }

    /**
     * Make unavailable the locks from the model.
     *
     * @return $this
     */
    public function withoutLocks()
    {
        if ($this->isLocking()) {
            $this->appends = array_values(
                array_diff($this->getAppends(), ['lock'])
            );
        }

        return $this;
    }

    /**
     * Get whether the locks should be appended to the model.
     *
     * @return true|null
     */
    protected static function getLocksAttribute()
    {
        $attributes = (new ReflectionClass(static::class))
            ->getAttributes(Locks::class);

        if ($attributes !== []) {
            return true;
        }

        return null;
    }
}
