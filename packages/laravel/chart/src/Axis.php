<?php

declare(strict_types=1);

namespace Honed\Chart;

use Honed\Chart\Concerns\HasColor;
use Honed\Chart\Concerns\HasAnimationDuration;
use Honed\Chart\Exceptions\InvalidAxisException;
use Honed\Chart\Concerns\ExcludesFromDomainCalculation;

class Axis extends ChartComponent
{
    use HasColor;
    use ExcludesFromDomainCalculation;
    use HasAnimationDuration;

    /**
     * The type of the axis.
     * 
     * @var 'x'|'y'|null
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
     * @var \Honed\Chart\Label|null
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
     * @var \Honed\Chart\Tick|null
     */
    protected $tick;

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
     */
    public function type($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the type of the axis.
     * 
     * @return 'x'|'y'
     * 
     * @throws \Honed\Chart\Exceptions\InvalidAxisException
     */
    public function getType()
    {
        if (! in_array($this->type, ['x', 'y'])) {
            InvalidAxisException::throw($this->type);
        }

        return $this->type;
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
        return $this->type('x');
    }

    /**
     * Set the axis to be for the Y axis.
     * 
     * @return $this
     */
    public function y()
    {
        return $this->type('y');
    }

    /**
     * Flush the state of the axis.
     * 
     * @return void
     */
    public static function flushState()
    {
        static::$defaultGrid = null;
        static::$defaultDomain = null;

        static::flushAnimationDurationState();
        static::flushExcludeFromDomainCalculationState();
    }

    /**
     * {@inheritdoc}
     */
    public function representation()
    {
        return [
            'type' => $this->getType(),
            'position' => $this->getPosition(),
            ...($this->getLabel()?->toArray() ?? []),
            'fullSize' => $this->isFullSize(),
            'gridLine' => $this->isGrid(),
            'domainLine' => $this->isDomain(),
            ...($this->getTick()?->toArray() ?? []),
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
        ];
    }

    public function __get($name)
    {
        dd($name);
    }
}
