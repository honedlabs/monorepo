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
     * @return $this
     */
    public function snap(bool $value = true): static
    {
        $this->snap = $value;

        return $this;
    }

    public function getSnap(): ?bool
    {
        return $this->snap;
    }
}
