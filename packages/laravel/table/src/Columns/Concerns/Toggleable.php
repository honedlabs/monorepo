<?php

declare(strict_types=1);

namespace Honed\Table\Columns\Concerns;

trait Toggleable
{
    /**
     * Whether the instance supports toggling.
     *
     * @var bool
     */
    protected $toggleable = false;

    /**
     * Whether the instance is toggled active by default.
     *
     * @var bool
     */
    protected $defaultToggled = true;

    /**
     * Set the instance to be toggleable.
     *
     * @param  bool  $enable
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

    /**
     * Set the default toggled state.
     *
     * @param  bool  $default
     * @return $this
     */
    public function defaultToggled($default = true)
    {
        $this->defaultToggled = $default;

        return $this;
    }

    /**
     * Determine if the instance is toggled active by default.
     *
     * @return bool
     */
    public function isDefaultToggled()
    {
        return $this->defaultToggled;
    }
}
