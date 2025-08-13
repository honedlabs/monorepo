<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

use Honed\Chart\Enums\Easing;
use ValueError;

trait Animatable
{
    /**
     * Whether to enable animation
     *
     * @var bool|null
     */
    protected $animation;

    /**
     * Whether to set graphic number threshold to animation. Animation will be disabled when graphic number is larger than threshold.
     *
     * @var int|null
     */
    protected $animationThreshold;

    /**
     * Duration of  the first animation.
     *
     * @var int|null
     */
    protected $animationDuration;

    /**
     * Easing method used for the first animation.
     *
     * @var Easing|null
     */
    protected $animationEasing;

    /**
     * Delay before updating the first animation.
     *
     * @var int|null
     */
    protected $animationDelay;

    /**
     * Time for animation to complete.
     *
     * @var int|null
     */
    protected $animationDurationUpdate;

    /**
     * Easing method used for animation.
     *
     * @var Easing|null
     */
    protected $animationEasingUpdate;

    /**
     * Delay before updating animation.
     *
     * @var int|null
     */
    protected $animationDelayUpdate;

    /**
     * Set whether to enable animation.
     *
     * @return $this
     */
    public function animate(bool $value = true): static
    {
        $this->animation = $value;

        return $this;
    }

    /**
     * Set whether to not enable animation.
     *
     * @return $this
     */
    public function dontAnimate(bool $value = true): static
    {
        return $this->animate(! $value);
    }

    /**
     * Get whether to enable animation.
     *
     * @return true|null
     */
    public function isAnimated(): ?bool
    {
        return $this->animation ?: null;
    }

    /**
     * Get whether to not enable animation.
     *
     * @return true|null
     */
    public function isNotAnimated(): ?bool
    {
        return ! $this->animation ?: null;
    }

    /**
     * Set the animation threshold.
     *
     * @return $this
     */
    public function animationThreshold(?int $value): static
    {
        $this->animationThreshold = $value;

        return $this;
    }

    /**
     * Get the animation threshold.
     */
    public function getAnimationThreshold(): ?int
    {
        return $this->animationThreshold;
    }

    /**
     * Set the animation duration.
     *
     * @return $this
     */
    public function animationDuration(?int $value): static
    {
        $this->animationDuration = $value;

        return $this;
    }

    /**
     * Get the animation duration.
     */
    public function getAnimationDuration(): ?int
    {
        return $this->animationDuration;
    }

    /**
     * Set the animation easing method used for the first animation.
     *
     * @return $this
     *
     * @throws ValueError if the easing method is not a valid easing method
     */
    public function animationEasing(Easing|string $value): static
    {
        if (! $value instanceof Easing) {
            $value = Easing::from($value);
        }

        $this->animationEasing = $value;

        return $this;
    }

    /**
     * Get the animation easing method used for the first animation.
     */
    public function getAnimationEasing(): ?string
    {
        return $this->animationEasing?->value;
    }

    /**
     * Set the animation delay.
     *
     * @return $this
     */
    public function animationDelay(?int $value): static
    {
        $this->animationDelay = $value;

        return $this;
    }

    /**
     * Get the animation delay.
     */
    public function getAnimationDelay(): ?int
    {
        return $this->animationDelay;
    }

    /**
     * Set the animation duration update.
     *
     * @return $this
     */
    public function animationDurationUpdate(?int $value): static
    {
        $this->animationDurationUpdate = $value;

        return $this;
    }

    /**
     * Get the animation duration update.
     */
    public function getAnimationDurationUpdate(): ?int
    {
        return $this->animationDurationUpdate;
    }

    /**
     * Set the animation easing method used for animation.
     *
     * @return $this
     *
     * @throws ValueError if the easing method is not a valid easing method
     */
    public function animationEasingUpdate(Easing|string $value): static
    {
        if (! $value instanceof Easing) {
            $value = Easing::from($value);
        }

        $this->animationEasingUpdate = $value;

        return $this;
    }

    /**
     * Get the animation easing method used for animation.
     */
    public function getAnimationEasingUpdate(): ?string
    {
        return $this->animationEasingUpdate?->value;
    }

    /**
     * Get the animation parameters as an array representation.
     *
     * @return array<string, mixed>
     */
    public function getAnimationParameters(): array
    {
        return [
            'animation' => $this->isAnimated(),
            'animationThreshold' => $this->getAnimationThreshold(),
            'animationDuration' => $this->getAnimationDuration(),
            'animationEasing' => $this->getAnimationEasing(),
            'animationDelay' => $this->getAnimationDelay(),
            'animationDurationUpdate' => $this->getAnimationDurationUpdate(),
            'animationEasingUpdate' => $this->getAnimationEasingUpdate(),
        ];
    }
}
