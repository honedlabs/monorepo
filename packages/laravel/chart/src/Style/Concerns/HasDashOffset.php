<?php

declare(strict_types=1);

namespace Honed\Chart\Style\Concerns;

trait HasDashOffset
{
    /**
     * The offset distance of the dash.
     *
     * @var int|null
     */
    protected $dashOffset;

    /**
     * Set the offset distance of the dash.
     *
     * @return $this
     */
    public function dashOffset(int $value): static
    {
        $this->dashOffset = $value;

        return $this;
    }

    /**
     * Get the offset distance of the dash.
     */
    public function getDashOffset(): ?int
    {
        return $this->dashOffset;
    }
}
