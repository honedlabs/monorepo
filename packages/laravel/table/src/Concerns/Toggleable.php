<?php

declare(strict_types=1);

namespace Honed\Table\Concerns;

trait Toggleable
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
     * Determine if the instance is toggleable.
     * 
     * @return bool
     */
    public function isToggleable()
    {
        return $this->toggleable;
    }
}