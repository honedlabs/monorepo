<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait HasType
{
    /**
     * The type for the instance.
     *
     * @var string
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
     * Define the type.
     *
     * @return string|null
     */
    public function defineType()
    {
        return null;
    }

    /**
     * Get the type.
     *
     * @return string|null
     */
    public function getType()
    {
        return $this->type ??= $this->defineType();
    }

    /**
     * Determine if the type is set.
     *
     * @return bool
     */
    public function hasType()
    {
        return isset($this->getType());
    }
}
