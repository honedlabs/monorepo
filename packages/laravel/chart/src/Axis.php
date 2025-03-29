<?php

declare(strict_types=1);

namespace Honed\Chart;

use Honed\Chart\Concerns\HasColor;
use Honed\Core\Primitive;

class Axis extends Primitive
{
    use HasColor;

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
     * 
     */
    protected $grid;

    protected $line;

    protected $ticks;

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
     * Set the axis to be for the X axis.
     * 
     * @return $this
     */
    public function x()
    {
        $this->type = 'x';

        return $this;
    }

    /**
     * Set the axis to be for the Y axis.
     * 
     * @return $this
     */
    public function y()
    {
        $this->type = 'y';

        return $this;
    }

    public function toArray()
    {
        return [
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


        ];
    }
    
}
