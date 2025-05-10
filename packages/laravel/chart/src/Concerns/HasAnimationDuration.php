<?php

declare(strict_types=1);

namespace Honed\Chart\Concerns;

trait HasAnimationDuration
{
    /**
     * The duration of the animation.
     * 
     * @var int|null
     */
    protected $duration;

    /**
     * The default duration of the animation.
     * 
     * @var int|null
     */
    protected static $defaultDuration;

    /**
     * Set the duration of the animation.
     * 
     * @param int|null $duration
     * @return $this
     */
    public function duration($duration)
    {
        $this->duration = $duration;

        return $this;
    }

    /**
     * Get the duration of the animation.
     * 
     * @return int|null
     */
    public function getDuration()
    {
        return $this->duration ?? static::$defaultDuration;
    }

    /**
     * Set the default duration of the animation.
     * 
     * @param int $duration
     * @return void
     */
    public static function useDuration($duration)
    {
        static::$defaultDuration = $duration;
    }

    /**
     * Flush the state of the animation duration.
     * 
     * @return void
     */
    public static function flushAnimationDurationState()
    {
        static::$defaultDuration = null;
    }

    /**
     * Get the duration of the animation as an array.
     * 
     * @return array<string, mixed>
     */
    public function animationDurationToArray()
    {
        return [
            'duration' => $this->getDuration()
        ];
    }
}