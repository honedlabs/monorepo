<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns\Emphasis;

trait HasScale
{
    /**
     * Whether to scale the element when highlighted (for example, pie sectors).
     *
     * @var bool|null
     */
    protected $scale;

    /**
     * Additional size to apply when scaling in the emphasis state.
     *
     * @var int|float|null
     */
    protected $scaleSize;

    /**
     * Set whether to scale the element when highlighted.
     *
     * @return $this
     */
    public function scale(bool $value = true): static
    {
        $this->scale = $value;

        return $this;
    }

    /**
     * Get whether scaling is enabled for emphasis.
     */
    public function getScale(): ?bool
    {
        return $this->scale;
    }

    /**
     * Set the extra size applied when scaling in the emphasis state.
     *
     * @return $this
     */
    public function scaleSize(int|float|null $value): static
    {
        $this->scaleSize = $value;

        return $this;
    }

    /**
     * Get the emphasis scale size.
     */
    public function getScaleSize(): int|float|null
    {
        return $this->scaleSize;
    }
}
