<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasDescription
{
    /**
     * The description.
     *
     * @var string|\Closure(...mixed):string|null
     */
    protected $description;

    /**
     * Set the description.
     *
     * @param  string|\Closure(...mixed):string|null  $description
     * @return $this
     */
    public function description($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get the description.
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
     * Evaluate the description.
     *
     * @param  array<string,mixed>  $parameters
     * @param  array<class-string,mixed>  $typed
     * @return string|null
     */
    public function resolveDescription($parameters = [], $typed = [])
    {
        /** @var string|null */
        $evaluated = $this->evaluate($this->description, $parameters, $typed);

        return $evaluated;
    }

    /**
     * Determine if a description is set.
     *
     * @return bool
     */
    public function hasDescription()
    {
        return isset($this->description);
    }
}
