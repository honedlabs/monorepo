<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait Allowable
{
    /**
     * The allow condition.
     *
     * @var (\Closure(...mixed):bool)|bool
     */
    protected $allow = true;

    /**
     * Set the allow condition.
     *
     * @param  (\Closure(...mixed):bool)|bool  $value
     * @return $this
     */
    public function allow($value)
    {
        $this->allow = $value;

        return $this;
    }

    /**
     * Get the allow condition callback.
     *
     * @return (\Closure(...mixed):bool)|bool
     */
    public function allowCallback()
    {
        return $this->allow;
    }

    /**
     * Determine if the parameters pass the allow condition.
     *
     * @param  array<string,mixed>  $parameters
     * @param  array<class-string,mixed>  $typed
     * @return bool
     */
    public function isAllowed($parameters = [], $typed = [])
    {
        return (bool) $this->evaluate($this->allowCallback(), $parameters, $typed);
    }
}
