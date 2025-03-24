<?php

declare(strict_types=1);

namespace Honed\Lock;

use Illuminate\Support\Facades\Gate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Arr;
use Laravel\SerializableClosure\Support\ReflectionClosure;

class Locker
{
    /**
     * The abilities to use to generate the locks.
     * 
     * @var array<int,string>
     */
    protected $locks = [];

    /**
     * Whether to include the locks in the serialization of models.
     * 
     * @var bool
     */
    protected $includeLocks = false;

    /**
     * Set the abilities to use to generate the locks.
     * 
     * @param  iterable<int,string>  ...$locks
     * @return $this
     */
    public function locks(...$locks)
    {
        $this->locks = Arr::flatten($locks);

        return $this;
    }

    /**
     * Get the abilities to use to generate the locks.
     * 
     * @return array<int,string>
     */
    public function getLocks()
    {
        return $this->locks;
    }

    /**
     * Set whether to include the locks when serializing models.
     * 
     * @param bool $includeLocks
     * @return $this
     */
    public function includeLocks($includeLocks)
    {
        $this->includeLocks = $includeLocks;

        return $this;
    }

    /**
     * Determine if the locks should be included when serializing models.
     * 
     * @return bool
     */
    public function includesLocks()
    {
        return $this->includeLocks;
    }

    /**
     * Get locks from gate abilities.
     * 
     * @return array<string,bool>
     */
    public function generateLocks()
    {
        $locks = $this->getLocks();

        return collect(Gate::abilities())
            ->filter(function (\Closure $closure, $ability) use ($locks) {
                if (filled($locks) && ! \in_array($ability, $locks)) {
                    return false;
                }

                $reflection = new ReflectionClosure($closure);

                return $reflection->getNumberOfParameters() === 1;
            })
            ->mapWithKeys(static fn (\Closure $closure, $ability) => [
                $ability => Gate::check($ability),
            ])
            ->toArray();
    }

    /**
     * Get the abilities from the policy.
     * 
     * @param  \Illuminate\Database\Eloquent\Model|class-string<\Illuminate\Database\Eloquent\Model>  $model
     * @return array<int,string>
     */
    public function getAbilitiesFromPolicy($model)
    {
        $policy = Gate::getPolicyFor($model);

        if (! $policy) {
            return [];
        }

        $reflection = new \ReflectionClass($policy);

        return \array_map(
            static fn (\ReflectionMethod $method) => $method->getName(),
            $reflection->getMethods(\ReflectionMethod::IS_PUBLIC)
        );
    }
}