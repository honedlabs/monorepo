<?php

declare(strict_types=1);

namespace Honed\Chart;

use Honed\Chart\Concerns\ExcludesFromDomainCalculation;
use Honed\Chart\Concerns\FiltersUndefined;
use Honed\Chart\Concerns\HasAnimationDuration;
use Honed\Chart\Concerns\HasColor;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Traits\Macroable;
use JsonSerializable;

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
        return $this->snap;
    }

    /**
     * Set whether to snap the crosshair to the nearest value by default.
     * 
     * @param bool $snap
     * @return $this
     */
    public static function shouldSnap($snap = true)
    {
        static::$defaultSnap = $snap;
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
            'hideWhenFarFromPointer' => null,
            'hideWhenFarFromPointerDistance' => null,
            'snapToData' => $this->snaps(),
            ...$this->animationDurationToArray(),
            ...$this->excludeFromDomainToArray(),
        ]);
    }
}