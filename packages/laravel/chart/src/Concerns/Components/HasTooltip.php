<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns\Components;

use Closure;
use Honed\Chart\Tooltip;

trait HasTooltip
{
    /**
     * The tooltip.
     *
     * @var ?Tooltip
     */
    protected $tooltipInstance;

    /**
     * Add a tooltip.
     *
     * @param  Tooltip|(Closure(Tooltip):Tooltip)|bool|null  $value
     * @return $this
     */
    public function tooltip(Tooltip|Closure|bool|null $value = true): static
    {
        $this->tooltipInstance = match (true) {
            $value => $this->withTooltip(),
            $value instanceof Closure => $value($this->withTooltip()),
            $value instanceof Tooltip => $value,
            default => null,
        };

        return $this;
    }

    /**
     * Get the tooltip
     */
    public function getTooltip(): ?Tooltip
    {
        return $this->tooltipInstance;
    }

    /**
     * Create a new tooltip, or use the existing one.
     */
    protected function withTooltip(): Tooltip
    {
        return $this->tooltipInstance ??= Tooltip::make();
    }
}
