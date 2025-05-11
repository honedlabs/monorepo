<?php

declare(strict_types=1);

namespace Honed\Chart;

use JsonSerializable;
use Honed\Chart\Enums\Position;
use Illuminate\Support\Traits\Macroable;
use Honed\Chart\Concerns\FiltersUndefined;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Support\Traits\Conditionable;
use Honed\Chart\Exceptions\InvalidPositionException;

class Tooltip implements Arrayable, JsonSerializable
{
    use Macroable;
    use Conditionable;
    use FiltersUndefined;

    /**
     * Whether the tooltip should follow the mouse cursor
     * 
     * @var bool|null
     */
    protected $follow;

    /**
     * Whether the tooltip should follow the mouse cursor by default
     * 
     * @var bool|null
     */
    protected static $defaultFollow;

    /**
     * Whether the tooltip can be hovered, when follow is false
     * 
     * @var bool|null
     */
    protected $hover;

    /**
     * Whether the tooltip can be hovered by default, when follow is false
     * 
     * @var bool|null
     */
    protected static $defaultHover;

    /**
     * The horizontal placement of the tooltip.
     * 
     * @var 'left'|'right'|null
     */
    protected $horizontalPosition;

    /**
     * The vertical placement of the tooltip.
     * 
     * @var 'top'|'bottom'|null
     */
    protected $verticalPosition;

    /**
     * The horizontal shift of the tooltip.
     * 
     * @var int|null
     */
    protected $horizontalShift;

    /**
     * The vertical shift of the tooltip.
     * 
     * @var int|null
     */
    protected $verticalShift;
    
    /**
     * Set whether the tooltip should follow the mouse cursor.
     * 
     * @param bool $follow
     * @return $this
     */
    public function follow($follow = true)
    {
        $this->follow = $follow;

        return $this;
    }

    /**
     * Get whether the tooltip should follow the mouse cursor.
     * 
     * @return bool|null
     */
    public function follows()
    {
        return $this->follow ?? static::$defaultFollow;
    }

    /**
     * Set whether the tooltip should follow the mouse cursor by default.
     * 
     * @param bool $follow
     * @return void
     */
    public static function shouldFollow($follow = true)
    {
        static::$defaultFollow = $follow;
    }

    /**
     * Set whether the tooltip can be hovered, when follow is false.
     * 
     * @param bool $hover
     * @return $this
     */
    public function hover($hover = true)
    {
        $this->hover = $hover;

        return $this;
    }

    /**
     * Get whether the tooltip can be hovered, when follow is false.
     * 
     * @return bool|null
     */
    public function hovers()
    {
        return $this->hover ?? static::$defaultHover;
    }

    /**
     * Set whether the tooltip can be hovered by default, when follow is false.
     * 
     * @param bool $hover
     * @return void
     */
    public static function shouldHover($hover = true)
    {
        static::$defaultHover = $hover;
    }

    /**
     * Set the horizontal placement of the tooltip.
     * 
     * @param string|\Honed\Chart\Enums\Position $position
     * @return $this
     * 
     * @throws \Honed\Chart\Exceptions\InvalidPositionException
     */
    public function horizontalPosition($position)
    {
        if (! $position instanceof Position) {
            $position = Position::tryFrom($position);
        }

        if (! $position || ! $position->isHorizontal()) {
            InvalidPositionException::throw($position, 'horizontal');
        }

        $this->horizontalPosition = $position?->value;

        return $this;
    }

    /**
     * Get the horizontal placement of the tooltip.
     * 
     * @return string|null
     */
    public function getHorizontalPosition()
    {
        return $this->horizontalPosition;
    }

    /**
     * Set the horizontal placement of the tooltip.
     * 
     * @param string|\Honed\Chart\Enums\Position $position
     * @return $this
     * 
     * @throws \Honed\Chart\Exceptions\InvalidPositionException
     */
    public function place($position)
    {
        return $this->horizontalPosition($position);
    }

    /**
     * Set the horizontal placement of the tooltip.
     * 
     * @param string|\Honed\Chart\Enums\Position $position
     * @return $this
     * 
     * @throws \Honed\Chart\Exceptions\InvalidPositionException
     */
    public function placement($position)
    {
        return $this->horizontalPosition($position);
    }

    /**
     * Set the vertical placement of the tooltip.
     * 
     * @param string|\Honed\Chart\Enums\Position $position
     * @return $this
     * 
     * @throws \Honed\Chart\Exceptions\InvalidPositionException
     */
    public function verticalPosition($position)
    {
        if (! $position instanceof Position) {
            $position = Position::tryFrom($position);
        }

        if (! $position || ! $position->isVertical()) {
            InvalidPositionException::throw($position, 'horizontal');
        }

        $this->verticalPosition = $position?->value;

        return $this;
    }

    /**
     * Get the vertical placement of the tooltip.
     * 
     * @return string|null
     */
    public function getVerticalPosition()
    {
        return $this->verticalPosition;
    }

    /**
     * Set the vertical placement of the tooltip.
     * 
     * @param string|\Honed\Chart\Enums\Position $position
     * @return $this
     * 
     * @throws \Honed\Chart\Exceptions\InvalidPositionException
     */
    public function align($position)
    {
        return $this->verticalPosition($position);
    }

    /**
     * Set the vertical placement of the tooltip.
     * 
     * @param string|\Honed\Chart\Enums\Position $position
     * @return $this
     * 
     * @throws \Honed\Chart\Exceptions\InvalidPositionException
     */
    public function alignment($position)
    {
        return $this->verticalPosition($position);
    }

    /**
     * Set the horizontal shift of the tooltip.
     * 
     * @param int|null $shift
     * @return $this
     */
    public function horizontalShift($shift)
    {
        if (is_null($shift)) {
            return $this;
        }

        if ($shift < 0) {
            $this->horizontalPosition(Position::Left);
        } else {
            $this->horizontalPosition(Position::Right);
        }

        $this->horizontalShift = abs($shift);

        return $this;
    }

    /**
     * Get the horizontal shift of the tooltip.
     * 
     * @return int|null
     */
    public function getHorizontalShift()
    {
        return $this->horizontalShift;
    }

    /**
     * Set the vertical shift of the tooltip.
     * 
     * @param int|null $shift
     * @return $this
     */
    public function verticalShift($shift)
    {
        if (is_null($shift)) {
            return $this;
        }

        if ($shift < 0) {
            $this->verticalPosition(Position::Top);
        } else {
            $this->verticalPosition(Position::Bottom);
        }

        $this->verticalShift = abs($shift);

        return $this;
    }

    /**
     * Get the vertical shift of the tooltip.
     * 
     * @return int|null
     */
    public function getVerticalShift()
    {
        return $this->verticalShift;
    }

    /**
     * Set the horizontal and vertical shifts of the tooltip.
     * 
     * @param int|null $x
     * @param int|null $y
     * @return $this
     */
    public function shift($x = null, $y = null)
    {
        return $this->horizontalShift($x)->verticalShift($y);

    }

    /**
     * Shift the tooltip to the left.
     * 
     * @param int $shift
     * @return $this
     */
    public function shiftLeft($shift)
    {
        return $this->horizontalShift(-$shift);
    }

    /**
     * Shift the tooltip to the right.
     * 
     * @param int $shift
     * @return $this
     */
    public function shiftRight($shift)
    {
        return $this->horizontalShift($shift);
    }
    
    /**
     * Shift the tooltip up.
     * 
     * @param int $shift
     * @return $this
     */
    public function shiftUp($shift)
    {
        return $this->verticalShift(-$shift);
    }

    /**
     * Shift the tooltip down.
     * 
     * @param int $shift
     * @return $this
     */
    public function shiftDown($shift)
    {
        return $this->verticalShift($shift);
    }
    
    /**
     * Flush the state of the tooltip.
     * 
     * @return void
     */
    public static function flushState()
    {
        static::$defaultFollow = null;
        static::$defaultHover = null;
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
            'followCursor' => $this->follows(),
            'allowHover' => $this->hovers(),
            'horizontalPlacement' => $this->getHorizontalPosition(),
            'horizontalShift' => $this->getHorizontalShift(),
            'verticalPlacement' => $this->getVerticalPosition(),
            'verticalShift' => $this->getVerticalShift(),
        ]);
    }
}
