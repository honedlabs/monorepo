<?php

declare(strict_types=1);

namespace Honed\Chart;

use Honed\Chart\Concerns\FiltersUndefined;
use Honed\Core\Primitive;
use Honed\Chart\Concerns\HasColor;
use Honed\Chart\Exceptions\InvalidAxisException;

class Axis extends Primitive
{
    use HasColor;
    use FiltersUndefined;

    /**
     * The display label for this axis.
     * 
     * @var string|null
     */
    protected $label;

    /**
     * The type of the axis.
     * 
     * @var 'x'|'y'
     */
    protected $type;

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

    public static function make()
    {
        return new self;
    }

    /**
     * Set the display label for this axis.
     * 
     * @param string|null $label
     * @return $this
     */
    public function label($label)
    {
        $this->label = $label;

        return $this;
    }

    /**
     * Get the display label for this axis.
     * 
     * @return string|null
     */
    public function getLabel()
    {
        return $this->label;
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
            'label' => $this->getLabel(),
            'position' => $this->getPosition(),
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
