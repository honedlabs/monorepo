<?php

declare(strict_types=1);

namespace Honed\Table\Concerns;

trait CanBeToggled
{
    /**
     * Whether the instance supports toggling.
     * 
     * @var bool
     */
    protected $toggleable = false;

    /**
     * Set the instance to be toggleable.
     * 
     * @param bool $enable
     * @return $this
     */
    public function toggleable($enable = true)
    {
        $this->toggleable = $enable;

        return $this;
    }

    /**
     * Set the instance to not be toggleable.
     * 
     * @param bool $disable
     * @return $this
     */
    public function notToggleable($disable = true)
    {
        return $this->toggleable(! $disable);
    }

    /**
     * Determine if the instance is toggleable.
     * 
     * @return bool
     */
    public function isToggleable()
    {
        return $this->toggleable;
    }

    /**
     * Determine if the instance is not toggleable.
     * 
     * @return bool
     */
    public function isNotToggleable()
    {
        return ! $this->isToggleable();
    }
}