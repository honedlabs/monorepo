<?php

declare(strict_types=1);

namespace Honed\Chart;

use Honed\Chart\Concerns\ExcludesFromDomainCalculation;
use Honed\Chart\Concerns\FiltersUndefined;
use Honed\Chart\Concerns\HasAnimationDuration;
use Honed\Core\Primitive;
use Honed\Chart\Concerns\HasColor;
use Honed\Chart\Exceptions\InvalidAxisException;

class Axis extends Primitive
{
    use HasColor;
    use FiltersUndefined;
    use ExcludesFromDomainCalculation;
    use HasAnimationDuration;

    /**
     * The type of the axis.
     * 
     * @var 'x'|'y'
     */
    protected $type;

    /**
     * Whether to extend the axis domain line to be full width or height.
     * 
     * @var bool|null
     */
    protected $fullSize;

    /**
     * The display label for this axis.
     * 
     * @var string|null
     */
    protected $label;

    /**
     * Whether to show the grid lines.
     * 
     * @var bool|null
     */
    protected $grid;

    /**
     * Whether to show the grid lines by default.
     * 
     * @var bool|null
     */
    protected static $defaultGrid;

    /**
     * Whether to show the domain lines.
     * 
     * @var bool|null
     */
    protected $domain;

    /**
     * Whether to show the domain lines by default.
     * 
     * @var bool|null
     */
    protected static $defaultDomain;

    /**
     * Whether to show the tick lines.
     * 
     * @var bool|null
     */
    protected $ticks;

    /**
     * Whether to show the tick lines by default.
     * 
     * @var bool|null
     */
    protected static $defaultTicks;

    /**
     * Create a new axis.
     * 
     * @param string|null $label
     * @return static
     */
    public static function make($label = null)
    {
        return resolve(static::class)
            ->label($label);
    }

    /**
     * Set which axis this is for.
     * 
     * @param 'x'|'y' $type
     * @return $this
     * 
     * @throws \Honed\Chart\Exceptions\InvalidAxisException
     */
    public function type($type)
    {
        if (! in_array($type, ['x', 'y'])) {
            InvalidAxisException::throw($type);
        }

        $this->type = $type;

        return $this;
    }

    /**
     * Set which axis this is for.
     * 
     * @param 'x'|'y' $type
     * @return $this
     * 
     * @throws \Honed\Chart\Exceptions\InvalidAxisException
     */
    public function for($type)
    {
        return $this->type($type);
    }

    /**
     * Set the axis to be for the X axis.
     * 
     * @return $this
     */
    public function x()
    {
        return $this->for('x');
    }

    /**
     * Set the axis to be for the Y axis.
     * 
     * @return $this
     */
    public function y()
    {
        return $this->for('y');
    }

    public function toArray()
    {
        return $this->filterUndefined([
            'type' => $this->getType(),
            'position' => $this->getPosition(),
            ...$this->getLabel()?->toArray(),
            'fullSize' => $this->isFullSize(),
            'gridLine' => $this->isGrid(),
            'domainLine' => $this->isDomain(),
            ...$this->getTick()?->toArray(),
            ...$this->excludeFromDomainToArray(),
            ...$this->animationDurationToArray(),
            
            'labelFontSize' => null,
            'labelColor' => null,
            'labelMargin' => null,
            'gridLine' => null,
            'domainLine' => null,
            'tickLine' => null,
            'tickTextFontSize' => null,
            'tickTextColor' => null,
            'tickTextAlign' => null,
            'tickTextAngle' => null,
            'tickTextAlign' => null,
            'tickTextWidth' => null,
            'tickTextFitMode' => null,
            'tickTextTrimType' => null,
            'tickTextForceWordBreak' => null,
            'numTicks' => null,
            'minMaxTicksOnly' => null,
            'tickValues' => null,
            'tickTextHideOverlapping' => null,
            'duration' => null,
        ]);
    }
    
}
