<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Closure;
use Honed\Core\Contracts\WithAllowance;

trait Allowable
{
    /**
     * The allow condition.
     *
     * @var (\Closure(...mixed):bool)|bool|null
     */
    protected $allow;

    /**
     * Set the allow condition.
     *
     * @param  (\Closure(...mixed):bool)|bool|null  $allow
     * @return $this
     */
    public function allow($allow)
    {
        $this->allow = $allow;

        return $this;
    }

    /**
     * Get the allow condition callback.
     *
     * @return (\Closure(...mixed):bool)|bool
     */
    public function getAllowCallback()
    {
        if (isset($this->allow)) {
            return $this->allow;
        }

        if ($this instanceof WithAllowance) {
            return $this->allow = Closure::fromCallable([$this, 'allowUsing']);
        }

        return true;
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
        $allow = $this->getAllowCallback();

        return (bool) $this->evaluate($allow, $parameters, $typed);
    }
}
