<?php

namespace Honed\Core\Concerns;

trait HasName
{
    /**
     * The name.
     *
     * @var string|null
     */
    protected $name;

    /**
     * Set the name.
     *
     * @param  string|null  $name
     * @return $this
     */
    public function name($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the name.
     *
     * @return string|null
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Determine if the name is set.
     *
     * @return bool
     */
    public function hasName()
    {
        return filled($this->getName());
    }
}
