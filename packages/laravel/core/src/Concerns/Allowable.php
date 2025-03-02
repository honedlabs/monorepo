<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait Allowable
{
    /**
     * @var \Closure|bool
     */
    protected $allow = true;

    /**
     * Set the allow condition for the instance.
     *
     * @param  \Closure|bool  $allow
     * @return $this
     */
    public function allow($allow)
    {
        $this->allow = $allow;

        return $this;
    }

    /**
     * Determine if the instance allows the given parameters.
     *
     * @param  array<string,mixed>  $parameters
     * @param  array<string,mixed>  $typed
     * @return bool
     */
    public function isAllowed($parameters = [], $typed = [])
    {
        $evaluated = (bool) $this->evaluate($this->allow, $parameters, $typed);

        return $evaluated;
    }
}
