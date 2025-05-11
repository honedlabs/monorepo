<?php

declare(strict_types=1);

namespace Honed\Chart\Enums;

enum Position: string
{
    case Top = 'top';
    case Right = 'right';
    case Bottom = 'bottom';
    case Left = 'left';

    /**
     * Determine if the position is a valid horizontal position.
     * 
     * @return bool
     */
    public function isHorizontal()
    {
        return $this === self::Left || $this === self::Right;
    }

    /**
     * Determine if the position is a valid vertical position.
     * 
     * @return bool
     */
    public function isVertical()
    {
        return $this === self::Top || $this === self::Bottom;
    }
}