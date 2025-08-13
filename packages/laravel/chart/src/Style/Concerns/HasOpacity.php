<?php

declare(strict_types=1);

namespace Honed\Chart\Style\Concerns;

trait HasOpacity
{
    /**
     * The opacity.
     *
     * @var int|null
     */
    protected $opacity;

    /**
     * Set the opacity.
     *
     * @return $this
     */
    public function opacity(?int $value): static
    {
        $this->opacity = $value;

        return $this;
    }

    /**
     * Get the opacity.
     */
    public function getOpacity(): ?int
    {
        return $this->opacity;
    }
}
