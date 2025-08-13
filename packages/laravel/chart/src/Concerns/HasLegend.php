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
     * @var Legend|null
     */
    protected $legend;

    /**
     * Add a legend.
     *
     * @param  Legend|(Closure(Legend):Legend)|null  $value
     * @return $this
     */
    public function legend(Legend|Closure|null $value = null): static
    {
        $this->legend = match (true) {
            is_null($value) => $this->withLegend(),
            $value instanceof Closure => $value($this->withLegend()),
            default => $value,
        };

        return $this;
    }

    /**
     * Get the legend
     */
    public function getLegend(): ?Legend
    {
        return $this->legend;
    }

    /**
     * Create a new legend, or use the existing one.
     */
    protected function withLegend(): Legend
    {
        return $this->legend ??= Legend::make();
    }
}
