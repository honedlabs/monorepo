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
     * @param  bool  $value
     * @return $this
     */
    public function toggleable($value = true)
    {
        $this->toggleable = $value;

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
