<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasName
{
    /**
     * @var string|\Closure|null
     */
    protected $name;

    /**
     * Set the name for the instance.
     *
     * @param  string|\Closure|null  $name
     * @return $this
     */
    public function name($name)
    {
        if (! \is_null($name)) {
            $this->name = $name;
        }

        return $this;
    }

    /**
     * Get the name for the instance.
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->name instanceof \Closure
            ? $this->resolveName()
            : $this->name;
    }

    /**
     * Evaluate the name for the instance.
     *
     * @param  array<string,mixed>  $parameters
     * @param  array<string,mixed>  $typed
     * @return string|null
     */
    public function resolveName($parameters = [], $typed = [])
    {
        /** @var string|null */
        $evaluated = $this->evaluate($this->name, $parameters, $typed);

        $this->name = $evaluated;

        return $evaluated;
    }

    /**
     * Determine if the instance has a name set.
     *
     * @return bool
     */
    public function hasName()
    {
        return ! \is_null($this->name);
    }

    /**
     * Convert a string to the name format
     *
     * @param  string|null  $label
     * @return string|null
     */
    public static function makeName($label)
    {
        if (\is_null($label)) {
            return null;
        }

        return str($label)
            ->snake()
            ->lower()
            ->toString();
    }
}
