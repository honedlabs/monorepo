<?php

declare(strict_types=1);

namespace Honed\Core\Concerns;

trait CanBeDefault
{
    /**
     * Whether the instance is the default.
     *
     * @var bool
     */
    protected $default = false;

    /**
     * Set the instance to the default.
     *
     * @param  bool  $value
     * @return $this
     */
    public function default($value = true)
    {
        $this->default = $value;

        return $this;
    }

    /**
     * Set the instance to not the default.
     *
     * @return $this
     */
    public function notDefault()
    {
        return $this->default(false);
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

    /**
     * Determine if the instance is not the default.
     *
     * @return bool
     */
    public function isNotDefault()
    {
        return ! $this->isDefault();
    }
}
