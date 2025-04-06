<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait Allowable
{
    /**
     * The allow condition.
     *
     * @var \Closure(mixed...):bool|bool
     */
    protected $allow = true;

    /**
     * Set the allow condition.
     *
     * @param  \Closure(mixed...):bool|bool  $allow
     * @return $this
     */
    public function allow($allow)
    {
        $this->allow = $allow;

        return $this;
    }

    /**
     * Define the allow condition.
     *
     * @return \Closure(mixed...):bool|bool|null
     */
    public function defineAllow()
    {
        return null;
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
        $allow = $this->allow ??= $this->defineAllow();

        return (bool) $this->evaluate($allow, $parameters, $typed);
    }
}
