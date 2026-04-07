<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns\AxisPointer;

trait HasSnap
{
    /**
     * @var bool|null
     */
    protected $snap;

    /**
     * Enable or disable snap-to-tick.
     *
     * @return $this
     */
    public function snap(bool $value = true): static
    {
        $this->snap = $value;

        return $this;
    }

    /**
     * Whether snap-to-tick is enabled.
     */
    public function getSnap(): ?bool
    {
        return $this->snap;
    }
}
