<?php

declare(strict_types=1);

namespace Honed\Chart\Charts;

use Honed\Chart\Series;
use Honed\Chart\Concerns\HasColor;
use Honed\Chart\Concerns\HasCurveType;
use Honed\Chart\Concerns\ExcludesFromDomainCalculation;
use Honed\Chart\Support\Constants;

class Area extends Series
{
    use HasColor;
    use HasCurveType;
    use ExcludesFromDomainCalculation;

    /**
     * The opacity of the area.
     * 
     * @var int
     */
    protected $opacity = 100;

    /**
     * Whether to always show an area if the pixel height is less than 1.
     * 
     * @var bool|null
     */
    protected $floor;

    /**
     * Whether to always show an area if the pixel height is less than 1 by default.
     * 
     * @var bool|null
     */
    protected static $defaultFloor;

    /**
     * {@inheritDoc}
     */
    public function getType()
    {
        return Constants::AREA_CHART;
    }

    /**
     * Set the opacity of the area.
     * 
     * @param int $opacity
     * @return $this
     */
    public function opacity($opacity)
    {
        $this->opacity = $opacity;

        return $this;
    }

    /**
     * Get the opacity of the area.
     * 
     * @return float
     */
    public function getOpacity()
    {
        return $this->opacity / 100;
    }    

    /**
     * Set whether to always show an area if the pixel height is less than 1.
     * 
     * @param bool $floor
     * @return $this
     */
    public function floor($floor = true)
    {
        $this->floor = $floor;

        return $this;
    }

    /**
     * Get whether to always show an area if the pixel height is less than 1.
     * 
     * @return bool
     */
    public function isFlooring()
    {
        return $this->floor ?? static::$defaultFloor;
    }

    /**
     * Set whether to always show an area if the pixel height is less than 1 by
     * default.
     * 
     * @param bool $floor
     * @return void
     */
    public static function shouldFloor($floor = true)
    {
        static::$defaultFloor = $floor;
    }
    public function toArray()
    {
        return $this->filterUndefined(
            \array_merge(parent::toArray(), [
                'color' => $this->getColor(),
                'curveType' => $this->getCurveType(),
                // 'baseline' => $this->getBaseline(),
                'opacity' => $this->getOpacity(),
                'minHeight1Px' => $this->isFlooring(),
                'excludeFromDomainCalculation' => $this->isExcludedFromDomain(),
            ])
        );
    }
}