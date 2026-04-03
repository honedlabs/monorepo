<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns\Components;

use Closure;
use Honed\Chart\Tooltip\Tooltip;

trait HasTooltip
{
    /**
     * The tooltip.
     *
     * @var ?Tooltip
     */
    protected $tooltip;

    /**
     * Add a tooltip.
     *
     * @param  Tooltip|(Closure(Tooltip):Tooltip)|bool|null  $value
     * @return $this
     */
    public function tooltip(Tooltip|Closure|bool|null $value = true): static
    {
        $this->tooltip = match (true) {
            $value => $this->withTooltip(),
            ! $value => null,
            $value instanceof Closure => $value($this->withTooltip()),
            default => $value,
        };

        return $this;
    }

    /**
     * Get the tooltip
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
