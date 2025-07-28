<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

use Honed\Chart\Enums\Orientation;

trait HasOrientation
{
    /**
     * The orientation to use.
     * 
     * @var \Honed\Chart\Enums\Orientation|null
     */
    protected $orientation;

    /**
     * Set the orientation of the element.
     * 
     * @return $this
     */
    public function orientation(Orientation|string $orientation): static
    {
        if (! $orientation instanceof Orientation) {
            $orientation = Orientation::from($orientation);
        }

        $this->orientation = $orientation;

        return $this;
    }

    /**
     * Get the orientation of the element.
     */
    public function getOrientation(): ?string
    {
        return $this->orientation?->value;
    }
}