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
            'horizontalPlacement',
            'horizontalShift',
            'verticalPlacement',
            'verticalShift',
        ]);
    }
}
