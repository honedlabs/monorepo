<?php

declare(strict_types=1);

namespace Honed\Chart;

use JsonSerializable;
use Honed\Chart\Concerns\HasColor;
use Honed\Chart\Concerns\HasStroke;
use Illuminate\Support\Traits\Macroable;
use Honed\Chart\Concerns\FiltersUndefined;
use Illuminate\Contracts\Support\Arrayable;
use Honed\Chart\Concerns\HasAnimationDuration;
use Honed\Chart\Concerns\ExcludesFromDomainCalculation;

/**
 * @implements \Illuminate\Contracts\Support\Arrayable<string, mixed>
 */
class CrossHair implements Arrayable, JsonSerializable
{
    use Macroable;
    use FiltersUndefined;
    use HasColor;
    use HasStroke;
    use HasAnimationDuration;
    use ExcludesFromDomainCalculation;

    /**
     * Whether to hide the crosshair when far from the pointer.
     * 
     * @var bool|null
     */
    protected $hide;

    /**
     * Whether to hide the crosshair when far from the pointer by default.
     * 
     * @var bool|null
     */
    protected static $defaultHide;

    /**
     * The distance from the pointer at which the crosshair is hidden.
     * 
     * @var int|null
     */
    protected $hideAt;

    /**
     * The distance from the pointer at which the crosshair is hidden by 
     * default.
     * 
     * @var int|null
     */
    protected static $defaultHideAt;

    /**
     * Whether to snap the crosshair to the nearest value.
     * 
     * @var bool|null
     */
    protected $snap;
    
    /**
     * Whether to snap the crosshair to the nearest value by default.
     * 
     * @var bool|null
     */
    protected static $defaultSnap;

    /**
     * Create a new crosshair instance.
     * 
     * @return static
     */
    public static function make()
    {
        return resolve(static::class);
    }

    /**
     * Set whether to hide the crosshair when far from the pointer.
     * 
     * @param bool $hide
     * @return $this
     */
    public function hide($hide = true)
    {
        $this->hide = $hide;

        return $this;
    }

    /**
     * Get whether to hide the crosshair when far from the pointer.
     * 
     * @return bool|null
     */
    public function hides()
    {
        return $this->hide ?? static::$defaultHide;
    }

    /**
     * Set whether to hide the crosshair when far from the pointer by default.
     * 
     * @param bool $hide
     * @return void
     */
    public static function shouldHide($hide = true)
    {
        static::$defaultHide = $hide;
    }

    /**
     * Set the distance from the pointer at which the crosshair is hidden.
     * 
     * @param int $pixels
     * @return $this
     */
    public function hideAt($pixels)
    {
        $this->hideAt = $pixels;

        return $this;
    }

    /**
     * Get the distance from the pointer at which the crosshair is hidden.
     * 
     * @return int|null
     */
    public function getHideDistance()
    {
        return $this->hideAt ?? static::$defaultHideAt;
    }

    /**
     * Set the distance from the pointer at which the crosshair is hidden by 
     * default.
     * 
     * @param int $pixels
     * @return void
     */
    public static function useHideDistance($pixels)
    {
        static::$defaultHideAt = $pixels;
    }

    /**
     * Set whether to snap the crosshair to the nearest value.
     * 
     * @param bool $snap
     * @return $this
     */
    public function snap($snap = true)
    {
        $this->snap = $snap;
        
        return $this;
    }

    /**
     * Get whether to snap the crosshair to the nearest value.
     * 
     * @return bool|null
     */
    public function snaps()
    {
        return $this->snap ?? static::$defaultSnap;
    }

    /**
     * Set whether to snap the crosshair to the nearest value by default.
     * 
     * @param bool $snap
     * @return void
     */
    public static function shouldSnap($snap = true)
    {
        static::$defaultSnap = $snap;
    }

    /**
     * Flush the state of the crosshair.
     * 
     * @return void
     */
    public static function flushState()
    {
        static::$defaultHide = null;
        static::$defaultHideAt = null;
        static::$defaultSnap = null;
        static::flushStrokeState();
        static::flushAnimationDurationState();
        static::flushExcludeFromDomainCalculationState();
    }

    /**
     * {@inheritdoc}
     */
    public function jsonSerialize(): mixed
    {
        return $this->toArray();
    }

    /**
     * {@inheritdoc}
     */
    public function toArray()
    {
        return $this->filterUndefined([
            ...$this->colorToArray(),
            ...$this->strokeToArray(),
            'hideWhenFarFromPointer' => $this->hides(),
            'hideWhenFarFromPointerDistance' => $this->getHideDistance(),
            'snapToData' => $this->snaps(),
            ...$this->animationDurationToArray(),
            ...$this->excludeFromDomainToArray(),
        ]);
    }
}