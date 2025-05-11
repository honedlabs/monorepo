<?php

namespace Honed\Chart;

use Honed\Chart\Concerns\FiltersUndefined;
use Honed\Chart\Concerns\HasWidth;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Collection;
use Illuminate\Support\Traits\Conditionable;
use Illuminate\Support\Traits\Macroable;
use JsonSerializable;

/**
 * @implements \Illuminate\Contracts\Support\Arrayable<string, mixed>
 */
class Tick implements Arrayable, JsonSerializable
{
    use Macroable;
    use Conditionable;
    use HasWidth;
    use FiltersUndefined;

    /**
     * Whether to show the tick line.
     * 
     * @var bool|null
     */
    protected $line;

    /**
     * Whether to show the tick line by default.
     * 
     * @var bool|null
     */
    protected static $defaultLine;

    /**
     * How to align the tick with respect to the marker.
     * 
     * @var string|null
     */
    protected $align;

    /**
     * How to align the tick with respect to the marker by default.
     * 
     * @var string|null
     */
    protected static $defaultAlign;

    /**
     * The rotation of the text in degrees
     * 
     * @var int|null
     */
    protected $rotation;

    /**
     * The rotation of the text in degrees by default.
     * 
     * @var int|null
     */
    protected static $defaultRotation;

    /**
     * 
     */
    protected $trim;

    /**
     * 
     */
    protected $trimType;

    /**
     * 
     */
    protected $wordBreak;

    /**
     * The number of ticks to show.
     * 
     * @var int|null
     */
    protected $number;

    /**
     * Whether to only display the minimum and maximum ticks.
     * 
     * @var bool|null
     */
    protected $minMax;

    /**
     * The tick values to use.
     * 
     * @var array<int, mixed>|null
     */
    protected $values;

    /**
     * Set whether the tick line should be shown.
     * 
     * @param bool $show
     * @return $this
     */
    public function line($show = true)
    {
        $this->line = $show;

        return $this;
    }

    /**
     * Set whether the tick line should be shown.
     * 
     * @param bool $show
     * @return void
     */
    public function showLine($show = true)
    {
        return $this->line($show);
    }

    /**
     * Get whether the tick line should be shown.
     * 
     * @return bool|null
     */
    public function showsLine()
    {
        return $this->line ?? static::$defaultLine;
    }

    /**
     * Set whether the tick line should be shown by default.
     * 
     * @param bool $show
     * @return void
     */
    public static function shouldShowLine($show = true)
    {
        static::$defaultLine = $show;
    }

    /**
     * Set the tick values to use.
     * 
     * @param iterable<int, mixed> $values
     * @return $this
     */
    public function values($values)
    {
        if ($values instanceof Collection) {
            $values = $values->all();
        }

        $this->values = $values;

        return $this;
    }

    /**
     * Get the tick values to use.
     * 
     * @return array<int, mixed>|null
     */
    public function getValues()
    {
        return $this->values;
    }

    /**
     * Flush the state of the tick.
     * 
     * @return void
     */
    public static function flushState()
    {
        static::$defaultLine = null;
        static::$defaultAlign = null;
    }

    /**
     * Get the colour configuration as an array.
     * 
     * @return array<string, mixed>
     */
    public function colorToArray()
    {
        return [
            'tickTextColor' => $this->getColor()
        ];
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
            'tickLine' => $this->showsLine(),
            'minMaxTicksOnly' => $this->isMinMax(),
            'minMaxTicksOnlyWhenWidthIsLess',
            'tickValues' => $this->getValues(),
            'numTicks' => $this->getQuantity(),
            'tickTextFitMode' => $this->getFitMode(),
            'tickTextWidth' => $this->getWidth(),
            'tickTextForceWordBreak' => $this->breaks(),
            'tickTextTrimType' => $this->getTrimType(),
            'tickTextFontSize' => $this->getFontSize(),
            'tickTextAlign',
            ...$this->colorToArray(),
            'tickTextAngle' => $this->getRotation(),
            'tickTextHideOverlapping' => $this->hidesOverlapping(),
            'tickPadding' => $this->getPadding(),
        ]);
    }
}