<?php

namespace Honed\Chart;

use Honed\Chart\Concerns\FiltersUndefined;
use Honed\Chart\Concerns\HasPadding;
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
    use HasPadding;
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
     * Whether overlapping labels should be hidden.
     * 
     * @var bool|null
     */
    protected $overlap;

    /**
     * Whether overlapping labels should be hidden by default.
     * 
     * @var bool|null
     */
    protected static $defaultOverlap;

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
     * Set the rotation of the text.
     * 
     * @param int $degrees
     * @return $this
     */
    public function rotation($degrees)
    {
        $this->rotation = $degrees;

        return $this;
    }

    /**
     * Set the rotation of the text.
     * 
     * @param int $degrees
     * @return $this
     */
    public function rotate($degrees)
    {
        return $this->rotation($degrees);
    }

    /**
     * Set the rotation of the text.
     * 
     * @param int $degrees
     * @return $this
     */
    public function angle($degrees)
    {
        return $this->rotation($degrees);
    }

    /**
     * Get the rotation of the text.
     * 
     * @return int|null
     */
    public function getRotation()
    {
        return $this->rotation ?? static::$defaultRotation;
    }

    /**
     * Set the rotation of the text by default.
     * 
     * @param int $degrees
     * @return void
     */
    public static function useRotation($degrees)
    {
        static::$defaultRotation = $degrees;
    }

    /**
     * Set whether overlapping labels should be hidden.
     * 
     * @param bool $hide
     * @return $this
     */
    public function overlap($hide = true)
    {
        $this->overlap = $hide;

        return $this;
    }

    /**
     * Set whether overlapping labels should be hidden.
     * 
     * @param bool $hide
     * @return $this
     */
    public function hideOverlaps($hide = true)
    {
        return $this->overlap($hide);
    }

    /**
     * Get whether overlapping labels should be hidden.
     * 
     * @return bool|null
     */
    public function hidesOverlapping()
    {
        return $this->overlap ?? static::$defaultOverlap;
    }

    /**
     * Set whether overlapping labels should be hidden by default.
     * 
     * @param bool $hide
     * @return void
     */
    public static function shouldHideOverlaps($hide = true)
    {
        static::$defaultOverlap = $hide;
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