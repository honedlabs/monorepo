<?php

namespace Honed\Core\Concerns;

trait HasType
{
    /**
     * The type for the instance.
     *
     * @var string|null
     */
    protected $type;

    /**
     * Set the type.
     *
     * @param  string|null  $type
     * @return $this
     */
    public function type($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the type.
     *
     * @return string|null
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Determine if the type is set.
     *
     * @return bool
     */
    public function hasType()
    {
        return filled($this->getType());
    }
}
