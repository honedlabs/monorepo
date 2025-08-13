<?php

declare(strict_types=1);

namespace Honed\Chart\Axis\Concerns;

/**
 * @internal
 */
trait CanBeAlignedWithLabel
{
    /**
     * Whether to align the tick with the label.
     *
     * @var bool
     */
    protected $alignWithLabel = false;

    /**
     * Set whether to align the tick with the label.
     *
     * @return $this
     */
    public function alignWithLabel(bool $value = true): static
    {
        $this->alignWithLabel = $value;

        return $this;
    }

    /**
     * Set whether to not align the tick with the label.
     *
     * @return $this
     */
    public function dontAlignWithLabel(bool $value = true): static
    {
        return $this->alignWithLabel(! $value);
    }

    /**
     * Get whether to align the tick with the label.
     *
     * @return true|null
     */
    public function isAlignedWithLabel(): ?bool
    {
        return $this->alignWithLabel ?: null;
    }

    /**
     * Get whether to not align the tick with the label.
     */
    public function isNotAlignedWithLabel(): bool
    {
        return ! $this->isAlignedWithLabel();
    }
}
