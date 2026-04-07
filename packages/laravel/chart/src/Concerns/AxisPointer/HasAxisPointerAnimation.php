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
     * @var int|float|null
     */
    protected $animationDurationUpdate;

    /**
     * @return $this
     */
    public function pointerAnimation(bool $value = true): static
    {
        $this->pointerAnimation = $value;

        return $this;
    }

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

    public function getAnimationDurationUpdate(): int|float|null
    {
        return $this->animationDurationUpdate;
    }
}
