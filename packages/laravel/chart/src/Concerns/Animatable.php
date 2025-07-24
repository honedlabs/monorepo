<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

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
     * @var \Honed\Chart\Enums\Easing|null
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
     * @var \Honed\Chart\Enums\Easing|null
     */
    protected $animationEasingUpdate;

    /**
     * Delay before updating animation.
     * 
     * @var int|null
     */
    protected $animationDelayUpdate;
}
