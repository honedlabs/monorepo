<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasName
{
    /**
     * The name.
     *
     * @var string
     */
    protected $name;

    /**
     * Set the name.
     *
     * @param  string  $name
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
     * @return string
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
        return isset($this->name);
    }
}
