<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns\AxisPointer;

trait HasAxisPointerAnimation
{
    /**
     * @var bool|null
     */
    protected $pointerAnimation;

    /**
     * Duration (ms) for pointer position updates when the axis scale or layout changes.
     *
     * @var int|float|null
     */
    protected $animationDurationUpdate;

    /**
     * Enable or disable axis pointer animation.
     *
     * @return $this
     */
    public function pointerAnimation(bool $value = true): static
    {
        $this->pointerAnimation = $value;

        return $this;
    }

    /**
     * Whether axis pointer animation is enabled.
     */
    public function getPointerAnimation(): ?bool
    {
        return $this->pointerAnimation;
    }

    /**
     * @return $this
     */
    public function animationDurationUpdate(int|float|null $value): static
    {
        $this->animationDurationUpdate = $value;

        return $this;
    }

    /**
     * @return int|float|null
     */
    public function getAnimationDurationUpdate(): int|float|null
    {
        return $this->animationDurationUpdate;
    }
}
