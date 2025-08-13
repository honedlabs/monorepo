<?php

declare(strict_types=1);

namespace Honed\Chart\Axis\Concerns;

/**
 * @internal
 */
trait CanBeInverted
{
    /**
     * Whether the axis should be inverted.
     *
     * @var bool|null
     */
    protected $invert;

    /**
     * Set whether to contain the zero position of the axis compulsively.
     *
     * @return $this
     */
    public function invert(bool $value = true): static
    {
        $this->invert = $value;

        return $this;
    }

    /**
     * Set whether to not contain the zero position of the axis compulsively.
     *
     * @return $this
     */
    public function dontInvert(bool $value = true): static
    {
        return $this->invert(! $value);
    }

    /**
     * Get whether to contain the zero position of the axis compulsively.
     *
     * @return true|null
     */
    public function isInverted(): ?bool
    {
        return $this->invert ?: null;
    }

    /**
     * Get whether to not contain the zero position of the axis compulsively.
     */
    public function isNotInverted(): bool
    {
        return ! $this->isInverted();
    }
}
