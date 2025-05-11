<?php

namespace Honed\Chart;

use Honed\Chart\Concerns\FiltersUndefined;
use Honed\Chart\Concerns\HasWidth;
use Illuminate\Contracts\Support\Arrayable;
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
    public static function shouldShowLine(bool $show = true)
    {
        static::$defaultLine = $show;
    }

    /**
     * Set the tick values to use.
     * 
     * @param array<int, mixed> $values
     * @return $this
     */
    public function values(array $values)
    {
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
            'tickTextFontSize' => $this->getFontSize(),
            'tickTextColor' => $this->getColor(),
            'tickTextAngle' => $this->getRotation(),
            'tickTextAlign',
            'tickTextWidth' => $this->getWidth(),
            'tickTextFitMode',
            'tickTextTrimType',
            'tickTextForceWordBreak',
            'numTicks' => $this->getQuantity(),
            'minMaxTicksOnly' => $this->isMinMax(),
            'tickValues' => $this->getValues(),
            'tickTextHideOverlapping' => $this->hidesOverlapping(),
        ]);
    }
}