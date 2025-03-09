<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasDescription
{
    /**
     * The description for the instance.
     *
     * @var string|\Closure|null
     */
    protected $description;

    /**
     * Set the description for the instance.
     *
     * @param  string|\Closure|null  $description
     * @return $this
     */
    public function description($description)
    {
        if (! \is_null($description)) {
            $this->description = $description;
        }

        return $this;
    }

    /**
     * Get the description for the instance.
     *
     * @return string|null
     */
    public function getDescription()
    {
        return $this->description instanceof \Closure
            ? $this->resolveDescription()
            : $this->description;
    }

    /**
     * Evaluate the description for the instance.
     *
     * @param  array<string,mixed>  $parameters
     * @param  array<string,mixed>  $typed
     * @return string|null
     */
    public function resolveDescription($parameters = [], $typed = [])
    {
        /** @var string|null */
        $evaluated = $this->evaluate($this->description, $parameters, $typed);

        $this->description = $evaluated;

        return $evaluated;
    }

    /**
     * Determine if the instance has a description set.
     *
     * @return bool
     */
    public function hasDescription()
    {
        return ! \is_null($this->description);
    }
}
