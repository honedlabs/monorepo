<?php

declare(strict_types=1);

namespace Honed\Lock;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Gate;
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
     * The method to use to retrieve the locks.
     *
     * @var array<int,string>
     */
    protected $using;

    /**
     * Whether to include the locks in the serialization of models.
     *
     * @var bool
     */
    protected $appends = false;

    /**
     * Set the abilities to include in the locks.
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
     * Get the abilities to include in the locks.
     *
     * @return array<int,string>
     */
    public function getLocks()
    {
        return $this->locks;
    }

    /**
     * Set the method to use to retrieve the locks.
     *
     * @param  array<int,string>  $using
     * @return $this
     */
    public function using($using)
    {
        $this->using = $using;

        return $this;
    }

    /**
     * Get the method to use to retrieve the locks.
     *
     * @return array<int,string>|null
     */
    public function uses()
    {
        return $this->using;
    }

    /**
     * Set whether to include the locks when serializing models.
     *
     * @param  bool  $appends
     * @return $this
     */
    public function appendToModels($appends = true)
    {
        $this->appends = $appends;

        return $this;
    }

    /**
     * Determine if the locks should be included when serializing models.
     *
     * @return bool
     */
    public function appendsToModels()
    {
        return $this->appends;
    }

    /**
     * Get locks from gate abilities.
     *
     * @return array<string,bool>
     */
    public function all()
    {
        $locks = $this->getLocks();

        $abilities = $this->uses() ?? Gate::abilities();

        /** @var array<string,bool> */
        return collect($abilities)
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
    public function fromPolicy($model)
    {
        $policy = Gate::getPolicyFor($model);

        if (! $policy) {
            return [];
        }

        /** @phpstan-ignore-next-line */
        $reflection = new \ReflectionClass($policy);

        return \array_map(
            static fn (\ReflectionMethod $method) => $method->getName(),
            $reflection->getMethods(\ReflectionMethod::IS_PUBLIC)
        );
    }
}
