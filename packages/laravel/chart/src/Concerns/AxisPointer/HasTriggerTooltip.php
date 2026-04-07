<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns\AxisPointer;

trait HasTriggerTooltip
{
    /**
     * @var bool|null
     */
    protected $triggerTooltip;

    /**
     * @return $this
     */
    public function triggerTooltip(bool $value = true): static
    {
        $this->triggerTooltip = $value;

        return $this;
    }

    public function getTriggerTooltip(): ?bool
    {
        return $this->triggerTooltip;
    }
}
