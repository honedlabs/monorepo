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
     * Set the instance to the default.
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
     * Set the instance to not the default.
     *
     * @param  bool  $notDefault
     * @return $this
     */
    public function notDefault($notDefault = true)
    {
        return $this->default(! $notDefault);
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
