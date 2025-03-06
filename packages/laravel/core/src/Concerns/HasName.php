<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasName
{
    /**
     * @var string|null
     */
    protected $name;

    /**
     * Set the name for the instance.
     *
     * @param  string|null  $name
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
        return $this->name;
    }

    /**
     * Determine if the instance has an name set.
     *
     * @return bool
     */
    public function hasName()
    {
        return ! \is_null($this->name);
    }
}
