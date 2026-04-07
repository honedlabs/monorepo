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
     * Enable or disable tooltip updates when the pointer moves.
     *
     * @return $this
     */
    public function triggerTooltip(bool $value = true): static
    {
        $this->triggerTooltip = $value;

        return $this;
    }

    /**
     * Whether the pointer triggers the tooltip.
     */
    public function getTriggerTooltip(): ?bool
    {
        return $this->triggerTooltip;
    }
}
