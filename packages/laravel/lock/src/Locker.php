<?php

declare(strict_types=1);

namespace Honed\Lock;

use Closure;
use Honed\Lock\Contracts\Lockable;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Gate;
use Laravel\SerializableClosure\Support\ReflectionClosure;
use ReflectionClass;
use ReflectionMethod;

use function array_map;
use function in_array;

class Locker implements Lockable
{
    /**
     * The abilities to use to generate the locks.
     *
     * @var array<int,string>
     */
    protected $abilities = [];

    /**
     * The method to use to retrieve the locks.
     *
     * @var array<int,string>|(Closure(mixed...):array<int,string>)|null
     */
    protected $using;

    /**
     * Whether to append the locks to the model.
     *
     * @var bool
     */
    protected $append = false;

    /**
     * Set the abilities to include in the abilities.
     *
     * @param  iterable<int,string>  ...$abilities
     * @return $this
     */
    public function abilities(...$abilities)
    {
        $this->abilities = Arr::flatten($abilities);

        return $this;
    }

    /**
     * Set an ability to include in the abilities.
     *
     * @param  string  $ability
     * @return $this
     */
    public function ability($ability)
    {
        $this->abilities[] = $ability;

        return $this;
    }

    /**
     * Get the abilities to include in the abilities.
     *
     * @return array<int,string>
     */
    public function getAbilities()
    {
        return $this->abilities;
    }

    /**
     * Get the abilities from the policy.
     *
     * @param  \Illuminate\Database\Eloquent\Model|class-string<\Illuminate\Database\Eloquent\Model>  $model
     * @return array<int,string>
     */
    public function abilitiesFromPolicy($model)
    {
        $policy = Gate::getPolicyFor($model);

        if (! $policy) {
            return [];
        }

        /** @phpstan-ignore-next-line */
        $reflection = new ReflectionClass($policy);

        return array_map(
            static fn (ReflectionMethod $method) => $method->getName(),
            $reflection->getMethods(ReflectionMethod::IS_PUBLIC)
        );
    }

    /**
     * Set the method to use to retrieve the abilities.
     *
     * @param  array<int,string>|Closure(mixed...):array<int,string>  $using
     * @return $this
     */
    public function using($using)
    {
        $this->using = $using;

        return $this;
    }

    /**
     * Get the method to use to retrieve the abilities.
     *
     * @return array<int,string>|null
     */
    public function uses()
    {
        if ($this->using instanceof Closure) {
            return ($this->using)();
        }

        return $this->using;
    }

    /**
     * Get abilities from gate abilities.
     *
     * @return array<string,bool>
     */
    public function all()
    {
        $locks = $this->getAbilities();

        $abilities = $this->uses() ?? Gate::abilities();

        /** @var array<string,bool> */
        return collect($abilities)
            ->filter(function (Closure $closure, $ability) use ($locks) {
                if (filled($locks) && ! in_array($ability, $locks)) {
                    return false;
                }

                $reflection = new ReflectionClosure($closure);

                return $reflection->getNumberOfParameters() === 1;
            })
            ->mapWithKeys(static fn (Closure $closure, $ability) => [
                $ability => Gate::check($ability),
            ])
            ->all();
    }

    /**
     * Set whether to append the abilities to the model.
     *
     * @param  bool  $append
     * @return void
     */
    public function shouldAppend($append = true)
    {
        $this->append = $append;
    }

    /**
     * Determine if the locks should be appended to the model.
     *
     * @return bool
     */
    public function appendsLocks()
    {
        return $this->append;
    }

    /**
     * Get the property name to serialize as when sharing via inertia.
     *
     * @return string
     */
    public function getProperty()
    {
        /** @var string */
        return Config::get('lock.property', 'lock');
    }
}
