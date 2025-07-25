<?php

declare(strict_types=1);

namespace Honed\Chart\Axis\Concerns;

trait CanBeScaled
{
    /**
     * Whether to contain the zero position of the axis compulsively.
     * 
     * @var bool|null
     */
    protected $scale;

    /**
     * Set whether to contain the zero position of the axis compulsively.
     * 
     * @return $this
     */
    public function scale(bool $value = true): static
    {
        $this->scale = $value;

        return $this;
    }

    /**
     * Set whether to not contain the zero position of the axis compulsively.
     * 
     * @return $this
     */
    public function dontScale(bool $value = true): static
    {
        return $this->scale(! $value);
    }

    /**
     * Get whether to contain the zero position of the axis compulsively.
     * 
     * @return true|null
     */
    public function isScaled(): ?bool
    {
        return $this->scale ?: null;
    }

    /**
     * Get whether to not contain the zero position of the axis compulsively.
     */
    public function isNotScaled(): bool
    {
        return ! $this->isScaled();
    }
}
