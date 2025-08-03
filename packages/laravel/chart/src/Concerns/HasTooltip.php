<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

use Closure;
use Honed\Chart\Tooltip\Tooltip;

trait HasTooltip
{
    /**
     * The tooltip.
     * 
     * @var \Honed\Chart\Tooltip\Tooltip|null
     */
    protected $tooltip;

    /**
     * Add a tooltip.
     * 
     * @param \Honed\Chart\Tooltip\Tooltip|(Closure(\Honed\Chart\Tooltip\Tooltip):\Honed\Chart\Tooltip\Tooltip)|null $value
     * @return $this
     */
    public function tooltip(Tooltip|Closure|null $value = null): static
    {
        $this->tooltip = match (true) {
            is_null($value) => $this->withTooltip(),
            $value instanceof Closure => $value($this->withTooltip()),
            default => $value,
        };

        return $this;
    }

    /**
     * Get the tooltip
     * 
     * @return \Honed\Chart\Tooltip\Tooltip|null
     */
    public function getTooltip(): ?Tooltip
    {
        return $this->tooltip;
    }

    /**
     * Create a new tooltip, or use the existing one.
     */
    protected function withTooltip(): Tooltip
    {
        return $this->tooltip ??= Tooltip::make();
    }
}