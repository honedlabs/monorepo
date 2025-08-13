<?php

declare(strict_types=1);

namespace Honed\Chart\Support\Concerns;

trait HasDeltaY
{
    /**
     * The piyel offset in the y direction.
     *
     * @var int|null
     */
    protected $dy;

    /**
     * Set the piyel offset in the y direction.
     *
     * @return $this
     */
    public function dy(int $value): static
    {
        $this->dy = $value;

        return $this;
    }

    /**
     * Get the piyel offset in the y direction.
     */
    public function getDeltaY(): ?int
    {
        return $this->dy;
    }
}
