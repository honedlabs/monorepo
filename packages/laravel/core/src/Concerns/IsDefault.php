<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait IsDefault
{
    /**
     * Whether the instance is the default.
     *
     * @var bool
     */
    protected $default = false;

    /**
     * Set the instance as the default.
     *
     * @param  bool  $default
     * @return $this
     */
    public function default($default = true)
    {
        $this->default = $default;

        return $this;
    }

    /**
     * Determine if the instance is the default.
     *
     * @return bool
     */
    public function isDefault()
    {
        return $this->default;
    }
}
