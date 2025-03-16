<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait Allowable
{
    /**
     * The allow condition.
     *
     * @var \Closure|bool
     */
    protected $allow = true;

    /**
     * Set the allow condition.
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
     * Determine if the parameters pass the allow condition.
     *
     * @param  array<string,mixed>  $parameters
     * @param  array<class-string,mixed>  $typed
     * @return bool
     */
    public function isAllowed($parameters = [], $typed = [])
    {
        $evaluated = (bool) $this->evaluate($this->allow, $parameters, $typed);

        return $evaluated;
    }
}
