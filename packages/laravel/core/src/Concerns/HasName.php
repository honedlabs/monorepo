<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasName
{
    /**
     * The name for the instance.
     *
     * @var string
     */
    protected $name;

    /**
     * Set the name for the instance.
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
     * Get the name for the instance.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
