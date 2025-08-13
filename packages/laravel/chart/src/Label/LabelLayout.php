<?php

declare(strict_types=1);

namespace Honed\Chart\Label;

use Honed\Chart\Label\Concerns\CanHideOverlap;
use Honed\Chart\Label\Concerns\CanMoveOverlap;
use Honed\Chart\Label\Concerns\HasDeltaX;
use Honed\Chart\Style\Concerns\CanBeRotated;
use Honed\Chart\Style\Concerns\HasFontSize;
use Honed\Chart\Style\Concerns\HasHeight;
use Honed\Chart\Style\Concerns\HasWidth;
use Honed\Chart\Support\Concerns\CanBeAligned;
use Honed\Chart\Support\Concerns\CanBeVerticalAligned;
use Honed\Chart\Support\Concerns\Draggable;
use Honed\Chart\Support\Concerns\HasDeltaY;
use Honed\Chart\Support\Concerns\HasX;
use Honed\Chart\Support\Concerns\HasY;
use Honed\Core\Contracts\NullsAsUndefined;
use Honed\Core\Primitive;

class LabelLayout extends Primitive implements NullsAsUndefined
{
    use CanHideOverlap;
    use CanMoveOverlap;
    use HasX;
    use HasY;
    use HasDeltaX;
    use HasDeltaY;
    use CanBeRotated;
    use HasWidth;
    use HasHeight;
    use CanBeAligned;
    use CanBeVerticalAligned;
    use Draggable;
    use HasFontSize;

    /**
     * Create a new label layout instance.
     */
    public static function make(): static
    {
        return resolve(static::class);
    }

    /**
     * Get the representation of the label layout.
     * 
     * @return array<string, mixed>
     */
    protected function representation(): array
    {
        return [
            'hideOverlap' => $this->isHidingOverlap(),
            'moveOverlap' => $this->getMoveOverlap(),
            'x' => $this->getX(),
            'y' => $this->getY(),
            'dx' => $this->getDeltaX(),
            'dy' => $this->getDeltaY(),
            'rotate' => $this->getRotation(),
            'width' => $this->getWidth(),
            'height' => $this->getHeight(),
            'align' => $this->getAlign(),
            'verticalAlign' => $this->getVerticalAlign(),
            'fontSize' => $this->getFontSize(),
            'draggable' => $this->isDraggable(),
            // 'labelLinePoints' => $this->getLabelLinePoints(),
        ];
    }
}