<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns\Components;

use Closure;
use Honed\Chart\Legend;

trait HasLegend
{
    /**
     * The legend.
     *
     * @var ?Legend
     */
    protected $legendInstance;

    /**
     * Add a legend.
     *
     * @param  Legend|(Closure(Legend):Legend)|bool|null  $value
     * @return $this
     */
    public function legend(Legend|Closure|bool|null $value = true): static
    {
        $this->legendInstance = match (true) {
            $value => $this->withLegend(),
            ! $value => null,
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
        return $this->legendInstance;
    }

    /**
     * Create a new legend, or use the existing one.
     */
    protected function withLegend(): Legend
    {
        return $this->legendInstance ??= Legend::make();
    }
}
