<?php

declare(strict_types=1);

namespace Honed\Chart\Series\Line\Concerns;

/**
 * @internal
 */
trait HasStep
{
    /**
     * Whether to show the step.
     * 
     * @var bool|string|null
     */
    protected $step;

    /**
     * Set whether to show the step.
     * 
     * @return $this
     */
    public function step(bool|string $value = true): static
    {
        $this->step = $value;

        return $this;
    }

    /**
     * Get whether to show the step.
     */
    public function getStep(): bool|string|null
    {
        return $this->step;
    }
}