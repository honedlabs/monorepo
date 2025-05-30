<?php

declare(strict_types=1);

namespace Honed\Lock\Contracts;

use Closure;

interface Lockable
{
    /**
     * Set the abilities to include in the locks.
     *
     * @param  string|iterable<int,string>  ...$abilities
     * @return $this
     */
    public function abilities(...$abilities);

    /**
     * Set an ability to include in the locks.
     *
     * @param  string  $ability
     * @return $this
     */
    public function ability($ability);

    /**
     * Get the abilities to include in the locks.
     *
     * @return array<int,string>
     */
    public function getAbilities();

    /**
     * Get the abilities from a policy.
     *
     * @param  \Illuminate\Database\Eloquent\Model|class-string<\Illuminate\Database\Eloquent\Model>  $model
     * @return array<int,string>
     */
    public function abilitiesFromPolicy($model);

    /**
     * Set the method to use to retrieve the abilities.
     *
     * @param  array<int,string>|(Closure(mixed...):array<int,string>)|null  $using
     * @return $this
     */
    public function using($using);

    /**
     * Get the method to use to retrieve the abilities.
     *
     * @return array<int,string>|null
     */
    public function uses();

    /**
     * Get the locks from gate abilities.
     *
     * @return array<string,bool>
     */
    public function all();

    /**
     * Set whether to append the locks to the model.
     *
     * @param  bool  $append
     * @return void
     */
    public function shouldAppend($append = true);

    /**
     * Determine if the locks should be appended to the model.
     *
     * @return bool
     */
    public function appendsLocks();

    /**
     * Get the property name to serialize as when sharing via inertia.
     *
     * @return string
     */
    public function getProperty();
}
