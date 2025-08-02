<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

use Honed\Chart\Enums\Orientation;

trait HasOrientation
{
    /**
     * The orientation to use.
     * 
     * @var string|null
     */
    protected $orientation;

    /**
     * Set the orientation of the element.
     * 
     * @return $this
     */
    public function orientation(string|Orientation $orientation): static
    {
        $this->orientation = is_string($orientation) ? $orientation : $orientation->value;

        return $this;
    }

    /**
     * Set the orientation of the element to be horizontal.
     * 
     * @return $this
     */
    public function horizontal(): static
    {
        return $this->orientation(Orientation::Horizontal);
    }

    /**
     * Set the orientation of the element to be vertical.
     * 
     * @return $this
     */
    public function vertical(): static
    {
        return $this->orientation(Orientation::Vertical);
    }

    /**
     * Get the orientation of the element.
     */
    public function getOrientation(): ?string
    {
        return $this->orientation;
    }
}