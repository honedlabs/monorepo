<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

use Honed\Core\Contracts\WithExtra;

trait HasExtra
{
    /**
     * Extra data.
     *
     * @var array<string,mixed>|(\Closure(...mixed):array<string,mixed>)|null
     */
    protected $extra;

    /**
     * Set the extra data.
     *
     * @param  array<string,mixed>|(\Closure(...mixed):array<string,mixed>)|null  $extra
     * @return $this
     */
    public function extra($extra)
    {
        $this->extra = $extra;

        return $this;
    }

    /**
     * Get the extra callback.
     * 
     * @return array<string,mixed>|(\Closure(...mixed):array<string,mixed>)|null
     */
    public function getExtraCallback()
    {
        if (isset($this->extra)) {
            return $this->extra;
        }

        if ($this instanceof WithExtra) {
            return $this->extra = \Closure::fromCallable([$this, 'extraUsing']);
        }

        return null;
    }

    /**
     * Get the extra data.
     *
     * @param  array<string,mixed>  $parameters
     * @param  array<class-string,mixed>  $typed
     * @return array<string,mixed>
     */
    public function getExtra($parameters = [], $typed = [])
    {
        return $this->evaluate($this->getExtraCallback(), $parameters, $typed);
    }

    /**
     * Determine if extra data is set.
     *
     * @return bool
     */
    public function hasExtra()
    {
        return filled($this->getExtraCallback());
    }
}
