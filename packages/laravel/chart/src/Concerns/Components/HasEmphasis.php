<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns\Components;

use Closure;
use Honed\Chart\Emphasis;

trait HasEmphasis
{
    /**
     * The ECharts `emphasis` option (highlight state) for this component, typically a series.
     *
     * @var Emphasis|null
     */
    protected $emphasisInstance;

    /**
     * Set the emphasis configuration.
     *
     * @param  Emphasis|(Closure(Emphasis): Emphasis)|bool|null  $value
     * @return $this
     */
    public function emphasis(Emphasis|Closure|bool|null $value = true): static
    {
        $this->emphasisInstance = match (true) {
            $value instanceof Closure => $value($this->withEmphasis()),
            $value instanceof Emphasis => $value,
            $value === true => $this->withEmphasis(),
            default => null,
        };

        return $this;
    }

    /**
     * Get the emphasis configuration.
     *
     * @return Emphasis|null
     */
    public function getEmphasis(): ?Emphasis
    {
        return $this->emphasisInstance;
    }

    /**
     * Lazily resolve the emphasis instance for proxies and closures.
     */
    protected function withEmphasis(): Emphasis
    {
        return $this->emphasisInstance ??= Emphasis::make();
    }
}
