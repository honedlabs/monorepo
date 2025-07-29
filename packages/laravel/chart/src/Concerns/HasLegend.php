<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

use Closure;
use Honed\Chart\Legend\Legend;

trait HasLegend
{
    /**
     * The legend.
     * 
     * @var \Honed\Chart\Legend\Legend|null
     */
    protected $legend;

    /**
     * Add a legend.
     * 
     * @param \Honed\Chart\Legend\Legend|(Closure(\Honed\Chart\Legend\Legend):mixed)|null $value
     * @return $this
     */
    public function legend(Legend|Closure|null $value): static
    {
        return match (true) {
            is_null($value) => $this->newLegend(),
            $value instanceof Closure => $value($this->newLegend()),
            default => $this->legend = $value,
        };

        return $this;
    }

    /**
     * Get the legend
     * 
     * @return \Honed\Chart\Legend\Legend|null
     */
    public function getLegend(): ?Legend
    {
        return $this->legend;
    }

    /**
     * Create a new legend, or use the existing one.
     */
    protected function newLegend(): Legend
    {
        return $this->legend ??= Legend::make();
    }
}