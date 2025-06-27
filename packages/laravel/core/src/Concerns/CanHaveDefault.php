<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait CanHaveDefault
{
    /**
     * The default value to use if one is not provided.
     *
     * @var mixed
     */
    protected $default;

    /**
     * Set a default value to use if one is not provided.
     *
     * @param  mixed  $default
     * @return $this
     */
    public function default($default)
    {
        $this->default = $default;

        return $this;
    }

    /**
     * Get the default value to use if one is not provided.
     *
     * @return mixed
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * Check if the instance has a default value.
     *
     * @return bool
     */
    public function hasDefault()
    {
        return isset($this->default);
    }
}
